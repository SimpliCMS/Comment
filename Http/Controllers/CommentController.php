<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Core\Http\Controllers\Controller;
use Modules\Comment\Models\Comment;
use Modules\Comment\Models\Reply;
use Response;

class CommentController extends Controller {

    public function store(Request $request) {
        if (Auth::check()) {
            if ($request->filled('parent_id')) {
                // Code to execute when the input exists and is not empty
                $parent_id = $request->input('parent_id');
                $partialView = 'comment::partials.reply'; // Change the partial view for replies
                $partialVar = 'reply';

                $comment = Reply::create([
                            'comment' => $request->input('comment'),
                            'user_id' => Auth::user()->id,
                            'parent_id' => $parent_id,
                            'type' => $request->input('type'),
                            'type_id' => $request->input('type_id')
                ]);
            } else {
                // Code to execute when the input does not exist or is empty
                $parent_id = null;
                $partialView = 'comment::partials.comment'; // Use the original partial view for main comments
                $partialVar = 'comment';

                $comment = Comment::create([
                            'comment' => $request->input('comment'),
                            'user_id' => Auth::user()->id,
                            'parent_id' => $parent_id,
                            'type' => $request->input('type'),
                            'type_id' => $request->input('type_id')
                ]);
            }

            $view = View::make($partialView, [$partialVar => $comment, 'type' => $comment->type, 'type_id' => $comment->type_id])->render();

            return $view;
        } else {
            return response()->json([
                        'status' => 'error',
                        'message' => 'Something went wrong.'
            ]);
        }
    }

    public function pollComments(Request $request) {
        $type = $request->input('type');
        $type_id = $request->input('type_id');
        $lastPollTime = $request->input('last_poll_time');

        if (!empty(auth()->user()->id)) {
            $currentUserId = auth()->user()->id;

            $comments = Comment::where('type', $type)
                    ->where('type_id', $type_id)
                    ->where('created_at', '>', $lastPollTime)
                    ->where('user_id', '!=', $currentUserId)
                    ->get();
        } else {
            $comments = Comment::where('type', $type)
                    ->where('type_id', $type_id)
                    ->where('created_at', '>', $lastPollTime)
                    ->whereNull('parent_id')
                    ->get();
        }

        $commentHtml = [];
        $replyHtml = [];

        foreach ($comments as $comment) {
            $commentPartialView = view('comment::partials.comment_content_poll')
                    ->with('comment', $comment)
                    ->with('type', $comment->type)
                    ->with('type_id', $comment->type_id)
                    ->render();

            $commentHtml[] = [
                'html' => $commentPartialView,
                'id' => $comment->id,
            ];
        }



        $response = [
            'commenthtml' => $commentHtml,
            'last_poll_time' => now()->toDateTimeString(),
        ];

        return response()->json($response);
    }

    public function pollReplies(Request $request) {
        $type = $request->input('type');
        $type_id = $request->input('type_id');
        $lastPollTime = $request->input('last_poll_time');

        if (!empty(auth()->user()->id)) {
            $currentUserId = auth()->user()->id;

            $replies = Reply::where('type', $type)
                    ->where('type_id', $type_id)
                    ->where('created_at', '>', $lastPollTime)
                    ->where('user_id', '!=', $currentUserId)
                    ->get();
        } else {
            $replies = Reply::where('type', $type)
                    ->where('type_id', $type_id)
                    ->where('created_at', '>', $lastPollTime)
                    ->whereNull('parent_id')
                    ->get();
        }

        $replyHtml = [];

        foreach ($replies as $reply) {
            $replyPartialView = view('comment::partials.reply')
                    ->with('reply', $reply)
                    ->with('type', $reply->type)
                    ->with('type_id', $reply->type_id)
                    ->render();

            $replyHtml[] = [
                'html' => $replyPartialView,
                'id' => $reply->id,
                'parent_id' => $reply->parent_id,
            ];
        }



        $response = [
            'replyhtml' => $replyHtml,
            'last_poll_time' => now()->toDateTimeString(),
        ];

        return response()->json($response);
    }

}
