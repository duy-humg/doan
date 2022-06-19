$(document).ready(function () {

        $(".block_div_").click(function(){
            $(this).hide();
            var i=$(this).data('id');
            $('#hide_'+i).toggle();
            $('.hide-class-'+i).css({'display': 'block'});
        });

    $(".hide_div_").click(function(){
        $(this).hide();
        var i=$(this).data('id');
        $('#show_'+i).toggle();
        $('.hide-class-'+i).css({'display': 'none'});
    });

});
function order($id_pro) {
    $('html,body').animate({scrollTop: '0px'}, 500);
    var $id = $id_pro;
    var $quan = 1;
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=products&view=product&raw=1&task=buy',
        data: "quantity=" + $quan + "&id=" + $id,
        success: function (data) {
            $("#wrapper-popup").html(data);
            ajax_pop_cart();
            del_cart();
        }
    });
    $(".wrapper-popup").show();
    $(".full").show();

}


function ajax_pop_cart(){
    $("#close-cart").click(function(){
        $(".wrapper-popup-2").hide();
        $(".wrapper-popup").hide();
        $(".full").hide();
    });
}

function del_cart() {

    $(".name-product .del-pro-link").click(function () {
        $a = $(this).attr("data-tr");
        $("." + $a).hide();

        var $id = $(this).attr("data-id");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/index.php?module=products&view=product&task=edel',
            data: "id=" + $id,
            success: function () {

            }
        });
    });
    $(".continue-buy").click(function () {
        document.order_form.submit();
    });
}