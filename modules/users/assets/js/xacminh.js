function validateOtp() {
    otp_code1 = $('#otp_code1').val();
    otp_code2 = $('#otp_code2').val();
    otp_code3 = $('#otp_code3').val();
    otp_code4 = $('#otp_code4').val();
    otp_code5 = $('#otp_code5').val();
    otp_code6 = $('#otp_code6').val();
    if(!otp_code1 || !otp_code2 || !otp_code3 || !otp_code4  || !otp_code5 || !otp_code6){
        $(".p-error-otp").css("display", "block");
        
        return false;
    }else{
        $(".p-error-otp").css("display", "none");

    }

    otp_code = $('#input_opt_code').val();

    get_opt = otp_code1+otp_code2+otp_code3+otp_code4+otp_code5+otp_code6
    if(otp_code != get_opt){
        $(".p-error-otp2").css("display", "block");
        return false;
    }else{
       
        document.frmOtp.submit();
            
    }
    
    // return false;
}
$(document).ready(function () {
    
    $(".otp_input").on("keyup",function(){
        var value= $(this).val();
        var regex_phone = /^0\d{1}$/;
        if (regex_phone.test(value)) {
            $('.p-error-otp').css("display",'block');
        }else{
            $('.p-error-otp').css("display",'none');
            $('.p-error-otp2').css("display",'none');
        };
    });

    const myTimeout = setTimeout(myGreeting, 60000);

    function myGreeting() {
        $('.p-2-code').css("display",'block');
        $('.p-time-count').css("display",'none');
    }

    $('#resend_code_email_smt').click(function () {
        
        document.resend_code_email.submit();
    });
        
});
