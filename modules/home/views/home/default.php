<?php
global $tmpl, $config;
$tmpl->setMeta('og:image', URL_ROOT . $config['logo']);
$tmpl->addStylesheet('home', 'modules/home/assets/css');
   $tmpl -> addStylesheet('owl.carousel.min','libraries/owlcarousel/assets');
   $tmpl -> addStylesheet('owl.theme.default','libraries/owlcarousel/assets');
   $tmpl -> addScript('owl.carousel.min','libraries/owlcarousel');
$tmpl->addScript('default', 'modules/home/assets/js');
//$alert_info = array(
//    0 => FSText::_('Danh mục đã hết'),
//);

$limit_sp = 20;

use Guzzle\Http\Url; ?>
<input type="hidden" id="alert_info" value='<?php echo json_encode($alert_info) ?>'/>
<div class="slide_home">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            $i = 0;
            foreach ($banner as $key => $slider) {
                ?>
                <li data-target="#myCarousel" data-slide-to="<?php echo $i ?> "
                    class="<?php echo ($key == 0) ? "active" : ""; ?>">
                </li>
                <?php $i++;
            } ?>
        </ol>

        <div class="carousel-inner">

            <?php $i = 0;
            foreach ($banner as $key => $slider) {
                ?>
                <div class="item <?php echo ($key == 0) ? "active" : ""; ?> ">
                    <img src="<?php echo URL_ROOT.str_replace('/original/','/original/', @$slider->image) ?>" alt="<?php echo $key->id ?>">
                </div>
                <?php $i++;
            } ?>

        </div>

<!--        <a class="left carousel-control" href="#myCarousel" data-slide="prev">-->
<!--            <span class="glyphicon glyphicon-chevron-left"><img src="--><?php //echo URL_ROOT.'modules/home/assets/images/back.png' ?><!--" alt="back"></span>-->
<!--        </a>-->
<!--        <a class="right carousel-control" href="#myCarousel" data-slide="next">-->
<!--            <span class="glyphicon glyphicon-chevron-right"><img src="--><?php //echo URL_ROOT.'modules/home/assets/images/next.png' ?><!--" alt="back"></span>-->
<!--        </a>-->
    </div>
</div>
<div class="container">
    <div class="tienich_mobile">
        <?php foreach ($tienich as $item){ ?>
            <div class="item_tienich">
                <a href="#" class="a_item_tienich">
                    <div class="inline">
                        <img src="<?php echo URL_ROOT. str_replace('original', 'resized', $item->image); ?>" alt="<?php echo $item->name ?>">
                        <span><?php echo $item->name ?></span>
                    </div>

                </a>
            </div>
        <?php } ?>

    </div>
    <div class="combo">
        <h2>
            <?= FSText::_('Combo quà tặng'); ?>
            <a href="<?php echo FSRoute::_('index.php?module=combo&view=home') ?>"><?= FSText::_('Xem tất cả'); ?><i class="fal fa-angle-right"></i></a>
        </h2>
        <div class="upcoming">
            <div class="content_upcoming owl-carousel">
                <?php
                foreach ($combo as $item) {
                    $link = '';
                    ?>
                    <div class="item_sp">
                        <a class="img" href="<?php echo $link ?>">
                            <img  class="img_pc"  src="<?php echo URL_ROOT. str_replace('original', 'large', $item->image); ?>" alt="<?php echo $item->title ?>">
                            <img class="img_m" src="<?php echo URL_ROOT. str_replace('original', 'normal', $item->icon); ?>" alt="<?php echo $item->icon ?>">
                        </a>
                        <a class="name_sp" href="<?php echo $link ?>"><?php echo $item->title ?></a>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="tienich">
        <?php foreach ($tienich as $item){ ?>
            <div class="item_tienich">
                <a href="#" class="a_item_tienich">
                    <div class="inline">
                        <img  class="img_h" src="<?php echo URL_ROOT. str_replace('original', 'resized', $item->image); ?>" alt="<?php echo $item->name ?>">
                        <img class="img_hover" src="<?php echo URL_ROOT. str_replace('original', 'resized', $item->icon); ?>" alt="<?php echo $item->name ?>">

                        <span><?php echo $item->name ?></span>
                    </div>

                </a>
            </div>
        <?php } ?>

    </div>
    <div class="home_products">
        <div class="block-1">
            <h2>
                <?= FSText::_('Sản phẩm mới nhất'); ?>
                <a href="<?php echo FSRoute::_('index.php?module=products&view=home') ?>"><?= FSText::_('Xem tất cả'); ?><i class="fal fa-angle-right"></i></a>
            </h2>
        </div>
        <div class="clearfix">

        </div>
        <div class="block-2 row">
            <?php $s=1; foreach ($list_sp as $item_sp){
                $class3 = '';
                if($s%3==0){
                    $class3 .= 'mg3';
                }
                $class4 = '';
                if($s%4==0){
                    $class4 .= 'mg4';
                }
                $class5 = '';
                if($s%5==0){
                    $class5 .= 'mg5';
                }
                $class6 = '';
                if($s%6==0){
                    $class6 .= 'mg6';
                }
                $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item_sp->category_alias . '&code=' . $item_sp->alias . '&id=' . $item_sp->id);
                ?>
                <div class="image-check col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="<?php echo $link; ?>">
                        <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $item_sp->image); ?>" class="img-responsive">
                        <p class="name_sp" href="<?php echo $link ?>"><?php echo $item_sp->name ?></p>
                        <div class="money_sp-more">
                            <div class="money_sp">

                                <?php if($item_sp->price_old){ ?>
                                    <p class="text-price-old"><?php echo format_money($item_sp->price_old) ?></p>
                                <?php } ?>
                                <p class="text-price" ><?php echo format_money($item_sp->price) ?></p>
                            </div>
                            <div class="more">
                                <p class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('Xem shop') ?></p>
                                <p><?php echo FSText::_('Đã bán') ?> <?php echo $item_sp->daban ?></p>
                            </div>
                        </div>
                        <?php if($item_sp->price_old){ ?>
                            <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                            <p class="text-giam-gia">- <?php echo $item_sp->giamgia ?>%</p>
                        <?php } ?>
                    </a>
                    <a class="bg" href="<?php echo $link; ?>">
                        <span>MUA NGAY</span>
                    </a>
                </div>

                <?php $s++; } ?>
        </div>
        <div class="bao-morehang ">
            <div class="more-hang c-promotions-list loas block-2 row">

            </div>
        </div>

        <?php if (count($list_sp) >= 20) {
                ?>
            <div class="div-more">
                    <div class="c-view-more bg-white is-margin">
                        <a class="load_more" href="javascript:void(0)" data-pagecurrent="1" data-nextpage="2"
                           limit="<?php echo $limit_sp; ?>"
                        >
                            <?= FSText::_('Xem thêm'); ?>
                        </a>
                    </div>
            </div>
        <?php } ?>

    </div>
</div>
