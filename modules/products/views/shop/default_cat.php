<?php
//die;<link rel="stylesheet" type="text/css" href="../css/sanpham.css">
//	<link rel="stylesheet" href="../css/owl.carousel.min.css">
//    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
//    <script src="../js/owl.carousel.js"></script>
global $tmpl;
$tmpl->addStylesheet('cat1', 'modules/products/assets/css');
//$tmpl->addStylesheet('sanpham', 'modules/products/assets/css');
$tmpl->addStylesheet('owl.carousel.min', 'modules/products/assets/css');
$tmpl->addStylesheet('owl.theme.default.min', 'modules/products/assets/css');
$tmpl->addScript('owl.carousel', 'modules/products/assets/js');
$tmpl->addScript('cat', 'modules/products/assets/js');
//$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$act = FSInput::get('sort');
$fist = "";
$prices = FSInput::get('prices');
$origin = FSInput::get('origin');
$object = FSInput::get('object');
$color = FSInput::get('color');
$producer = FSInput::get('producer');
$company = FSInput::get('company');
$sort = FSInput::get('sort');
switch ($sort) {
    case 'hits':
        $name_sort = "Xem nhiều nhất";
        break;
    case 'sale_of':
        $name_sort = "Khuyến mãi";
        break;
    case 'buy':
        $name_sort = "Bán chạy";
        break;
    case 'new':
        $name_sort = "Mới nhất";
        break;
    case 'up':
        $name_sort = "Giá từ thấp đến cao";
        break;
    case 'down':
        $name_sort = "Giá từ cao đến thấp";
        break;
    default:
        $name_sort = "Mặc định";
}
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$tmpl->addTitle($cat->name);
if ($prices || $origin || $object || $color || $producer || $company || strpos($url, '?')) {
    $fist = "";
} else
    $fist = '?';
//echo 1;die;
?>
<input type="hidden" name="quantity" id="quantity" value="1">

<aside class="new-contents">
    <div class="row">
        <div class=" col-md-2 col-sm-12 col-xs-12 visible mobile">
            <div class="frame_head clearfix">
                <a class="btn btn10" data-toggle="collapse" href="#collapseExample" role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Danh mục sách
                    <i class="fa fa-angle-down"></i>
                </a>
                <div class="collapse mobile_cat" id="collapseExample">
                    <?php echo $tmpl->load_direct_blocks("services_menu", array("style" => "default")); ?>
                </div>
            </div>
        </div>
        <div class="main-column-left col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <div class="frame_head clearfix">
                <h2><span class="title_prd"><?php echo FSText::_("Danh mục sách"); ?></span></h2>
                <?php echo $tmpl->load_direct_blocks("services_menu", array("style" => "default")); ?>
            </div>

            <?php
            if (!FSInput::get('prices')) {

                ?>
                <div class="filter_price filmb">
                    <div class="panel-heading-company">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" href="javascript:void(0)">
                                <?php echo FSText::_("Giá sản phẩm"); ?>
                            </a>
                        </h4>
                    </div>
                    <ul>
                        <?php foreach ($list_price as $item) { ?>
                            <li>
                                <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&prices=' . $item->id . ':' . $item->alias ?>"><?php echo $item->name; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php
            }
            ?>
            <!--            --><?php
            //            if ($cat->not_book) {
            //                if(!$producer){
            //                ?>
            <!--                <div class="panel-info-company filmb">-->
            <!--                    <div class="panel-heading-company">-->
            <!--                        <h4 class="panel-title">-->
            <!--                            <a class="accordion-toggle" href="javascript:void(0)">-->
            <!--                                --><?php //echo FSText::_("Thương hiệu - nhà sản xuất"); ?>
            <!--                            </a>-->
            <!--                        </h4>-->
            <!--                    </div>-->
            <!--                    <div class="panel-collapse-company" style="height: 300px;overflow-y: scroll;">-->
            <!--                        <ul class="list-group">-->
            <!--                            --><?php //foreach ($list_producer as $item) { ?>
            <!--                                <li class="list-group-item">-->
            <!--                                    <a href="-->
            <?php //echo 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].$fist. '&producer=' . $item->id . ':' . $item->alias ?><!--">-->
            <?php //echo $item->name; ?><!--</a>-->
            <!--                                </li>-->
            <!--                            --><?php //} ?>
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                --><?php
            //            }} else {
            //                if(!$company){
            //                ?>
            <!--                <div class="panel-info-company filmb">-->
            <!--                    <div class="panel-heading-company">-->
            <!--                        <h4 class="panel-title">-->
            <!--                            <a class="accordion-toggle" href="javascript:void(0)">-->
            <!--                                --><?php //echo FSText::_("Nhà phát hành"); ?>
            <!--                            </a>-->
            <!--                        </h4>-->
            <!--                    </div>-->
            <!--                    <div class="panel-collapse-company" style="height: 300px;overflow-y: scroll;">-->
            <!--                        <ul class="list-group">-->
            <!--                            --><?php //foreach ($list_company as $item) { ?>
            <!--                                <li class="list-group-item">-->
            <!--                                    <a href="-->
            <?php //echo 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].$fist. '&company=' . $item->id . ':' . $item->alias ?><!--">-->
            <?php //echo $item->name; ?><!--</a>-->
            <!--                                </li>-->
            <!--                            --><?php //} ?>
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                --><?php
            //            }}
            //            ?>


            <div class="panel-info-company filmb">
                <div class="panel-heading-company">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" href="javascript:void(0)">
                            <?php echo FSText::_("Tác giả"); ?>
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse-company" style="height: 300px;overflow-y: scroll;">
                    <ul class="list-group">
                        <?php foreach ($list_author as $item) { ?>
                            <li class="list-group-item">
                                <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&company=' . $item->id . ':' . $item->alias ?>"><?php echo $item->name; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!--            --><?php
            //                if(!$object) {
            //                    ?>
            <!--                    <div class="filter_price filmb">-->
            <!--                        <div class="panel-heading-company">-->
            <!--                            <h4 class="panel-title">-->
            <!--                                <a class="accordion-toggle" href="javascript:void(0)">-->
            <!--                                    --><?php //echo FSText::_("Đối tượng sử dụng"); ?>
            <!--                                </a>-->
            <!--                            </h4>-->
            <!--                        </div>-->
            <!--                        <ul>-->
            <!--                            --><?php //foreach ($list_object as $item) { ?>
            <!--                                <li>-->
            <!--                                    <a href="-->
            <?php //echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&object=' . $item->id . ':' . $item->alias ?><!--">-->
            <?php //echo $item->name; ?><!--</a>-->
            <!--                                </li>-->
            <!--                            --><?php //} ?>
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                    --><?php
            //                }
            //            if ($cat->not_book) {
            //                if(!$color) {
            //                    ?>
            <!--                    <div class="filter_price filmb" style="margin-top: 20px;padding-top: 20px;border-top: 1px solid #eee;">-->
            <!--                        <div class="panel-heading-company">-->
            <!--                            <h4 class="panel-title">-->
            <!--                                <a class="accordion-toggle" href="javascript:void(0)">-->
            <!--                                    --><?php //echo FSText::_("Màu sắc"); ?>
            <!--                                </a>-->
            <!--                            </h4>-->
            <!--                        </div>-->
            <!--                        <ul>-->
            <!--                            --><?php //foreach ($list_color as $item) { ?>
            <!--                                <li>-->
            <!--                                    <a href="-->
            <?php //echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&color=' . $item->id . ':' . $item->alias ?><!--">-->
            <?php //echo $item->name; ?><!--</a>-->
            <!--                                </li>-->
            <!--                            --><?php //} ?>
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                    --><?php
            //                }
            //                if(!$origin){
            //                    ?>
            <!--                <div class="filter_price filmb" style="margin-top: 20px;padding-top: 20px;border-top: 1px solid #eee;">-->
            <!--                    <div class="panel-heading-company">-->
            <!--                        <h4 class="panel-title">-->
            <!--                            <a class="accordion-toggle" href="javascript:void(0)">-->
            <!--                                --><?php //echo FSText::_("Xuất xứ"); ?>
            <!--                            </a>-->
            <!--                        </h4>-->
            <!--                    </div>-->
            <!--                    <ul>-->
            <!--                        --><?php //foreach ($list_origin as $item) { ?>
            <!--                            <li>-->
            <!--                                <a href="-->
            <?php //echo 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].$fist. '&origin=' . $item->id . ':' . $item->alias; ?><!--">-->
            <?php //echo $item->name; ?><!--</a>-->
            <!--                            </li>-->
            <!--                        --><?php //} ?>
            <!--                    </ul>-->
            <!--                </div>-->
            <!--                --><?php
            //            }}
            //            ?>

        </div>
        <div class="main-column-content col-lg-10 col-md-10 col-sm-12 col-xs-12">
            <!--            <div class="title-module"><h1>--><?php //echo $cat->name; ?><!--</h1>-->
            <!--                <p>Có <span>--><?php //echo $total; ?><!-- </span>sản phẩm</p>-->
            <!--            </div>-->

            <div class="list-products">
                <div class="filter-items  filmb">
                    <?php
                    if ($prices || $origin || $object || $color || $producer || $company) {
                        ?>
                        <h4>Tiêu chí đang chọn:</h4>
                        <?php
                        if ($prices) {
                            $urlp = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkp = str_replace('&prices=' . $prices, '', $urlp);
                            ?>
                            <p>Giá: <?= $pri->name ?><a href="<?= $linkp ?>">&#215;</a></p>
                            <?php
                        }
                        if ($producer) {
                            $urlpr = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkpr = str_replace('&producer=' . $producer, '', $urlpr);
                            ?>
                            <p>Thương hiệu: <?= $pro->name ?><a href="<?= $linkpr ?>">&#215;</a></p>
                            <?php
                        }

                        if ($company) {
                            $urlcm = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkcm = str_replace('&company=' . $company, '', $urlcm);
                            ?>
                            <p>Tác giả: <?= $coma->name ?><a href="<?= $linkcm ?>">&#215;</a></p>
                            <?php
                        }

                        if ($object) {
                            $urlob = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkob = str_replace('&object=' . $object, '', $urlob);
                            ?>
                            <p>Đối tượng: <?= $obj->name ?><a href="<?= $linkob ?>">&#215;</a></p>
                            <?php
                        }

                        if ($color) {
                            $urlco = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkco = str_replace('&color=' . $color, '', $urlco);
                            ?>
                            <p>Màu sắc: <?= $cor->name ?><a href="<?= $linkco ?>">&#215;</a></p>
                            <?php
                        }

                        if ($origin) {
                            $urlor = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkor = str_replace('&origin=' . $origin, '', $urlor);
                            ?>
                            <p>Xuất xứ: <?= $ori->name ?><a href="<?= $linkor ?>">&#215;</a></p>
                            <?php
                        }
                        $linkurl = explode('?', $url);
                        ?>
                        <p class="dellall">Xóa tất cả<a href="<?= $linkurl[0] ?>">&#215;</a></p>
                        <?php
                    }
                    ?>
                </div>
                <!--                <div class="tendency_shopping  filmb">-->
                <!--                    <p>--><?php //echo FSText::_("Xu hướng tiêu dùng"); ?><!--</p>-->
                <!--                    <ul class="clearfix">-->
                <!--                        --><?php //foreach ($list_tags as $item) { ?>
                <!--                            --><?php
                //                            if ($item->link) {
                //                                $link_tags = $item->link;
                //                            } else {
                //                                $link_tags = FSRoute::_('index.php?module=products&view=search&keyword=' . $item->alias);
                //                            }
                //                            ?>
                <!--                            <li><a href="--><?php //echo $link_tags; ?><!--"-->
                <!--                                   target="-->
                <?php //echo ($item->target == 1) ? '_blank' : ''; ?><!--">--><?php //echo $item->name; ?><!--</a>-->
                <!--                            </li>-->
                <!--                        --><?php //} ?>
                <!--                    </ul>-->
                <!--                </div>-->
                <!--                <div class="sort_product  filmb">-->
                <!--                    <p>-->
                <!--                        --><?php //echo FSText::_("Sắp xếp theo"); ?><!--:-->
                <!--                        <a class="-->
                <?php //if ($act == 'hits' || $act == '') echo 'active'; ?><!--"-->
                <!--                           href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&sort=hits'); ?><!--">-->
                <?php //echo FSText::_("Xem nhiều nhất"); ?><!--</a>-->
                <!--                        <a class="--><?php //if ($act == 'sale_of') echo 'active'; ?><!--"-->
                <!--                           href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&sort=sale_of'); ?><!--">-->
                <?php //echo FSText::_("Khuyến mãi"); ?><!--</a>-->
                <!--                        <a class="--><?php //if ($act == 'buy') echo 'active'; ?><!--"-->
                <!--                           href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&sort=buy'); ?><!--">-->
                <?php //echo FSText::_("Bán chạy"); ?><!--</a>-->
                <!--                        <a class="--><?php //if ($act == 'new') echo 'active'; ?><!--"-->
                <!--                           href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&sort=new'); ?><!--">-->
                <?php //echo FSText::_("Mới nhất"); ?><!--</a>-->
                <!--                        <a class="--><?php //if ($act == 'up') echo 'active'; ?><!--"-->
                <!--                           href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&sort=up'); ?><!--">-->
                <?php //echo FSText::_("Giá từ thấp đến cao"); ?><!--</a>-->
                <!--                        <a class="--><?php //if ($act == 'down') echo 'active'; ?><!--"-->
                <!--                           href="-->
                <?php //echo FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&sort=down'); ?><!--">-->
                <?php //echo FSText::_("Giá từ cao đến thấp"); ?><!--</a>-->
                <!--                    </p>-->
                <!--                </div>-->
                <?php if ($list_hot) { ?>
                    <div class="right_1_content">
                        <div class="a_right1_content">
                            <p class="p3"><?php echo $cat->name; ?> bán chạy nhất</p>
                        </div>
                        <div class="b_right1_content">
                            <div class="content_6">
                                <div class="content6_1 owl-carousel owl-theme">
                                    <?php foreach ($list_hot as $item) {
                                        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                                        $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                                        ?>
                                        <div class="a_content6_1 item">
                                            <a class="image_check" href="<?php echo $link; ?>">
                                                <img class="img_spchitiet4_1" src="<?php echo $image ?>" onerror="this.src='/images/not_picture.png'">
                                                <p class="p28"><?php echo $item->name; ?></p>
                                                <p class="p29"><?php echo getWord(3, $item->author_book); ?></p>
                                                <!--                                        <p class="a5_5"><a class="a5" href="">-31%</a></p>-->
                                                <div class="evaluate">
                                                    <div style="display: flex;">
                                                        <?php if (!$item->rating_count) { ?>
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                        <?php } else { ?>
                                                            <?php if (formatNumber($item->rating_count) == 1) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 2) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 3) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 4) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                            <?php } ?>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="price-book clearfix">
                                                    <?php echo format_money($item->price); ?>
                                                    <?php if ($item->price < $item->price_old) { ?>
                                                        <span class="sale-tag sale-tag-square"><?php echo '- ' . $item->discount . ' %'; ?></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="price-regular">
                                                    <?php if ($item->price < $item->price_old) { ?>
                                                        <?php echo format_money($item->price_old); ?>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                            <div class="p31 bottom-add-cart">
                                                <a href="#" class="a6" onclick="order(<?php echo $item->id; ?>)">
                                                    <p class="buy-now"><?php echo FSText::_("Thêm vào giỏ hàng"); ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix right_2_content">
                        <!--                    --><?php //echo $tmpl->load_direct_blocks('banners', array('style' => 'default', 'category_id' => '14')); ?>
                        <?php foreach ($banner1 as $key) { ?>
                            <a href="<?php echo $key->link; ?>" class="img_baner1" title='<?php echo $key->name; ?>'>
                                <?php if ($key->width && $key->height) { ?>
                                    <img class="img-responsive" alt="<?php echo $key->name; ?>"
                                         src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $key->image); ?>"
                                         width="<?php echo $key->width; ?>" height="<?php echo $key->height; ?>">
                                <?php } else { ?>
                                    <img class="img-responsive" alt="<?php echo $key->name; ?>"
                                         src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $key->image); ?>">
                                <?php } ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($list_sale) { ?>
                    <div class="right_3_content">
                        <div class="a_right1_content">
                            <p class="p3"><?php echo $cat->name; ?> đang khuyến mại</p>
                        </div>
                        <div class="b_right1_content">
                            <div class="content_6">
                                <div class="content6_1 owl-carousel owl-theme">
                                    <?php foreach ($list_sale as $item) {
                                        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                                        $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                                        ?>
                                        <div class="a_content6_1 item">
                                            <a class="image_check" href="<?php echo $link; ?>">
                                                <img class="img_spchitiet4_1" src="<?php echo $image ?>" onerror="this.src='/images/not_picture.png'">
                                                <p class="p28"><?php echo $item->name; ?></p>
                                                <p class="p29"><?php echo getWord(3, $item->author_book); ?></p>
                                                <!--                                        <p class="a5_5"><a class="a5" href="">-31%</a></p>-->
                                                <div class="evaluate">
                                                    <div style="display: flex;">
                                                        <?php if (!$item->rating_count) { ?>
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                        <?php } else { ?>
                                                            <?php if (formatNumber($item->rating_count) == 1) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 2) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 3) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 4) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                            <?php } ?>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="price-book clearfix">
                                                    <?php echo format_money($item->price); ?>
                                                    <?php if ($item->price < $item->price_old) { ?>
                                                        <span class="sale-tag sale-tag-square"><?php echo '- ' . $item->discount . ' %'; ?></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="price-regular">
                                                    <?php if ($item->price < $item->price_old) { ?>
                                                        <?php echo format_money($item->price_old); ?>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                            <div class="p31 bottom-add-cart">
                                                <a href="#" class="a6" onclick="order(<?php echo $item->id; ?>)">
                                                    <p class="buy-now"><?php echo FSText::_("Thêm vào giỏ hàng"); ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix right_4_content">
                        <?php foreach ($banner2 as $key) { ?>
                            <a href="<?php echo $key->link; ?>" class="img_baner1" title='<?php echo $key->name; ?>'>
                                <?php if ($key->width && $key->height) { ?>
                                    <img class="img-responsive" alt="<?php echo $key->name; ?>"
                                         src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $key->image); ?>"
                                         width="<?php echo $key->width; ?>" height="<?php echo $key->height; ?>">
                                <?php } else { ?>
                                    <img class="img-responsive" alt="<?php echo $key->name; ?>"
                                         src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $key->image); ?>">
                                <?php } ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($list_new) { ?>
                    <div class="right_5_content">
                        <div class="a_right1_content">
                            <p class="p3"><?php echo $cat->name; ?> mới ra mắt</p>
                        </div>
                        <div class="b_right1_content">
                            <div class="content_6">
                                <div class="content6_1 owl-carousel owl-theme">
                                    <?php foreach ($list_new as $item) {
                                        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                                        $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
//                                    var_dump($list_new);die;
                                        ?>
                                        <div class="a_content6_1 item">
                                            <a class="image_check" href="<?php echo $link; ?>">
                                                <img class="img_spchitiet4_1" src="<?php echo $image ?>" onerror="this.src='/images/not_picture.png'">
                                                <p class="p28"><?php echo $item->name; ?></p>
                                                <p class="p29"><?php echo getWord(3, $item->author_book); ?></p>
                                                <!--                                        <p class="a5_5"><a class="a5" href="">-31%</a></p>-->
                                                <div class="evaluate">
                                                    <div style="display: flex;">
                                                        <?php if (!$item->rating_count) { ?>
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <img class="img_sao1"
                                                                 src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                        <?php } else { ?>
                                                            <?php if (formatNumber($item->rating_count) == 1) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 2) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 3) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else if (formatNumber($item->rating_count) == 4) { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao3.png' ?>">
                                                            <?php } else { ?>
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                                <img class="img_sao1"
                                                                     src="<?php echo URL_ROOT . 'images\icon_sao1.png' ?>">
                                                            <?php } ?>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="price-book clearfix">
                                                    <?php echo format_money($item->price); ?>
                                                    <?php if ($item->discount) { ?>
                                                        <span class="sale-tag sale-tag-square"><?php echo '- ' . $item->discount . ' %'; ?></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="price-regular">
                                                    <?php if ($item->price < $item->price_old) { ?>
                                                        <?php echo format_money($item->price_old); ?>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                            <div class="p31 bottom-add-cart">
                                                <a href="#" class="a6" onclick="order(<?php echo $item->id; ?>)">
                                                    <p class="buy-now"><?php echo FSText::_("Thêm vào giỏ hàng"); ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix right_6_content">
                        <?php foreach ($banner3 as $key) { ?>
                            <a href="<?php echo $key->link; ?>" class="img_baner1" title='<?php echo $key->name; ?>'>
                                <?php if ($key->width && $key->height) { ?>
                                    <img class="img-responsive" alt="<?php echo $key->name; ?>"
                                         src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $key->image); ?>" onerror="this.src='/images/not_picture.png'"
                                         width="<?php echo $key->width; ?>" height="<?php echo $key->height; ?>">
                                <?php } else { ?>
                                    <img class="img-responsive" alt="<?php echo $key->name; ?>"
                                         src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $key->image); ?>">
                                <?php } ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!--                <div class="right_7_content">-->
                <!--                    <div class="a_right1_content">-->
                <!--                        <p class="p3">--><?php //echo $cat->name; ?><!-- sắp ra mắt</p>-->
                <!--                    </div>-->
                <!--                    <div class="b_right1_content">-->
                <!--                        <div class="content_6">-->
                <!--                            <div class="content6_1 owl-carousel owl-theme">-->
                <!--                                --><?php //foreach ($list_coming as $item) {
                //                                    $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                //                                    $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                ////                                    var_dump($list_new);die;
                //                                    ?>
                <!--                                    <div class="a_content6_1 item">-->
                <!--                                        <a class="image_check" href="-->
                <?php //echo $link; ?><!--">-->
                <!--                                            <img class="img_spchitiet4_1" src="-->
                <?php //echo $image ?><!--">-->
                <!--                                            <p class="p28">-->
                <?php //echo $item->name; ?><!--</p>-->
                <!--                                            <p class="p29">-->
                <?php //echo getWord(3, $item->author_book); ?><!--</p>-->
                <!--                                            <!--                                        <p class="a5_5"><a class="a5" href="">-31%</a></p>-->
                <!--                                            <div class="evaluate">-->
                <!--                                                <div style="display: flex;">-->
                <!--                                                    --><?php //if (!$item->rating_count) { ?>
                <!--                                                        <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                    --><?php //} else { ?>
                <!--                                                        --><?php //if (formatNumber($item->rating_count) == 1) { ?>
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        --><?php //} else if (formatNumber($item->rating_count) == 2) { ?>
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        --><?php //} else if (formatNumber($item->rating_count) == 3) { ?>
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        --><?php //} else if (formatNumber($item->rating_count) == 4) { ?>
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao3.png'?><!--">-->
                <!--                                                        --><?php //} else { ?>
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                            <img class="img_sao1" src="-->
                <?php //echo URL_ROOT.'images\icon_sao1.png'?><!--">-->
                <!--                                                        --><?php //} ?>
                <!---->
                <!--                                                    --><?php //} ?>
                <!--                                                </div>-->
                <!--                                            </div>-->
                <!--                                            <div class="price-book clearfix">-->
                <!--                                                --><?php //echo format_money($item->price); ?>
                <!--                                                --><?php //if ($item->discount) { ?>
                <!--                                                    <span class="sale-tag sale-tag-square">-->
                <?php //echo '- ' . $item->discount . ' %'; ?><!--</span>-->
                <!--                                                --><?php //} ?>
                <!--                                            </div>-->
                <!--                                            <div class="price-regular">-->
                <!--                                                --><?php //if ($item->price != $item->price_old) { ?>
                <!--                                                    --><?php //echo format_money($item->price_old); ?>
                <!--                                                --><?php //} ?>
                <!--                                            </div>-->
                <!--                                        </a>-->
                <!--                                        <div class="p31 bottom-add-cart">-->
                <!--                                            <a href="#" class="a6" onclick="order(<?php //echo $item->id; ?>)">
                <!--                                              <p class="buy-now"><?php //echo FSText::_("Thêm vào giỏ hàng"); ?><!--</p>-->
                <!--                                            </a>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                --><?php //} ?>
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="clearfix right_8_content">-->
                <!--                    --><?php //foreach ($banner4 as $key){ ?>
                <!--                        <a href="--><?php //echo $key -> link;?><!--" class="img_baner1" title='-->
                <?php //echo $key -> name;?><!--'>-->
                <!--                            --><?php //if($key -> width && $key -> height){?>
                <!--                                <img class="img-responsive"  alt="-->
                <?php //echo $key -> name; ?><!--" src="-->
                <?php //echo URL_ROOT.str_replace('/original/','/resized/', $key -> image);?><!--" width="-->
                <?php //echo $key -> width;?><!--" height="--><?php //echo $key -> height;?><!--">-->
                <!--                            --><?php //} else { ?>
                <!--                                <img class="img-responsive" alt="-->
                <?php //echo $key -> name; ?><!--" src="-->
                <?php //echo URL_ROOT.str_replace('/original/','/resized/', $key -> image);?><!--">-->
                <!--                            --><?php //}?>
                <!--                        </a>-->
                <!--                    --><?php //} ?>
                <!--                </div>-->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</aside>

