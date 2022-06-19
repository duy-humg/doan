<?php if($get){ ?>
    <p class="infor-price_">
                             <span class="price_old"><?php if ($get->price > $get->price_h) {
                                     echo format_money($get->price);
                                 } ?></span>
        <span class="infor-price">

                            <?php if ($get->price_h) {
                                echo format_money($get->price_h);
                            } else {
                                echo 'Liên hệ';
                            } ?>
                                </span>

        <?php if($get->price){
            $giam = ceil(100 - ($get->price_h/$get->price)*100)

            ?>
            <?php if($giam != 0){ ?>
                <span class="p-giamgia">-<?php echo $giam ?>% GIẢM</span>
            <?php } ?>
        <?php } ?>
    </p>
    <input type="hidden" id="price_input" name='price' value="<?php echo $get->price_h ?>"/>
    <input type="hidden" id="check_conhang" name='check_conhang' value="1"/>
    <input type="hidden" id="id_sub" name='id_sub'
           value="<?php echo $get->id ?>"/>
<?php }else{ ?>
    <p class="infor-price_">
        <span class="infor-price">
           Sản phẩm tạm thời hết hàng
        </span>
    </p>
    <input type="hidden" id="price_input" name='price' value="0"/>
    <input type="hidden" id="check_conhang" name='check_conhang' value="0"/>
    <input type="hidden" id="id_sub" name='id_sub'
           value="<?php echo $get->id ?>"/>
<?php } ?>
