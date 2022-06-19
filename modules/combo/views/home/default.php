<?php
global $tmpl,$config;
$tmpl->addStylesheet('home', 'modules/combo/assets/css');
$tmpl -> addStylesheet('owl.carousel.min','libraries/owlcarousel/assets');
$tmpl -> addStylesheet('owl.theme.default','libraries/owlcarousel/assets');
$tmpl -> addScript('owl.carousel.min','libraries/owlcarousel');
$tmpl->addScript('home', 'modules/combo/assets/js');
//$tmpl->addStylesheet('tintuc', 'modules/news/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$tmpl->setMeta('og:image', URL_ROOT . $config['logo']);
$limit_sp = 15;

?>
<div class="container">
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

        </div>
    </div>
</div>

<div class="container">
    <div class="combo">
       <div class="list_combo row">
           <?php $i=1;
           foreach ($list as $item) {
               $link = '';
               $class= '';
               if($i%3==0){
                   $class .= 'mg3';
               }
               ?>
               <div class="item_sp col-md-4 col-sm-6 col-xs-6 <?php echo $class ?>">
                   <a class="img" href="<?php echo $link ?>">
                       <img src="<?php echo URL_ROOT. str_replace('original', 'large', $item->image); ?>" alt="<?php echo $item->title ?>">
                   </a>
                   <a class="name_sp" href="<?php echo $link ?>"><?php echo $item->title ?></a>
               </div>
           <?php $i++; } ?>
       </div>
        <div class="bao-morehang ">
            <div class="more-hang c-promotions-list loas list_combo row">

            </div>
        </div>

        <?php if (count($list) >= 15) {
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

