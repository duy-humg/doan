<?php
global $config, $tmpl;
//$tmpl->addScript('form');
$tmpl->addScript('promotion', 'modules/promotion/assets/js');
$tmpl->addStylesheet('promotion', 'modules/promotion/assets/css');
$title_list = array();
$j=0;
?>

<div class="promotion-list">
    <?php foreach ($list as $item) {
        $j++;?>
        <div class="list_promotion_content clearfix">
            <h2 class="title-promotion"><?php echo $item->name; ?></h2>
            <div class="list_cat_promotion clearfix">   
                <?php
                    $i = 0;
                    foreach ($list_package[$item->id] as $data) {
                        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $data->id);
                    $i++;
                ?>
                    <div class="<?php echo ($i > 10)?'hide-class-'.$j:''; ?> image-check col-lg-3 col-md-3 col-sm-6 col-xs-6 " >
                        <a href="<?php echo $link; ?>">
                            <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $data->image); ?>" class="img-responsive">
                            <div class="title-book"><?php echo $data->name; ?></div>
                            <div class="price-book clearfix">
                                <?php echo format_money($data->price); ?>
                                <?php if($data->price != $data->price_old){ ?>
                                <span class="price-regular"><?php echo format_money($data->price_old); ?></span>
                                <?php } ?>
                                <?php if($data->discount){ ?>
                                <span class="sale-tag sale-tag-square"><?php echo $data->discount . ' %'; ?></span>
                                <?php } ?>
                            </div>
                        </a>
<!--                        <p class="buy-now"><a href="--><?php //echo URL_ROOT.'index.php?module=products&view=product&task=buynow&id='.$data->id; ?><!--">--><?php //echo FSText::_("Thêm vào giỏ hàng");?><!--</a></p>-->
                        <p class="buy-now"><a href="javascript:void(0)" onclick="order(<?php echo $data->id; ?>)">
                            <?php echo FSText::_("Thêm vào giỏ hàng"); ?>
                        </a></p>
                    </div>
                <?php if($i == 10){ ?>
                <div class="clearfix"></div>
                <p class="show_all clearfix"><span data-id="<?=$j?>" class="block_div_" id="show_<?=$j?>"><?php echo FSText::_("Xem tất cả");?></span></p>
                <?php  } ?>
                <?php }
                    if($i >= 10){
                        ?>
                        <div class="clearfix"></div>
                        <p class="show_all clearfix"><span style="display: none" data-id="<?=$j?>" class="hide_div_" id="hide_<?=$j?>"><?php echo FSText::_("Thu gọn");?></span></p>
                        <?php
                    }
                        ?>
            </div>
        </div>
    <?php } ?>
</div>
