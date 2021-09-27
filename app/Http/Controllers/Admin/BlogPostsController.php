<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Blog;
use App\Models\BlogPostCategory;
use App\Models\Tag;

class BlogPostsController extends Controller {

    public function index() {
        return view('admin.blog_posts.index', [
        ]);
    }

    public function datatable(Request $request) {
        $searchFilters = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'blog_post_category_id' => ['nullable', 'numeric', 'exists:blog_post_categories,id'],
            'author' => ['nullable', 'numeric', 'exists:users,id'],
            'status' => ['nullable', 'numeric', 'in:0,1'],
            'importance' => ['nullable', 'numeric', 'in:0,1'],
            'tag_ids' => ['nullable', 'array', 'exists:tags,id']
        ]);

        $query = Blog::query()
                ->with(['blogPostCategory', 'tags', 'users'])
                ->join('blog_post_categories', 'blog_posts.blog_post_category_id', '=', 'blog_post_categories.id')
                ->join('users', 'blog_posts.blog_post_user_id', '=', 'users.id')
                ->select(['blog_posts.*', 'blog_post_categories.name AS blog_post_category_name', 'users.name AS author']);
        
        $dataTable = \DataTables::of($query);

        $dataTable->addColumn('actions', function ($blogPost) {
                    return view('admin.blog_posts.partials.actions', ['blogPost' => $blogPost]);
                })
                ->addColumn('author', function ($blogPost) {
                    return $blogPost->users->name;
                })
                ->addColumn('comments', function ($blogPost) {
                    return $blogPost->comments->count();
                })
                ->editColumn('photo2', function ($blogPost) {
                    return view('admin.blog_posts.partials.blog_post_photo2', ['blogPost' => $blogPost]);
                })
                ->editColumn('status', function ($blogPost) {
                    return view('admin.blog_posts.partials.status', ['blogPost' => $blogPost]);
                })
                ->editColumn('important', function ($blogPost) {
                    return view('admin.blog_posts.partials.important', ['blogPost' => $blogPost]);
                })
                ->editColumn('id', function ($blogPost) {
                    return '#' . $blogPost->id;
                })
                ->editColumn('name', function ($blogPost) {
                    return '<strong>' . e($blogPost->name) . '</strong>';
                })
                ->editColumn('views', function ($blogPost) {
                    return $blogPost->views;
                })
                ->editColumn('created_at', function ($blogPost) {
                    return date_format($blogPost->created_at, 'd/m/Y H:i:s l');
                })
        ;

        $dataTable->rawColumns(['name', 'photo2', 'actions']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {

                    $query->orWhere('blog_posts.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_posts.description', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_post_categories.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_posts.id', '=', $searchTerm);
                });
            }

            if (isset($searchFilters['name'])) {
                $query->where('blog_posts.name', 'LIKE', '%' . $searchFilters['name'] . '%');
            }

            if (isset($searchFilters['blog_post_category_id'])) {
                $query->where('blog_post_categories.id', '=', $searchFilters['blog_post_category_id']);
            }

            if (isset($searchFilters['author'])) {
                $query->where('users.id', '=', $searchFilters['author']);
            }

            if (isset($searchFilters['status'])) {
                $query->where('blog_posts.status', '=', $searchFilters['status']);
            }

            if (isset($searchFilters['importance'])) {
                $query->where('blog_posts.important', '=', $searchFilters['importance']);
            }

            if (isset($searchFilters['tag_ids'])) {
                $query->whereHas('tags', function ($subQuery) use ($searchFilters) {
                    $subQuery->whereIn('tag_id', $searchFilters['tag_ids']);
                });
            }
        });

        return $dataTable->make(true);
    }

    public function add(Request $request) {
        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->get();

        $tags = Tag::all();

        return view('admin.blog_posts.add', [
            'blogPostCategories' => $blogPostCategories,
            'tags' => $tags,
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'blog_post_user_id' => ['required', 'numeric', 'exists:users,id'],
            'blog_post_category_id' => ['required', 'numeric', 'exists:blog_post_categories,id'],
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:blog_posts,name'],
            'description' => ['nullable', 'string', 'min:50', 'max:500'],
            'details' => ['nullable', 'string'],
            'important' => ['required', 'numeric', 'in:0,1'],
            'tag_id' => ['required', 'array', 'exists:tags,id'],
            'photo1' => ['nullable', 'file', 'image'],
            'photo2' => ['nullable', 'file', 'image'],
        ]);


        $newBlogPost = new Blog();

        $newBlogPost->fill($formData);
        $newBlogPost->save();

        //Tagovi se cuvaju u veznoj tabeli - odrzavanje veze vise na vise
        $newBlogPost->tags()->sync($formData['tag_id']);

        if ($request->hasFile('photo1')) {
            $photoFile = $request->file('photo1');

            $newPhotoFileName = $newBlogPost->id . '_photo1_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/blog_posts/'),
                    $newPhotoFileName
            );

            $newBlogPost->photo1 = $newPhotoFileName;
            $newBlogPost->save();

            \Image::make(public_path('/storage/blog_posts/' . $newBlogPost->photo1))
                    ->fit(640, 426)
                    ->save();
        }

        if ($request->hasFile('photo2')) {
            $photoFile = $request->file('photo2');

            $newPhotoFileName = $newBlogPost->id . '_photo2_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/blog_posts/thumbs/'),
                    $newPhotoFileName
            );

            $newBlogPost->photo2 = $newPhotoFileName;
            $newBlogPost->save();

            \Image::make(public_path('/storage/blog_posts/thumbs/' . $newBlogPost->photo2))
                    ->fit(256, 256)
                    ->save();
        }

        session()->flash('system_message', __('New tag has been added.'));

        return redirect()->route('admin.blog_posts.index');
    }

    public function edit(Request $request, Blog $blogPost) {
        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->get();

        $tags = Tag::all();

        return view('admin.blog_posts.edit', [
            'blogPost' => $blogPost,
            'blogPostCategories' => $blogPostCategories,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, Blog $blogPost) {

        $formData = $request->validate([
            'blog_post_user_id' => ['required', 'numeric', 'exists:users,id'],
            'blog_post_category_id' => ['required', 'numeric', 'exists:blog_post_categories,id'],
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('blog_posts')->ignore($blogPost->id)],
            'description' => ['nullable', 'string', 'min:50', 'max:500'],
            'details' => ['nullable', 'string'],
            'important' => ['required', 'numeric', 'in:0,1'],
            'tag_id' => ['required', 'array', 'exists:tags,id'],
            'photo1' => ['nullable', 'file', 'image'],
            'photo2' => ['nullable', 'file', 'image'],
        ]);

        $blogPost->fill($formData);
        $blogPost->save();
        $blogPost->tags()->sync($formData['tag_id']);


        if ($request->hasFile('photo1')) {
            $blogPost->deletePhoto1();

            $photoFile = $request->file('photo1');

            $newPhotoFileName = $blogPost->id . '_photo1_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/blog_posts/'),
                    $newPhotoFileName
            );

            $blogPost->photo1 = $newPhotoFileName;
            $blogPost->save();

            \Image::make(public_path('/storage/blog_posts/' . $blogPost->photo1))
                    ->fit(640, 426)
                    ->save();
        }

        if ($request->hasFile('photo2')) {
            $blogPost->deletePhoto2();

            $photoFile = $request->file('photo2');

            $newPhotoFileName = $blogPost->id . '_photo2_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/blog_posts/thumbs/'),
                    $newPhotoFileName
            );

            $blogPost->photo2 = $newPhotoFileName;
            $blogPost->save();

            \Image::make(public_path('/storage/blog_posts/thumbs/' . $blogPost->photo2))
                    ->fit(256, 256)
                    ->save();
        }
        session()->flash('system_message', __('BlogPost has been updated'));

        return redirect()->route('admin.blog_posts.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $blog = Blog::findOrFail($formData['id']);

        $blog->delete();

        //brisanje iz vezne tabele
        //odrzavanje relacija
        \DB::table('blog_post_tags')
                ->where('blog_post_id', '=', $blog->id)
                ->delete();

        $blog->deletePhoto1();
        $blog->deletePhoto2();

        return response()->json([
                    'system_message' => __('Product has been deleted.')
        ]);
    }

    public function deletePhoto(Request $request, Blog $blogPost) {
        $formData = $request->validate([
            'photo' => ['required', 'string', 'in:photo1,photo2'],
        ]);

        $photoFieldName = $formData['photo'];
        $blogPost->deletePhoto($photoFieldName);

        $blogPost->$photoFieldName = null;
        $blogPost->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $blogPost->getPhotoUrl($photoFieldName),
        ]);
    }

    public function changeStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $blogPost = Blog::findOrFail($formData['id']);

        $blogPost->status = $blogPost->status == 1 ? 0 : 1;

        $blogPost->save();

        if ($blogPost->status == 1) {
            return response()->json(['system_message' => __("Blog post status has been enabled")]);
        } else {
            return response()->json(['system_message' => __("Blog post status has been disabled")]);
        }
    }

    public function importance(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $blogPost = Blog::findOrFail($formData['id']);

        $blogPost->important = $blogPost->important == 1 ? 0 : 1;

        $blogPost->save();

        if ($blogPost->important == 1) {
            return response()->json(['system_message' => __("Blog post status has been enabled")]);
        } else {
            return response()->json(['system_message' => __("Blog post status has been disabled")]);
        }
    }

}
