$(document).ready( function(){
    // $(function() {
    //     var minPriceInRupees = 0;
    //     var maxPriceInRupees = 500;
    //     var currentMinValue = 33;
    //     var currentMaxValue = 333;
    //
    //     $( "#slider-range" ).slider({
    //         range: true,
    //         min: minPriceInRupees,
    //         max: maxPriceInRupees,
    //         values: [ currentMinValue, currentMaxValue ],
    //         slide: function( event, ui ) {
    //             $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    //             currentMinValue = ui.values[ 0 ];
    //             currentMaxValue = ui.values[ 1 ];
    //         },
    //         stop: function( event, ui ) {
    //             currentMinValue = ui.values[ 0 ];
    //             currentMaxValue = ui.values[ 1 ];
    //             alert('currentMinValue and currentMaxValue updated !!!');
    //             alert('currentMinValue = '+currentMinValue+' currentMaxValue = '+currentMaxValue);
    //         }
    //     });
    //
    //     $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    //         " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    // });
    $( function() {
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 75, 300 ],
            slide: function( event, ui ) {
                // alert(ui.values[ 0 ] );
                $( "#amount" ).val( "$" + ui.values[ 0 ] + " - đ" + ui.values[ 1 ] );
            }
        });
        $( "#amount" ).val( "đ" + $( "#slider-range" ).slider( "values", 0 ) +
            " - đ" + $( "#slider-range" ).slider( "values", 1 ) );
    } );
});
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    // document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    $('.full').show();
}
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    // document.body.style.backgroundColor = "white";
    $('.full').hide();
}
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
        var htp_host = $('#htp_host').val();
        var uri = $('#uri').val();
        // alert(data_id);

        pagecurrent = Number(pagecurrent);
        nextpage = Number(nextpage);

        $(this).attr("data-pagecurrent", nextpage);
        $(this).attr("data-nextpage", nextpage + 1);
        // alert(limit);
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: '/index.php?module=products&view=cat&raw=1&task=loadmore_hang',
            // url: '/index.php?module=project&view=home&raw=1&task=loadmore',
            data: '&pagecurrent=' + pagecurrent + '&limit=' + limit + '&htp_host=' + htp_host + '&uri=' + uri ,
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
    $('#a-more-nd-dm').click(function () {
        $( ".noidung-dm .nd" ).addClass( "nd-more");
        $( "#a-more-nd-dm" ).addClass( "a-thugon");
    });

    $("#search_sp").keypress(function(){
        search_sp =  $("#search_sp").val();
        hangsp =  $("#hangsp").val();
        sapxepsp =  $("#sapxepsp").val();
        typesp =  $("#typesp").val();
        id_cat =  $("#id_cat_dm").val();
        // alert(id_cat);

        h_sp = '';
        if(hangsp){
            h_sp = "&hang="+hangsp;
        }
        s_sp = '';
        if(sapxepsp){
            s_sp = "&sapxep="+sapxepsp;
        }

        t_sp = '';
        if(typesp){
            t_sp = "&type="+typesp;
        }

        let str = search_sp;

        if(str.length>=1){
            $.ajax({
                url: "index.php?module=products&view=cat&task=search_sp&raw=1"+h_sp + s_sp + t_sp,
                type: 'GET',
                data: {search_sp: search_sp,id_cat:id_cat},
                dataType: 'html',
                success: function (data) {

                    $(".list-products").html(data);
                    // $(".item-service"+$i).remove();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
                }
            });
        }

    });


    LoadMore();

});

var LoadMore_sp = function () {
    $('.c-view-more-sp .load_more-sp').click(function () {

        var pagecurrent = $(this).attr("data-pagecurrent");
        var nextpage = $(this).attr("data-nextpage");
        var limit = $(this).attr("limit");
        var id_cat = $(this).attr("id_cat");
        var type_alias = $(this).attr("type_alias");
        // var start = $(this).attr("data-start");
        // var end = $(this).attr("data-end");
        var id = $(this).attr("data-id");
        var dclass = $(this).attr("data-class");
        var col = $(this).attr("data-col");
        var col2 = $(this).attr("data-col2");

        var data_id = $('#data_id').val();
        var hangsp = $('#hangsp').val();
        var sapxepsp = $('#sapxepsp').val();
        var typesp = $('#typesp').val();
        h_sp = '';
        if(hangsp){
            h_sp = '&hang='+hangsp;
        }
        s_sp = '';
        if(sapxepsp){
            s_sp = '&sapxep='+sapxepsp;
        }

        t_sp = '';
        if(typesp){
            t_sp = '&type='+typesp;
        }
        // alert(data_id);

        pagecurrent = Number(pagecurrent);
        nextpage = Number(nextpage);

        $(this).attr("data-pagecurrent", nextpage);
        $(this).attr("data-nextpage", nextpage + 1);
        // alert(limit);
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: '/index.php?module=products&view=cat&raw=1&task=loadmore',
            // url: '/index.php?module=project&view=home&raw=1&task=loadmore',
            data: '&pagecurrent=' + pagecurrent + '&limit=' + limit + '&id_cat=' + id_cat + h_sp + t_sp + s_sp,
            success: function (html) {

                if (html == '') {
                    // alert(array_info[0]);
                    $('.c-view-more-sp .load_more-sp').hide();
                } else
                    $('.more-sp').append(html);
            }
        });
    })

};
$(document).ready(function () {

    LoadMore_sp();

});



