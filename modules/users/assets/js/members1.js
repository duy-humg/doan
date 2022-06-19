$(document).ready(function () {
    var alert_info = $('#alert_info').val();
    alert_info1 = alert_info ? JSON.parse(alert_info) : [];

    $('.src_area').change(function () {
        if ($('#others')[0].checked) {
            $('#others_collapse').slideDown(300);
        } else $('#others_collapse').slideUp();
    });

    $('.submitEditAccount').click(function () {
        if (validateEditUser()) {
            $('#frmEditAccount').submit()
        }
    });

    $('.submitChangePassword').click(function () {
        if (validateChangePass()) {
            $('#frmChangePassword').submit()
        }
    });

    $('.submitEditAddress').click(function () {
        if (validateEditAddress()) {
            $('#frmMemberAddress').submit()
        }
    });
    $('.submitNewsletter').click(function () {
        $('#frmNewsletter').submit()
    });

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=members&view=members&raw=1&task=ajax_load_order',
        data: {},
        success: function (data) {
            // var res = JSON.parse(data);
            // console.log(data);
            $('#table-order').html(data);
        }
    });

    $('#resend_code').click(function () {
        mail = $('#active1').val();
        tel = $('#active2').val();
        $('#main').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '/index.php?module=members&view=members&raw=1&task=re_send_OTP',
            data: {mail: mail, tel: tel},
            success: function ($json) {
                $('#load').remove();
                $json = JSON.parse($json);
                $html = $json.message;
                if ($json.error == false) {
                    // console.log($json);
                    $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
                    $('#reg_modal').modal('toggle');
                    $('#reg_message').html($image + '<p>'+$html+'</p>' + '<a id="a_message" data-dismiss="modal">Close</a>');
                    $('#a_message').click(function () {
                        $('#otp_code').focus();
                    });
                }
                if ($json.error == true) {
                    $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
                    $('#reg_modal').modal('toggle');
                    $('#reg_message').html($image + $html + '<a id="a_message" data-dismiss="modal">Close</a>');
                    // $("#frmRegister")[0].reset();
                    $('#a_message').click(function () {
                        $('#otp_code').focus();
                    });
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('#load').remove();
                alert('There was an error uploading to the server. Please check the connection.')
            }
        });
    });

    // $('#reg_country').click(function () {
    //     tel_code = $(this).find(':selected').attr('data-tel');
    //     $('#tel_code').val('+'+tel_code);
    // });

    $('#reg_email').blur(function () {
        if ($(this).val() != ''){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/index.php?module=members&view=members&raw=1&task=do_validate_email',
                data: {reg_email: $(this).val()},
                success: function ($json) {
                    $html = $json.message;
                    if ($json.error == true) {
                        invalid('reg_email', $json.message);
                        $('#reg_email').focus();
                    }
                    if($json.error == false){
                        valid('reg_email');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('There was an error uploading to the server. Please check the connection.')
                }
            });
        }
    });

    $('#reg_phone').blur(function () {
        var tel_code = $('#tel_code').val();
        if ($(this).val() != ''){
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/index.php?module=members&view=members&raw=1&task=do_validate_tel',
                data: {reg_tel: tel_code+$(this).val()},
                success: function ($json) {
                    $html = $json.message;
                    if ($json.error == true) {
                        invalid('reg_phone', $json.message);
                        $('#reg_phone').focus();
                    }
                    if($json.error == false){
                        valid('reg_phone');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('There was an error uploading to the server. Please check the connection.')
                }
            });
        }
    })

});

function isTel(elemid, helperMsg) {
    elem = $('#' + elemid);
    var numericExpression = /^\+?1?\s*?\(?\d{3}(?:\)|[-|\s])?\s*?\d{3}[-|\s]?\d{4}$/;
    if (elem.val().match(numericExpression)) {
        valid(elemid);
        return true;
    } else {
        invalid(elemid, helperMsg);
        return false;
    }
}

function cityValidator(elemid, helperMsg) {
    elem = $('#' + elemid);
    var val_elem = elem.val();

    if (!val_elem || val_elem.length < 2) {
        invalid(elemid, helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function lastnameValidator(elemid, helperMsg) {
    elem = $('#' + elemid);
    var val_elem = elem.val();

    if (!val_elem || val_elem.length < 2) {
        invalid(elemid, helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function nameValidator(elemid, helperMsg) {
    elem = $('#' + elemid);
    var val_elem = elem.val();

    if (!val_elem || val_elem.length < 3) {
        invalid(elemid, helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function passwordValidator(elemid, helperMsg) {
    elem = $('#' + elemid);
    var val_elem = elem.val();

    if (!val_elem || val_elem.length < 4) {
        invalid(elemid, helperMsg);
        elem.focus(); // set the focus to this input
        return false;
    } else {
        valid(elemid);
        return true;
    }
}

function confirmPassword(helperMsg) {
    elem_value = $('#new_password').val();
    elem2_value = $('#conf_password').val();

    if (elem_value != elem2_value) {
        invalid('conf_password', helperMsg);
        return false;
    } else {
        valid('new_password');
        return true;
    }
}

function validateOtp() {
    if (!notEmpty("otp_code1", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("otp_code2", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("otp_code3", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("otp_code4", alert_info1[0])) {
        return false;
    }
    var $data = $('#frmOtp').serialize();
    $('#main').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=members&view=members&raw=1&task=do_otp',
        data: $data,
        success: function ($json) {
            $('#load').remove();
            $html = $json.message;
            if ($json.error == false) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
                $(window.location).attr('href', $json.redirect);
            }
            if ($json.error == true) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
                $('#reg_modal').modal('toggle');
                $('#reg_message').html($image + $html + '<a id="a_message" data-dismiss="modal">Close</a>');
                // $("#frmRegister")[0].reset();
                $('#a_message').click(function () {
                    invalid('otp_code', $json.message);
                    $('#otp_code').focus();
                });
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#load').remove();
            alert('There was an error uploading to the server. Please check the connection.')
        }
    });
    return false;
}

function validateRegister() {
    if (!notEmpty("reg_name", alert_info1[0])) {
        return false;
    }
    if (!nameValidator("reg_name", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("reg_email", alert_info1[1])) {
        return false;
    }
    if (!emailValidator("reg_email", alert_info1[1])) {
        return false;
    }
    if (!notEmpty("reg_password", alert_info1[2])) {
        return false;
    }
    if (!passwordValidator("reg_password", alert_info1[2])) {
        return false;
    }

    if (!notEmpty("reg_country", alert_info1[4])) {
        return false;
    }

    if (!notEmpty("reg_phone", alert_info1[3])) {
        return false;
    }
    // if (!isPhone("reg_phone", alert_info1[3])) {
    //     return false;
    // }

    if (madeCheckbox("others")) {
        if (!notEmpty("reg_others", alert_info1[7])) {
            return false;
        }
    }
    if (!notEmptyCaptcha("captcha", alert_info1[5])) {
        return false;
    }
    if (!madeCheckbox("privacy", alert_info1[6])) {
        return false;
    }
    var $data = $('#frmRegister').serialize();
    $('#main').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '/index.php?module=members&view=members&raw=1&task=do_register',
        data: $data,
        success: function ($json) {
            $html = $json.message;
            if ($json.error == false) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
                // $('#reg_modal').modal('toggle');
                // $('#reg_message').html($image + $html);
                // $('#modal-login').modal('toggle');
                // $("#frmRegister")[0].reset();
                // console.log($json.redirect);
                // $(window.location).attr('href', $json.redirect);
                // console.log($json);
                $('#frmRegister').append($json.input);
                $('#frmRegister').submit();
            }
            if ($json.error == true) {
                $('#load').remove();
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
                if($json.focus == 'not_allow'){
                    $("#frmRegister")[0].reset();
                }
                $('#reg_modal').modal('toggle');
                $('#reg_message').html($image + $html + '<a id="a_message" data-dismiss="modal">Close</a>');
                // $("#frmRegister")[0].reset();
                $('#a_message').click(function () {
                    if($json.focus == 'email'){
                        invalid('reg_email', $json.message);
                        $('#reg_email').focus();
                    }
                    if($json.focus == 'telephone'){
                        invalid('reg_phone', $json.message);
                        $('#reg_phone').focus();
                    }
                })
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#load').remove();
            alert('Error sending message. Please check your phone number!');
            $('#reg_phone').focus();
        }
    });
    return false;
}

function validateLogin() {
    $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';

    if ($('#log_username').val() == '') {
        $('#log_modal').modal('toggle');
        $('#log_message').html($image + '<p>Please enter your name!</p>' + '<a data-dismiss="modal">Close</a>');
        $('#log_message>a').click(function () {
            $('#log_username').focus();
        });
        // alert('Please enter your username.');
        $('#log_username').focus();
        return false;
    }
    if ($('#log_password').val() == '') {
        $('#log_modal').modal('toggle');
        $('#log_message').html($image + '<p>Please enter your password!</p>' + '<a data-dismiss="modal">Close</a>');
        $('#log_message>a').click(function () {
            $('#log_password').focus();
        });
        // alert('Please enter your password.');
        $('#log_password').focus();
        return false;
    }

    var $data = $('form#frmLogin').serialize();

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=members&view=members&raw=1&task=do_login',
        data: $data,
        success: function (data) {
            // console.log(data);
            if (data.error == true) {
                $('#log_modal').modal('toggle');
                $('#log_message').html($image + '<p>' + data.message + '</p>' + '<a data-dismiss="modal">Close</a>');
                // alert(data.message);
            } else {
                $(window.location).attr('href', data.redirect);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('There was an error uploading to the server. Please check the connection.');
        }
    });
    return false;
}

function validateChangepass() {
    if ($('#cpassword').val() == '') {
        Boxy.alert('Bạn vui lòng nhập mật khẩu hiện tại.', function () {
            $('#cpassword').focus();
        }, {
            title: 'Thông báo.', afterShow: function () {
                $('#boxy_button_OK').focus();
            }
        });
        return false;
    }
    if ($('#password').val() == '') {
        Boxy.alert('Bạn vui lòng nhập mật khẩu mới.', function () {
            $('#password').focus();
        }, {
            title: 'Thông báo.', afterShow: function () {
                $('#boxy_button_OK').focus();
            }
        });
        return false;
    }
    if ($('#password').val() != $('#repassword').val()) {
        Boxy.alert('Bạn vui lòng nhập mật khẩu.', function () {
            $('#repassword').focus();
        }, {
            title: 'Thông báo.', afterShow: function () {
                $('#boxy_button_OK').focus();
            }
        });
        return false;
    }
    document.forms['frmChangepass'].submit();
}

function validateForgotUpdate() {
    if (!notEmpty("u_code", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("new_password", alert_info1[1])) {
        return false;
    }
    if (!passwordValidator("new_password", alert_info1[1])) {
        return false;
    }
    if (!notEmpty("conf_password", alert_info1[1])) {
        return false;
    }
    if (!passwordValidator("conf_password", alert_info1[1])) {
        return false;
    }
    if (!confirmPassword(alert_info1[2])) {
        return false;
    }
    var $data = $('form#frmUpdateForgotPass').serialize();
    $('#main').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=members&view=members&raw=1&task=do_update_forgot_pass',
        data: $data,
        success: function (data) {
            $('#load').remove();
            if(data.error == true && data.focus == 'code'){
                invalid('u_code', data.message);
                $('#u_code').focus();
            }else if(data.error == true && data.focus == 'password'){
                invalid('new_password', data.message);
                $('#new_password').focus();
            } else if(data.error == false){
                // $(window.location).attr('href', data.redirect);
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
                $('#reg_modal').modal('toggle');
                $('#reg_message').html($image + '<p>'+data.message+'</p>' + '<a href="'+data.redirect+'" id="a_message">Click here to login</a>');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#load').remove();
            alert('There was an error uploading to the server. Please check the connection.');
        }
    });
    return false;
}

function validateForgotten() {
    if (!notEmpty("email", alert_info1[1])) {
        return false;
    }
    if (!emailValidator("email", alert_info1[1])) {
        return false;
    }
    var $data = $('form#frmForgottenPassword').serialize();
    $('#main').append('<div id="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/index.php?module=members&view=members&raw=1&task=do_forgot_pass',
        data: $data,
        success: function (data) {
            $('#load').remove();
            $html = data.message;
            if (data.error == false) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
                $('#forgotten_modal').modal('toggle');
                $('#forgotten_message').html($image + $html + '<a data-dismiss="modal">Close</a>');
                $("#frmForgottenPassword")[0].reset();
            }
            if (data.error == true) {
                $image = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
                $('#forgotten_modal').modal('toggle');
                $('#forgotten_message').html($image + $html + '<a id="a_message" data-dismiss="modal">Close</a>');
                $('#a_message').click(function () {
                    invalid('email', alert_info1[1]);
                    $('#email').focus();
                })
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('#load').remove();
            alert('There was an error uploading to the server. Please check the connection.');
        }
    });
    return false;
}

function validateEditUser() {
    if (!notEmpty("first_name", alert_info1[0])) {
        return false;
    }
    if (!nameValidator("first_name", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("last_name", alert_info1[7])) {
        return false;
    }
    if (!lastnameValidator("last_name", alert_info1[7])) {
        return false;
    }
    if (!notEmpty("telephone", alert_info1[3])) {
        return false;
    }
    else {

    }
    return true;
}

function validateChangePass() {
    if (!notEmpty("curr_password", alert_info1[2])) {
        return false;
    }
    if (!passwordValidator("curr_password", alert_info1[2])) {
        return false;
    }
    if (!notEmpty("new_password", alert_info1[2])) {
        return false;
    }
    if (!passwordValidator("new_password", alert_info1[2])) {
        return false;
    }
    if (!notEmpty("conf_password", alert_info1[2])) {
        return false;
    }
    if (!passwordValidator("conf_password", alert_info1[2])) {
        return false;
    }
    if (!confirmPassword(alert_info1[7])) {
        return false;
    }
    else {

    }
    return true;
}

function validateEditAddress() {
    if (!notEmpty("first_name", alert_info1[0])) {
        return false;
    }
    if (!nameValidator("first_name", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("last_name", alert_info1[0])) {
        return false;
    }
    if (!nameValidator("last_name", alert_info1[0])) {
        return false;
    }
    if (!notEmpty("add1", alert_info1[8])) {
        return false;
    }
    if (!nameValidator("add1", alert_info1[8])) {
        return false;
    }
    if (!notEmpty("country", alert_info1[4])) {
        return false;
    }
    if (!notEmpty("telephone", alert_info1[3])) {
        return false;
    }
    // if (!isTel("telephone", alert_info1[3])) {
    //     return false;
    // }
    if (!notEmpty("city", alert_info1[9])) {
        return false;
    }
    if (!cityValidator("city", alert_info1[9])) {
        return false;
    }
    
    // if (!notEmpty("region", alert_info1[10])) {
    //     return false;
    // }
    // if (!cityValidator("region", alert_info1[10])) {
    //     return false;
    // }
    if (!notEmpty("post", alert_info1[11])) {
        return false;
    }
    else {

    }
    return true;
}

$('#city_id').change(function () {
    setSelectDistricts($('#district_id'), $(this).val(), 0);
});

$(document).ready(function () {
    $('#submit_FormContact').click(function () {
        var submit = 'frmContact';

        if (checkFormsubmit2())
            document.getElementById(submit).submit();

    });
    $('#frmRegister').keypress(function (e) {
        if (e.which == 13) {
            validateRegister();
            return false;
        }
    });

    $('#frmLogin').keypress(function (e) {
        if (e.which == 13) {
            validateLogin();
            return false;
        }
    });

    if ($('.datepicker').length)
        $('.datepicker').datepicker({
            showOn: 'button',
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            buttonImage: '/templates/default/scss/images/ui-icon-calendar.png'
        });

    if ($('select#district_id').length)
        setSelectDistricts($('#district_id'), $('#city_id').val(), $('#district_id').attr('data-id'));
});


$(document).on('click', '.other-page, .next-page, .pre-page, .last-page, .first-page', function(e) {
    let page = $(this).attr("data-page");
    // console.log(id);
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=members&view=members&raw=1&task=ajax_load_order',
        data: 'page=${page}',
        success: function (data) {
            // let res = JSON.parse(data);
            // console.log(data);
            $("#table-order").html(data)
        }
    })
});

function load_region($country_id,$total_quantity,$address_id) {
    var price_total = parseInt($('#price_before_ship').val());

    $.ajax({
        type: 'get',
        url: '/index.php?module=products&view=cart&raw=1&task=ajax_load_region',
        dataType: 'JSON',
        data: {country_id: $country_id, price_total:price_total, total_quantity : $total_quantity},
        success: function (data) {
            // console.log(data);
            price_total = data.price_by_country + price_total;
            // $('#price_total').val(price_total)
            $('.price_total').html(price_total)
            $('#price_by_country').val(data.price_by_country)
            $('.price_by_country').val(data.price_by_country_format)
            // console.log(price_total)
            $("#region").html(data);
            showOption(data.region)
            return true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
    return false;
}

function showOption(region) {
    console.table(region)
    var option = '';

    region.forEach(item => {
        option += `<option data-id="${item.id}" value="${item.id}">${item.name}</option>`
    });

    $("#region").html(option);

}

function setDefault(uid,id) {
    link = 'address-book.html';
    $.ajax({
        type: 'get',
        url: '/index.php?module=members&view=members&raw=1&task=ajax_change_default_add',
        dataType: 'JSON',
        data: {userID: uid, addID:id},
        success: function (data) {
            window.location.href=link;
            return true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
}