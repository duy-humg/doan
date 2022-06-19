$(document).ready(function () {
    /* FORM CONTACT */
    $('#submitbt').click(function () {
        if (checker()) {
            document.contact.submit();
        }
    });


    // $('#resetbt').click(function () {
    //     document.contact.reset();
    // })

    // $('a.open-switcher').click(function () {
    //     var switchParent = $('#right');
    //     if (!switchParent.hasClass('active')) {
    //         switchParent.addClass('active');
    //         $('a.open-switcher').addClass('active');
    //
    //     } else {
    //         switchParent.removeClass('active');
    //         $('a.open-switcher').removeClass('active');
    //         $('#right').css({'height': ($('.right-ct').height()) + 50});
    //     }
    // });

});

function checker() {

    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

    if (!notEmpty("contact_name", "Bạn chưa nhập họ và tên")) {
        return false;
    }
    if (!lengthMin("contact_name", 6, '"Họ tên của bạn" phải 6 kí tự trở lên, vui lòng sửa lại!')) {
        return false;
    }


    if (!notEmpty("gender", "Bạn chưa chọn giới tính")) {
        return false;
    }

    if (!notEmpty("birth_year", "Bạn chưa chọn năm sinh")) {
        return false;
    }

    if (!notEmpty("job", "Bạn chưa nhập nghề nghiệp")) {
        return false;
    }

    if (!notEmpty("phone", "Bạn chưa nhập số điện thoại."))
        return false;

    if (!isPhone("phone", "Số điện thoại không đúng."))
        return false;

    if (!lengthMin("phone", 8, 'Số điện thoại không đúng.')) {
        return false;
    }
    if (!lengthMax("phone", 11, 'Số điện thoại không đúng.')) {
        return false;
    }
    if (!notEmpty("email", "Bạn chưa nhập Email."))
        return false;
    if (!notEmpty("email", "Bạn chưa nhập Email")) {

        if (!emailValidator("email", "Emal không đúng định dạng")) {
            return false;
        }
    }

    if (!notEmpty("city_id", "Bạn chưa chọn tỉnh/thành phố")) {
        return false;
    }

    if (!notEmpty("home_district", "Bạn chưa chọn quận/huyện")) {
        return false;
    }

    if (!notEmpty("txtCaptcha", "Nhập mã xác minh"))
        return false;

    // $('#submitbt').removeClass('submitbt');
    // $('#submitbt').remove();

    // $.ajax({
    //     url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
    //     data: {txtCaptcha: $('#txtCaptcha').val()},
    //     dataType: "text",
    //     async: false,
    //     success: function (data) {
    //         console.log(data);
    //         $('label.username_check').prev().remove();
    //         $('label.username_check').remove();
    //         if (data == '0') {
    //             invalid('txtCaptcha', 'Captcha là không chính xác.');
    //             //alert('Captcha is incorrect');
    //             //console.log('--------');
    //             return false;
    //         } else {
    //             valid('txtCaptcha');
    //             console.log('+++');
    //             document.contact.submit();
    //             return true;
    //
    //         }
    //     }
    // });
    return true;
}

function checkFormsubmit() {
    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

    alert('is here');
    // return false;
    if (!notEmpty("contact_name", "Bạn chưa nhập họ và tên")) {
        return false;
    }
    if (!lengthMin("contact_name", 6, '"Họ tên của bạn" phải 6 kí tự trở lên, vui lòng sửa lại!')) {
        return false;
    }
    if (!notEmpty("gender", "Bạn chưa chọn giới tính")) {
        return false;
    }

    if (!notEmpty("birth_year", "Bạn chưa chọn năm sinh")) {
        return false;
    }

    if (!notEmpty("iob", "Bạn chưa nhập nghề nghiệp")) {
        return false;
    }

    if (!notEmpty("phone", "Bạn chưa nhập số điện thoại."))
        return false;

    if (!isPhone("phone", "Số điện thoại không đúng."))
        return false;

    if (!lengthMin("phone", 8, 'Số điện thoại không đúng.')) {
        return false;
    }
    if (!lengthMax("phone", 11, 'Số điện thoại không đúng.')) {
        return false;
    }

    if (notEmpty("email", "Bạn chưa nhập Email")) {

        if (!emailValidator("email", "Emal không đúng định dạng")) {
            return false;
        }
    } else {

    }



    if (!notEmpty("iob", "Bạn chưa chọn tỉnh/thành phố")) {
        return false;
    }

    if (!notEmpty("iob", "Bạn chưa chọn quận/huyện")) {
        return false;
    }



    if (!notEmpty("txtCaptcha", "Nhập mã xác minh"))
        return false;


    $.ajax({
        url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
        data: {txtCaptcha: $('#txtCaptcha').val()},
        dataType: "text",
        async: false,
        success: function (data) {
            console.log(data);
            $('label.username_check').prev().remove();
            $('label.username_check').remove();
            if (data == '0') {
                invalid('txtCaptcha', 'Captcha là không chính xác.');
                //alert('Captcha is incorrect');
                //console.log('--------');
                return false;
            } else {
                valid('txtCaptcha');
                console.log('+++');
                document.contact.submit();
                return true;
            }
        }
    });
}

$("#city_id").change(function () {
    $.ajax({
        url: "index.php?module=users&view=users&task=ajax_get_districs&raw=1",
        type: 'GET',
        data: {cities_id: $(this).val()},
        dataType: 'html',
        success: function ($html) {
            $("#home_district").html($html);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
});