/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#submit_login').click(function () {
        if (checkFormsubmit())
            document.login_form.submit();
    });

    $('.login_form').keypress(function (e) {
        if (e.which == 13) {
            if (checkFormsubmit())
                document.login_form.submit();
        }
    });
});

function checkFormsubmit()
{

    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

    if (!notEmpty2("user_username", "Nhập username", "Bạn chưa nhập tên đăng nhập"))
    {
        return false;
    }

    if (!notEmpty2("user_password", "password", "Bạn chưa nhập password"))
    {
        return false;
    }
    
    return true;
}
function validateForgot() {

    if ($('#username').val() == '') {
        alert('Bạn vui lòng nhập tên đăng nhập hoặc email.');
        $('#username').focus();

        return false;
    }

    var $data = $('form#frm_forget_pass').submit();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=users&view=users&raw=1&task=forget_save',
        data: $data,
        success: function (data) {
            console.log(data);
//            Boxy.alert(data.message, function () {
            if (data.error == false) {
                alert('Yêu cầu đã được gửi đi. Vui lòng kiểm tra email để thực hiện bước tiếp theo.');
                $(window.location).attr('href', data.redirect);
            }
//            }, {title: 'Thông báo.', afterShow: function () {
//                    $('#boxy_button_OK').focus();
//                }});
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
//            Boxy.alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.', function () {
//            }, {title: 'Thông báo.', afterShow: function () {
//                    $('#boxy_button_OK').focus();
//                }});
        }
    });
    return false;
}