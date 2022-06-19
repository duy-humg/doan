<?php
global $tmpl, $config;
$tmpl->addStylesheet('success', 'modules/products/assets/css');
//$tmpl->addStylesheet('thanhtoan_thanhcong', 'modules/products/assets/css');

//$tmpl->addScript("success", "modules/products/assets/js");
?>
<div class="container m_b">
    <div class="margin-top-cat">
        <div class="note_top">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg_mb">
                    <div class="icon-success">
                        <img class="img-responsive" src="<?php echo URL_ROOT . 'images/done.png'; ?>">
                        <p class="codess">
                            <span>Mã đơn hàng: <?php echo 'DH' . str_pad($id, 8, "0", STR_PAD_LEFT); ?></span></p>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mg_mb1">
                    <p class="title_order">Đặt hàng thành công!</p>
                    <?php echo $config['success']; ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="box-list-total">
            <div class="box-list">
                <h3 class="title-success"><?php echo FSText::_("Thông tin người nhận hàng"); ?></h3>
                <p class="name-customer"><?php echo $info_guest['name']; ?>
                    - <?php echo $info_guest['telephone']; ?></p>
                <p class="address-customer"><?php echo $info_guest['address'] . ", " . $info_guest['wards'] . ', ' . $info_guest['district'] . ', ' . $info_guest['province']; ?></p>
                <table width="100%" border="0" class="table-product-cart visible_pc">
                    <thead>
                    <tr>
                        <th width="60%"><?php echo FSText::_("Tên sản phẩm"); ?></th>
                        <th class="text-center"><?php echo FSText::_("Đơn giá"); ?></th>
                        <th class="text-center"><?php echo FSText::_("Số lượng"); ?></th>
                        <th class="text-right"><?php echo FSText::_("Tổng tiền"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_price = 0;
                    foreach ($list_cart as $item) {
                        if ($item[4]) {
                            $product = $data[$item[4]];
                            $price = $product->price_sub;
                        } else {
                            $product = $data[$item[0]];
                            $price = $product->price;
                        }
                        $total_price += $price * $item[1];
                        if (!$item[4]) {
                            $image = URL_ROOT . str_replace('/original/', '/small/', $product->image);
                        } else {
//                            $item_img = $model->get_record('record_id =' . $item[0] . ' AND prd_type_id =' . $product->products_type, 'fs_products_images', 'image');
                            $image = URL_ROOT . str_replace('/original/', '/small/', $product->image_sub);
                        }
                        ?>
                        <tr>
                            <td class="clearfix">
                                <a class="clearfix"
                                   href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $product->category_alias . '&code=' . $product->alias . '&id=' . $product->id); ?>">
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <img src="<?php echo $image ?>">
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                                        <?php echo $product->name; ?>
                                        <p style="margin-top: 8px">Phân loại: <?php echo $product->products_type_name ?></p>
                                    </div>
                                </a>
                            </td>
                            <td data-label="Đơn giá" class="text-center td_mb"><?php echo format_money($price); ?></td>
                            <td data-label="Số lượng" class="text-center td_mb"><?php echo $item[1]; ?></td>
                            <td data-label="Tổng tiền"
                                class="text-right"><?php echo format_money($price * $item[1]); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="list_cat_mb visible-xs">
                    <h3>Danh sách sản phẩm</h3>
                    <?php
                    $total_price = 0;
                    foreach ($list_cart as $item) {
                        if ($item[4]) {
                            $product = $data[$item[4]];
                            $price = $product->price_sub;
                        } else {
                            $product = $data[$item[0]];
                            $price = $product->price;
                        }
                        $total_price += $price * $item[1];
                        $link_view = FSRoute::_('index.php?module=products&view=product&code=' . $product->alias . '&id=' . $product->id . '&ccode=' . $product->category_alias);
                        $image = URL_ROOT . str_replace('/original/', '/tiny/', $product->image);
                        ?>
                        <div class="row pd_col">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 mg_col">
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 mg_col">
                                    <a href="<?php echo $link_view ?>">
                                        <img src="<?php echo $image ?>" alt="<?php echo $product->name ?>"
                                             class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 mg_col">
                                    <a href="<?php echo $link_view ?>">
                                        <p class="name_mb"><?php echo $product->name ?></p>
                                        <?php if ($item[4]) { ?>
                                            <p class="type_prd">Loại:
                                                <?php if ($product->color_name && $product->products_type_name) { ?>
                                                    <span><?php echo $product->color_name ?>
                                                        , </span>
                                                <?php } elseif ($product->color_name && !$product->products_type_name) { ?>
                                                    <span><?php echo $product->color_name ?>
                                                            </span>
                                                <?php } ?>
                                                <?php if ($product->products_type_name) { ?>
                                                    <span><?php echo $product->products_type_name ?></span>
                                                <?php } ?>
                                            </p>
                                        <?php } ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mg_col mg_col_r">
                                <p><?php echo format_money($price); ?></p>
                                <p><?php echo 'x' . $item[1]; ?></p>
                                <p class="price_item_mb"><?php echo format_money($price * $item[1]); ?></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>
                </div>
            </div>
            <div class="total-price-list">
                <div class="row mg1">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="info-train-left">
                            <?php if ($info_guest['note_send']) { ?>
                                <p><span><?php echo FSText::_("Lời nhắn"); ?>
                                        :</span> <?php echo $info_guest['note_send']; ?></p>
                            <?php } ?>
                            <p><span><?php echo FSText::_("Đơn vị vận chuyển"); ?>
                                    :</span> <?php echo $info_guest['transport']; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="info-price-left">
                            <div class="borde-top-price">
                                <p class="clearfix"><?php echo FSText::_("Tổng tiền sản phẩm"); ?><span
                                            class="red-price red1"><?php echo format_money($total_price); ?></span></p>
                                <p class="clearfix"><?php echo FSText::_("Tổng phí vận chuyển"); ?><span
                                            class="blue-price"><?php if ($order->fee) {
                                            echo format_money((double)$order->fee);
                                        } else echo '0đ'; ?></span></p>
                                <!--                                    <p class="clearfix">-->
                                <?php //echo FSText::_("Đợn vị vận chuyển"); ?><!--<span class="red-price">-->
                                <? //=$order->transport; ?><!--</span></p>-->
                                <!--                                    --><?php //
                                //                                    $discount_member = 0;
                                //                                    if ($member->member_level == 1) {
                                //                                        $discount_member = $total_price * 0;
                                //                                    } else if ($member->member_level == 2) {
                                //                                        $discount_member = $total_price * 0.05;
                                //                                    } else if ($member->member_level == 3) {
                                //                                        $discount_member = $total_price * 0.07;
                                //                                    }
                                //                                    ?>
                                <!--                                    <p class="clearfix">-->
                                <?php //echo FSText::_("Chương trình khuyến mại"); ?><!--<span class="blue-price">-->
                                <? //=$order->discount_title?><!--</span></p>-->
                                <!--                                    <p class="clearfix">-->
                                <?php //echo FSText::_("Giảm giá"); ?><!--<span class="blue-price">-->
                                <? //=$order->discount_money?><!--</span></p>-->
                                <!--                                    <p class="clearfix">-->
                                <?php //echo FSText::_("Cấp thành viên"); ?><!--<span class="blue-price">-->
                                <?php //echo format_money_0($discount_member); ?><!--</span></p>-->
                            </div>
                            <p class="clearfix"><?php echo FSText::_("Số tiền cần phải trả"); ?><span
                                        class="red-price red2">
                                        <?php if ($order->total_after_discount && $order->fee) {
                                            echo format_money($order->total_after_discount + (double)$order->fee);
                                        } elseif (!$order->total_after_discount && $order->fee)
                                            echo format_money((double)$order->fee);
                                        elseif ($order->total_after_discount && !$order->fee)
                                            echo format_money($order->total_after_discount);
                                        elseif (!$order->total_after_discount && !$order->fee)
                                            echo "0 đ";
                                        ?>
                                    <!--                                    --><?php //echo format_money( $total_price) ?>
                                    </span></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>