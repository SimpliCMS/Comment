<div class="mt-3">
    <div class="col">
        <div class="headings d-flex justify-content-between align-items-center mb-3">
            <h5>comments(<span id="comment-count">{{ count($comments) }}</span>)</h5>
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
    @auth
    <div class="card p-3 mb-2">
        <form method="post" id="comment-form" data-action="{{ route('comment.add') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="comment" id="comment-input" class="form-control" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <input type="hidden" name="type_id" value="{{ $type_id }}" />
            </div>
            <div class="form-group">
                <input type="button" id="comment-submit" class="btn btn-primary mt-1" value="Add Comment" />
            </div>
        </form>
    </div>
    @endauth
    <div id="comment-container" class="comment">
        @foreach($comments as $comment)
        @include('comment::partials.comment', ['comment' => $comment])

        <div class="col-11 mt-2">
            <h5 style="margin-left: 10%">replies(<span id="reply-count-{{ $comment->id }}">{{ count($comment->replies) }}</span>)</h5>
        </div>
        <div id="reply-container-{{ $comment->id }}">
            @foreach($comment->replies as $reply)
            <div id="reply-{{ $reply->id }}" class="reply">
                @include('comment::partials.reply', ['reply' => $reply])
            </div>
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
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        // Add the CSRF token to all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add Comment AJAX
        $('#comment-submit').click(function () {
            var comment = $('#comment-input').val();
            var type = $('[name="type"]').val();
            var type_id = $('[name="type_id"]').val();

            $.ajax({
                type: 'POST',
                url: $('#comment-form').data('action'),
                data: {
                    comment: comment,
                    type: type,
                    type_id: type_id
                },
                success: function (response) {
                    // Add the new comment to the top of the comment div
                    $('#comment-container').prepend(response);
                    $('#comment-input').val('');

                    // Update comment count
                    var commentCount = parseInt($('#comment-count').text());
                    $('#comment-count').text(commentCount + 1);
                }
            });
        });

        // Add Reply AJAX
        $('.reply-submit').click(function () {
            var replyForm = $(this).closest('.reply-form');
            var comment = replyForm.find('.reply-input').val();
            var type = replyForm.find('[name="type"]').val();
            var type_id = replyForm.find('[name="type_id"]').val();
            var parent_id = replyForm.find('[name="parent_id"]').val();

            $.ajax({
                type: 'POST',
                url: replyForm.data('action'),
                data: {
                    comment: comment,
                    type: type,
                    type_id: type_id,
                    parent_id: parent_id
                },
                success: function (response) {
                    // Add the new reply to the bottom of the replies of the comment
                    $('#reply-container-' + parent_id).append(response);
                    replyForm.find('.reply-input').val('');

                    // Update reply count for the parent comment
                    var replyCount = parseInt($('#reply-count-' + parent_id).text());
                    $('#reply-count-' + parent_id).text(replyCount + 1);
                }
            });
        });
    });

</script>

@endpush
