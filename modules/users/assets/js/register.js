$(document).ready(function () {
    // del_his();

    check_re_pass();
    check_exist_email();
    check_exist_phone();
    // check_exist_username();

    $('#submit_dk').click(function () {
        if (checkFormsubmit()) {
            // $('.preloader').show();
            document.register_form_user.submit();
        }

    })

    //   ajax load district
    $("select#city_id").change(function () {
        $.ajax({
            url: "/index.php?module=members&view=edit&task=ajax_get_district&raw=1",
            data: {
                cid: $(this).val()
            },
            dataType: "text",
            success: function (text) {
                j = eval("(" + text + ")");
                var options = '';
                options += '<option value="">Chọn quận huyện<option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].id + '">&nbsp;&nbsp;&nbsp;' + j[i].name + '</option>';
                }
                $("#district_id").html(options);
                $("#district_id").removeAttr('disabled');
                $("#district_id").trigger("chosen:updated");
                //$('#district_id option:first').attr('selected', 'selected');
                // elemnent_fisrt = $('#district_id option:first').val();
            }
        });
    });

    var info_register = $('#login_register').val();
    array_info = info_register ? JSON.parse(info_register) : [];

});

function del_his() {
    $('form[autocomplete="off"] input').each(function () {

        var input = this;
        var name = $(input).attr('name');
        var id = $(input).attr('id');

        $(input).removeAttr('name');
        $(input).removeAttr('id');

        setTimeout(function () {
            $(input).attr('name', name);
            $(input).attr('id', id);
        }, 1);
    });
}
function checkFormsubmit() {
    // $('.label_error').remove();
    $('label.label_error').prev().remove();
    $('label.label_error').remove();

    // if(!notEmpty("username", array_info[0])){
    //    scrollTop('#username');
    // 	return false;
    // }
    // if(!lengthYear("username",3,20, array_info[1])){
    //     scrollTop('#username');
    // 	return false;
    // }
    if (!notEmpty("dk_ho", "Bạn chưa nhập họ")) {
        scrollTop('#dk_ho');
        return false;
    }
    if (!notEmpty("dk_name", "Bạn chưa nhập tên")) {
        scrollTop('#dk_name');
        return false;
    }
    // if (!number_name("dk_name", "Bạn không được dùng số và các ký tự đặc biệt")) {
    //     scrollTop('#dk_name');
    //     return false;
    // }

    // if (!notEmpty("email", array_info[12])) {
    //     scrollTop('#email');
    //     return false;
    // }
    // if (!emailValidator("email", array_info[18])) {
    //     scrollTop('#email');
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
    if (!notEmpty("dk_mail", "Bạn phải nhập email")) {
        scrollTop('#dk_mail');
        return false;
    }
    if (!emailValidator("dk_mail", "Email không đúng định dạng")) {
        scrollTop('#dk_mail');
        return false;
    }
    // if(!lengthYear("dk_phone",9,12, "Bạn phải nhập tối thiểu 10 số và tối đa 11 số")){
    //     scrollTop('#dk_phone');
    // 	return false;
    // }
    if (!notEmpty2("dk_password", "password", "Bạn chưa nhập password")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!lengthMin("dk_password", 8, "Mật khẩu phải từ 8-32 kí tự, bao gồm cả chữ in hoa và số")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!uppercase('dk_password', "Mật khẩu phải từ 8-32 kí tự, bao gồm cả chữ in hoa và số")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!number_pass('dk_password', "Mật khẩu phải từ 8-32 kí tự, bao gồm cả chữ in hoa và số")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!checkMatchPass_2("dk_password", "re_password", "Password bạn nhập không khớp")) {
        scrollTop('#re_password');
        return false;
    }
    // if ($('#rules').is(':checked')) {
    //     return true;
    // } else {
    //     alert('Vui lòng đồng ý với điều khoản của chúng tôi, cảm ơn!')
    //     return false;
    // }
    // if ($('#security').is(':checked')) {
    //     return true;
    // } else {
    //     alert('Vui lòng đồng ý với chính sách bảo vệ thông tin cá nhân của chúng tôi, cảm ơn!')
    //     return false;
    // }
    if (!madeCheckbox("agree", "Bạn cần đồng ý với điều khoản của chúng tôi")) {
        return false;
    }
    if (!madeCheckbox("security", "Bạn cần đồng ý với chính sách bảo vệ thông tin cá nhân của chúng tôi")) {
        return false;
    }
    //   if(!lengthMin("full_name",6, array_info[6]))
    // {
    //    scrollTop('#full_name');
    // 	return false;
    // }
    // if($("#birth_day option:selected").val() == '0'){
    // 	invalid("birth_day", array_info[7]);
    // 	scrollTop('#birth_day');
    // 	return false;
    // }
    // if($("#birth_month option:selected").val() == '0'){
    // 	invalid("birth_month", array_info[8] );
    // 	scrollTop('#birth_month');
    // 	return false;
    // }
    // if($("#birth_year option:selected").val() == '0'){
    // 	invalid("birth_year", array_info[9] );
    // 	scrollTop('#birth_year');
    // 	return false;
    // }
    // if(!notEmpty("telephone", array_info[10])){
    //    scrollTop('#telephone');
    // 	return false;
    // }
    // if(!isPhone("telephone", array_info[11])){
    //    scrollTop('#telephone');
    // 	return false;
    // }
    // if(!lengthYear("telephone",9,12, array_info[15])){
    //     scrollTop('#telephone');
    // 	return false;
    // }
    // if(!notEmpty("number_cmnd","Hãy nhập Số CMND")){
    //    scrollTop('#number_cmnd');
    // 	return false;
    // }
    // if(!isPhone("number_cmnd","Bạn phải nhập CMND dạng số")){
    //    scrollTop('#number_cmnd');
    // 	return false;
    // }

    // if($("#city_id option:selected").val() == '0'){
    // 	invalid("city_id", array_info[24]);
    // 	scrollTop('#city_id');
    // 	return false;
    // }
    // if($("#district_id option:selected").val() == '0'){
    // 	invalid("district_id", array_info[25] );
    // 	scrollTop('#district_id');
    // 	return false;
    // }
    // if(!notEmpty("address", array_info[14])){
    //    scrollTop('#address');
    // 	return false;
    // }

    // if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị")){
    //    scrollTop('#txtCaptcha');
    //       return false;
    // }

    // $.ajax({url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
    // 	data: {txtCaptcha: $('#txtCaptcha').val()},
    // 	dataType: "text",
    // 	async: false,
    // 	success: function(result) {
    // 		console.log(result);
    // 		if(result == 0){
    // 			invalid('txtCaptcha','Bạn nhập sai mã hiển thị');
    // 			console.log('--------');
    // 			return false;
    // 		} else {
    // 			valid('txtCaptcha');
    // 			console.log('+++');
    // 				document.formSignUp.submit();
    // 			return true;
    // 		}
    // 	}
    // });
    // document.formSeekerSignUp.submit();
    return true;
    // return false;
}

function scrollTop(name) {
    if (!name)
        return false;
    $(name).focus();
    //var top_ = $(name).position().top;
    var offset = $(name).offset();
    $('html, body').animate({
        scrollTop: offset.top
    }, 'slow');
}

/* CHECK EXIST PASSWORD  */
function check_exist_password() {
    $('#dk_password').blur(function () {
        if ($(this).val() != '') {

            if (!notEmpty2("dk_password", "password", array_info[2])) {
                scrollTop('#dk_password');
                return false;
            }
            if (!lengthMin("dk_password", 8, array_info[3])) {
                scrollTop('#dk_password');
                return false;
            }
            if (!uppercase('dk_password', array_info[3])) {
                scrollTop('#dk_password');
                return false;
            }
            if (!number_pass('dk_password', array_info[3])) {
                scrollTop('#dk_password');
                return false;
            } else {
                valid('dk_password');
                $('<div class=\'label_success \'>' + array_info[21] + '</div>').insertAfter($('#dk_password').parent().children(':last'));
            }
        } else {
            valid('dk_password');
            $('<div class=\'label_success hide \'>' + array_info[21] + '</div>').insertAfter($('#dk_password').parent().children(':last'));
        }
    });
    $('#re_password').blur(function () {
        if ($(this).val() != '') {
            if (!checkMatchPass_2("password", "re_password", array_info[4])) {
                scrollTop('#re_password');
                return false;
            } else {
                valid('re_password');
                $('<div class=\'label_success \'>' + array_info[22] + '</div>').insertAfter($('#re_password').parent().children(':last'));
            }
        } else {
            valid('password');
            $('<div class=\'label_success hide \'>' + array_info[21] + '</div>').insertAfter($('#password').parent().children(':last'));
        }
    });

    $('#full_name').blur(function () {
        if ($(this).val() != '') {
            if (!notEmpty("full_name", array_info[5])) {
                scrollTop('#full_name');
                return false;
            }
            if (!number_name("full_name", array_info[23])) {
                scrollTop('#full_name');
                return false;
            }
            if (!number_name2("full_name", array_info[23])) {
                scrollTop('#full_name');
                return false;
            }
        } else {
            valid('full_name');
            $('<div class=\'label_success hide \'>' + array_info[21] + '</div>').insertAfter($('#full_name').parent().children(':last'));
        }
    });
};
function check_re_pass(){
    $('#re_password').blur(function(){
        if($(this).val() != $('#dk_password').val()){
            invalid('re_password');
            $('.label_error').remove();
            $('.label_success').remove();
            $('<div class=\'label_error\'>'+'Mật khẩu không khớp. vui lòng nhập lại'+'</div>').insertAfter($('#re_password').parent().children(':last'));

        }else {
            valid('re_password');
            $('.label_error').remove();
            $('.label_success').remove();
            $('<div class=\'label_success\'>'+'Khớp mật khẩu'+'</div>').insertAfter($('#re_password').parent().children(':last'));
        }
    });
}
/* CHECK EXIST USERNAME  */
// function check_exist_username(){
// 	$('#username').blur(function(){
// 		if($(this).val() != ''){
//
// 			if(!lengthYear("username",3,20, array_info[1]))
// 				return false;
//
// 			$.ajax({url:"/index.php?module=members&view=register&task=ajax_check_exits_username&raw=1",
// 				data: {username: $(this).val()},
// 				dataType : "text",
// 				success: function(result) {
// 					  if(result == 0){
// 					  		invalid('username', array_info[16]);
// 					  } else {
// 						  valid('username');
// 						  $('<div class=\'label_success \'>'+array_info[17]+'</div>').insertAfter($('#username').parent().children(':last'));
// 					  }
// 				  }
// 			});
// 		}
// 	});
// };
/* CHECK EXIST EMAIL  */
function check_exist_email() {
    $('#dk_mail').blur(function () {
        if ($(this).val() != '') {

            if (!emailValidator("dk_mail", "Email không đúng định dạng"))
                return false;
            $.ajax({
                url: "/index.php?module=users&task=ajax_check_exist_email&raw=1",
                data: {email_register: $(this).val()},
                dataType: "text",
                success: function (result) {
                    if (result == 0) {
                        invalid('dk_mail', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');
                    } else {
                        valid('dk_mail');
                        $('<div class=\'label_success \'>Email này được chấp nhận</div>').insertAfter($('#dk_mail').parent().children(':last'));
                    }

                }
            });
        }
    });
    // $('#telephone').blur(function () {
    //     if ($(this).val() != '') {
    //         if (!notEmpty("telephone", array_info[10])) {
    //             scrollTop('#telephone');
    //             return false;
    //         }
    //         if (!isPhone("telephone", array_info[11])) {
    //             scrollTop('#telephone');
    //             return false;
    //         }
    //         if (!lengthYear("telephone", 9, 12, array_info[15])) {
    //             scrollTop('#telephone');
    //             return false;
    //         }
    //     } else {
    //         valid('telephone');
    //         $('<div class=\'label_success hide \'>' + array_info[21] + '</div>').insertAfter($('#telephone').parent().children(':last'));
    //     }
    // });
    // $('#number_cmnd').blur(function () {
    //     if ($(this).val() != '') {
    //         if (!isPhone("number_cmnd", array_info[11])) {
    //             scrollTop('#number_cmnd');
    //             return false;
    //         }
    //     } else {
    //         valid('number_cmnd');
    //         $('<div class=\'label_success hide \'>' + array_info[21] + '</div>').insertAfter($('#number_cmnd').parent().children(':last'));
    //     }
    // });
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

jQuery(function ($) {
    $('#username').keyup(function (e) {
        var alert_info = $('#login_register').val();
        alert_info = alert_info ? JSON.parse(alert_info) : [];
        var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
        var str = $(this).val();
        if (!characterReg.test(str)) {
            invalid("username", alert_info[26]);
            str = removeDiacritics(str);
            $(this).val(str);
            return false;
        }
        if (e.which === 32) {
            //alert('No space are allowed in usernames');
            invalid("username", alert_info[27]);
            str = str.replace(/\s/g, '');
            $(this).val(str);
            return false;
        }
        var characterReg2 = /^([a-zA-Z0-9]{4,20})$/;
        if (!characterReg2.test(str)) {
            invalid("username", alert_info[1]);
            str = removeDiacritics(str);
            str = str.replace(/\s/g, '');
            $(this).val(str);
            return false;
        } else {
            valid("username", alert_info[17]);
            str = removeDiacritics(str);
            str = str.replace(/\s/g, '');
            $(this).val(str);
        }
    }).blur(function () {
        var str = $(this).val();
        str = removeDiacritics(str);
        str = str.replace(/\s/g, '');
        $(this).val(str);
        if (str.length == 0) {
            $('.label_error').hide();
        }
    });
});

function removeDiacritics(input) {
    var output = "";
    var normalized = input.normalize("NFD");
    var i = 0;
    var j = 0;
    while (i < input.length) {
        output += normalized[j];

        j += (input[i] == normalized[j]) ? 1 : 2;
        i++;
    }
    return output;
}