@push('style')
<link rel="stylesheet" href="{{ url('modules/Comment/resources/assets/comment.css') }}">
@endpush
<div class="row mt-3">
    <div class="col">
        <div class="headings d-flex justify-content-between align-items-center mb-3">
            <h5>comments({{ count($comments) }})</h5>
            <div class="buttons">
                <span class="badge bg-white d-flex flex-row align-items-center">
                    <span class="text-primary">Comments "ON"</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                    </div>
                </span>
            </div>
        </div>
    </div>


    <div class="card p-3">
        <form method="post" action="{{ route('comment.add') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="comment" class="form-control" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <input type="hidden" name="type_id" value="{{ $type_id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary mt-1" value="Add Comment" />
            </div>
        </form>
    </div>

    @foreach($comments as $comment)
    <div class="card p-3 mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="user d-flex flex-row align-items-center">
                <img src="{{ $comment->user->profile->getProfileAvatar() }}" width="30" class="user-img rounded-circle mr-2">
                <span><small class="font-weight-bold text-primary ms-2">{{ $comment->user->name }}</small> <small class="font-weight-bold">{{ $comment->comment }}</small></span>
            </div>
            <small>{{ $comment->timeAgo() }}</small>
        </div>
        <div class="action d-flex justify-content-between mt-2 align-items-center">
            <div class="reply px-4">
                <small>Reply</small>
            </div>
            <div class="icons align-items-center">

            </div>
        </div>
    </div>
    <div class="col-11 mt-2">
        <h5 style="margin-left: 10%">replies({{ count($comment->replies) }})</h5>
    </div>
    @foreach($comment->replies as $reply)
    <div class="col-11 mt-2">
        <div class="card p-3" style="margin-left: 11%; width: 100%">
            <div class="d-flex justify-content-between align-items-right">
                <div class="user d-flex flex-row align-items-center">
                    <img src="{{ $reply->user->profile->getProfileAvatar() }}" width="30" class="user-img rounded-circle mr-2">
                    <span><small class="font-weight-bold text-primary ms-2">{{ $reply->user->name }}</small> <small class="font-weight-bold">{{ $reply->comment }}</small></span>
                </div>
                <small>{{ $reply->timeAgo() }}</small>
            </div>
            <div class="action d-flex justify-content-between mt-2 align-items-center">
                <div class="reply px-4">
                    <small>Reply</small>
                </div>
                <div class="icons align-items-center">

                </div>
            </div>
        </div>

    </div>
    @endforeach
    <div class="col-11 mt-3">
        <div class="card p-3" style="margin-left: 11%; width: 100%">
            <form method="post" action="{{ route('comment.add') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="comment" class="form-control" />
                    <input type="hidden" name="type" value="{{ $type }}" />
                    <input type="hidden" name="type_id" value="{{ $type_id }}" />
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary mt-1" value="Add Reply" />
                </div>
            </form>
        </div>
    </div>
    @endforeach




</div>
</div>