var LoadMore = function () {
    $('.c-view-more .load_more').click(function () {

        var pagecurrent = $(this).attr("data-pagecurrent");
        var nextpage = $(this).attr("data-nextpage");
        var limit = $(this).attr("limit");
        var type_id = $(this).attr("type_id");
        var type_alias = $(this).attr("type_alias");
        // var start = $(this).attr("data-start");
        // var end = $(this).attr("data-end");
        var id = $(this).attr("data-id");
        var dclass = $(this).attr("data-class");
        var col = $(this).attr("data-col");
        var col2 = $(this).attr("data-col2");

        var data_id = $('#data_id').val();
        // alert(data_id);

        pagecurrent = Number(pagecurrent);
        nextpage = Number(nextpage);

        $(this).attr("data-pagecurrent", nextpage);
        $(this).attr("data-nextpage", nextpage + 1);
        // alert(limit);
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: '/index.php?module=combo&view=home&raw=1&task=loadmore',
            // url: '/index.php?module=project&view=home&raw=1&task=loadmore',
            data: '&pagecurrent=' + pagecurrent + '&limit=' + limit  ,
            success: function (html) {

                if (html == '') {
                    // alert(array_info[0]);
                    $('.c-view-more .load_more').hide();
                } else
                    $('.more-hang').append(html);
            }
        });
    })

};
$(document).ready(function () {

    LoadMore();

});

