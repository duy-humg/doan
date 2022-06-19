<?php
global $config, $tmpl;
//$tmpl->addStylesheet("products", "blocks/products/assets/css");
$tmpl->addScript("defaultcat", "blocks/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$cat->alias.'&cid='.$cat->id);
?>
<div id="block_id_<?php echo $id; ?>">
    <div class="list_products clearfix">
        <div class="head-block-product clearfix">
            <h3 class="not-bgr">
                <a href="<?php echo $link; ?>">
                    <span class="title-cat-block"><?php echo $title; ?></span>
                    <span><?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-angle-right" ></i></span>
                </a>
            </h3>

        </div>
            <div class="main-column-left">
                <img class="img-responsive" src="<?php echo URL_ROOT . str_replace('original', 'resized', $cat->image); ?>">
            </div>
            <div class="main-column-content sli-c">
                <div class="sider-slick-cat">
                    <?php
                    foreach ($list as $item) {
                        $link = FSRoute::_('index.php?module=products&view=product&ccode='.$item->category_alias.'&code='.$item->alias.'&id='.$item->id);
                    ?>
                        <div class="image-check">
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo URL_ROOT.str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                                <div class="title-book"><?php echo $item->name; ?></div>
                                <div class="price-book clearfix">
                                    <?php echo format_money($item->price); ?>
                                    <?php if($item->price != $item->price_old){ ?>
                                    <span class="price-regular"><?php echo format_money($item->price_old); ?></span>
                                    <?php } ?>
                                    <?php if($item->discount){ ?>
                                    <span class="sale-tag sale-tag-square"><?php echo $item->discount . ' %'; ?></span>
                                    <?php } ?>
                                </div>
                            </a>
                            <?php
                            if(!$item->quantity){
                                ?>
                                <img class="hh" src="<?=URL_ROOT.'images/het.png'?>" alt="">
                                <?php
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        foreach ($list as $item) {
            $link = FSRoute::_('index.php?module=products&view=product&ccode='.$item->category_alias.'&code='.$item->alias.'&id='.$item->id);
            ?>
            <div class="image-check pc" style="display: none">
                <a href="<?php echo $link; ?>">
                    <img src="<?php echo URL_ROOT.str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                    <div class="title-book"><?php echo $item->name; ?></div>
                    <div class="price-book clearfix">
                        <?php echo format_money($item->price); ?>
                        <?php if($item->price != $item->price_old){ ?>
                            <span class="price-regular"><?php echo format_money($item->price_old); ?></span>
                        <?php } ?>
                        <?php if($item->discount){ ?>
                            <span class="sale-tag sale-tag-square"><?php echo $item->discount . ' %'; ?></span>
                        <?php } ?>
                    </div>
                </a>
                <?php
                if(!$item->quantity){
                    ?>
                    <img class="hh" src="<?=URL_ROOT.'images/het.png'?>" alt="">
                    <?php
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
