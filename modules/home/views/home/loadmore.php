<?php foreach ($list as $item) {
    $link = FSRoute::_('index.php?module=products&view=cat&ccode=' . $item->alias . '&cid=' . $item->id);
    $list_prd = $model->get_list($item->list_parents);
    ?>
    <div class="list_products clearfix">
        <div class="head-block-product clearfix">
            <h3>
                <a href="<?php echo $link; ?>">
                    <span class="not-bgr"><?php echo $item->name; ?></span>
                    <span>
                    <?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-angle-right"></i></span>
                </a>
            </h3>

        </div>
        <div class="box_prd">
            <div class="row list_sp">
                <?php
                foreach ($list_prd as $key) {
                    $link1 = FSRoute::_('index.php?module=products&view=product&code=' . $key->alias . '&id=' . $key->id);
                    ?>
                    <div class="col-md-2 col-sm-3 col-xs-2 prd_detail">
                        <div class="image-check">
                            <?php if ($key->is_hot == 1) { ?>
                                <img src="<?php echo URL_ROOT; ?>templates/default/images/hot-pc.png"
                                     alt="hình ảnh"
                                     class="img-responsive hot">
                            <?php } ?>
                            <?php if ($key->price_old > $key->price) { ?>
                                <img src="<?php echo URL_ROOT; ?>templates/default/images/sale.png"
                                     alt="hình ảnh"
                                     class="img-responsive sale">
                                <span class="discount"><?php echo ($key->discount) . '%' ?></span>
                            <?php } ?>
                            <a href="<?php echo $link1; ?>">
                                <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $key->image); ?>"
                                     onerror="this.src='/images/not_picture.png'" class="img-responsive">
                                <div class="title-book"><?php echo $key->name; ?></div>
                                <div class="price-book clearfix">
                                    <?php echo format_money($key->price); ?><span>/cái</span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>