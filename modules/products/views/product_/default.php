<?php
//echo 1;
global $tmpl, $config;
$tmpl->addStylesheet('lightgallery.min', 'modules/products/assets/css');
$tmpl->addStylesheet('lightslider', 'modules/products/assets/css');
$tmpl->addStylesheet('detail', 'modules/products/assets/css');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/jquery/owlcarousel/assets');
//$tmpl->addStylesheet('bootstrap.min', 'modules/products/assets/css');
$tmpl->addScript('lightslider', 'modules/products/assets/js');
$tmpl->addScript('lightgallery-all.min', 'modules/products/assets/js');
$tmpl->addScript("detail", "modules/products/assets/js");
$tmpl->addScript("jquery.raty", "modules/products/assets/js");
$tmpl->addStylesheet('owl.carousel.min', 'libraries/owlcarousel/assets');
$tmpl->addStylesheet('owl.theme.default', 'libraries/owlcarousel/assets');
$tmpl->addScript('owl.carousel.min', 'libraries/owlcarousel');

$seo_title = $data->seo_title ? $data->seo_title : $data->name;
$seo_keyword = $data->seo_keyword ? $data->seo_keyword : $seo_title;
$seo_description = $data->seo_description ? $data->seo_description : strip_tags($data->content);
$seo_description = cutString($seo_description, 200);
$tmpl->addMetakey($seo_keyword);
//$tmpl->addMetades($seo_description . ' - Nhà sách Geni ');

$tmpl->setMeta('og:image:secure_url', URL_ROOT . str_replace('/original/', '/tiny/', $data->image));
$tmpl->setMeta('og:image', URL_ROOT . str_replace('/original/', '/tiny/', $data->image));

$tmpl->setMeta('og:type', 'article');
$tmpl->setMeta('og:url', 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$tmpl->setMeta('og:title', $seo_title);
$tmpl->setMeta('og:description', $seo_description);
$tmpl->addTitle($seo_title);
$url_current = $_SERVER['REQUEST_URI'];
//var_dump($url_current);
$url_current = substr(URL_ROOT, 0, strlen(URL_ROOT) - 1) . $url_current;
//var_dump($_SESSION['user_id']);
$id = FSInput::get('id');
$product_list = ($_SESSION['cart']);
$checked = '';
foreach ($product_list as $prd) {
    if ($prd[0] == $data->id and $prd[2] == 2) {
        $checked .= 'checked';
    }
}
//var_dump($_SESSION["user_id"]);
if ($_SESSION["user_id"]) {
    $favourite_item = $model->get_records('published = 1 and record_id =' . $id . ' AND `like` = 1', 'fs_products_favourite');
    $favourite_user = $model->get_record('published = 1 and record_id =' . $id . ' AND user_id = ' . $_SESSION["user_id"], 'fs_products_favourite');
}
//var_dump($favourite_user);
//var_dump($data->author_book);
//var_dump($sum_rate);
$total_cart = 0;
if (isset($_SESSION['cart'])) {
    $product_list = $_SESSION['cart'];
    foreach ($product_list as $prd) {
        $total_cart += $prd[1];
    }
}
?>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=2255714267773107&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<input type="hidden" name="quantity" id="quantity" value="1">
<input type="hidden" name="product_id" id="product_id" value="<?php echo $data->id; ?>">
<input type="hidden" id="products_sub" value="<?php echo @$json ?>">
<div class="content">
    <div class="pc">

        <div class="content_2 row">
            <div class="left_content2 col-md-6 col-sm-6 col-xs-12">
                <div class="clearfix silde-img row-item">
                    <?php if($product_images){ ?>
                        <ul id="imageGallery">
                            <?php foreach ($product_images as $item) {
                                ?>
                                <li data-thumb="<?php echo URL_ROOT . str_replace('/original/', '/original/', $item->image) ?>" data-src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image) ?>">
                                    <img src="<?php echo URL_ROOT . str_replace('/original/', '/original/', $item->image) ?>" />
                                </li>
                            <?php } ?>
                        </ul>
                    <?php }else{ ?>
                        <div class="bao-img">
                            <img src="<?php echo $data->image ?>" alt="<?php echo $data->name; ?>">
                        </div>

                    <?php } ?>

                </div>
            </div>
            <div class="right_content2 col-md-6 col-sm-6 col-xs-12">
                <h1 class="name_prd"><?php echo $data->name; ?></h1>
                <div class="thuonghieu-tinhtrang">
                    <p class="p-thuonghieu"><?php echo FSText::_("Thương hiệu");?>: <span><?php echo $data->name_thuonghieu ?></span></p>
                    <p class="p-tinhtrang"><?php echo FSText::_("Tình trạng");?>: <span><?php if($data->is_tinhtrang==1){ ?>Còn hàng<?php }else{ ?>Hết hàng<?php } ?></span></p>
                </div>
                <div class="giatien visible_pc">
                    <p class="infor-price_">
                        <span class="infor-price">
                        <?php if ($data->price) {
                            echo format_money($data->price);
                        } else {
                            echo 'Liên hệ';
                        } ?>
                            </span>
                        <span class="price_old"><?php if ($data->price_old > $data->price) {
                                echo format_money($data->price_old);
                            } ?></span>
                        <?php if($data->price_old){ ?>
                            <span class="p-giamgia">-<?php echo $data->giamgia ?>%</span>
                        <?php } ?>


                    </p>
                </div>
                <div class="giatien visible-xs">
                    <p class="infor-price_">
                        <span class="infor-price">
                        <?php if ($data->price) {
                            echo format_money($data->price);
                        } else {
                            echo 'Liên hệ';
                        } ?>
                            </span>
                        <span class="price_old"><?php if ($data->price_old > $data->price) {
                                echo format_money($data->price_old);
                            } ?></span>
                    </p>
                </div>

                <?php if (count($product)) { ?>
                    <div class="row dvi">
                        <div class="row-left">
                            <p><?php echo FSText::_("Đơn vị tính:");?></p>
                        </div>
                        <div class="row-right bdbt">
                            <div class="products_type">
                                <?php

                                foreach ($product as $item) {
                                    ?>
                                    <div data="products_type_item" name="products_type_title"
                                         name-item="<?php echo $item->name; ?>"
                                         products_type_id="<?php echo $item->id; ?>"
                                         class="item_price products_type_item products_type_click">
                                        <p><?php echo $item->name; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="clearfix">

                </div>
<!--                <div class="danhgia_sao1">-->
<!--                    <div class="visible_pc">-->
<!--                        --><?php //if (!$total_cmt) { ?>
<!--                            <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                        --><?php //} else { ?>
<!--                            --><?php //if (formatNumber($sum_rate) == 1) { ?>
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            --><?php //} else if (formatNumber($sum_rate) == 2) { ?>
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            --><?php //} else if (formatNumber($sum_rate) == 3) { ?>
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            --><?php //} else if (formatNumber($sum_rate) == 4) { ?>
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao3.png' ?><!--">-->
<!--                            --><?php //} else { ?>
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                                <img class="img_sao1" src="--><?php //echo URL_ROOT . 'images\icon_sao1.png' ?><!--">-->
<!--                            --><?php //} ?>
<!---->
<!--                        --><?php //} ?>
<!--                    </div>-->
<!--                    <p class="p2">--><?php //echo formatNumber($sum_rate); ?><!--/5</p>-->
<!--                    <p class="p3">(Xem --><?php //echo $total_cmt; ?><!-- đánh giá)</p>-->
<!--                    <span class="mb_span">|</span>-->
<!--  -->
<!--                    <div class="quantt">-->
<!--                        <p class=" --><?php //if ($data->quantity) {
//                            echo ' quant';
//                        } else {
//                            echo ' out_of_stock';
//                        } ?><!-- ">--><?php //if ($data->quantity) {
//                                echo 'Còn hàng';
//                            } else {
//                                echo 'Hết hàng';
//                            } ?>
<!--                        </p>-->
<!--                    </div>-->
<!--                    <span class="mb_span">|</span>-->
<!--                    <div class="share_mobile">-->
<!---->
<!--                        <a href="javascript:void (0);" class="open_share">-->
<!--                            <img src="--><?php //echo URL_ROOT . 'modules/products/assets/images/share.png' ?><!--"-->
<!--                                 alt="share"-->
<!--                                 class="img-responsive">-->
<!--                        </a>-->
<!--                        <div class="share_mb">-->
<!---->
<!--                            <script type="text/javascript"-->
<!--                                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d9f134510ff2443"></script>-->
<!---->
<!---->
<!--                            <div class="addthis_inline_share_toolbox_eip1"></div>-->
<!---->
<!---->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                    <p class="favorite_prd">-->
<!--                        --><?php //if ($favourite_user->like == 1) { ?>
<!--                            <a class="click_fvr" href="javascript: void(0)" onclick="un_like()" title="bỏ thích">-->
<!---->
<!--                                <i class="fas fa-heart"></i>-->
<!---->
<!--                                <span class="mb_span">Đã thích(--><?//= count($favourite_item) ?><!--)</span>-->
<!--                            </a>-->
<!---->
<!--                        --><?php //} else { ?>
<!--                            <a class="click_fvr" href="javascript: void(0)" onclick="like()" title="thích">-->
<!---->
<!--                                <i class="fal fa-heart"></i>-->
<!---->
<!--                                <span class="mb_span">Đã thích(--><?//= count($favourite_item) ?><!--)</span>-->
<!--                            </a>-->
<!--                        --><?php //} ?>
<!--                    </p>-->
<!--                </div>-->



                <div class=" buy_mobile_popup">
                    <div class="row-left left_quan">
                        <p class="quan2">Số lượng</p>
                    </div>
                    <div class=" row-right right_quan">

                        <p class="quantity">
                                                <span class="number-input">
                                                     <button onclick="down_quantity(<?php echo $data->id?>)"
                                                             class="down"></button>
                                                    <input type="number"
                                                           name="quantity_<?php echo $data->id?>"
                                                           id="quantity_<?php echo $data->id?>"
                                                           class="numbersOnly<?php echo $i; ?>"
                                                           maxlength="5"
                                                           onblur="change_quantity(<?php echo $data->id ?>)"
                                                           value="1" />
                                                    <button onclick="up_quantity(<?php echo $data->id  ?>)"
                                                            class="plus"></button>
                                                    <button onclick="this.parentNode.querySelector('input#quantity_<?php echo $data->id; ?>').stepDown()"
                                                            class="docccwn hide"></button>
                                                </span>
                        </p>
                    </div>


                </div>
                <div class="bottom-add-cart">
                    <a href="#" onclick="order(<?php echo $data->id; ?>)">
                        <p class="buy-now">
                            <?php echo FSText::_("Thêm vào giỏ hàng"); ?>
                        </p>
                    </a>
                </div>
                <div class="tien-ich-sp">
                    <?php foreach ($list_tienich as $item){ ?>
                        <div class="item-tienich">
                            <div class="img">
                                <img src="<?php echo URL_ROOT.$item->image ?>" alt="<?php echo $item->name ?>">
                            </div>
                            <p class="name"><?php echo $item->name ?></p>
                        </div>
                    <?php } ?>

                </div>
                <div class="bottom-buy-now  col-sm-4 col-xs-6">
                    <form id="frombuyb" name="formbuyb"
                          action="<?php echo URL_ROOT . 'index.php?module=products&view=product&task=buynow&id=' . $data->id; ?>"
                          method="post">
<!--                        <a href="javascript:void(0)" onclick="submitFormb()">-->
<!---->
<!--                            <p class="buy-now">--><?php //echo FSText::_("Mua ngay"); ?><!--</p>-->
<!--                        </a>-->
                        <input type="hidden" name="quantity_now" id="quantity_now" value="1">
                        <input type="hidden" name="quantity_sub" id="quantity_sub" value="">
                        <input type="hidden" name="quantity_main" id="quantity_main"
                               value="300">

                        <input type="hidden" id="products_type_input_buynow" name='products_type_input_buynow'
                               value=""/>
                        <input type="hidden" id="id_sub" name='id_sub'
                               value=""/>
                        <input type="hidden" id="price_input_buynow" name='price_input_buynow'
                               value="<?php echo $data->price ?>"/>
                    </form>
                    <div class="clearfix"></div>
                </div>



            </div>
        </div>
        <?php if($list_muacung){ ?>
            <div class="sp_muacung">
                <div class="block-1-muacung">
                     <h3><?php echo FSText::_("Thông tin sản phẩm"); ?></h3>
                     <p class="p-total-money">
                         <?php echo FSText::_("Tổng tiền"); ?>
                        <span class="">0đ</span>
                     </p>
                    <input type="hidden" id="total_money_muacung" value="0">
                    <input type="hidden" id="id_muacung" value="">
                    <a class="a-add-giohang" href="javascript:void(0)" onclick="muacung()"><?php echo FSText::_("Thêm vào giỏ hàng"); ?></a>
                </div>
                <div class="block-2-muacung row">
                    <?php foreach ($list_muacung as $item){
                        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                        ?>
                        <div class="item-sp col-md-3">
                            <div class="bao-item-sp bao-item-sp-<?php echo $item->id ?>" id="bao-item-sp-<?php echo $item->id ?>">
                                <a class="a-img" href="<?php echo $link ?>">
                                    <img src="<?php echo URL_ROOT. str_replace('original', 'tiny', $item->image); ?>" alt="<?php echo $item->name ?>">
                                </a>
                                <a class="a-title" href="<?php echo $link ?>">
                                    <?php echo $item->name ?>
                                </a>
                                <div class="money_sp">
                                    <p class="text-price" ><?php echo format_money($item->price) ?></p>
                                    <?php if($item->price_old){ ?>
                                        <p class="text-price-old"><?php echo format_money($item->price_old) ?></p>
                                        <p class="giamgia">-<?php echo $item->giamgia ?>%</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <input type="hidden" id="money-muacung-<?php echo $item->id ?>" value="<?php echo $item->price ?>">
                            <div class="check_box1">
                                <label class="check-box">
                                    <input type="checkbox" id="check_<?php echo $item->id ?>" class="check_" required onclick="check(<?php echo $item->id ?>)">
                                    <span class="checkmark"><?php echo FSText::_("Chọn mua"); ?></span>
                                </label>
                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>
        <?php } ?>

        <div class="content_4 row">
            <div class="left-thongtin-content4 col-md-7">
                <h3><?php echo FSText::_("Thông tin sản phẩm"); ?></h3>
                <div class="content-nd boxdesc" id="boxdesc" style="height: 500px;" data-height="500">
                    <?php echo $data->content ?>
                </div>
                <div class="more-thugon">
                    <a class="details_click clickmore" href="javascript:void(0)" data-class="1" data-id='boxdesc'>Xem thêm </a> <span class="caret"></span>
                </div>

                <?php include 'plugins/comments/comments_tree.php'; ?>

            </div>


            <div class="right-thong-tin-content4 col-md-5">
                <div class="div-list-nhomhang">
                    <h3><?php echo FSText::_("Nhóm hàng thường mua"); ?></h3>
                    <div class="list-nhomhang row">
                        <?php $i=1; foreach ($nhomhang as $item){
                            $class = '';
                            if($i%5==0){
                                $class .= 'mg5';
                            }
                            $link = FSRoute::_("index.php?module=products&view=cat&ccode=".$item->alias. "&cid=" . $item->id );
                            ?>
                            <div class="item-nhomhang col-sm-4 <?php echo $class ?> <?php if($i==9){ ?>item-mg9<?php } ?>">
                                <a class="img-nhomhang" href="<?php echo $link ?>">
                                    <img src="<?php echo URL_ROOT. str_replace('original', 'normal', $item->icon); ?>" alt="">
                                </a>
                                <a class="info-nhomhang" href="<?php echo $link ?>">
                                    <?php echo $item->name ?>
                                </a>
                            </div>
                            <?php $i++; } ?>
                    </div>
                    <div class="upcoming">
                        <div class="content_upcoming owl-carousel">
                            <?php $i=1; foreach ($nhomhang as $item){
                                $link = FSRoute::_("index.php?module=products&view=cat&ccode=".$item->alias. "&cid=" . $item->id );
                                ?>
                                <div class="item-nhomhang">
                                    <a class="img-nhomhang" href="<?php echo $link ?>">
                                        <img src="<?php echo URL_ROOT. str_replace('original', 'normal', $item->icon); ?>" alt="<?php echo $item->name ?>">
                                    </a>
                                    <a class="info-nhomhang" href="<?php echo $link ?>">
                                        <?php echo $item->name ?>
                                    </a>
                                </div>
                                <?php $i++; } ?>
                        </div>
                    </div>
                </div>
                <div class="news-khuyenmai">
                    <h3>
                        <?php echo FSText::_("Khuyến mãi"); ?>
                        <a href="<?php echo FSRoute::_('index.php?module=news&view=cat&ccode=' . $list_news[0]->category_alias . '&id=' . $list_news[0]->category_id); ?>"><?php echo FSText::_("Xem tất cả"); ?> <i class="fal fa-chevron-right"></i></a>
                    </h3>
                    <div class="list-km">
                        <?php foreach ($list_news as $item){
                            $link = FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id);
                            ?>
                            <div class="item-km">
                                <a class="img-km" href="<?php echo $link ?>">
                                    <img src="<?php echo URL_ROOT. str_replace('original', 'small', $item->image); ?>" alt="">
                                </a>
                                <div class="info-km">
                                    <a class="a-title-km" href="<?php echo $link ?>"><?php echo $item->title ?></a>
                                    <p class="time-km"><i class="fal fa-clock"></i> <?php echo date('H:i d/m/Y', strtotime($item->created_time)); ?></p>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>

            </div>
        </div>

        <?php include 'default_related.php'; ?>

    </div>
</div>

<input type="hidden" id="products_type_count" name='products_type_count'
       value="<?php echo(count($product)) ?>"/>
<input type="hidden" id="products_type_input" name='products_type'
       value=""/>
<input type="hidden" id="price_input" name='price' value="<?php echo $data->price ?>"/>
<input type="hidden" id="return" name='return' value="<?php echo $url_current ?>"/>
<input type="hidden" id="user_id" name='user_id' value="<?php echo $_SESSION['user_id'] ?>"/>


