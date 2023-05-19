<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Core\Http\Controllers\Controller;
use Modules\Comment\Models\Comment;
use Response;

class CommentController extends Controller {

    public function store(Request $request) {
        if (Auth::check()) {
            if ($request->filled('parent_id')) {
                // Code to execute when the input exists and is not empty
                $parent_id = $request->input('parent_id');
                $partialView = 'comment::partials.reply'; // Change the partial view for replies
                $partialVar = 'reply';
            } else {
                // Code to execute when the input does not exist or is empty
                $parent_id = null;
                $partialView = 'comment::partials.comment'; // Use the original partial view for main comments
                $partialVar = 'comment';
            }

            $comment = Comment::create([
                        'comment' => $request->input('comment'),
                        'user_id' => Auth::user()->id,
                        'parent_id' => $parent_id,
                        'type' => $request->input('type'),
                        'type_id' => $request->input('type_id')
            ]);

            $view = View::make($partialView, [$partialVar => $comment])->render();

            return $view;
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => 'Something went wrong.'
            ]);
        }
    }

    public function replyStore(Request $request, $model) {
        
    }

}
