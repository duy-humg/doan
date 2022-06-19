<!--	RELATE CONTENT		-->
<?php
$total_content_relate = count($relate_products_list);
//var_dump($total_content_relate);
if ($total_content_relate) {
    ?>
    <div class="list_products">
        <div class="head-block-product clearfix">
            <h3>
                <!--                <a href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&cid=' . $data->category_id . '&ccode=' . $data->category_alias); ?><!--">-->
                <a href="#">
                    <span class="not-bgr"><?php echo FSText::_('Có thể bạn cũng cần mua'); ?></span>
                    <!--                    <span>-->
                    <!--                    -->
                    <?php //echo FSText::_("Xem tất cả"); ?><!--<i class="fal fa-angle-right"></i></span>-->
                </a>
            </h3>
        </div>
        <div class="box_prd">
            <div class="row list_sp">
                <?php
                for ($i = 0; $i < $total_content_relate; $i++) {
                    $item = $relate_products_list[$i];
                    $link = FSRoute::_('index.php?module=products&view=product&code=' . $item->alias . '&ccode=' . $item->category_alias . '&id=' . $item->id);
                    ?>
                    <div class="col-md-2 col-sm-3 col-xs-2 prd_detail">
                        <div class=" image-check">
                            <?php if ($item->is_hot == 1) { ?>
                                <img src="<?php echo URL_ROOT; ?>templates/default/images/hot-pc.png" alt=""
                                     class="img-responsive hot">
                            <?php } ?>
                            <?php if ($item->price_old > $item->price) { ?>
                                <img src="<?php echo URL_ROOT; ?>templates/default/images/sale.png" alt=""
                                     class="img-responsive sale">
                                <span class="discount"><?php echo ($item->discount) . '%' ?></span>
                            <?php } ?>
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $item->image); ?>"
                                     class="img-responsive">
                                <div class="title-book"><?php echo $item->name; ?></div>
                                <div class="price-book clearfix">
                                    <?php echo format_money($item->price); ?>
                                    <?php if ($item->unit && $item->price != 0) { ?>
                                        <span>/cái</span>
                                    <?php } ?>
                                    <!--                                --><?php //if ($item->discount) { ?>
                                    <!--                                    <span class="sale-tag sale-tag-square">-->
                                    <?php //echo '- ' . $item->discount . ' %'; ?><!--</span>-->
                                    <!--                                --><?php //} ?>
                                </div>
                                <!--                            <div class="price-regular">-->
                                <!--                                --><?php //if ($item->price != $item->price_old) { ?>
                                <!--                                    --><?php //echo format_money($item->price_old); ?>
                                <!--                                --><?php //} ?>
                                <!---->
                                <!--                            </div>-->
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<!--	end RELATE CONTENT		-->
