$(document).ready(function () {
   
    check_exist_email();
    $('.button-submit-edit').click(function () {
        check_exist_email();
            // $('.preloader').show();
            document.form-user-edit.submit();
        

    })

});
function check_exist_email() {
    $('#email').blur(function () {
        if ($(this).val() != '') {

            if (!emailValidator("email", "Email không đúng định dạng"))
                return false;
            $.ajax({
                url: "/index.php?module=users&task=ajax_check_exist_email&raw=1",
                data: {email_register: $(this).val()},
                dataType: "text",
                success: function (result) {
                    if (result == 0) {
                        invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');
                        return false;
                    } else {
                        valid('dk_mail');
                        $('<div class=\'label_success \'>Email này được chấp nhận</div>').insertAfter($('#email').parent().children(':last'));
                    }

                }
            });
        }
    });
}