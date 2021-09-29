<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Comment;
use App\Models\Blog;

class CommentsController extends Controller {

    public function index(Request $request) {
        //$comments = Comment::all();

        return view('admin.comments.index', [
            //'comments' => $comments,
        ]);
    }

    public function datatable(Request $request) {
        $searchFilters = $request->validate([
            'id' => ['nullable', 'numeric', 'exists:comment,id'],
        ]);

        $query = Comment::query()
                ->with(['blogPost'])
                ->join('blog_posts', 'comments.blog_post_id', '=', 'blog_posts.id')
                ->select(['comments.*', 'blog_posts.name as blog_posts_name']);

        $dataTable = \DataTables::of($query);

        $dataTable->addColumn('actions', function ($comment) {
                    return view('admin.comments.partials.actions', ['comment' => $comment]);
                })
                ->addColumn('blog_post_name', function ($comment) {
                    return optional($comment->blog_post)->name;
                })
                ->editColumn('status', function ($comment) {
                    return view('admin.comments.partials.status', ['comment' => $comment]);
                })
                ->editColumn('id', function ($comment) {
                    return '#' . $comment->id;
                })
                ->editColumn('name', function ($comment) {
                    return '<strong>' . e($comment->name) . '</strong>';
                })
                ->editColumn('created_at', function ($comment) {
                    return date_format($comment->created_at, 'd/m/Y H:i:s l');
                })
        ;

        $dataTable->rawColumns(['name', 'actions']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where('comments.id', '=', $searchTerm);
            }
        });

        return $dataTable->make(true);
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
