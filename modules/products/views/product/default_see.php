<!--	RELATE CONTENT		-->
<?php
$total_content_relate = count($list_see);
if ($total_content_relate) {
    ?>
    <div class="list_products">
        <div class="head-block-product clearfix">
            <h3>
                <!--                <a href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&cid=' . $data->category_id . '&ccode=' . $data->category_alias); ?><!--">-->
                <a href="javascript:void(0)">
                    <span class="not-bgr"><?php echo FSText::_('Sản phẩm bạn vừa xem'); ?></span>
<!--                    <span>--><?php //echo FSText::_("Xem tất cả"); ?><!--<i class="fal fa-angle-right"></i></span>-->
                </a>
            </h3>
        </div>
        <div class="sider-slick-add">
            <?php
            for ($i = 0; $i < $total_content_relate; $i++) {
                $item = $list_see[$i];
                $link = FSRoute::_('index.php?module=products&view=product&code=' . $item->alias . '&ccode=' . $item->category_alias . '&id=' . $item->id);
                ?>
                <div class="image-check">
                    <a href="<?php echo $link; ?>">
                        <img src="<?php echo URL_ROOT.str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                        <div class="title-book"><?php echo $item->name; ?></div>
                        <div class="author"><?php echo $item->author_book; ?></div>
                        <div class="evaluate">
                            <img src="blocks/banners/assets/images/sao.png">
                        </div>
                        <div class="price-book clearfix">
                            <?php echo format_money($item->price); ?>
                            <?php if($item->discount){ ?>
                                <span class="sale-tag sale-tag-square"><?php echo '- '.$item->discount . ' %'; ?></span>
                            <?php } ?>
                        </div>
                        <div class="price-regular">
                            <?php if( $item->price != $item->price_old){ ?>
                                <?php echo format_money($item->price_old); ?>
                            <?php } ?>

                        </div>
                    </a>
                    <div class="p31">
                        <a class="a6" href="#">Thêm vào giỏ hàng</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<!--	end RELATE CONTENT		-->
