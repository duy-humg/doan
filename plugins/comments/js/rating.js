submit_comment();

function submit_comment() {
    // $('#submitbt').click(function(){
    // 	if(!notEmpty("name","Bạn phải nhập tên"))
    // 		return false;
    // 	if(!notEmpty("text","Bạn phải nhập nội dung"))
    // 		return false;
    //
    // });

}

function check_login($value) {
    if ($value == 0) {
        alert("Bạn phải đăng nhập thì mới được sử dụng chức năng này.");
        $("#comment_form").addClass("hide");
        return;
    } else if ($value == 1) {
        $("#comment_form").removeClass("hide");
        return;
    }
}

$(document).ready(function () {
    $('.star-detail').raty({
        halfShow: true,
        readOnly: true,
        score: function () {
            return $(this).attr('data-rating');
        },
        starOff: '/images/star-empty.png',
        starOn: '/images/star-fill.png',
    });
    // $('.item-comment .star-detail').raty({
    //     // halfShow: true,
    //     readOnly: true,
    //     score: function () {
    //         return $(this).attr('data-rating');
    //     },
    //
    //     starOff: '/images/star-empty.png',
    //     starOn: '/images/star-fill.png',
    //     // starHalf: '/images/star-half.png',
    // });


//cau hinh danh gia chat luong
    $('.rating-value').raty({

        starOff: 'images/star-empty.png',
        starOn: 'images/star-fill.png',
        cancel: false,

    });
})

