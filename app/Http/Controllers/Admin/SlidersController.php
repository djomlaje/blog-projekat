<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Validation\Rule;

class SlidersController extends Controller {

    public function index(Request $request) {
        $sliders = Slider::orderBy('priority')
                ->get();

        return view('admin.sliders.index', [
            'sliders' => $sliders,
        ]);
    }

    public function add(Request $request) {
        return view('admin.sliders.add', [
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30', 'unique:slider,name'],
            'url_title' => ['nullable', 'string', 'min:2', 'max:30', 'unique:slider,urlTitle'],
            'url' => ['nullable', 'url'],
            'description' => ['nullable', 'string', 'min:10', 'max:255'],
            'photo' => ['nullable', 'file', 'image']
        ]);
        $newSlider = new Slider();

        $newSlider->fill($formData);

        //vadimo kategoriju sa najvecim prioritetom
        $sliderWithHighestPriority = Slider::orderBy('priority', 'DESC')
                ->first();

        //ako kategorija ne postoji u bazi
        if ($sliderWithHighestPriority) {

            $newSlider->priority = $sliderWithHighestPriority->priority + 1;
        } else {
            $newSlider->priority = 1;
        }

        $newSlider->save();

        $this->handlePhotoUpload($request, $newSlider);
        
        session()->flash('system_message', __('Slider has been added.'));

        return redirect()->route('admin.sliders.index');
    }

    public function edit(Request $request, Slider $slider) {
        return view('admin.sliders.edit', [
            'slider' => $slider,
        ]);
    }

    public function update(Request $request, Slider $slider) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:20', Rule::unique('slider')->ignore($slider->id)],
            'url_title' => ['nullable', 'string', 'min:2', 'max:20', Rule::unique('slider', 'urlTitle')->ignore($slider->id)],
            'url' => ['nullable', 'url'],
            'description' => ['nullable', 'string', 'min:2', 'max:2000'],
            'photo' => ['nullable', 'file', 'image']
        ]);
        $slider->fill($formData);
        $slider->save();

        $this->handlePhotoUpload($request, $slider);
        
        session()->flash('system_message', __('Slider has been updated'));

        return redirect()->route('admin.sliders.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slider,id'],
        ]);

        $slider = Slider::findOrFail($formData['id']);

        $slider->delete();

        Slider::where('priority', '>', $slider->priority)
                ->decrement('priority');
        
        $slider->deletePhoto();

        session()->flash('system_message', __('Slider has been deleted.'));

        return redirect()->route('admin.sliders.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string'],
        ]);

        $priorities = explode(',', $formData['priorities']);

        foreach ($priorities as $key => $id) {
            $slider = Slider::findOrFail($id);

            $slider->priority = $key + 1;

            $slider->save();
        }

        session()->flash('system_message', __('Slider priorities have been changed.'));

        return redirect()->route('admin.sliders.index');
    }
    
    public function changeStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slider,id'],
        ]);

        $slider = Slider::findOrFail($formData['id']);

        $slider->status = $slider->status == 1 ? 0 : 1;
        

        $slider->save();

        if ($slider->status == 1) {
            return response()->json(['system_message' => __("Slider has been enabled")]);
        } else {
            return response()->json(['system_message' => __("Slider has been disabled")]);
        }
    }
    
    public function deletePhoto(Request $request, Slider $slider) {
        $formData = $request->validate([
            'photo' => ['required', 'string', 'in:photo'],
        ]);

        $photoFieldName = $formData['photo'];

        $slider->deletePhoto($photoFieldName);

        $slider->$photoFieldName = null;
        $slider->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $slider->getPhotoUrl($photoFieldName),
        ]);
    }

    protected function handlePhotoUpload(Request $request, Slider $slider) {
        if ($request->hasFile('photo')) {


            $slider->deletePhoto('photo');

            $photoFile = $request->file('photo');

            $newPhotoFileName = $slider->id . '_' . 'photo' . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/sliders/'),
                    $newPhotoFileName
            );

            $slider->photo = $newPhotoFileName;

            $slider->save();

            //originalna slika
            \Image::make(public_path('/storage/sliders/' . $slider->photo))
                    ->fit(1518, 453)
                    ->save();
        }
    }

}
