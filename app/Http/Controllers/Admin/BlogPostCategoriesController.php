<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPostCategory;
use Illuminate\Validation\Rule;

class BlogPostCategoriesController extends Controller {

    public function index(Request $request) {
        $blogPostCategories = BlogPostCategory::orderBy('priority')
                ->get();

        return view('admin.blog_post_categories.index', [
            'blogPostCategories' => $blogPostCategories,
        ]);
    }

    public function add(Request $request) {
        return view('admin.blog_post_categories.add', [
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30', 'unique:blog_post_categories,name'],
            'description' => ['nullable', 'string', 'min:10', 'max:255'],
        ]);

        $newBlogPostCategory = new BlogPostCategory();

        $newBlogPostCategory->fill($formData);

        //vadimo kategoriju sa najvecim prioritetom
        $blogPostCategoryWithHighestPriority = BlogPostCategory::orderBy('priority', 'DESC')
                ->first();

        //ako kategorija ne postoji u bazi
        if ($blogPostCategoryWithHighestPriority) {

            $newBlogPostCategory->priority = $blogPostCategoryWithHighestPriority->priority + 1;
        } else {
            $newBlogPostCategory->priority = 1;
        }

        $newBlogPostCategory->save();

        session()->flash('system_message', __('Blog Post Category has been added.'));

        return redirect()->route('admin.blog_post_categories.index');
    }

    public function edit(Request $request, BlogPostCategory $blogPostCategory) {
        return view('admin.blog_post_categories.edit', [
            'blogPostCategory' => $blogPostCategory,
        ]);
    }

    public function update(Request $request, BlogPostCategory $blogPostCategory) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:20', Rule::unique('blog_post_categories')->ignore($blogPostCategory->id)],
            'description' => ['nullable', 'string', 'min:2', 'max:2000'],
        ]);

        $blogPostCategory->fill($formData);
        $blogPostCategory->save();

        session()->flash('system_message', __('Product Category has been updated'));

        return redirect()->route('admin.blog_post_categories.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_post_categories,id'],
        ]);

        $blogPostCategory = BlogPostCategory::findOrFail($formData['id']);

        $blogPostCategory->delete();

        BlogPostCategory::where('priority', '>', $blogPostCategory->priority)
                ->decrement('priority');


        session()->flash('system_message', __('Blog Post Category has been deleted.'));

        return redirect()->route('admin.blog_post_categories.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string'],
        ]);

        $priorities = explode(',', $formData['priorities']);

        foreach ($priorities as $key => $id) {
            $blogPostCategory = BlogPostCategory::findOrFail($id);

            $blogPostCategory->priority = $key + 1;

            $blogPostCategory->save();
        }

        session()->flash('system_message', __('Blog Post Category priorities have been changed.'));

        return redirect()->route('admin.blog_post_categories.index');
    }

}
