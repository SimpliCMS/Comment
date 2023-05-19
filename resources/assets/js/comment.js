$(document).ready(function () {

var comment = '#comment-container';
        var form = '#add-comment-form';
        $(form).on('submit', function (event) {
event.preventDefault();
        var url = $(this).attr('data-action');
        $.ajax({
        url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                var row = ' <div class="card p-3 mt-3">';
                        row += ' <div class="d-flex justify-content-between align-items-center">';
                        row += ' <div class="user d-flex flex-row align-items-center">';
                        row += '<img src="" width="30" class="user-img rounded-circle mr-2">';
                        row += '<span><small class="font-weight-bold text-primary ms-2"></small> <small class="font-weight-bold"></small></span>';
                        row += '</div>
                        row += '<small></small>';
                        row += '</div>
                        row += '<div class="action d-flex justify-content-between mt-2 align-items-center">';
                        row += '<div class="reply px-4">';
                        row += '  ' + response.comment + '';
                        row += '</div>
                        row += '<div class="icons align-items-center">';
                        row += '</div>';
                        row += '</div>';
                        row += '</div>';
                        $(comment).prepend(row);
                        $(form).trigger("reset");
                },
                error: function (response) {
                }
        });
});
        });

