<?php
global $tmpl, $config;
$tmpl->addScript("cart", "modules/products/assets/js");
$tmpl->addStylesheet('cart1', 'modules/products/assets/css');
$total_quan = 0;
$list_prd_cart = array();
foreach ($list_cart as $prd) {
    $total_quan += $prd[1];
    if ($prd[4]) {
        $list_prd_cart[] = $prd[4];
    } else {
        $list_prd_cart[] = $prd[0];
    }

}
//var_dump($list_cart);
$str_list_prd_cart = implode(',', $list_prd_cart);
//var_dump($str_list_prd_cart);

?>

<div class="cartmain_">
    <form id="order_form" name="order_form" method="post"
          action="#">
        <!--              action="--><?php //echo FSRoute::_('index.php?module=products&view=cart'); ?><!--">-->
        <div class="row">
            <div class="col_order_form col-md-12 col-sm-12">
                <div class=" left_body bgr">
                    <div class="title-popup">Giỏ hàng của bạn </div>
                    <div class="table-responsive table_">
                        <table width="100%" border="0" class="table-product-pack table" cellpadding="6">
                            <tbody id="popup-cart">

                            <?php

                            if (isset($_SESSION['cart'])) {
                                $list_cart = $_SESSION['cart'];

                                if (count($list_cart)) {
                                    // echo '</pre>';
                                    $i = 0;
                                    $total = 0;
                                    if ($list_cart) {
                                        foreach ($list_cart as $prd) {
                                            $i++;
                                            if ($prd[4]) {
                                                $product = $data[$prd[4]];
//                                        var_dump($product);
                                                $product_sub = $model->get_records('published = 1 and product_id=' . $prd[0], 'fs_products_sub', '*');
                                                $products_type = array();
                                                $color = array();
                                                $json = '['; // start the json array element
                                                $json_names = array();
                                                foreach ($product_sub as $item) {
                                                    if ($item->products_type) {
                                                        if (in_array($item->products_type, $products_type)) {
                                                        } else {
                                                            $products_type[] = $item->products_type;
                                                        }
                                                    }

                                                    $price_sub = $item->price_h;

                                                    $price_sub_old = $item->price;
                                                    $json_names[] = "{price_old : $price_sub_old, quantity: $item->quantity, discount: $item->discount, price: $price_sub , id: $item->id, product_type_id: $item->products_type}";
                                                }
                                                $json .= implode(',', $json_names);
                                                $json .= ']'; // end the json array element
                                                if (!$product) {
                                                    continue;
                                                }

                                                $price = $product->price_sub;
//                                                $price_new = $product->price;
                                                $price_old = $product->price_old_sub;
                                            } else {

                                                $product = $data[$prd[0]];
                                                $price = $product->price;
                                                $price_old = $product->price_old;
                                            }
//                                                var_dump($product);
//                                                if ($prd[2] == 1) {
//                                                if ($product->discount) {
                                            $total += $price * $prd[1];
//                                                    var_dump($total);
//                                                } else {
//                                                    $total += $price_old * $prd[1];
//                                                }
//                                                } else {
//                                                    $total += $price_old * $prd[1];
//                                                }
//var_dump($total);
//                                                $link_del_prd = FSRoute::_('index.php?module=products&view=cart&task=edel&id=' . $prd[0] . '&Itemid=65');
                                            $link_view = FSRoute::_('index.php?module=products&view=product&code=' . $product->alias . '&id=' . $product->id . '&ccode=' . $product->category_alias);
                                            if (!$prd[4]) {
                                                $image = URL_ROOT . str_replace('/original/', '/small/', $product->image);
                                            }else{
//                                                    $item_img = $model->get_record('record_id =' .$prd[0].' AND prd_type_id ='.$product->products_type,'fs_products_images','image');
                                                $image = URL_ROOT . str_replace('/original/', '/small/', $product->image_sub);
                                            }
                                            ?>
                                            <tr class="<?php echo "tr-pop-" . $i; ?>">
                                                <td class="check_box1">
                                                    <label class="check-box">
                                                        <input type="checkbox" class="check_"
                                                               onclick="cbyuy(<?php if ($prd[4]) {
                                                                   echo $product->id_sub;
                                                               } else {
                                                                   echo $product->id;
                                                               } ?>,<?= $price * $prd[1] ?>,<?= $prd[1] ?>)"
                                                               id="item_<?php if ($prd[4]) {
                                                                   echo $product->id_sub;
                                                               } else {
                                                                   echo $product->id;
                                                               } ?>" value=""
                                                               checked="checked" required>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="name-product">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 imb">
                                                        <!--                                                            <input type="checkbox" id="item_-->
                                                        <?php //echo $product->id_sub ?><!--" value="" checked="checked" required>-->
                                                        <!--                                                            <label for="item_-->
                                                        <?php //echo $product->id_sub ?><!--"></label>-->
                                                        <a class="pull-left" href="<?php echo $link_view; ?>">
                                                            <img class="img-responsive" src="<?php echo $image; ?>"
                                                                 alt="<?php echo htmlspecialchars($product->name); ?>">
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 nmb">
                                                        <h4 class="media-heading">
                                                            <a href="<?php echo $link_view ?>"><?php echo $product->name; ?></a>
                                                        </h4>
                                                    </div>
                                                    <div class="clear"></div>
                                                </td>
                                                <td class="product_type">
                                                    <!--                                                        <a class="dropdown-toggle dropdow_type" href="#"-->
                                                    <!--                                                           id="dropdownMenuButton-->
                                                    <?php //echo $i ?><!--"-->
                                                    <!--                                                           data-toggle="dropdown" aria-haspopup="true"-->
                                                    <!--                                                           aria-expanded="false">-->
                                                    <?php if ($prd[4]) { ?>
                                                        <!--                                                            <a class="dropdow_type" data-toggle="collapse"-->
                                                        <!--                                                               href="#collapseExample--><?php //echo $i ?><!--" role="button"-->
                                                        <!--                                                               aria-expanded="false"-->
                                                        <!--                                                               aria-controls="collapseExample--><?php //echo $i ?><!--">-->
                                                        <p class="title_type">Phân loại: <span
                                                                    class="up_arrow"></span></p>
                                                        <p class="loai"><span><?php echo $product->name_sub ?></span>
                                                        </p>
                                                        <!--                                                            </a>-->

                                                        <!--                                                        <div class="dropdown-menu menuu"-->
                                                        <!--                                                             aria-labelledby="dropdownMenuButton-->
                                                        <?php //echo $i ?><!--">-->
                                                        <div class="collapse menuu"
                                                             id="collapseExample<?php echo $i ?>">
                                                            <input type="hidden" class="products_sub"
                                                                   value="<?php echo @$json ?>">
                                                            <?php if (count($color)) { ?>
                                                                <div class="color_item_">
                                                                    <p class="color_title">Màu sắc:</p>
                                                                    <div class="color">
                                                                        <?php foreach ($color as $item) {
                                                                            $color_item = $model->get_record('id=' . $item, 'fs_products_color', '*');
//                                                                            var_dump($color_item->id);
//                                                                            var_dump($product->color_id);
                                                                            ?>
                                                                            <div data="color_item"
                                                                                 name="color_title"
                                                                                 name-item="<?php echo $color_item->name; ?>"
                                                                                 color_id="<?php echo $color_item->id; ?>"
                                                                                 class="item_price color_item color_click <?php if ($product->color_id == $color_item->id) {
                                                                                     echo 'active2';
                                                                                 } ?>">
                                                                                <p><?php echo $color_item->name; ?></p>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (count($products_type)) { ?>
                                                                <div class="products_type_item_">
                                                                    <p class="prd_type_title color_title">Phân loại
                                                                        hàng:</p>
                                                                    <div class="products_type">
                                                                        <?php foreach ($products_type as $item) {
                                                                            $products_type_item = $model->get_record('id=' . $item, 'fs_products_type', '*');
                                                                            ?>
                                                                            <div data="products_type_item"
                                                                                 name="$products_type_title"
                                                                                 name-item="<?php echo $products_type_item->name; ?>"
                                                                                 products_type_id="<?php echo $products_type_item->id; ?>"
                                                                                 class="item_price products_type_item products_type_click  <?php if ($product->products_type == $products_type_item->id) {
                                                                                     echo 'active2';
                                                                                 } ?>">
                                                                                <p><?php echo $products_type_item->name; ?></p>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="sbm">
                                                                <a href="#" class=" replay">Trở lại</a>
                                                                <a href="#" class=" confirm"
                                                                   onclick="change_adj(<?php echo $prd[4] ?>)">Xác
                                                                    nhận</a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td class="td-price">
                                                    <p>
                                                        <span class="price">

                                                            <?php if ($prd[4]) { ?>
                                                                <?php
                                                                echo ($product->discount_sub) ? format_money($price, 'đ') : format_money($price_old, 'đ');
                                                                ?>
                                                            <?php } else { ?>
                                                                <?php
                                                                //                                                            var_dump($price);
                                                                echo ($product->discount) ? format_money($price, 'đ') : format_money($price_old, 'đ');
                                                                ?>
                                                            <?php } ?>
                                                        </span>
                                                    </p>
                                                    <?php if ($prd[4]) { ?>
                                                        <?php if ($product->discount_sub) { ?>
                                                            <p>
                                                                <span class="old_price "> <?php echo format_money($price_old, 'đ'); ?></span>
                                                            </p>
                                                            <!--                                                            <p>-->
                                                            <!--                                                                <span class="old_price1 "> --><?php //echo '-' . $product->discount . '%'; ?><!--</span>-->
                                                            <!--                                                            </p>-->
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($product->discount) { ?>
                                                            <p>
                                                                <span class="old_price "> <?php echo format_money($price_old, 'đ'); ?></span>
                                                            </p>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="td-quantity text-center">
                                                    <div class="visible-xs cart_mb12">
                                                        <h4 class="media-heading">
                                                            <a href="<?php echo $link_view ?>"><?php echo $product->name; ?></a>
                                                            <span class="price_ttol"><?php echo format_money($price * $prd[1], 'đ') ?></span>
                                                        </h4>
                                                        <?php if ($prd[4]) { ?>
                                                            <!--                                                                <a class="dropdow_type" data-toggle="collapse"-->
                                                            <!--                                                                   href="#collapseExample_mb--><?php //echo $i ?><!--"-->
                                                            <!--                                                                   role="button"-->
                                                            <!--                                                                   aria-expanded="false"-->
                                                            <!--                                                                   aria-controls="collapseExample--><?php //echo $i ?><!--">-->
                                                            <p class="title_type">Phân loại: <span
                                                                        class="up_arrow"></span></p>
                                                            <p class="loai"><span><?php echo $product->color_name ?>
                                                                    <?php if ($product->color_name) {
                                                                        echo ', ';
                                                                    } ?> </span><span><?php echo $product->name_sub ?></span>
                                                            </p>
                                                            <div class="clearfix"></div>
                                                            <!--                                                                </a>-->

                                                            <!--                                                        <div class="dropdown-menu menuu"-->
                                                            <!--                                                             aria-labelledby="dropdownMenuButton-->
                                                            <?php //echo $i ?><!--">-->
                                                            <div class="collapse menuu"
                                                                 id="collapseExample_mb<?php echo $i ?>">
                                                                <input type="hidden" class="products_sub"
                                                                       value="<?php echo @$json ?>">
                                                                <?php if (count($color)) { ?>
                                                                    <div class="color_item_">
                                                                        <p class="color_title">Màu sắc:</p>
                                                                        <div class="color">
                                                                            <?php foreach ($color as $item) {
                                                                                $color_item = $model->get_record('id=' . $item, 'fs_products_color', '*');
//                                                                            var_dump($color_item->id);
//                                                                            var_dump($product->color_id);
                                                                                ?>
                                                                                <div data="color_item"
                                                                                     name="color_title"
                                                                                     name-item="<?php echo $color_item->name; ?>"
                                                                                     color_id="<?php echo $color_item->id; ?>"
                                                                                     class="item_price color_item color_click <?php if ($product->color_id == $color_item->id) {
                                                                                         echo 'active2';
                                                                                     } ?>">
                                                                                    <p><?php echo $color_item->name; ?></p>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if (count($products_type)) { ?>
                                                                    <div class="products_type_item_">
                                                                        <p class="prd_type_title color_title">Phân
                                                                            loại
                                                                            hàng:</p>
                                                                        <div class="products_type">
                                                                            <?php foreach ($products_type as $item) {
                                                                                $products_type_item = $model->get_record('id=' . $item, 'fs_products_type', '*');
                                                                                ?>
                                                                                <div data="products_type_item"
                                                                                     name="$products_type_title"
                                                                                     name-item="<?php echo $products_type_item->name; ?>"
                                                                                     products_type_id="<?php echo $products_type_item->id; ?>"
                                                                                     class="item_price products_type_item products_type_click  <?php if ($product->products_type == $products_type_item->id) {
                                                                                         echo 'active2';
                                                                                     } ?>">
                                                                                    <p><?php echo $products_type_item->name; ?></p>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sbm">
                                                                    <a href="#" class=" replay">Trở lại</a>
                                                                    <a href="#" class=" confirm"
                                                                       onclick="change_adj(<?php echo $prd[4] ?>)">Xác
                                                                        nhận</a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($prd[4]) { ?>
                                                            <?php if ($product->discount_sub) { ?>
                                                                <p class="price_old_mb">
                                                                    <span class="old_price "> <?php echo format_money($price_old, 'đ'); ?></span>
                                                                </p>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <?php if ($product->discount) { ?>
                                                                <p class="price_old_mb">
                                                                    <span class="old_price "> <?php echo format_money($price_old, 'đ'); ?></span>
                                                                </p>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <p class="price_mb">
                                                        <span class="price">

                                                            <?php if ($prd[4]) { ?>
                                                                <?php
                                                                echo ($product->discount_sub) ? format_money($price, 'đ') : format_money($price_old, 'đ');
                                                                ?>
                                                            <?php } else { ?>
                                                                <?php
                                                                //                                                            var_dump($price);
                                                                echo ($product->discount) ? format_money($price, 'đ') : format_money($price_old, 'đ');
                                                                ?>
                                                            <?php } ?>
                                                        </span>
                                                        </p>

                                                    </div>


                                                    <div class="quan">
                                                         <span class="number-input">
                                                             <button type="button" onclick="down_quantity(<?php if ($prd[4]) {
                                                                 echo $prd[4];
                                                             } else {
                                                                 echo $prd[0];
                                                             } ?>)"
                                                                     class="down"></button>
                                                            <input type="number"
                                                                   name="quantity_<?php if ($prd[4]) {
                                                                       echo $prd[4];
                                                                   } else {
                                                                       echo $prd[0];
                                                                   } ?>"
                                                                   id="quantity_<?php if ($prd[4]) {
                                                                       echo $prd[4];
                                                                   } else {
                                                                       echo $prd[0];
                                                                   } ?>"
                                                                   class="numbersOnly<?php echo $i; ?>"
                                                                   maxlength="5"
                                                                   onblur="change_quantity(<?php if ($prd[4]) {
                                                                       echo $prd[4];
                                                                   } else {
                                                                       echo $prd[0];
                                                                   } ?>)"
                                                                   value="<?php echo $prd[1] ?>"/>
                                                             <input type="hidden" name="quan_max_<?php echo ($prd[4])?$prd[4]:$prd[0] ?>"  id="quan_max_<?php echo ($prd[4])?$prd[4]:$prd[0] ?>" value="<?php echo ($prd[4])?$product->quantity_sub:$product->quantity ?>">
                                                            <button type="button" onclick="up_quantity(<?php if ($prd[4]) {
                                                                echo $prd[4];
                                                            } else {
                                                                echo $prd[0];
                                                            } ?>)"
                                                                    class="plus"></button>

                                                        </span>
                                                    </div>
                                                    <div class="del_mb visible-xs">
                                                        <a data-id="<?php if ($prd[4]) {
                                                            echo $prd[4];
                                                        } else {
                                                            echo $prd[0];
                                                        } ?>"
                                                           data-tr="<?php echo "tr-pop-" . $i; ?>"
                                                           class="del-pro-link"
                                                           href="#"
                                                           title="">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="total_price_item text-center" width='10%'>
                                                    <p class="price_ttol"><?php echo format_money($price * $prd[1], 'đ') ?></p>
                                                </td>
                                                <td class="text-center td_delete">
                                                    <a data-id="<?php if ($prd[4]) {
                                                        echo $prd[4];
                                                    } else {
                                                        echo $prd[0];
                                                    } ?>"
                                                       data-tr="<?php echo "tr-pop-" . $i; ?>" class="del-pro-link"
                                                       href="#"
                                                       title="">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>

                                            </tr>

                                            <?php
                                        }
                                        $i++;
                                    }
                                }
                            }
                            //                                var_dump($total);
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="free_ship">Miễn phí vận chuyển với đơn hàng
                        từ <?php echo format_money($config['feeAdc']) ?></p>
                </div>
            </div>
        </div>
        <!--                <div class="col-md-12 col-sm-12">-->
        <!--            --><?php //echo $total ?>
        <div class="ft-popup-cart right_body bgr">
            <div class="row">
                <div class="left_bot col-md-4 col-xs-12">
                    <label class="check-box">Chọn tất cả(<span><?php echo $total_quan ?></span>)
                        <input type="checkbox" checked="checked" id="checkAll">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="right_bot col-md-8 col-xs-12">
                    <div class="pop1 pop">
                        <p class="txt-total-pop visible_pc">Tổng tiền hàng(<span
                                    class="quantt"><?php echo $total_quan ?></span> sản phẩm):
                            <span class=" total-pop total-pop1"><?php echo format_money($total, 'đ'); ?></span>
                        </p>
                        <p class="txt-total-pop visible-xs">Tổng tiền:
                            <span class=" total-pop total-pop1"><?php echo format_money($total, 'đ'); ?></span>
                        </p>
                    </div>
                    <div class="sub-wrapper-popup">
                        <!--                        <a href="-->
                        <?php //echo FSRoute::_('index.php?module=products&view=pay'); ?><!--"-->
                        <!--                           class="bt-pop continue-buy text-center">Mua hàng </a>-->
                        <a href="javascript:void(0)"
                           class="bt-pop continue-buy text-center" id="submit_buy" onclick="submitFormb()">Mua
                            hàng </a>
                    </div>
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
<div class="relate">
    <?php include 'default_related.php'; ?>
</div>


<!--<input type="hidden" id="color_input" name='color'-->
<!--       value=""/>-->
<input type="hidden" id="products_type_input" name='products_type'
       value=""/>
<input type="hidden" name="quantity_sub" id="quantity_sub" value="">
<input type="hidden" id="id_sub" name='id_sub'
       value=""/>
<input type="hidden" id="price_input" name='price' value=""/>
