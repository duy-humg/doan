function validateOtp() {
    if (checkFormsubmit()) {
        // $('.preloader').show();
        document.thiet_lap.submit();
    }
   
}

$(document).ready(function () {
    
    $("#dk_password").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{1}$/;
        if (regex_phone.test(value)) {
            $('.label_error').css("display",'block');
        }else{
            $('.label_error').css("display",'none');
            $('.label_error').css("display",'none');
        };
    });

    const myTimeout = setTimeout(myGreeting, 60000);

    function myGreeting() {
        $('.p-2-code').css("display",'block');
        $('.p-time-count').css("display",'none');
    }
        
});

function checkFormsubmit() {
    // $('.label_error').remove();
    $('label.label_error').prev().remove();
    $('label.label_error').remove();

    
    if (!notEmpty2("dk_password", "password", "Bạn chưa nhập mật khẩu")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!lengthMin("dk_password", 8, "Mật khẩu phải từ 8-16 kí tự, bao gồm cả chữ in hoa và số")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!uppercase('dk_password', "Mật khẩu phải từ 8-16 kí tự, bao gồm cả chữ in hoa và số")) {
        scrollTop('#dk_password');
        return false;
    }
    if (!number_pass('dk_password', "Mật khẩu phải từ 8-16 kí tự, bao gồm cả chữ in hoa và số")) {
        scrollTop('#dk_password');
        return false;
    }
  
   
   
    return true;
    
}
