<p class="text-chon">
    <a class="a-ql"  onclick="ql_huyen()" href="javascript:void(0)"><i class="fal fa-chevron-left"></i></a>
    Chọn Quận huyện Tại <?php echo $get_city->name ?>
</p>
<input type="hidden" id="id_city_menu" value="<?php echo $get_city->id ?>">
<div class="nd_vitri">
    <div class="input-search-vitri">
        <input type="text" id="huyen_search" value="" placeholder="Tìm nhanh tỉnh thành, quận huyện...">
    </div>
    <div class="list_vitri">
        <div class="box box-list-address">
            <ul>
                <?php foreach ($huyen as $item){ ?>
                    <li>
                        <a href="javascript:void(0)" onclick="xa(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script>

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

    $(document).ready(function () {

        $("#huyen_search").keypress(function(){
            huyen_search =  $("#huyen_search").val();
            id_city_menu =  $("#id_city_menu").val();


            let str = huyen_search;

            if(str.length>=1){
                $.ajax({
                    url: "index.php?module=home&view=home&task=search_huyen&raw=1",
                    type: 'GET',
                    data: {huyen_search: huyen_search,id_city_menu:id_city_menu},
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




</script>