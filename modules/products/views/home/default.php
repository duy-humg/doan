<?php
global $tmpl;
$tmpl->addStylesheet('home', 'modules/products/assets/css');
$tmpl->addScript("home", "modules/products/assets/js");
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$model = $this -> model;
$thuonghieu = FSInput::get('thuonghieu');
$arr_thuonghieu = explode(':',$thuonghieu);

$sapxep = FSInput::get('sapxep');
$arr_sapxep = explode(':',$sapxep);
//var_dump($arr_thuonghieu);

$nguoidung = FSInput::get('nguoidung');
$arr_nguoidung = explode(':',$nguoidung);

$price = FSInput::get('price');
$arr_price = explode(':',$price);
if($price){
    $get_price = $model->get_price($arr_price[0]);
}



$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url_2 = $_SERVER['REQUEST_URI'];
$lik = FSRoute::_('index.php?module=products&view=home');
$loc = str_replace($lik,' ',$url_2);
$loc_2 = str_replace('/san-pham.html',' ',$loc );

if ($thuonghieu || $nguoidung || $sapxep || $price || strpos($url, '?')) {
    $fist = "";
} else
    $fist = '?';
?>

 <?php if(strlen($loc_2 ) > 1){ ?>
    <input type="hidden" name="loc_sp" id="loc_sp" value="1">
<?php } ?>
<?php if($nguoidung){ ?>
    <input type="hidden" name="nguoidung" id="nguoidung" value="<?php echo $nguoidung ?>">
<?php } ?>

<?php if($sapxep){ ?>
    <input type="hidden" name="sapxep" id="sapxep" value="<?php echo $sapxep ?>">
<?php } ?>

<?php if($thuonghieu){ ?>
    <input type="hidden" name="thuonghieu" id="thuonghieu" value="<?php echo $thuonghieu ?>">
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
                <div class="frame_head clearfix">
                    <h2  class="h2_frame_head btn btn-info" data-toggle="collapse" data-target="#demo_dm"><span><?php echo FSText::_("Danh mục sản phẩm"); ?></span></h2>
                    <div id="demo_dm" class="collapse in">
                        <?php foreach ($dm as $item){
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
                <div class="block-2-left">
                    <h2  class="h2_block-2 btn btn-info" data-toggle="collapse" data-target="#demo_bl">Bộ lọc tìm kiếm</h2>
                    <div id="demo_bl" class="collapse in">
                        <div class="item_bl">
                            <h3><?php echo $list_thuonghieu[0]->category_name ?></h3>
                            <ul>
                                <?php foreach ($list_thuonghieu as $item){
//                                    echo $item->id;
                                    ?>
                                    <li>
                                        <?php if($thuonghieu){ ?>
                                            <a  id="th_<?php echo $item->id ?>" class="<?php if($item->id == $arr_thuonghieu[0]){ ?>active_type <?php } ?> " href="<?php echo str_replace('&thuonghieu='.$thuonghieu,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&thuonghieu=' . $item->id . ':' . $item->alias)  ?>">
                                                <?php if($item->id == $arr_thuonghieu[0]){ ?>
                                                    <img src="<?php echo URL_ROOT.'images/input_check.svg' ?>" alt="img_check">
                                                <?php }else{ ?>
                                                    <span class="span_loc"></span>
                                                <?php } ?>
    
                                                <?php echo $item->name ?>
                                            </a>
                                        <?php }else{ ?>
                                            <a id="th_<?php echo $item->id ?>" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&thuonghieu=' . $item->id . ':' . $item->alias ?>">
                                                <?php if($item->id == $arr_thuonghieu[0]){ ?>
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
                        <div class="item_bl">
                            <h3><?php echo $list_nguoidung[0]->category_name ?></h3>
                            <ul>
                                <?php foreach ($list_nguoidung as $item){ ?>
                                    <li>
                                        <?php if($nguoidung){ ?>
                                            <a id="nd_<?php echo $item->id ?>" class="<?php if($item->id == $arr_nguoidung[0]){ ?>active_type <?php } ?> " href="<?php echo str_replace('&nguoidung='.$nguoidung,'','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&nguoidung=' . $item->id . ':' . $item->alias)  ?>">
                                                <?php if($item->id == $arr_nguoidung[0]){ ?> 
                                                    <img src="<?php echo URL_ROOT.'images/input_check.svg' ?>" alt="img_check">
                                                <?php }else{ ?>
                                                    <span class="span_loc"></span>
                                                <?php } ?>
                                                <?php echo $item->name ?>
                                            </a>
                                        <?php }else{ ?>
                                            <a id="nd_<?php echo $item->id ?>" href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $fist . '&nguoidung=' . $item->id . ':' . $item->alias ?>">
                                            <?php if($item->id == $arr_nguoidung[0]){ ?> 
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

