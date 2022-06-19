$(document).ready(function () {
    
    $('.a-email').click(function () {
        $('#type_method').val(1);
        document.method_form.submit();
    });
    $('.a-phone').click(function () {
        $('#type_method').val(2);
        document.method_form.submit();
    });

        
});