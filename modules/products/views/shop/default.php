<?php
//echo 1;
global $tmpl;
$tmpl->addStylesheet('home', 'modules/products/assets/css');
$tmpl->addScript("home", "modules/products/assets/js");
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$model = $this -> model;

$arr_bl =  array();
foreach ($list_bl as $item_a){
    $b = str_replace('-','',$item_a->alias);

    $item_a = FSInput::get($b);

    $arr_bl[] = $item_a;
}

$sapxep = FSInput::get('sapxep');
$arr_sapxep = explode(':',$sapxep);
$category = FSInput::get('category');
$arr_category = explode(':',$category);

$price = FSInput::get('price');
$arr_price = explode(':',$price);
if($price){
    $get_price = $model->get_price($arr_price[0]);
}



$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//$tmpl->addTitle($cat->name);
if ($sapxep || $price || $category || strpos($url, '?')) {
    $fist = "";
} else
    $fist = '?';

   
?>
<input type="hidden" name="quantity" id="quantity" value="1">
<input type="hidden" name="id_cat_dm" id="id_cat_dm" value="<?php echo $cat->id ?>">

<div class="container">
    <aside class="new-contents new-contents-shop">

        <div class="content_3 row">
            <div class="left_content3 col-md-4">
                <div class="img_shop">
                    <img src="<?php echo URL_ROOT . str_replace('original', 'small', $get_shop->image); ?>" alt="<?php echo $get_shop->name ?>">
                </div>
                <div class="name_shop">
                    <p class="p-name-shop"><?php echo $get_shop->name ?></p>
                    <div class="btn-shop">
                        <a class="a-chat" href="#"><?php echo FSText::_("Chat ngay"); ?></a>
                       
                    </div>
                </div>
            </div>
            <div class="right_content3 col-md-8">
                <p class="text_shop text_shop_1 text_shop_left"><?php echo FSText::_("Đánh giá"); ?><span>0</span></p>
                <p class="text_shop text_shop_2 text_shop_center"><?php echo FSText::_("Tỉ lệ phản hồi"); ?><span><?php echo $get_shop->ti_le ?></span></p>
                <p class="text_shop text_shop_3 text_shop_right"><?php echo FSText::_("Tham gia"); ?><span><?php echo $get_shop->thamgia ?></span></p>
                <p class="text_shop text_shop_4 text_shop_2_ text_shop_left"><?php echo FSText::_("Sản phẩm"); ?><span><?php echo count($listsp_shop) ?></span></p>
                <p class="text_shop text_shop_5 text_shop_2_ text_shop_center"><?php echo FSText::_("Thời gian phản hồi"); ?><span><?php echo $get_shop->time_ph ?></span></p>
            </div>
            <div class="clearfix"> </div>
            <div class="right_content3_mobile">
                <p class="text_shop text_shop_1 text_shop_left"><span>0</span> <?php echo FSText::_("Đánh giá"); ?></p>
                <p class="text_shop text_shop_2 text_shop_center"><span><?php echo $get_shop->ti_le ?></span> <?php echo FSText::_("Phản hồi chat"); ?></p>
                <p class="text_shop text_shop_4 text_shop_2_ text_shop_left"><span><?php echo count($listsp_shop) ?></span> <?php echo FSText::_("Sản phẩm"); ?></p>
            </div>
            <?php if (count($list_shop_m)) { ?>
                <div class="block_3_content_4">
                    <h3>
                        <?php echo FSText::_("Các sản phẩm khác của shop"); ?>
                        <a href="<?php echo  FSRoute::_('index.php?module=products&view=shop&cid=' . $get_shop->id . '&ccode=' . $get_shop->alias) ?>"><?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-chevron-right"></i></a>
                    </h3>
                    <div class="list_shop">
                        <?php
                        $i = 0;
                        foreach ($list_shop_m as $item) {
                            $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                            $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                            ?>
                            <?php $i++; ?>
                            <div class="image-check image-check-<?php echo $i ?> col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                <a href="<?php echo $link; ?>">
                                    <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                                    <p class="name_sp" href="<?php echo $link ?>"><?php echo $item->name ?></p>
                                    <div class="money_sp-more">
                                        <div class="money_sp">

                                            <?php if($item->price_old){ ?>
                                                <p class="text-price-old"><?php echo format_money($item->price_old) ?></p>
                                            <?php } ?>
                                            <p class="text-price" ><?php echo format_money($item->price) ?></p>
                                        </div>
                                        <div class="more">
                                            <p class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('Xem shop') ?></p>
                                            <p><?php echo FSText::_('Đã bán') ?> <?php echo $item->daban ?>k</p>
                                        </div>
                                    </div>
                                    <?php if($item->price_old){ ?>
                                        <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                                        <p class="text-giam-gia">- <?php echo $item->giamgia ?>%</p>
                                    <?php } ?>
                                </a>
                                <a class="bg" href="<?php echo $link; ?>">
                                    <span>MUA NGAY</span>
                                </a>
                            </div>
                            <?php if (($i%4) == 0) { ?>
                                <div class="clearfix "></div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="main-column-left col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <?php if($dm_0){ ?>
                    <div class="frame_head clearfix">
                        <h2  class="h2_frame_head btn btn-info" data-toggle="collapse" data-target="#demo_dm"><span><?php echo FSText::_("Danh sách shop"); ?></span></h2>
                        <div id="demo_dm" class="collapse in">
                            <?php foreach ($dm_0 as $item){
                                $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                                ?>
                                <p class="p-dm">
                                    <a href="<?php echo $link ?>">
                                        <?php echo $item->name ?>
                                    </a>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="main-column-content col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <div class="sort_product">
                    <p>
                        <span><?php echo FSText::_("Sắp xếp theo");?>:</span>
                        <?php if($sapxep){ ?>
                            <a class="<?php if(1 == $arr_sapxep[0]){ ?>active_sapxep <?php } ?>" href="<?php echo str_replace('&sapxep='.$sapxep,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&sapxep=1:pho-bien')  ?>"><?php echo FSText::_("Phổ biến"); ?></a>
                            <a class="<?php if(2 == $arr_sapxep[0]){ ?>active_sapxep <?php } ?>" href="<?php echo str_replace('&sapxep='.$sapxep,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&sapxep=2:moi-nhat')  ?>"><?php echo FSText::_("Mới nhất"); ?></a>
                            <a class="<?php if(3 == $arr_sapxep[0]){ ?>active_sapxep <?php } ?>" href="<?php echo str_replace('&sapxep='.$sapxep,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&sapxep=3:ban-chay')  ?>"><?php echo FSText::_("Bán chạy"); ?></a>
                        <?php }else{ ?>
                            <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&sapxep=1:pho-bien' ?>"><?php echo FSText::_("Phổ biến"); ?></a>
                            <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&sapxep=2:moi-nhat' ?>"><?php echo FSText::_("Mới nhất"); ?></a>
                            <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&sapxep=3:ban-chay' ?>"><?php echo FSText::_("Bán chạy"); ?></a>
                        <?php } ?>

                    </p>
                    <div class="price_loc">
                        <?php if($price){ ?>
                            <a class="a-gia" data-toggle="collapse" data-target="#demo_price"><?php echo $get_price->name ?></a>
                        <?php }else{ ?>
                            <a class="a-gia" data-toggle="collapse" data-target="#demo_price">Giá</a>
                        <?php } ?>


                        <div id="demo_price" class="collapse">
                            <?php foreach ($list_price_ as $item){ ?>
                                <?php if($price){ ?>
                                    <a href="<?php echo str_replace('&price='.$price,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&price=' . $item->id . ':' . $item->alias)  ?>">
                                        <?php echo $item->name ?>
                                    </a>
                                <?php }else{ ?>
                                    <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&price=' . $item->id . ':' . $item->alias ?>">
                                        <?php echo $item->name ?>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="list-products">


                    <div class="row">
                        <?php if ($total) { ?>
                            <?php
                            $i = 0;
                            foreach ($list as $item) {
                                $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                                $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                                ?>
                                <?php $i++; ?>
                                <div class="image-check col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                    <a href="<?php echo $link; ?>">
                                        <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                                        <p class="name_sp" href="<?php echo $link ?>"><?php echo $item->name ?></p>
                                        <div class="money_sp-more">
                                            <div class="money_sp">

                                                <?php if($item->price_old){ ?>
                                                    <p class="text-price-old"><?php echo format_money($item->price_old) ?></p>
                                                <?php } ?>
                                                <p class="text-price" ><?php echo format_money($item->price) ?></p>
                                            </div>
                                            <div class="more">
                                                <p class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('Xem shop') ?></p>
                                                <p><?php echo FSText::_('Đã bán') ?> <?php echo $item->daban ?>k</p>
                                            </div>
                                        </div>
                                        <?php if($item->price_old){ ?>
                                            <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                                            <p class="text-giam-gia">- <?php echo $item->giamgia ?>%</p>
                                        <?php } ?>
                                    </a>
                                    <a class="bg" href="<?php echo $link; ?>">
                                        <span>MUA NGAY</span>
                                    </a>
                                </div>
                                <?php if (($i%4) == 0) { ?>
                                    <div class="clearfix "></div>
                                <?php } ?>

                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php if ($pagination) echo $pagination->showPagination(3); ?>
            </div>
        </div>
    </aside>
</div>

<!--<p>-->
<!--    <label for="amount">Price range:</label>-->
<!--    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">-->
<!--</p>-->
<!--<div id="slider-range"></div>-->

