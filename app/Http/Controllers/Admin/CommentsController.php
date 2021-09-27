<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Comment;
use App\Models\Blog;


class CommentsController extends Controller {

    public function index(Request $request) {
        $comments = Comment::all();
        

        return view('admin.comments.index', [
            'comments' => $comments,
        ]);
    }

    
    public function changeStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:comments,id'],
        ]);
        
        $comment = Comment::findOrFail($formData['id']);

        $comment->status = $comment->status == 1 ? 0 : 1;

        $comment->save();

        if ($comment->status == 1) {
            return response()->json(['system_message' => __("Comment has been enabled")]);
        } else {
            return response()->json(['system_message' => __("Comment has been disabled")]);
        }
    }
}
