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
// var_dump($url_current);
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
@$_SESSION['daxem'] = $data->id.','.@$_SESSION['daxem'];
// var_dump($_SESSION["daxem"]);
if ($_SESSION["user_id"]) {
    $favourite_item = $model->get_records('published = 1 and record_id =' . $id . ' AND `like_f` = 1', 'fs_products_favourite');
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
$model = $this->model;
if($list_color){
//    $color_item_dau = $model->get_color_dau($data->id->id);
    $color_item_dau = $model->get_record('id=' . $list_color[0], 'fs_products_color', '*');
}
if($list_size){
//    $size_item_dau = $model->get_record('id=' . $list_size[0], 'fs_products_size', '*');
    if($color_item_dau){
        $size_item_dau = $model->get_size_dau($data->id,$color_item_dau->id);
    }else{
        $size_item_dau = $model->get_size_dau_2($data->id);
    }

}
$_SESSION['sp_link'] = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $data->id);

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
<!-- <form method="post" action="#" name="buy_now" class="form" enctype="multipart/form-data"> -->
    <div class="container">
        <div class="dm_procust">
            <ul>
                <li class="li-dau">
                    <a href="<?php echo URL_ROOT ?>">Trang chủ</a>
                </li>
                <li>
                    <a href="<?php echo FSRoute::_('index.php?module=products&view=home') ?>">Sản phẩm</a>
                </li>
                <li>
                    <a href="<?php echo  FSRoute::_('index.php?module=products&view=cat&cid=' . $dm[0]->id . '&ccode=' . $dm[0]->alias) ?>"><?php echo $dm[0]->name ?></a>
                </li>
                <li class="li-cuoi">
                    <span href="<?php echo $link; ?>"><?php echo $data->name; ?> </span>
                </li>

            </ul>
        </div>
        
        <div class="content">
            <div class="pc">
                <div class="content_2 row">
                    <div class="left_content2 col-md-6 col-sm-6 col-xs-12">
                        <div class="clearfix silde-img row-item">
                            <?php if($product_images){ ?>
                                <ul id="imageGallery">
                                    <?php foreach ($product_images as $item) {
                                        ?>
                                        <li data-thumb="<?php echo URL_ROOT . str_replace('/original/', '/original/', $item->image) ?>" data-src="<?php echo URL_ROOT . str_replace('/original/', '/original/', $item->image) ?>">
                                            <div class="bao_img">
                                                <img src="<?php echo URL_ROOT . str_replace('/original/', '/original/', $item->image) ?>" />
                                            </div>
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
                        
                            <h1 class="name_prd  <?php if($data->price_old){ ?>  name_prd_gg <?php } ?>">
                                <?php echo $data->name; ?>
                                <?php if($data->price_old){ ?>
                                    <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                                    <p class="text-giam-gia">- <?php echo $data->giamgia ?>%</p>
                                <?php } ?>
                            </h1>
                            <div class="all_cmt_daban">
                               
                                <?php if($total_cmt){ ?>
                                    <p class="tb_danhgia">
                                        <?php echo round($sum_rate ) ?>  
                                        <?php if(round($sum_rate)==1){ ?>
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <?php }elseif(round($sum_rate )==2){ ?>
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <?php }elseif(round($sum_rate )==3){ ?>
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <?php }elseif(round($sum_rate)==4){ ?>
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <?php }elseif(round($sum_rate )==5){ ?>
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                            <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                        <?php } ?>
                                    </p>
                                    <p class="count-danhgia">
                                        <?php echo $total_cmt ?> <span><?php echo FSText::_("Đánh giá");?></span>
                                    </p>
                                <?php }else{ ?>
                                    <p class="tb_danhgia">
                                        0   
                                        <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                        <img src="<?php echo URL_ROOT.'images/icon_sao3.png' ?>" alt="">
                                    </p>
                                    <p class="count-danhgia">
                                        0 <span><?php echo FSText::_("Đánh giá");?></span>
                                    </p>
                                <?php } ?>
                                    
                          
                                
                                <p class="text-daban">
                                    <?php echo $data->daban ?> <span><?php echo FSText::_("Đã bán");?></span>
                                </p>
                            </div>
                            <div id="price_vinashoes" class="giatien visible_pc">
                                <?php if($size_item_dau){ ?>
                                    <p class="infor-price_">
                                    <span class="price_old"><?php if ($size_item_dau->price > $size_item_dau->price_h) {
                                            echo format_money($size_item_dau->price);
                                        } ?></span>
                                    <span class="infor-price">

                                    <?php if ($size_item_dau->price_h) {
                                        echo format_money($size_item_dau->price_h);
                                    } else {
                                        echo 'Liên hệ';
                                    } ?>
                                        </span>

                                    <?php if($size_item_dau->price){
                                        $giam = ceil(100 - ($size_item_dau->price_h/$size_item_dau->price)*100)

                                        ?>
                                        <?php if($giam!=0){ ?>
                                            <span class="p-giamgia">-<?php echo $giam ?>% GIẢM</span>
                                        <?php } ?>
                                        
                                    <?php } ?>
                                    </p>
                                    <input type="hidden" id="price_input" name='price' value="<?php echo $size_item_dau->price_h ?>"/>
                                    <input type="hidden" id="check_conhang" name='check_conhang' value="1"/>
                                    <input type="hidden" id="id_sub" name='id_sub'
                                        value="<?php echo $size_item_dau->id ?>"/>
                                <?php }else{ ?>
                                    <p class="infor-price_">
                                        <span class="price_old"><?php if ($data->price_old > $data->price) {
                                                echo format_money($data->price_old);
                                            } ?>
                                            </span>
                                        <span class="infor-price">

                                        <?php if ($data->price) {
                                            echo format_money($data->price);
                                        } else {
                                            echo 'Liên hệ';
                                        } ?>
                                            </span>

                                        <?php if($data->price_old){ ?>
                                            <span class="p-giamgia">-<?php echo $data->giamgia ?>% GIẢM</span>
                                        <?php } ?>
                                    </p>
                                    <input type="hidden" id="price_input" name='price' value="<?php echo $data->price ?>"/>
                                    <input type="hidden" id="check_conhang" name='check_conhang' value="1"/>
                                    <input type="hidden" id="id_sub" name='id_sub'
                                        value=""/>
                                <?php } ?>

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

                            <div class="all_cmt_daban_mobile">
                                <p class="tb_danhgia">
                                    <?php echo FSText::_("5");?>
                                    <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                    <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                    <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                    <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                    <img src="<?php echo URL_ROOT.'images/icon_sao1.png' ?>" alt="">
                                </p>
                                
                                <p class="text-daban">
                                    <?php echo $data->daban ?> <span><?php echo FSText::_("Đã bán");?></span>
                                </p>

                                <div class="like favorite_prd">
                                    <?php if($_SESSION['user_id']){ ?>
                                        <?php if($love->like_f==1){ ?>
                                            <a class="a-like" href="javascript:void(0)" onclick="un_like()">
                                            <i class="fas fa-heart"></i>
                                            </a>
                                    
                                        <?php }else{ ?>
                                            <a class="a-like" href="javascript:void(0)" onclick="like()">
                                            <img src="<?php echo URL_ROOT.'modules/products/assets/images/heart.svg' ?>" alt="heart">
                                            </a>
                                        
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <a class="a-like" href="javascript:void(0)" onclick="like()">
                                            <img src="<?php echo URL_ROOT.'modules/products/assets/images/heart.svg' ?>" alt="heart">
                                        </a>
                                        <span>Chưa thích</span>
                                    <?php } ?>
                                </div>
                               
                            </div>
                            <div id="lis_clor">
                                 <?php if($list_color){ ?>
                                    <div class="list_color">
                                        <p class="info" id="info_color"><?php echo FSText::_('Màu'); ?> </p>
                                        <ul class="chosse-color" id="option_color ">
                                            <?php $i=1;
                                            foreach ($list_color as $item) {
                                                $model = $this->model;


                                                @$color_item = $model->get_record('id=' . $item, 'fs_products_color', '*');
                                                ?>
                                                <li  data="color_item" name="color_title"
                                                    name-item="<?php echo $color_item->name; ?>"
                                                    color_id="<?php echo $color_item->id; ?>"
                                                    class="item_price_2_color color_item color_vina_click a-option_color a-click-sur <?php if($i==1){ ?>active<?php } ?>"
                                                    data-toggle="tab" href="#board<?php echo $item ?>"
                                                >
                                                    <!-- <img src="<?php echo URL_ROOT.'/modules/products/assets/images/check.svg' ?>" alt="img"> -->
                                                    <p style="width: 100%;height: 100%;border-radius: 50% "><?php echo $color_item->name ?></p>
                                                </li>
                                                <?php $i++; } ?>
                                        </ul>
                                        <input type="hidden" name="color_id_vinashoes" id="color_id_vinashoes" value="<?php echo $color_item_dau->id ?>">
                                    </div>

                                 <?php } ?>
                            </div>
                           

                            <?php if ($list_size){

                                ?>
                                <div class="list_size">
                                    <p class="info" id="info_size"><?php echo FSText::_('Size'); ?></p>
                                    <ul class="chosse-size" id="option_size">
                                        <?php $i=1; foreach ($list_size as $item) {
                                            $model = $this->model;
                                            @$price_size = $model->get_record('product_id=' . $data->id .' and size_id='. $item, 'fs_products_sub', '*');
                                            // var_dump($price_size->price_h);
                                            @$size_item = $model->get_record('id=' . $item, 'fs_products_size', '*');
                                            ?>
                                            <li data="color_item" name="color_title" onclick="list_color(<?php echo $size_item->id ?>,<?php echo $data->id ?>)"
                                                name-item-size="<?php echo $size_item->name; ?>"
                                                size_id="<?php echo $size_item->id; ?>"
                                                <?php if($size_item->price_h > $size_item->price){ ?>
                                                    size_price_old="<?php echo format_money($price_size->price)  ?>"
                                                    size_dis="-<?php echo $price_size->discount  ?>% GIẢM"
                                                <?php } ?>
                                                size_price="<?php echo format_money($price_size->price_h)  ?>"
                                                
                                                class="a-option_size option_size_price<?php echo $size_item->id ?> <?php if($i==1){ ?>active<?php } ?>">
                                              
                                                <p><?php echo $size_item->name ?></p>

                                            </li>
                                            <?php $i++; } ?>

                                    </ul>
                                    <input type="hidden" name="size_id_vinashoes" id="size_id_vinashoes" value="<?php echo $size_item_dau->size_id ?>">
                                </div>
                            <?php } ?>

                            
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
                            <div class="text_free_vc">
                                <p class="left_free_vc"><?php echo FSText::_("Vận chuyển"); ?></p>
                                <p class="right_free_vc"><?php echo FSText::_("Miễn phí vận chuyển"); ?></p>
                            </div>
                            <div class="bottom-add-cart">
                                <a class="a-them" href="#" onclick="order(<?php echo $data->id; ?>)">
                                    <p class="buy-now">
                                        <?php echo FSText::_("Thêm vào giỏ hàng"); ?>
                                    </p>
                                </a>
                                <a class="a-mua" onclick="submit_buy_now(<?php echo $data->id; ?>)" href="javascript:void(0)">
                                    <span><?php echo FSText::_("Mua ngay"); ?></span>
                                </a>
                                <input type="hidden" id="link_buy_now" name="link_buy_now" value="<?php echo URL_ROOT . 'index.php?module=products&view=product&task=buynow&id=' . $data->id; ?>">
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
                                    <input type="hidden" name="quantity_sub" id="quantity_sub" value="1000">
                                    <input type="hidden" name="quantity_main" id="quantity_main"
                                        value="300">

                                    <input type="hidden" id="products_type_input_buynow" name='products_type_input_buynow'
                                        value=""/>

                                    <input type="hidden" id="price_input_buynow" name='price_input_buynow'
                                        value="<?php echo $data->price ?>"/>
                                </form>
                                <div class="clearfix"></div>
                            </div>


                            <div class="clearfix"></div>
                            <input type="hidden" name="module" value="products" />
                            <input type="hidden" name="task" value="buynow" />
                            <input type="hidden" name="view" value="product" />
                            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                        
                        
                        



                        



                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 share_like_tienich">
                        <div class="share">
                            <p><?php echo FSText::_("Chia sẻ"); ?>:</p>
                            <div class="list_share">
                                <a class="share_face" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo FSRoute::_("index.php?module=products&view=products&code=".$data->alias. "&id=" . $data->id ) ?>" target="_blank">
                                    <img src="<?php echo URL_ROOT.'images/sanpham/Facebook.svg' ?>" alt="facebook">
                                </a>
                                <a class="share_popup share_face" target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo FSRoute::_("index.php?module=products&view=products&code=".$data->alias. "&id=" . $data->id ) ?>">
                                    <img src="<?php echo URL_ROOT.'images/sanpham/Pinterest.svg' ?>" alt="linkedin">
                                </a>
                                <a class="share_popup" target="_blank" href="https://twitter.com/share?url=<?php echo FSRoute::_("index.php?module=products&view=products&code=".$data->alias. "&id=" . $data->id ) ?>">
                                    <i class="fa fa-twitter"></i>
                                    <img src="<?php echo URL_ROOT.'images/sanpham/Twitter.png' ?>" alt="Twitter">
                                </a>
                            </div>
                        </div>
                        <div class="like favorite_prd">
                            <?php if($_SESSION['user_id']){ ?>
                                <?php if($love->like_f==1){ ?>
                                    <a class="a-like" href="javascript:void(0)" onclick="un_like()">
                                    <i class="fas fa-heart"></i>
                                    </a>
                                    <span>Đã thích</span>
                                <?php }else{ ?>
                                    <a class="a-like" href="javascript:void(0)" onclick="like()">
                                    <img src="<?php echo URL_ROOT.'modules/products/assets/images/heart.svg' ?>" alt="heart">
                                    </a>
                                    <span>Chưa thích</span>
                                <?php } ?>
                            <?php }else{ ?>
                                <a class="a-like" href="javascript:void(0)" onclick="like()">
                                    <img src="<?php echo URL_ROOT.'modules/products/assets/images/heart.svg' ?>" alt="heart">
                                </a>
                                <span>Chưa thích</span>
                            <?php } ?>
                            
                    
                        </div>
                        <div class="dambao">
                            <p><?php echo FSText::_("Vinashoe đảm bảo"); ?></p>
                        </div>
                        <div class="camket">
                            <p><?php echo FSText::_("Cam kết hàng giống hình ảnh"); ?></p>
                        </div>
                    </div>
                </div>
                <div class="content_2_vc_mobile">
                    <p class="left_free_vc">Vận chuyển</p>
                    <p class="right_free_vc">Miễn phí vận chuyển</p>
                </div>
                <div class="content_2_tienich_mobile">
                     <p class="dambao">Vinashoe đảm bảo</p> 
                     <p class="camket">Cam kết hàng giống hình ảnh</p>
                </div>
                <?php if($get_shop){ ?>
                    <div class="content_3 row">
                        <div class="left_content3 col-md-4">
                            <div class="img_shop">
                                <img src="<?php echo URL_ROOT . str_replace('original', 'small', $get_shop->image); ?>" alt="<?php echo $get_shop->name ?>">
                            </div>
                            <div class="name_shop">
                                <p class="p-name-shop"><?php echo $get_shop->name ?></p>
                                <div class="btn-shop">
                                    <a class="a-chat" href="#"><?php echo FSText::_("Chat ngay"); ?></a>
                                    <a class="a-shop" href="<?php echo  FSRoute::_('index.php?module=products&view=shop&cid=' . $get_shop->id . '&ccode=' . $get_shop->alias) ?>"><?php echo FSText::_("Xem shop"); ?></a>
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
                <?php } ?>


                <div class="content_4 row">
                    <div class="left-thongtin-content4 col-md-9">
                        <div class="block_1_content_4">
                            <h3><?php echo FSText::_("Thông tin sản phẩm"); ?></h3>
                            <ul class="info_sp">
                                <li class="li-dm">
                                    <p class="left_info"><?php echo FSText::_("Danh Mục"); ?></p>
                                    <div class="right_info">
                                        <p class="li-dau">
                                            <a href="<?php echo URL_ROOT ?>">Trang chủ</a>
                                        </p>
                                        <p>
                                            <a href="<?php echo FSRoute::_('index.php?module=products&view=home') ?>">Sản phẩm</a>
                                        </p>
                                        <p>
                                            <a href="<?php echo  FSRoute::_('index.php?module=products&view=cat&cid=' . $dm[0]->id . '&ccode=' . $dm[0]->alias) ?>"><?php echo $dm[0]->name ?></a>
                                        </p>
                                        <p class="li-cuoi">
                                            <span href="<?php echo $link; ?>"><?php echo $data->name; ?> </span>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <p class="left_info"><?php echo FSText::_("Tình trạng"); ?></p>
                                    <p class="right_info">
                                        <?php if($data->is_news==1){ ?>
                                            <?php echo FSText::_("Mới"); ?>
                                        <?php }else{ ?>
                                            <?php echo FSText::_("Cũ"); ?>
                                        <?php } ?>
                                    </p>
                                </li>
                                <?php if($data->chatlieu){ ?>
                                    <li>
                                        <p class="left_info"><?php echo FSText::_("Chất liệu"); ?></p>
                                        <p class="right_info">
                                            <?php echo $data->chatlieu ?>
                                        </p>
                                    </li>
                                <?php } ?>
                                <?php if($data->khohang){ ?>
                                    <li>
                                        <p class="left_info"><?php echo FSText::_("Kho hàng"); ?></p>
                                        <p class="right_info">
                                            <?php echo $data->khohang ?>
                                        </p>
                                    </li>
                                <?php } ?>
                                <?php if($data->guitu){ ?>
                                    <li>
                                        <p class="left_info"><?php echo FSText::_("Gửi từ"); ?></p>
                                        <p class="right_info">
                                            <?php echo $data->guitu ?>
                                        </p>
                                    </li>
                                <?php } ?>

                            </ul>
                            <h3 class="h_mota"><?php echo FSText::_("MÔ TẢ SẢN PHẨM"); ?></h3>
                            <div class="content-nd">
                                <div class="nd_height">
                                    <?php echo $data->content ?>
                                </div>
                            </div>
                        </div>
                        <div class="block_2_content_4">
                            <h3><?php echo FSText::_("ĐÁNH GIÁ SẢN PHẨM"); ?></h3>
                            <?php include 'plugins/comments/comments_tree.php'; ?>
                        </div>
                        <?php if (count($list_shop)) { ?>
                            <div class="block_3_content_4">
                            <h3>
                                <?php echo FSText::_("Các sản phẩm khác của shop"); ?>
                                <a href="<?php echo  FSRoute::_('index.php?module=products&view=shop&cid=' . $get_shop->id . '&ccode=' . $get_shop->alias) ?>"><?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-chevron-right"></i></a>
                            </h3>
                            <div class="list_shop">
                                <?php
                                $i = 0;
                                foreach ($list_shop as $item) {
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
                                <?php } ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <?php } ?>
                        <?php if (count($relate_products_list)) { ?>
                            <div class="block_3_content_4">
                                <h3>
                                    <?php echo FSText::_("Sản phẩm liên quan"); ?>
                                    <a href="<?php echo  FSRoute::_('index.php?module=products&view=cat&cid=' . $dm[0]->id . '&ccode=' . $dm[0]->alias) ?>"><?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-chevron-right"></i></a>
                                </h3>
                                <div class="list_shop">

                                        <?php
                                        $i = 0;
                                        foreach ($relate_products_list as $item) {
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


                                        <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>

                    </div>


                    <div class="right-thong-tin-content4 col-md-3 ">
                        <div class="list_sp_banchay">
                            <h3><?php echo FSText::_("Top sản phẩm bán chạy"); ?></h3>
                            <?php
                            $i = 0;
                            foreach ($list_sp_banchay as $item) {
                                $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                                $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                                ?>
                                <?php $i++; ?>
                                <div class="image-check image-check-m-<?php echo $i ?> col-lg-3 col-md-3 col-sm-6 col-xs-6">
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
                                <?php if (($i%5) == 0) { ?>
                                    <div class="clearfix "></div>
                                <?php } ?>


                            <?php } ?>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <input type="hidden" id="products_type_count" name='products_type_count'
       value="<?php echo(count($product)) ?>"/>



<input type="hidden" id="return" name='return' value="<?php echo $url_current ?>"/>
<input type="hidden" id="id_shop" name='id_shop' value="<?php echo $data->id_shop ?>"/>
<input type="hidden" id="user_id" name='user_id' value="<?php echo $_SESSION['user_id'] ?>"/>

<!-- </form> -->



