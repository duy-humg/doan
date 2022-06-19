<?php if($list_color){ ?>
    <!-- <p>1</p> -->
    <div class="list_color">
        <p class="info" id="info_color"><?php echo FSText::_('Màu'); ?> </p>
        <?php if($product_3[0]){ ?>
            <ul class="chosse-color" id="option_color ">
            <?php $i=1;
            foreach ($list_color as $item) {
                $model = $this->model;
                @$color_item = $model->get_record('id=' . $item, 'fs_products_color', '*');
                ?>
                <li  data="color_item" name="color_title"
                    name-item="<?php echo $color_item->name; ?>"
                    color_id="<?php echo $color_item->id; ?>"
                    class="item_price_2_color color_item color_vina_click a-option_color a-click-sur <?php if($product_3[0]->color_id==$item){ ?>active<?php } ?>"
                    data-toggle="tab" href="#board<?php echo $item ?>"
                >
                    <!-- <img src="<?php echo URL_ROOT.'/modules/products/assets/images/check.svg' ?>" alt="img"> -->
                    <p style="width: 100%;height: 100%;border-radius: 50% "><?php echo $color_item->name ?></p>
                </li>
                <?php $i++; } ?>
            </ul>
            <input type="hidden" name="color_id_vinashoes" id="color_id_vinashoes" value="<?php echo $product_3[0]->color_id ?>">
        <?php }else{ ?>
            <ul class="chosse-color" id="option_color ">
            <?php $i=1;
            foreach ($list_color as $item) {
                $model = $this->model;
                @$color_item = $model->get_record('id=' . $item, 'fs_products_color', '*');
                ?>
                <li  data="color_item" name="color_title"
                    name-item="<?php echo $color_item->name; ?>"
                    color_id="<?php echo $color_item->id; ?>"
                    class="item_price_2_color color_item color_vina_click a-option_color a-click-sur <?php if($i==1){ ?>active<?php } ?>"
                    data-toggle="tab" href="#board<?php echo $item ?>"
                >
                    <!-- <img src="<?php echo URL_ROOT.'/modules/products/assets/images/check.svg' ?>" alt="img"> -->
                    <p style="width: 100%;height: 100%;border-radius: 50% "><?php echo $color_item->name ?></p>
                </li>
                <?php $i++; } ?>
            </ul>
            <input type="hidden" name="color_id_vinashoes" id="color_id_vinashoes" value="<?php echo $color_item_dau->id ?>">
        <?php } ?>
        
    </div>

<?php } ?>
<script>
    $(".item_price_2_color").click(function () {

        // var color   = $('#color_id_vinashoes').val();
        var size   = $('#size_id_vinashoes').val();
        var color = $(this).attr("color_id");

        id_color   = $('#color_id_vinashoes').val(color);
        // alert(color)
        // console.log(color_2);
        var id_shop    = $('#product_id').val();
        $.ajax({

            type: 'GET',
            url: '/index.php?module=products&view=product&raw=1&task=get_price_shop&id='+ id_shop + '&color=' + color + '&size=' + size,
            dataType : 'html',
            success : function(data){

                $("#price_vinashoes").html(data);
                // $('#district').removeAttr('disabled');
                return true;
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {}
        });
    });
</script>