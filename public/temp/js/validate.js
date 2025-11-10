// Click để xóa các thông báo đỏ của check dữ liệu
$('form .input-field').each(function () {
    $(this).click(function () {
        $(this).parent().find('.helper').remove();
        $(this).removeClass('input-error'); //
    })
})

// Prevent click events within the form from triggering the body click event
$('body form').on('click', function(e) {
    e.stopPropagation();
});

// Kiểm tra dữ liệu đầu vào đã nhập hay chưa ?

  // --------------------------- COMMENT ------------------------ //
$('#comment_area form button[type="submit"]').on('click', function(e){
    e.preventDefault();
    let form = $(this).closest('form');
    let formID = form.attr('id');
    let formAction = form.data('action'); // Lấy route action từ thuộc tính data-action
    if(validateForm(`#${formID}`)) {
        let formData = form.serialize(); // được sử dụng khi bạn muốn gửi dữ liệu của form dưới dạng chuỗi để thực hiện các yêu cầu HTTP như POST hoặc GET.
        $.ajax({
            type: "POST",
            url: formAction, // Sử dụng route action tương ứng của form
            data: formData,
            success: function(response) {
                toastr.success('Đã gửi bình luận!', 'Thông báo');
                // Xóa Các Dữ liệu cũ trong các ô Input
                $(`#${formID} input[type=text], #${formID} input[type=email], #${formID} textarea`).val('');
                // Gọi hàm hiển thị Comment ra HTML
                var dataId = $('#'+formID+' .boxCommentFormReplyID ').attr('id');
                if (formID === 'boxCommentForm') {
                    appendNewComment(response, 'comment-list');
                } else if (formID === 'boxCommentFormReply_'+dataId) {
                    appendNewComment(response, 'comment-list__child-'+dataId);
                }
            },
            error: function() {
                toastr.error('Lỗi bình luận!', 'Thông báo');
            }
        });
    }
});

//    Load thêm Bình luận
// Xử lý khi nhấn nút "Xem thêm bình luận"
$('#load-more-comments-btn').on('click', function() {
    var product_id = $(this).data('doc-id');
    var offset = $('#list-comment__data').data('comment-limit');
    var loadMoreCommentsCount = $('#list-comment__data').data('load-more');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/load-comments',
        type: 'GET',
        data: {
            product_id: product_id,
            offset: offset,
            loadMoreCommentsCount: loadMoreCommentsCount
        },
        success: function(response) {
            var comments = response.comments;
            if (comments.length > 0) {
                comments.forEach(function(comment) {
                    var formattedDateTime = new Date(comment.created_at).toLocaleString('en-US', { timeZone: 'UTC' });
                    // Tạo HTML cho mỗi bình luận
                    var newCommentHTML = `
                        <div class="comment-user" data-comment-index="${comment.index}">
                            <div class="comments-users d-flex mb-4">
                                <div class="comment-avata d-flex align-items-center justify-content-center mr-3">
                                     <img width="50" height="50" class="rounded-circle" src="/temp/images/avatars/${comment.avatar}" alt="Avatar">
                                 </div>
                                <div class="comment-user-info text-left w-100">
                                    <div class="comment-user-info text-left w-100-item">
                                        <a href="">${comment.name}</a>
                                    </div>
                                    <div class="comment-user-info text-left w-100-item">
                                        <i class="fa-solid fa-calendar-days "></i>
                                        <span>${formattedDateTime}</span>
                                    </div>
                                    <div class="comment-user-info text-left w-100-item">
                                        <p class="comment-user-desc m-0 mt-3">${comment.comment}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                    // Chèn HTML của bình luận vào danh sách bình luận
                    if (comment.parent_comment_id == null) {
                        // Nếu là bình luận cha, chèn vào cuối danh sách
                        $('.comment-list').append(newCommentHTML);
                    } else {
                        // Nếu là bình luận con, tìm bình luận cha tương ứng và chèn vào dưới
                        var parentComment = $(`.comment-user[data-id="${comment.parent_comment_id}"]`);
                        parentComment.find('.reply-box').append(newCommentHTML);
                    }
                });
                offset += comments.length;
                $('#list-comment__data').data('comment-limit', offset);

                // Kiểm tra nếu không còn comment mới, ẩn nút "hiển thị thêm bình luận"
                if (comments.length < loadMoreCommentsCount) {
                    $('#load-more-comments-btn').hide();
                }
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

// Kiểm tra dữ liệu đầu vào đã nhập hay chưa ?
function validateForm(formID) {
    let checkValid = true;
    $(formID).find('.input-field').each(function(){
        let value = $(this).val();
        let fieldType = $(this).attr('type'); // Get input field type
        $(this).removeClass('input-error'); // Remove input-error class
        // Check if the field is an email input and validate the format
        if (fieldType == 'email' && value !== '') {
            if (!isValidEmail(value)) {
                checkValid = false;
                $(this).addClass('input-error');
                let emailAlert = `<span class="helper text-danger" style="z-index: 999;margin-top: 75px;">Chưa nhập đúng kiểu email</span>`;
                $(this).parent().append(emailAlert);
            }
        }
        if (value == null || value == '' || value == undefined) {
            let $input = $(this);
            checkValid = false;
            // Kiểm tra xem có thẻ span báo lỗi chưa
            if (!$input.next('.helper.text-danger').length) {
                // Thêm thẻ span báo lỗi
                let htmlAlert = `<span class="helper text-danger" style="z-index: 999;margin-top: 75px;">${$input.data('require')}</span>`;
                $input.parent().append(htmlAlert);
            }
            if(!$input.hasClass('input-error')){
                $input.addClass('input-error');
            }
        }
    });
    return checkValid;
}

// Check xem có đúng kiểu Email khi nhập vào không ?
function isValidEmail(email) {
    // Basic email format validation using regular expression
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

//    HIỂN THỊ COMMENT
    function appendNewComment(commentData, targetList) {
        var avatar = $('.my-avatar').attr('src');
        var currentDate = new Date();
        var hours = currentDate.getHours();
        var minutes = currentDate.getMinutes();
        var seconds = currentDate.getSeconds();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1; // Tháng trong JavaScript bắt đầu từ 0
        var year = currentDate.getFullYear();
        var newComment = $('<div class="comments-users d-flex mb-4">' +
            '<div class="comment-avata d-flex align-items-center justify-content-center mr-3">' +
            '<img width="50" height="50" class="rounded-circle" src="' + avatar + '" alt="Avatar">' +
            '</div>' +
            '<div class="comment-user-info text-left w-100">' +
            '<div class="comment-user-info text-left w-100-item">' +
            '<a href="">' + commentData.user_name + '</a>' +
            '</div>' +
            '<div class="comment-user-info text-left w-100-item">' +
            '<i class="fa-solid fa-calendar-days me-1"></i>' +
            '<span>' + year + '-' + month + '-' + day +' ' + hours + ':' + minutes +':' + seconds + '</span>' +
            '</div>' +
            '<div class="comment-user-info text-left w-100-item">' +
            '<p class="comment-user-desc m-0 mt-3">' +
            commentData.comment +
            '</p>' +
            '</div>' +
            '<div class="reply">' +
            '<form id="boxCommentFormReply_' + commentData.id + '" class="comment-box child d-none bg-white p-3" data-action="http://productmanage.test/sendComment">' +
            '<p id="' + commentData.id + '" class="boxCommentFormReplyID d-none"></p>' +
            '<input type="hidden" name="_token" value="jmbwntWbDWzOKRBaCsvOPJtXzjTKp4tLhDcCXkq1" autocomplete="off">' +
            '<input type="hidden" name="product" value="59">' +
            '<input type="hidden" name="parent_comment_id" value="' + commentData.id + '">' +
            '<div class="d-flex">' +
            '<div class="comment-avata d-flex align-items-center justify-content-center mr-2">' +
            '<img width="50" height="50" class="rounded-circle" src="' + avatar + '" alt="Avatar">' +
            '</div>' +
            '<div class="form-comment w-100">' +
            '<textarea name="comment" class="input-field textarea-note w-100 p-3" rows="3" placeholder="Nhập bình luận *" data-require="Vui lòng nhập nội dung!"></textarea>' +
            '</div>' +
            '</div>' +
            '<button type="submit" class="send-comment float-right btn btn-primary">Gửi bình luận</button>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>');

        // Thêm bình luận vào thể có class " comment-list "
        $(`.${targetList}`).prepend(newComment);
    }

// Chức năng Bấm vào " Trả lời " thì hiển form bình luận
$('.reply-text__link').on('click', function(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
    // Ẩn tất cả các form trả lời hiện có
    $('.comment-box.child').addClass('d-none');

    // Hiển thị form trả lời tương ứng với liên kết được click
    var commentBox = $(this).closest('.comment-user').find('.comment-box.child');
    commentBox.removeClass('d-none');
});
