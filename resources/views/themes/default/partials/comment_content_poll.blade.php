<div class="card p-3 mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <div class="user d-flex flex-row align-items-center">
            <img src="{{ $comment->user->profile->getProfileAvatar() }}" width="30" class="user-img rounded-circle mr-2">
            <span>
                <small class="font-weight-bold text-primary ms-2">{{ $comment->user->name }}</small>
            </span>
        </div>
        <small>{{ $comment->timeAgo() }}</small>
    </div>
    <div class="action d-flex justify-content-between mt-2 align-items-center">
        <div class="reply px-4">
            {{ $comment->comment }}
        </div>
        <div class="icons align-items-center">
            <!-- Add any icons or additional elements here if needed -->
        </div>
    </div>
</div>
<div id="reply-container-{{ $comment->id }}">
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