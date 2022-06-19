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

$url_2 = $_SERVER['REQUEST_URI'];
$lik = FSRoute::_('index.php?module=products&view=cat&ccode='.$cat->alias.'&cid='.$cat->id);
$loc = str_replace($lik,' ',$url_2);
$thay = '/giay-pc'.$cat->id.'.html';
// var_dump($loc);
// echo '<br>';
// var_dump($thay);
// echo '<br>';
$loc_2 = str_replace($thay,' ',$loc );
// var_dump($loc_2);
if ($sapxep || $price || $category || strpos($url, '?')) {
    $fist = "";
} else
    $fist = '?';
?>
<input type="hidden" name="quantity" id="quantity" value="1">
<input type="hidden" name="id_cat_dm" id="id_cat_dm" value="<?php echo $cat->id ?>">
<?php if(strlen($loc_2 ) > 1){ ?>
    <input type="hidden" name="loc_sp" id="loc_sp" value="1">
<?php } ?>
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
    <aside class="new-contents">
        <div class="row">
            <div class="main-column-left col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <?php if($dm_0){ ?>
                    <div class="frame_head clearfix">
                        <h2  class="h2_frame_head btn btn-info" data-toggle="collapse" data-target="#demo_dm"><span><?php echo FSText::_("Danh mục sản phẩm"); ?></span></h2>
                        <div id="demo_dm" class="collapse in">
                            <?php foreach ($dm_0 as $item){
                                $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                                ?>
                                <p class="p-dm">
                                    <a <?php if($item->id==$cat->id){ ?> class="active_p-dm" <?php } ?> href="<?php echo $link ?>">
                                        <?php echo $item->name ?>
                                    </a>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="block-2-left">
                    <h2  class="h2_block-2 btn btn-info" data-toggle="collapse" data-target="#demo_bl">Bộ lọc tìm kiếm</h2>
                    <div id="demo_bl" class="collapse in">
                        <div class="item_bl">
                            <h3>Theo danh mục</h3>
                            <ul>
                                <?php foreach ($list_dm as $item){
//                                    echo $item->id;
                                    ?>
                                    <li>
                                    <?php if($category){ ?>
                                            <a  id="th_<?php echo $item->id ?>" class="<?php if($item->id == $arr_category[0]){ ?>active_type <?php } ?> " href="<?php echo str_replace('&category='.$category,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&category=' . $item->id . ':' . $item->alias)  ?>">
                                                <?php if($item->id == $arr_category[0]){ ?>
                                                    <img src="<?php echo URL_ROOT.'images/input_check.svg' ?>" alt="img_check">
                                                <?php }else{ ?>
                                                    <span class="span_loc"></span>
                                                <?php } ?>
                                                
                                                <?php echo $item->name ?>
                                            </a>
                                        <?php }else{ ?>
                                            <a id="th_<?php echo $item->id ?>" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&category=' . $item->id . ':' . $item->alias ?>">
                                                <?php if($item->id == $arr_category[0]){ ?>
                                                    <img src="<?php echo URL_ROOT.'images/input_check.svg' ?>" alt="img_check">
                                                <?php }else{ ?>
                                                    <span class="span_loc"></span>
                                                <?php } ?>
                                                <?php echo $item->name ?>
                                            </a>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php foreach ($list_bl as $item_2){
                            $list_nd_bl = $model->list_nd_bl($item_2->field_table);
                            $b_ct = str_replace('-','',$item_2->alias);
                            // var_dump($b_ct);
                            $item_ct_get = FSInput::get($b_ct);
                            
                            $arr_ct_get = explode(':',$item_ct_get);
                        //    var_dump($item_ct_get);
                            ?>
                            <div class="item_bl">
                                <h3><?php echo $item_2->title ?></h3>
                               
                                <ul>
                                    <?php foreach ($list_nd_bl as $item){
                                        ?>
                                        <li>
                                            
                                            <?php if($item_ct_get){ ?>
                                                <a  class="<?php if($item->id == $arr_ct_get[0]){ ?>active_type <?php } ?> " href="<?php echo str_replace('&'.str_replace('-','',$item_2->alias).'='.$item_ct_get,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&'.str_replace('-','',$item_2->alias).'=' . $item->id . ':' . $item->alias)  ?>">
                                                    <?php if($item->id == $arr_ct_get[0]){ ?>
                                                        <img src="<?php echo URL_ROOT.'images/input_check.svg' ?>" alt="img_check">
                                                    <?php }else{ ?>
                                                        <span class="span_loc"></span>
                                                    <?php } ?>
                                                    <?php echo $item->name ?>
                                                </a>
                                            <?php }else{ ?>
                                                <a  href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&'.str_replace('-','',$item_2->alias).'=' . $item->id . ':' . $item->alias ?>">
                                                    <?php if($item->id == $arr_ct_get[0]){ ?>
                                                        <img src="<?php echo URL_ROOT.'images/input_check.svg' ?>" alt="img_check">
                                                    <?php }else{ ?>
                                                        <span class="span_loc"></span>
                                                    <?php } ?>
                                                    <?php echo $item->name ?>
                                                </a>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>

                    </div>


                </div>

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
                                                <p><?php echo FSText::_('Đã bán') ?> <?php echo $item->daban ?></p>
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

