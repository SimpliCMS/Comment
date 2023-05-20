<!-- Comment -->
@include('comment::partials.comment_content', ['comment' => $comment])

@if(count($comment->replies) > 0)
<div class="col-11 mt-2">
    <h5 style="margin-left: 10%">replies(<span id="reply-count-{{ $comment->id }}">{{ count($comment->replies) }}</span>)</h5>
</div>
@endif
<div id="reply-container-{{ $comment->id }}">
    @foreach($comment->replies->sortBy('created_at') as $reply)
        @include('comment::partials.reply', ['reply' => $reply])
    @endforeach
</div>
@auth
<div class="col-11 mt-3 mb-3">
    <div class="card p-3" style="margin-left: 9%; width: 100%">
        <form method="post" class="reply-form" data-action="{{ route('comment.add') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="comment" class="form-control reply-input" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <input type="hidden" name="type_id" value="{{ $type_id }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="button" class="btn btn-primary mt-1 reply-submit" value="Add Reply" />
            </div>
        </form>
    </div>
</div>
@endauth
<!-- End Comment  -->
