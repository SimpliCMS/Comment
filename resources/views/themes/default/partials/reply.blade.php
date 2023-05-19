<!-- Reply -->
<div class="col-11 mt-2">
    <div class="card p-3" style="margin-left: 9%; width: 100%">
        <div class="d-flex justify-content-between align-items-right">
            <div class="user d-flex flex-row align-items-center">
                <img src="{{ $reply->user->profile->getProfileAvatar() }}" width="30" class="user-img rounded-circle mr-2">
                <span><small class="font-weight-bold text-primary ms-2">{{ $reply->user->name }}</small></span>
            </div>
            <small>{{ $reply->timeAgo() }}</small>
        </div>
        <div class="action d-flex justify-content-between mt-2 align-items-center">
            <div class="reply px-4">
                {{ $reply->comment }}
            </div>
            <div class="icons align-items-center">
            </div>
        </div>
    </div>
</div>
<!-- Reply -->
