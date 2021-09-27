<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function content(Request $request, Blog $blog)
    {
        $comments = Comment::query()
                ->where('status', '=', '1')
                ->where('blog_post_id', '=', $request->blogID)
                ->orderBy('created_at')
                ->get();
        
        $commentsCount = $comments->count();
        
        return view('front.blogs.partials.comments.comments_content', [
            'comments' => $comments,
            'commentsCount' => $commentsCount,
        ]);
    }
    
    
    
    public function list(Request $request)
    {
        
        return view('front.blogs.partials.comment_list', [
            
        ]);
    }


    public function insert(Request $request, Blog $blogPost)
    {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:blog_posts,name'],
            'email' => ['required', 'email', 'min:3', 'max:40'],
            'description' => ['required', 'string', 'max:2000'],
            'blog_post_id' => ['required', 'numeric', 'exists:comments,blog_post_id']
        ]);
        
        $newComment = new Comment();
        $newComment->fill($formData);
        $newComment->save();
        
        session()->flash('system_message', __('Comment has been added.'));
        return redirect()->route('front.blogs.single', ['blog' => $request->blogID]);
    }
    
}
