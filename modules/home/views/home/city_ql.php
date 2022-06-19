<p class="text-chon">Chọn Tỉnh, Thành Phố</p>
<div class="nd_vitri">
    <div class="input-search-vitri">
        <input type="text" id="city_search" value="" placeholder="Tìm nhanh tỉnh thành, quận huyện...">
    </div>
    <div class="list_vitri">
        <div class="box box-list-address">
            <ul>
                <?php foreach ($city as $item){ ?>
                    <li>
                        <a href="javascript:void(0)" onclick="huyen(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<script>
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


</script>