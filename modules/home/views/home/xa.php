<p class="text-chon">
    <a class="a-ql"  onclick="ql_xa()" href="javascript:void(0)"><i class="fal fa-chevron-left"></i></a>
    Chọn Xã/Phường Tại <?php echo $get_huyen->name ?>
</p>
<input type="hidden" id="id_city_menu" value="<?php echo $get_huyen->id ?>">
<div class="nd_vitri">
    <div class="input-search-vitri">
        <input type="text" id="huyen_search" value="" placeholder="Tìm nhanh xã/phường">
    </div>
    <div class="list_vitri">
        <div class="box box-list-address">
            <ul>
                <?php foreach ($ward as $item){ ?>
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
</script>