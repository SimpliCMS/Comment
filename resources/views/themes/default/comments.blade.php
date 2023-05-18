<div class="card mt-3">
    <div class="card-body">
        @auth
        <h5>Leave a comment</h5>
        <form method="post" action="{{ route('comment.add') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="comment" class="form-control" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <input type="hidden" name="type_id" value="{{ $type_id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;" value="Add Comment" />
            </div>
        </form>
        @endauth

        @foreach($comments as $comment)
        <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
            <img src="{{ $comment->user->profile->getProfileAvatar() }}" class="rounded-circle me-3" alt="Channel Avatar" width="50" height="50">
            <strong>{{ $comment->user->name }}</strong>
            <p>{{ $comment->comment }}</p>
            <a href="" id="reply">Reply to {{ $comment->user->name }}</a>
            <form method="post" action="{{ route('comment.add') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="comment" class="form-control" />
                    <input type="hidden" name="type" value="{{ $type }}" />
                    <input type="hidden" name="type_id" value="{{ $type_id }}" />
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;" value="Add Reply" />
                </div>
            </form>
            @foreach($comment->replies as $reply)
            <img src="{{ $reply->user->profile->getProfileAvatar() }}" class="rounded-circle me-3" alt="Channel Avatar" width="50" height="50">
            <strong>{{ $reply->user->name }}</strong>
            <p>{{ $reply->comment }}</p>
            <a href="" id="reply"></a>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
