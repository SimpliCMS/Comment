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
        @foreach($comments->sortByDesc('created_at') as $comment)
        @include('comment::partials.comment', ['comment' => $comment, 'type' => $type, 'type_id' => $type_id])

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
        // Add Reply AJAX (Using event delegation)
        $(document).on('click', '.reply-submit', function () {
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

    $(document).ready(function () {
        var lastPollTime = '{{ $lastPollTime ?? now() }}';

        function formatDate(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');
            var hours = String(date.getHours()).padStart(2, '0');
            var minutes = String(date.getMinutes()).padStart(2, '0');
            var seconds = String(date.getSeconds()).padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        function pollComments() {
            $.ajax({
                type: 'GET',
                url: '{{ route("comment.poll") }}',
                data: {
                    type: '{{ $type }}',
                    type_id: '{{ $type_id }}',
                    last_poll_time: lastPollTime
                },
                success: function (response) {
                    var commentHtml = response.commenthtml;
                    var newLastPollTime = response.last_poll_time;

                    // Check if new comments are available
                    if (commentHtml.length > 0) {
                        $.each(commentHtml, function (index, comment) {
                            // Prepend comment to #comment-container
                            $('#comment-container').prepend(comment.html);
                        });
                    }
                    // Update the last poll time
                    lastPollTime = newLastPollTime;

                    // Call the poll again after a delay
                    setTimeout(pollComments, 5000);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error case if needed
                }
            });
        }


        // Start polling comments and replies
        pollComments();

    });

    $(document).ready(function () {
        var lastPollTime = '{{ $lastPollTime ?? now() }}';

        function formatDate(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');
            var hours = String(date.getHours()).padStart(2, '0');
            var minutes = String(date.getMinutes()).padStart(2, '0');
            var seconds = String(date.getSeconds()).padStart(2, '0');

            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        function pollReplies() {
            $.ajax({
                type: 'GET',
                url: '{{ route("comment.replies.poll") }}',
                data: {
                    type: '{{ $type }}',
                    type_id: '{{ $type_id }}',
                    last_poll_time: lastPollTime
                },
                success: function (response) {
                    var replyHtml = response.replyhtml;
                    var newLastPollTime = response.last_poll_time;

                    // Check if new comments are available
                    if (replyHtml.length > 0) {
                        $.each(replyHtml, function (index, reply) {
                            // Prepend comment to #comment-container
                            $('#reply-container-' + reply.parent_id).append(reply.html);
                        });
                    }
                    // Update the last poll time
                    lastPollTime = newLastPollTime;

                    // Call the poll again after a delay
                    setTimeout(pollReplies, 5000);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error case if needed
                }
            });
        }
        // Start polling comments and replies
        pollReplies();
    });
</script>

@endpush
