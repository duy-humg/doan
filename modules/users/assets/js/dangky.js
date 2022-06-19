$(document).ready(function () {
    // del_his();

;
    check_exist_phone();
    // check_exist_username();

    $('#submit_dk').click(function () {
        if (checkFormsubmit()) {
            // $('.preloader').show();
            document.register_form_user.submit();
        }

    })

    
    var info_register = $('#login_register').val();
    array_info = info_register ? JSON.parse(info_register) : [];

});

function checkFormsubmit() {
    
    $('label.label_error').prev().remove();
    $('label.label_error').remove();

  
    if (!notEmpty("dk_phone", "Hãy nhập Số điện thoại")) {
        scrollTop('#dk_phone');
        return false;
    }
    if (!isPhone("dk_phone", "Bạn phải nhập dạng số")) {
        scrollTop('#dk_phone');
        return false;
    }
    if (!lengthRestriction("dk_phone", "10", "12",  'Vui lòng nhập từ  10 đến 12 số')) {
        return false;
    }

    return true;
    // return false;
}

function check_exist_phone(){
    // alert(1);
    $('#dk_phone').blur(function(){
        if($(this).val() != ''){
            // if(!emailValidator("dk_phone","Số điện thoại không đúng định dạng ")){
            //     return false;
            // }
            if (!notEmpty("dk_phone", "Hãy nhập Số điện thoại")) {
                scrollTop('#dk_phone');
                return false;
            }
            if (!isPhone("dk_phone", "Bạn phải nhập dạng số")) {
                scrollTop('#dk_phone');
                return false;
            }
            if (!lengthRestriction("dk_phone", "10", "12",  'Vui lòng nhập từ  10 đến 12 số')) {
                return false;
            }
            $.ajax({
                type: "POST",
                data: {phone_register: $('#dk_phone').val()},
                url: root+"index.php?module=users&task=ajax_check_exist_phone&raw=1",
                success: function(result) {
                    if(result == 0){
                        // invalid('dk_email');
                        $('.label_error').remove();
                        $('.label_success').remove();
                        $('<div class=\'label_error\'>'+'Số điện thoại này đã tồn tại hoặc không đúng. Bạn hãy sử dụng tên truy cập khác'+'</div>').insertAfter($('#dk_phone').parent().children(':last'));
                    } else {
                        // valid('dk_email');
                        $('.label_error').remove();
                        $('.label_success').remove();
                        $('<div class=\'label_success\'>'+'Số điện thoại này được chấp nhận'+'</div>').insertAfter($('#dk_phone').parent().children(':last'));
                    }
                }
            });
        }
    });
}
