$(document).ready(function () {
    $("input[name$='check_acount']").click(function() {
        var test = $(this).val();
        if(test == 'true'){
            $(".not_member_form_pay").hide();  
            $(".login_form_pay").show();
            $("input#true").prop('checked', true);
        }else{
            $(".not_member_form_pay").show();
            $("input#is_fall").prop('checked', true);
            $(".login_form_pay").hide();
        }
    });
    $("input[name$='check_member']").click(function() {
        var test = $(this).val();
        if(test == 'true'){
            $(".login_form_pay").show();  
            $(".not_member_form_pay").hide();
             $("input#true").prop('checked', true);
        }else{
            $(".not_member_form_pay").show();
            $(".login_form_pay").hide();
            $("input#is_fall").prop('checked', true);
            
        }
    });
});