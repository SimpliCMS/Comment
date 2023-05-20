<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
Route::prefix('comment')->group(function () {
    Route::post('/store', 'CommentController@store')->name('comment.add');
    Route::get('/poll', 'CommentController@pollComments')->name('comment.poll');
    Route::get('/replies/poll', 'CommentController@pollReplies')->name('comment.replies.poll');
});
