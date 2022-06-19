<?php
$total_quan = 0;
$tatal_price = 0;
//var_dump($_SESSION['cart']);
foreach ($product_list as $prd) {
    $total_quan += $prd[1];
    $total_price += $prd[1] * $prd[2];
}
//var_dump($product_list);
//var_dump($tatal_price);die;
?>
<!--<div class="wrapper-tb-pop">-->
<a href="javascript:void(0)" id="close-cart"><img src="<?php echo URL_ROOT . 'images/Path 523.svg' ?>"
                                                  alt="close cart"/></a>
<div class="title_popup clearfix">
<!--    <p class="quan">--><?php //echo $total_quan ?><!--<span> sản phẩm</span></p>-->
<!--    <p class="price_tt">--><?php //echo format_money($total_price, 'đ') ?><!--</p>-->
    <p class="add_success"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 16px;color: #6ac259; margin-right: 5px"></i><span>Thêm vào giỏ hàng thành công</span></p>
</div>
<div class="sbmm">
    <a href="<?php echo FSRoute::_('index.php?module=products&view=cart&task=cart'); ?>" class="btn order_now">Xem và chỉnh sửa giỏ hàng</a>
</div>
<!--<div id="popup-cart">-->
<!--    --><?php
//    if (isset($_SESSION['cart'])) {
//        $product_list = $_SESSION['cart'];
//        if (count($product_list)) {
//            // echo '</pre>';
//            $i = 0;
//            $total = 0;
//            if ($product_list) {
//                foreach ($product_list as $prd) {
//                    if ($prd[5]) {
//                        if ($prd[3] && !$prd[4]) {
//                            $where = ' AND b.color_id =' . $prd[3];
//                        } else
//                            if ($prd[4] && $prd[3]) {
//                                $where = ' AND b.color_id =' . $prd[3] . ' AND b.products_type =' . $prd[4];
//                            } else
//                                if ($prd[4] && !$prd[3]) {
//                                    $where = ' AND b.products_type =' . $prd[4];
//                                }
//                        $i++;
//
////                    var_dump($where);
////                    $product = $model->get_record('published = 1 AND product_id=' . $prd[0] . $where, 'fs_products_sub');
//                        $product = $model->get_product_sub($where);
////                                    var_dump($product);
//
//                    } else {
//                        $product = $model->getProduct($prd[0]);
//                    }
////                    var_dump($product);
//                    if (!$product)
//                        continue;
//                    if ($prd[5]) {
//                        $price_old = $product->price_old_sub;
//                        $price = $product->price_sub;
//                    }else{
//                        $price_old = $product->price_old;
//                        $price = $product->price;
//                    }
////                    $total += $price_new * $prd[1];
//                    $link_view = FSRoute::_('index.php?module=products&view=product&code=' . $product->alias . '&id=' . $product->id . '&ccode=' . $product->category_alias . '&Itemid=5');
//                    $image = URL_ROOT . str_replace('/original/', '/resized/', $product->image);
//                    ?>
<!--                    <div class="--><?php //echo "tr-pop-" . $i; ?><!-- prd_detail">-->
<!--                        <div class="img_product">-->
<!--                            <a class="pull-left" href="--><?php //echo $link_view; ?><!--">-->
<!--                                <img class="img-responsive" src="--><?php //echo $image; ?><!--"-->
<!--                                     alt="--><?php //echo htmlspecialchars($product->name); ?><!--">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div class="name_prd">-->
<!--                            <a href="--><?php //echo $link_view ?><!--">--><?php //echo $product->name; ?><!--</a>-->
<!--                            --><?php //if ($prd[3]) { ?>
<!--                                <p class="nature">Màu sắc: <span>--><?php //echo $product->color_name ?><!--</span></p>-->
<!--                            --><?php //} ?>
<!--                            --><?php //if ($prd[4]) { ?>
<!--                                <p class="nature">Phân loại hàng:-->
<!--                                    <span>--><?php //echo $product->products_type_name ?><!--</span></p>-->
<!--                            --><?php //} ?>
<!--                            <p class="price_prd">--><?php //echo format_money($price, 'đ') ?><!--</p>-->
<!--                        </div>-->
<!--                        <div class="del_prd">-->
<!--                            <a data-id="--><?php //if ($prd[5]){ echo  $product->id_sub;}else{
//                                echo $product->id;
//                            } ?><!--"-->
<!--                               data-tr="--><?php //echo "tr-pop-" . $i; ?><!--"-->
<!--                               class="del-pro-link"-->
<!--                               href="#"-->
<!--                               title="">-->
<!--                                <img src="--><?php //echo URL_ROOT ?><!--modules/products/assets/images/del_prd.png"-->
<!--                                     alt="Bỏ sản phẩm">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    --><?php
//                }
//                $i++;
//            }
//        }
//    }
//    ?>
<!--</div>-->
<!--<a href="--><?php //echo FSRoute::_('index.php?module=products&view=cart&task=cart'); ?><!--" class="btn order_now now_">Xem và-->
<!--    chỉnh sửa giỏ hàng</a>-->
<!--</div>-->