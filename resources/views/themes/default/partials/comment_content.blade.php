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

