<?php
global $tmpl, $config;
$tmpl->addScript("cart", "modules/products/assets/js");
$tmpl->addStylesheet('cart1', 'modules/products/assets/css');
$tmpl->addStylesheet('owl.carousel.min', 'libraries/owlcarousel/assets');
$tmpl->addStylesheet('owl.theme.default', 'libraries/owlcarousel/assets');
$tmpl->addScript('owl.carousel.min', 'libraries/owlcarousel');

$list_prd_cart = array();
$total_quan = 0;
$product_list_2 = array();
foreach ($list_cart as $prd) {
    if($prd[7]==1){
        $total_quan += $prd[1]*$prd[2];
        $product_list_2[] = array($prd[0],$prd[1],$prd[2],$prd[3],$prd[4],$prd[5],$prd[6],$prd[7]);
    }
}

$_SESSION['cart_2'] = $product_list_2;
//var_dump($total_quan);
if($_SESSION['daxem']){
    $list_sp_daxem = array_unique(explode(',',rtrim($_SESSION['daxem'],",")));
    // var_dump($list_sp_daxem);
}

?>
<div class="ql_m">
    <a href="<?php echo $_SESSION['sp_link'] ?>">
    <svg viewBox="0 0 22 17" role="img" class="stardust-icon stardust-icon-back-arrow _1aiFrB"><g stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(-3, -6)"><path d="M5.78416545,15.2727801 L12.9866648,21.7122915 C13.286114,22.0067577 13.286114,22.4841029 12.9866648,22.7785691 C12.6864297,23.0738103 12.200709,23.0738103 11.9004739,22.7785691 L3.29347136,15.0837018 C3.27067864,15.0651039 3.23845445,15.072853 3.21723364,15.0519304 C3.06240034,14.899273 2.99480814,14.7001208 3.00030983,14.5001937 C2.99480814,14.3002667 3.06240034,14.1003396 3.21723364,13.9476821 C3.23845445,13.9275344 3.2714646,13.9345086 3.29425732,13.9166857 L11.9004739,6.22026848 C12.200709,5.92657717 12.6864297,5.92657717 12.9866648,6.22026848 C13.286114,6.51628453 13.286114,6.99362977 12.9866648,7.288096 L5.78416545,13.7276073 L24.2140442,13.7276073 C24.6478918,13.7276073 25,14.0739926 25,14.5001937 C25,14.9263948 24.6478918,15.2727801 24.2140442,15.2727801 L5.78416545,15.2727801 Z"></path></g></svg>
        Quay lại
    </a>
</div>
<div class="total_price_m">
    <div class="all_detele">
        <div class="check_all">
            <?php if($_SESSION['check']==1){ ?>
                <input type="checkbox" id="all_checkbox_2" checked>
            <?php }else{ ?>
                <input type="checkbox" id="all_checkbox_2">
            <?php } ?>
            <span>Chọn tất cả</span>
        </div>
        <div class="detele_all">
            <a href="<?php echo 'index.php?module=products&view=product&task=unset_ss' ?>">
                <i class="far fa-trash-alt"></i>
                <span>Xóa tất cả</span>
            </a>
        </div>
       
    </div>
    <div class="cart_price_all">
        <p class="p_cart_price_all">Tổng số tiền <span class="span_cart_price_all">(<?php echo count($_SESSION['cart_2']) ?> Sản phẩm): <span class="span_tong"><?php if($total_quan){ ?><?php echo format_money($total_quan) ?><?php }else{ ?>0 đ<?php } ?> </span></span></p>
    </div>
    <a href="javascript:void(0)" class="smt_m">
            Mua hàng
    </a>
</div>
<p id="GFG_DOWN">
<div class="container">
    <div class="cartmain_">
        <form id="order_form" name="order_form" method="post"
              action="#">
            <div class="col_order_form ">
                <div class="table-responsive table_">
                    <div class="header-cart">
                        <div class="cart-check inline-header">
                            <p class="intut-header">
                                <?php if($_SESSION['check']==1){ ?>
                                    <input type="checkbox" id="all_checkbox" checked>
                                <?php }else{ ?>
                                    <input type="checkbox" id="all_checkbox">
                                <?php } ?>
                            </p>
                        </div>
                        <div class="cart-sp inline-header">
                            <p>Sản phẩm</p>
                        </div>
                        <div class="cart-price inline-header">
                            <p>Đơn giá</p>
                        </div>
                        <div class="cart-count inline-header">
                            <p>Số lượng</p>
                        </div>
                        <div class="cart-total-price inline-header">
                            <p>Số tiền</p>
                        </div>
                        <div class="cart-detele inline-header">
                            <p>Thao tác</p>
                        </div>
                    </div>
                    <div class="list-cart">
                        <?php foreach ($list_shop as $item){
                            $model = $this->model;
                            $get_shop = $model->get_shop($item);
                            ?>
                            <div class="item-shop">
                                <div class="header-shop">
                                    <?php if($_SESSION['check']==1){ ?>
                                        <?php if($_SESSION['id_shop']==$item or  $_SESSION['id_shop'] ==1){ ?>
                                            <input checked type="checkbox" class="all_checkbox_shop" id_shop="<?php echo $item ?>" id="all_checkbox_shop_<?php echo $item ?>">
                                        <?php }else{ ?>
                                            <input type="checkbox" class="all_checkbox_shop" id_shop="<?php echo $item ?>" id="all_checkbox_shop_<?php echo $item ?>">
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <input type="checkbox" class="all_checkbox_shop" id_shop="<?php echo $item ?>" id="all_checkbox_shop_<?php echo $item ?>">
                                    <?php } ?>

                                    <span class="name-shop"><?php echo $get_shop->name ?></span>
                                </div>
                                <?php $i = 0;$total = 0; foreach  ($list_cart as $prd){
                                    $i++;
                                    ?>
                                    <?php if($item==$prd[6]){
                                        $product_img = $model->get_records('published = 1 and id=' . $prd[0], 'fs_products', '*');
                                        $image = URL_ROOT . str_replace('/original/', '/tiny/', $product_img[0]->image);
                                        if($prd[5]){
                                            $product_sub = $model->get_records('published = 1 and id=' . $prd[5], 'fs_products_sub', '*');
                                        }
                                        $total_sp = $prd[1] * $prd[2];

                                        ?>
                                        <div class="item-sp">
                                            <div class="cart-check inline-header">
                                                <p class="intut-header">
                                                    <input class="check_item checkbox_all checkbox_shop_<?php echo $item ?>" id_shop_sp="<?php echo $item ?>" <?php if($prd[7]==1){ ?>checked<?php } ?> stt="<?php echo $i ?>" value="<?php if($prd[5]){ ?><?php echo $prd[5] ?><?php }else{ ?><?php echo $prd[0] ?> <?php } ?>" name="id_pub" id="cb<?php echo $i; ?>" type="checkbox" >
                                                </p>
                                            </div>
                                            <div class="cart-sp inline-header">
                                                <div class="img-sp">
                                                    <img src="<?php echo $image ?>" alt="">
                                                </div>
                                                <div class="name-sp">
                                                    <p><?php echo $product_img[0]->name ?></p>
                                                </div>
                                                <?php if($prd[5]){ ?>
                                                    <div class="pl">
                                                        <div>
                                                            <p>Phân loại hàng:</p>
                                                            <p class="p-pl">
                                                                <?php if($product_sub[0]->color_id){ ?><?php echo $product_sub[0]->color_name ?>, <?php } ?>
                                                                <?php if($product_sub[0]->size_id){ ?><?php echo $product_sub[0]->size_name ?><?php } ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                            <div class="cart-price inline-header">
                                                <div>
                                                    <?php if($prd[5]){ ?>
                                                        <?php if($product_sub[0]->price){ ?>
                                                            <p class="price_old"><?php echo format_money($product_sub[0]->price)  ?></p>
                                                        <?php } ?>
                                                        <p class="price-sp"><?php echo format_money($product_sub[0]->price_h ) ?></p>
                                                    <?php }else{ ?>
                                                        <?php if($product_img[0]->price_old){ ?>
                                                            <p class="price_old"><?php echo format_money($product_img[0]->price_old)  ?></p>
                                                        <?php } ?>
                                                        <p class="price-sp"><?php echo format_money($product_img[0]->price)  ?></p>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div class="cart-count inline-header">
                                                <div class="img-sp-m">
                                                    <img src="<?php echo $image ?>" alt="">
                                                </div>
                                                <div class="detele_m">
                                                    
                                                    <a data-id="<?php if ($prd[5]) {
                                                            echo $prd[5];
                                                        } else {
                                                            echo $prd[0];
                                                        } ?>"  data-tr="<?php echo "tr-pop-" . $i; ?>" class="del-pro-link"
                                                        href="#"
                                                        title="">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                <div class="info_sp_m">
                                                    <a href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $product_img[0]->category_alias . '&code=' . $product_img[0]->alias . '&id=' . $product_img[0]->id) ?>" class="name-sp"><?php echo $product_img[0]->name ?></a>
                                                    <?php if($prd[5]){ ?>
                                                        <p class="pl">
                                                            phân loại hàng:
                                                            <?php if($product_sub[0]->color_id){ ?>
                                                                <span><?php echo $product_sub[0]->color_name ?>, </span>
                                                            <?php } ?>

                                                            <?php if($product_sub[0]->size_id){ ?>
                                                                <span>
                                                                    <?php echo $product_sub[0]->size_name ?>
                                                                </span>
                                                            <?php } ?>
                                                        </p>
                                                    <?php } ?>
                                                    <div class="cart-price inline-header">
                                                        <?php if($prd[5]){ ?>
                                                            <?php if($product_sub[0]->price){ ?>
                                                                <p class="price_old"><?php echo format_money($product_sub[0]->price)  ?></p>
                                                            <?php } ?>
                                                            <p class="price-sp"><?php echo format_money($product_sub[0]->price_h ) ?></p>
                                                        <?php }else{ ?>
                                                            <?php if($product_img[0]->price_old){ ?>
                                                                <p class="price_old"><?php echo format_money($product_img[0]->price_old)  ?></p>
                                                            <?php } ?>
                                                            <p class="price-sp"><?php echo format_money($product_img[0]->price)  ?></p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                 <span class="number-input">
                                                             <button type="button" onclick="down_quantity(<?php if ($prd[5]) {
                                                                 echo $prd[5];
                                                             } else {
                                                                 echo $prd[0];
                                                             } ?>)"
                                                                     class="down"></button>
                                                            <input type="text"
                                                                   name="quantity_<?php if ($prd[5]) {
                                                                       echo $prd[5];
                                                                   } else {
                                                                       echo $prd[0];
                                                                   } ?>"
                                                                   id="quantity_<?php if ($prd[5]) {
                                                                       echo $prd[5];
                                                                   } else {
                                                                       echo $prd[0];
                                                                   } ?>"
                                                                   class="input-count numbersOnly<?php echo $i; ?>"
                                                                   maxlength="5"
                                                                   onblur="change_quantity(<?php if ($prd[5]) {
                                                                       echo $prd[5];
                                                                   } else {
                                                                       echo $prd[0];
                                                                   } ?>)"
                                                                   value="<?php echo $prd[1] ?>"/>
                                                             <input type="hidden" name="quan_max_<?php echo ($prd[5])?$prd[5]:$prd[0] ?>"  id="quan_max_<?php echo ($prd[5])?$prd[5]:$prd[0] ?>" value="1000">
                                                            <button type="button" onclick="up_quantity(<?php if ($prd[5]) {
                                                                echo $prd[5];
                                                            } else {
                                                                echo $prd[0];
                                                            } ?>)"
                                                                    class="plus"></button>

                                                        </span>
                                            </div>
                                            <div class="cart-total-price inline-header">
                                                <p><?php echo format_money($total_sp) ?></p>
                                            </div>
                                            <div class="cart-detele inline-header">
                                                <a data-id="<?php if ($prd[5]) {
                                                    echo $prd[5];
                                                } else {
                                                    echo $prd[0];
                                                } ?>"  data-tr="<?php echo "tr-pop-" . $i; ?>" class="del-pro-link"
                                                   href="#"
                                                   title="">Xóa</a>
                                            </div>
                                        </div>

                                    <?php } ?>

                                <?php } ?>
                            </div>

                        <?php } ?>
                    </div>
                    <div class="div-total">
                        <div class="footer_check_all">
                            <?php if($_SESSION['check']==1){ ?>
                                <input type="checkbox" id="all_checkbox_" checked>
                            <?php }else{ ?>
                                <input type="checkbox" id="all_checkbox_">
                            <?php } ?>

                            <span>Chọn tất cả (<?php echo count($list_cart) ?>)</span>
                        </div>
                        <div class="detele_all">
                            <a href="<?php echo 'index.php?module=products&view=product&task=unset_ss' ?>">Xóa</a>
                        </div>
                        <div class="cart_price_all">
                            <p class="p_cart_price_all">Tổng thanh toán <span class="span_cart_price_all">(<?php echo count($_SESSION['cart_2']) ?> Sản phẩm): <span class="span_tong"><?php if($total_quan){ ?><?php echo format_money($total_quan) ?><?php }else{ ?>0 đ<?php } ?> </span></span></p>
                        </div>
                        <div class="btn_mua <?php if($_SESSION['btn_mua']==1){ ?> btn_mua_active<?php } ?>">
                            <input type="submit" value="<?php echo FSText::_("Mua hàng"); ?>">
                        </div>
                    </div>
                    <div class="block_3_content_4">
                        <h3>
                            <?php echo FSText::_("có thể bạn sẽ thích"); ?>
                            <a href="#"><?php echo FSText::_("Xem tất cả"); ?><i class="fal fa-chevron-right"></i></a>
                        </h3>
                        <div class="list_shop">
                            <?php
                            $i = 0;
                            foreach ($list_sp as $item) {
                                $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                                $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                                ?>
                                <?php $i++; ?>
                                <div class="image-check image-check-m<?php echo $i ?> col-lg-3 col-md-3 col-sm-6 col-xs-6">
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
                        <div class="clearfix"></div>
                    </div>
                    <div class="block_3_content_4">
                        <h3>
                            <?php echo FSText::_("Vừa xem"); ?>
                        </h3>
                        <div class="list_shop">
                            <?php
                           
                            if($_SESSION['daxem']){ ?>
                                <?php
                                $i = 1;
                                foreach ($list_sp_daxem as $item) {
                                    $get_sp = $model->get_record_by_id($item, 'fs_products');
                                    $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $get_sp->category_alias . '&code=' . $get_sp->alias . '&id=' . $get_sp->id);
                                    $image = URL_ROOT . str_replace('original', 'tiny', $get_sp->image);
                                ?>
                                    <?php if($i <6 ){ ?>
                                        <div class="image-check image-check-m<?php echo $i ?> col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <a href="<?php echo $link; ?>">
                                                <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $get_sp->image); ?>" class="img-responsive">
                                                <p class="name_sp" href="<?php echo $link ?>"><?php echo $get_sp->name ?></p>
                                                <div class="money_sp-more">
                                                    <div class="money_sp">

                                                        <?php if($get_sp->price_old){ ?>
                                                            <p class="text-price-old"><?php echo format_money($get_sp->price_old) ?></p>
                                                        <?php } ?>
                                                        <p class="text-price" ><?php echo format_money($get_sp->price) ?></p>
                                                    </div>
                                                    <div class="more">
                                                        <p class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('Xem shop') ?></p>
                                                        <p><?php echo FSText::_('Đã bán') ?> <?php echo $get_sp->daban ?>k</p>
                                                    </div>
                                                </div>
                                                <?php if($get_sp->price_old){ ?>
                                                    <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                                                    <p class="text-giam-gia">- <?php echo $get_sp->giamgia ?>%</p>
                                                <?php } ?>
                                            </a>
                                            <a class="bg" href="<?php echo $link; ?>">
                                                <span>MUA NGAY</span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php $i++; } ?>
                            <?php } ?>
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>




            <input type="hidden" name="module" value="products"/>
            <input type="hidden" name="view" value="pay"/>
            <!--            <input type="hidden" name = "task" value = "forget_save" />-->
            <!--                </div>-->
            <!--            </div>-->
            <input type="hidden" name="total_price" id="total_price"
                   value="<?= $total ?>">
            <input type="hidden" name="total_price_check" id="total_price_check"
                   value="<?= $total ?>">
            <input type="hidden" name="list_product_add" id="list_product_add"
                   value="<?php echo ',' . $str_list_prd_cart . ',' ?>">
            <input type="hidden" name="list_product_add_check" id="list_product_add_check"
                   value="<?php echo ',' . $str_list_prd_cart . ',' ?>">
            <input type="hidden" name="total_quan" id="total_quan"
                   value="<?php echo $total_quan ?>">
            <input type="hidden" name="total_quan_check" id="total_quan_check"
                   value="<?php echo $total_quan ?>">
            <input type="hidden" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
                   name='return'/>
        </form>
    </div>
</div>

<input type="hidden" id="products_type_input" name='products_type'
       value=""/>
<input type="hidden" name="quantity_sub" id="quantity_sub" value="">
<input type="hidden" id="id_sub" name='id_sub'
       value=""/>
<input type="hidden" id="price_input" name='price' value=""/>
