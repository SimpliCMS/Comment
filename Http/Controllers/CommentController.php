<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Controllers\Controller;
use Modules\Comment\Models\Comment;

class CommentController extends Controller {

    public function store(Request $request) {
        if (Auth::check()) {
            if ($request->filled('parent_id')) {
                // Code to execute when the input exists and is not empty
                $parent_id = $request->input('parent_id');
            } else {
                // Code to execute when the input does not exist or is empty
                $parent_id = null;
            }
            Comment::create([
                'comment' => $request->input('comment'),
                'user_id' => Auth::user()->id,
                'parent_id' => $parent_id,
                'type' => $request->input('type'),
                'type_id' => $request->input('type_id')
            ]);

            return back()->withInput()->with('success', 'Comment Added successfully..!');
        } else {
            return back()->withInput()->with('error', 'Something wrong');
        }
    }

    public function replyStore(Request $request, $model) {
        
    }

}
