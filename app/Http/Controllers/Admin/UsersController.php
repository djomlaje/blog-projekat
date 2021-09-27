<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserCategory;
use App\Models\Size;

class UsersController extends Controller {

    public function index(Request $request) {
        //Napravio sam male izmjene u bazi 
        // description sam morao da stavim da moze da bude NULL
        // featured sam stavio da je po default-u = 0, a zatim moze da se mijenja nakon sto se doda proizvod
        // i moze da se stavi na pocetnu stranu
        //$users = User::query()
        //        ->with(['brand', 'userCategory', 'sizes'])
        //        ->get();

        return view('admin.users.index', [
                //'users' => $users,
        ]);
    }

    public function datatable(Request $request) {
        $searchFilters = $request->validate([
            'status' => ['nullable', 'numeric', 'in:0,1'],
            'email' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string'],
            'phoneNumber' => ['nullable', 'string'],
        ]);

        $query = User::query();


        $dataTable = \DataTables::of($query);

        $dataTable->addColumn('actions', function ($user) {
                    return view('admin.users.partials.actions', ['user' => $user]);
                })
                ->addColumn('status', function ($user) {
                    return view('admin.users.partials.status', ['user' => $user]);
                })
                ->editColumn('id', function ($user) {
                    return '#' . $user->id;
                })
                ->editColumn('photo', function ($user) {
                    return view('admin.users.partials.user_photo', ['user' => $user]);
                })
                ->editColumn('name', function ($user) {
                    return '<strong>' . e($user->name) . '</strong>';
                })
                ->editColumn('created_at', function ($user) {
                    return date_format($user->created_at, 'd/m/Y H:i:s l');
                })
        ;

        $dataTable->rawColumns(['name', 'photo', 'actions', 'created_at']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (isset($searchFilters['status'])) {
                $query->where('users.status', '=', $searchFilters['status']);
            }

            if (isset($searchFilters['name'])) {
                $query->where('users.name', 'LIKE', '%' . $searchFilters['name'] . '%');
            }

            if (isset($searchFilters['email'])) {
                $query->where('users.email', 'LIKE', '%' . $searchFilters['email'] . '%');
            }

            if (isset($searchFilters['phoneNumber'])) {
                $query->where('users.phoneNumber', 'LIKE', '%' . $searchFilters['phoneNumber'] . '%');
            }
        });

        return $dataTable->make(true);
    }

    public function add(Request $request) {

        if (\Auth::user()->admin == 0) {
            session()->flash('error_message', __('Only admin can add new user.'));
            return redirect()->back();
        }
        
        return view('admin.users.add', [
        ]);
    }

    public function insert(Request $request) {

        $formData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email'],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'file', 'image']
        ]);

        $newUser = new User();
        $newUser->password = \Hash::make('cubesphp');
        $newUser->phoneNumber = $formData['phoneNumber'];
        $newUser->fill($formData);

        $newUser->save();

        $this->handlePhotoUpload($request, $newUser);

        session()->flash('system_message', __('New user has been saved!'));

        return redirect()->route('admin.users.index');
    }

    public function edit(Request $request, User $user) {

        if (\Auth::user()->email == $user->email) {
            throw new \Exception('Something went wrong. You cannot edit your account.');
        } else {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }
    }

    public function update(Request $request, User $user) {

        $formData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'file', 'image']
        ]);

        $user->fill($formData);

        $user->save();

        $this->handlePhotoUpload($request, $user);

        session()->flash('system_message', __('User has been updated'));

        return redirect()->route('admin.users.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id'],
        ]);

        $formData['id'];

        $user = User::findOrFail($formData['id']);

        if (\Auth::user()->email == $user->email) {
            throw new \Exception('Something went wrong. User cannot delete himself.');
        } else {
            $user->delete();
        }



        return response()->json([
                    'system_message' => __('User has been deleted')
        ]);
    }

    public function changeStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id'],
        ]);

        $user = User::findOrFail($formData['id']);

        if (\Auth::user()->id == $formData['id']) {
            throw new \Exception__('Something went wrong. User cannot change his status.');
        } else {
            $user->status = $user->status == 1 ? 0 : 1;
        }

        $user->save();

        if ($user->status == 1) {
            return response()->json(['system_message' => __("User has been enabled")]);
        } else {
            return response()->json(['system_message' => __("User has been disabled")]);
        }
    }

    public function deletePhoto(Request $request, User $user) {
        $formData = $request->validate([
            'photo' => ['required', 'string', 'in:photo'],
        ]);

        $photoFieldName = $formData['photo'];

        $user->deletePhoto($photoFieldName);

        $user->$photoFieldName = null;
        $user->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $user->getPhotoUrl($photoFieldName),
        ]);
    }

    protected function handlePhotoUpload(Request $request, User $user) {
        if ($request->hasFile('photo')) {


            $user->deletePhoto('photo');

            $photoFile = $request->file('photo');

            $newPhotoFileName = $user->id . '_' . 'photo' . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/users/'),
                    $newPhotoFileName
            );

            $user->photo = $newPhotoFileName;

            $user->save();

            //originalna slika
            \Image::make(public_path('/storage/users/' . $user->photo))
                    ->fit(300, 300)
                    ->save();
        }
    }

}
