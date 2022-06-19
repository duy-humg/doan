<?php
global $config, $tmpl;
$tmpl->addStylesheet("products", "blocks/products/assets/css");
$tmpl->addScript("products", "blocks/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
$link = FSRoute::_('index.php?module=users&view=products_sort&task=products_dis');
?>
    <input type="hidden" name="quantity" id="quantity" value="1">
<?php if (count($list)) { ?>
    <div id="block_id_<?php echo $id; ?>">
        <div class="list_products clearfix">
            <div class="head-block-product clearfix">
                <h3>
                    <a href="<?php echo $link; ?>">
                        <span class="not-bgr"><?php echo FSText::_('Sản phẩm khuyến mại'); ?></span>
                        <span class="hidden-xs">
                    <?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-angle-right"></i></span>
                    </a>
                </h3>

            </div>
            <!--        <div class="sider-slick-add">-->
            <div class="box_prd">
                <div class="row list_sp">
                    <?php
                    foreach ($list as $item) {
                        $link = FSRoute::_('index.php?module=products&view=product&code=' . $item->alias . '&id=' . $item->id);
                        ?>
                        <div class="col-md-2 col-sm-3 col-xs-2 prd_detail">
                            <div class="image-check">
                                <?php if ($item->is_hot == 1) { ?>
                                    <img src="<?php echo URL_ROOT; ?>templates/default/images/hot-pc.png" alt="hình ảnh"
                                         class="img-responsive hot">
                                <?php } ?>
                                <?php if ($item->price_old > $item->price) { ?>
                                    <img src="<?php echo URL_ROOT; ?>templates/default/images/sale.png" alt="hình ảnh"
                                         class="img-responsive sale">
                                    <span class="discount"><?php echo ($item->discount) . '%' ?></span>
                                <?php } ?>
                                <a href="<?php echo $link; ?>">
                                    <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $item->image); ?>"
                                         onerror="this.src='/images/not_picture.png'" class="img-responsive">
                                    <div class="title-book"><?php echo $item->name; ?></div>
                                    <div class="price-book clearfix">
                                        <?php echo format_money($item->price); ?>
                                        <?php if ($item->unit && $item->price != 0) { ?>
                                            <span>/cái</span>
                                        <?php } ?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-2 col-sm-3 col-xs-2 prd_detail visible-xs view_mb">
                        <a href="<?=FSRoute::_('index.php?module=users&view=products_sort&task=products_dis')?>"><i class="fa fa-ellipsis-h"></i>
                            <span>Xem tất cả</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>