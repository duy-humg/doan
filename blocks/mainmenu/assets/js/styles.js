$(document).ready(function () {
    $('.menuMobile').click(function () {
        $('.listMobile').toggle(300);
    });
    $('.see-products-menu').hover(function () {
        $('.full2').show();
        $('.show_list_see_pr').show();
    });
    $(".full2, header").hover(function () {
        $(".show_list_see_pr").hide();
        $('.full2').hide();
    });
    $(".clickmore").click(function () {

        var id = $(this).attr("data-id");
        // alert(id);
        var less = $(this).attr("data-class");
        // alert(less);


        if (less == 1) {
            // alert(id);

            $("#" + id).height("auto");

            $(this).html("Thu gọn");

            $(this).removeAttr("data-class");

        } else {

            var height = $("#" + id).attr("data-height");

            $("#" + id).height(height);

            $(this).html("Xem thêm...");

            $(this).attr("data-class", "1");
        }
    });
});
