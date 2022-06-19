$(document).ready(function () {
    $("#city_search").keypress(function(){
        city_search =  $("#city_search").val();


        let str = city_search;

        if(str.length>=1){
            $.ajax({
                url: "index.php?module=home&view=home&task=search_city&raw=1",
                type: 'GET',
                data: {city_search: city_search},
                dataType: 'html',
                success: function (data) {

                    $(".box-list-address").html(data);
                    // $(".item-service"+$i).remove();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
                }
            });
        }
    });

    $("#huyen_search").keypress(function(){
        huyen_search =  $("#huyen_search").val();


        let str = huyen_search;

        if(str.length>=1){
            $.ajax({
                url: "index.php?module=home&view=home&task=search_huyen&raw=1",
                type: 'GET',
                data: {huyen_search: huyen_search},
                dataType: 'html',
                success: function (data) {

                    $(".box-list-address").html(data);
                    // $(".item-service"+$i).remove();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
                }
            });
        }
    });
});

function huyen(id) {
    $.ajax({
        url: "index.php?module=home&view=home&task=huyen&raw=1",
        type: 'GET',
        data: {id: id},
        dataType: 'html',
        success: function (data) {

            $(".chon-vitri").html(data);
            // $(".item-service"+$i).remove();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function xa(id) {
    $.ajax({
        url: "index.php?module=home&view=home&task=xa&raw=1",
        type: 'GET',
        data: {id: id},
        dataType: 'html',
        success: function (data) {

            $(".chon-vitri").html(data);
            // $(".item-service"+$i).remove();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function ql_huyen() {
    $.ajax({
        url: "index.php?module=home&view=home&task=city_ql&raw=1",
        type: 'GET',
        dataType: 'html',
        success: function (data) {

            $(".chon-vitri").html(data);
            // $(".item-service"+$i).remove();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function ql_xa() {
    $.ajax({
        url: "index.php?module=home&view=home&task=huyen_ql&raw=1",
        type: 'GET',
        dataType: 'html',
        success: function (data) {

            $(".chon-vitri").html(data);
            // $(".item-service"+$i).remove();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function xa(id) {
    // alert(1);
    $.ajax({
        url: "index.php?module=home&view=home&task=xa_click&raw=1",
        type: 'GET',
        data: {id: id},
        dataType: 'html',
        success: function (data) {

            // $(".chon-vitri").html(data);
            // $(".item-service"+$i).remove();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
    console.log(id);
    // alert(1);
    $(".address_user_menu .a-vitri-menu").click();

}