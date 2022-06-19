$(document).ready(function () {
    $("#show_add_code").change(function () {
        if ($(this).is(":checked") == true) {
            $("#code_down_price").show();
            $('#code_down_price').find('input').attr('required', true);
        } else {
            $("#code_down_price").hide();
            $('#code_down_price').find('input').attr('required', false);
        }
    });
    if ($('#code_down_price').is(":hidden")) {
        $('#code_down_price').find('input').attr('required', false);
    };

});

function yesnoCheck() {
    if ($('#put_bank').is(":checked") == true) {
        $('.info-banks-send').show();
    }
    else $('.info-banks-send').hide();
}
function showpre() {
    $('.preloader').show();
}