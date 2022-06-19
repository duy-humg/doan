<?php
global $tmpl, $config;
$tmpl->addStylesheet('success', 'modules/products/assets/css');
//$tmpl->addStylesheet('thanhtoan_thanhcong', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_datmua', 'modules/products/assets/css');
$tmpl->addStylesheet('quatang', 'modules/products/assets/css');

//$tmpl->addScript("success", "modules/products/assets/js");
//var_dump($info_guest);
//if($info_guest['hinhthuc'] ==)
?>
<!--<div class="menu-list-cart">-->
<!--    <div class="container clearfix">-->
<!--        <div class="col-md-12">-->
<!--            <div class="_progress-bar">-->
<!--                <span><i class="fa fa-shopping-cart"></i></span>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="col-md-12">-->
<!--            <div id="nav-content">-->
<!--                <ul class="clearfix">-->
<!--                    <li class="choice"><a id="last-checked" href="">ĐĂNG NHẬP</a></li>-->
<!--                    <li><a id="last-checked" href="">THÔNG TIN ĐẶT HÀNG</a></li>-->
<!--                    <li><a id="last-checked" href="">HÌNH THỨC THANH TOÁN</a></li>-->
<!--                    <li><a id="last-checked" href="">ĐẶT MUA</a></li>-->
<!--                    <li><a id="checked" href="">ĐẶT HÀNG THÀNH CÔNG</a></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="container">-->
<!--    <div class="margin-top-cat">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--                <div class="icon-success">-->
<!--                    <img class="img-responsive" src="--><?php //echo URL_ROOT . 'images/img-thanhtoanthanhcong.png'; ?><!--">-->
<!--                    <p><span>Mã đơn hàng: --><?php //echo 'DH' . str_pad($id, 8, "0", STR_PAD_LEFT); ?><!--</span></p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">-->
<!--                --><?php //echo $config['success']; ?>
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
<!--            <div class="box-list-total">-->
<!--                <div class="box-list">-->
<!--                    <h3 class="title-success">--><?php //echo FSText::_("Thông người nhận hàng"); ?><!--</h3>-->
<!--                    <p class="name-customer">--><?php //echo $info_guest['name']; ?>
<!--                        - --><?php //echo $info_guest['telephone']; ?><!--</p>-->
<!--                    <p class="address-customer">--><?php //echo $info_guest['address'] . ', ' . $info_guest['wards'] . ', ' . $info_guest['district'] . ', ' . $info_guest['province']; ?><!--</p>-->
<!--                    <table width="100%" border="0" class="table-product-cart">-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            <th width="60%">--><?php //echo FSText::_("Tên sản phẩm"); ?><!--</th>-->
<!--                            <th class="text-center">--><?php //echo FSText::_("Đơn giá"); ?><!--</th>-->
<!--                            <th class="text-center">--><?php //echo FSText::_("Số lượng"); ?><!--</th>-->
<!--                            <th class="text-right">--><?php //echo FSText::_("Tổng tiền"); ?><!--</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        --><?php
//                        $total_price = 0;
//                        foreach ($list_cart as $item) {
//                            if ($item[2] == 0) {
//                                $price = $data[$item[0]]->price;
//                            } else {
//                                $price = $data[$item[0]]->price_old1;
//                            }
//                            $total_price += $price * $item[1];
//                            ?>
<!--                            <tr>-->
<!--                                <td class="clearfix">-->
<!--                                    <a class="clearfix"-->
<!--                                       href="--><?php //echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?><!--">-->
<!--                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">-->
<!--                                            <img src="--><?php //echo URL_ROOT . str_replace('original', 'small', $data[$item[0]]->image); ?><!--">-->
<!--                                        </div>-->
<!--                                        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">-->
<!--                                            --><?php //echo $data[$item[0]]->name; ?>
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </td>-->
<!--                                <td class="text-center">--><?php //echo format_money($price); ?><!--</td>-->
<!--                                <td class="text-center">--><?php //echo $item[1]; ?><!--</td>-->
<!--                                <td class="text-right">--><?php //echo format_money($price * $item[1]); ?><!--</td>-->
<!--                            </tr>-->
<!--                        --><?php //} ?>
<!--                        </tbody>-->
<!--                    </table>-->
<!---->
<!--                </div>-->
<!--                <div class="total-price-list">-->
<!--                    <div class="row mg1">-->
<!--                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">-->
<!--                            <div class="info-train-left">-->
<!--                                --><?php //if ($info_guest['note_send']) { ?>
<!--                                    <p>-->
<!--                                        <span>--><?php //echo FSText::_("Lời nhắn"); ?><!--:</span> --><?php //echo $info_guest['note_send']; ?>
<!--                                    </p>-->
<!--                                --><?php //} ?>
<!--                                <!--<p><span>--><?php //echo FSText::_("Hình thức vận chuyển"); ?><!--:</span> VETTEL POST</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">-->
<!--                            <div class="info-price-left">-->
<!--                                <div class="borde-top-price">-->
<!--                                    <p class="clearfix">--><?php //echo FSText::_("Tổng tiền sản phẩm"); ?><!--<span-->
<!--                                                class="red-price red1">--><?php //echo format_money($total_price); ?><!--</span>-->
<!--                                    </p>-->
<!--                                    <p class="clearfix">--><?php //echo FSText::_("Tổng phí vận chuyển"); ?><!--<span-->
<!--                                                class="blue-price">--><?php //if ($order->fee) {
//                                                echo format_money((double)$order->fee);
//                                            } else echo '0đ'; ?><!--</span></p>-->
<!--                                    <!--                                    <p class="clearfix">-->
<!--                                    --><?php ////echo FSText::_("Đợn vị vận chuyển"); ?><!--<!--<span class="red-price">-->
<!--                                    --><?// //=$order->transport; ?><!--<!--</span></p>-->
<!--                                    --><?php
//                                    //                                    $discount_member = 0;
//                                    //                                    if ($member->member_level == 1) {
//                                    //                                        $discount_member = $total_price * 0;
//                                    //                                    } else if ($member->member_level == 2) {
//                                    //                                        $discount_member = $total_price * 0.05;
//                                    //                                    } else if ($member->member_level == 3) {
//                                    //                                        $discount_member = $total_price * 0.07;
//                                    //                                    }
//                                    ?>
<!--                                    <!--                                    <p class="clearfix">-->
<!--                                    --><?php ////echo FSText::_("Chương trình khuyến mại"); ?><!--<!--<span class="blue-price">-->
<!--                                    --><?// //=$order->discount_title?><!--<!--</span></p>-->
<!--                                    <!--                                    <p class="clearfix">-->
<!--                                    --><?php ////echo FSText::_("Giảm giá"); ?><!--<!--<span class="blue-price">-->
<!--                                    --><?// //=$order->discount_money?><!--<!--</span></p>-->
<!--                                    <!---->
<!--                                    <!--<p class="clearfix">--><?php //echo FSText::_("Cấp thành viên"); ?><!--<span class="blue-price">--><?php //echo format_money_0($discount_member); ?><!--</span></p>-->
<!--                                </div>-->
<!--                                <p class="clearfix">--><?php //echo FSText::_("Số tiền cần phải trả"); ?><!--<span-->
<!--                                            class="red-price red2">-->
<!--                                          --><?php //if ($order->total_after_discount && $order->fee) {
//                                              echo format_money($order->total_after_discount + (double)$order->fee);
//                                          } elseif (!$order->total_after_discount && $order->fee)
//                                              echo format_money((double)$order->fee);
//                                          elseif ($order->total_after_discount && !$order->fee)
//                                              echo format_money($order->total_after_discount);
//                                          elseif (!$order->total_after_discount && !$order->fee)
//                                              echo "0 đ";
//                                          ?>
<!--                                    </span></p></div>-->
<!--                        </div>-->
<!--                        <div class="clearfix"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div id="tieptuc-muahang">-->
<!--                    <a href="--><?php //echo URL_ROOT; ?><!--">-->
<!--                        <button type="button" class="btn btn-default" name="button">TIẾP TỤC MUA HÀNG</button>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<section>
    <div class="container">
        <div class="col-md-12 cart_pc">
            <div class="_progress-bar">
                <span><i class="fa fa-shopping-cart"></i></span>
            </div>
        </div>

        <div class="col-md-12">
            <div id="nav-content">
                <ul class="clearfix">
                    <li class="choice"><a id="last-checked" href=""><?php echo FSText::_("ĐĂNG NHẬP") ?></a></li>
                    <li><a id="last-checked" href=""><?php echo FSText::_("THÔNG TIN ĐẶT HÀNG") ?></a></li>
                    <li><a id="last-checked" href=""><?php echo FSText::_("HÌNH THỨC THANH TOÁN") ?></a></li>
                    <li class="choice1"><a id="checked" href=""><?php echo FSText::_("ĐẶT MUA") ?></a></li>
                    <li><a href=""><?php echo FSText::_("ĐẶT HÀNG THÀNH CÔNG") ?></a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12">
            <form action="<?php echo FSRoute::_('index.php?module=products&view=pay&task=success'); ?>"
                  name="form_success" class="form_success" method="post">
            <div id="body-content">
                <div class="col-md-8 body4">
                    <div class="body-content--1a clearfix">
                        <div class="col-md-4">
                            <div class="thongtin-muahang">
                                <h5><?php echo FSText::_("THÔNG TIN NGƯỜI MUA HÀNG") ?></h5>
                                <p><?php echo $info_guest['name']; ?></p>
                                <p><?php echo $info_guest['telephone']; ?></p>
                                <p><?php echo $info_guest['email']; ?></p>
                                <p><?php echo $info_guest['address'] . ', ' . $info_guest['wards'] . ', ' . $info_guest['district'] . ', ' . $info_guest['province']; ?></p>
                                <a href="<?php echo FSRoute::_("index.php?module=products&view=pay&task=step_address") ?>">Chỉnh
                                    sửa</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="diachi-nhanhang">
                                <h5><?php echo FSText::_("ĐỊA CHỈ NHẬN HÀNG") ?></h5>
                                <?php
                                if ($info_guest['same_address']) {
                                    ?>
                                    <p><?php echo $info_guest['name']; ?></p>
                                    <p><?php echo $info_guest['telephone']; ?></p>
                                    <p><?php echo $info_guest['email']; ?></p>
                                    <p><?php echo $info_guest['address'] . ', ' . $info_guest['wards'] . ', ' . $info_guest['district'] . ', ' . $info_guest['province']; ?></p>
                                <?php } else { ?>
                                    <p><?php echo $info_guest['re_name']; ?></p>
                                    <p><?php echo $info_guest['re_telephone']; ?></p>
                                    <p><?php echo $info_guest['re_email']; ?></p>
                                    <p><?php echo $info_guest['re_address'] . ', ' . $info_guest['re_wards'] . ', ' . $info_guest['re_district'] . ', ' . $info_guest['re_province']; ?></p>
                                <?php } ?>
                                <a href="<?php echo FSRoute::_("index.php?module=products&view=pay&task=step_address") ?>">Chỉnh
                                    sửa</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="vanchuyen-thanhtoan">
<!--                                <h5>--><?php //echo FSText::_("HÌNH THỨC GIAO HÀNG") ?><!--</h5>-->
<!--                                <p>--><?php //echo $info_guest['hinhthuc']; ?><!--</p>-->
<!--                                <a style="margin-bottom: 15px;display: block;"-->
<!--                                   href="--><?php //echo FSRoute::_("index.php?module=products&view=pay&task=step_address") ?><!--">Thay-->
<!--                                    đổi</a>-->

                                <h5><?php echo FSText::_("HÌNH THỨC THANH TOÁN") ?> </h5>
                                <p><?php
                                    if ($info_guest['payments'] == 1) {
                                        echo 'Thanh toán bằng chuyển khoản qua ngân hàng';
                                    } elseif ($info_guest['payments'] == 2) {
                                        echo 'Thanh toán khi nhận hàng';
                                    } else {
                                        echo 'Thanh toán online qua cổng thanh toán';
                                    }
                                    ?></p>
                                <a href="<?php echo FSRoute::_("index.php?module=products&view=pay&task=pay_code") ?>">Thay
                                    đổi</a>
                            </div>
                        </div>
                    </div>
                    <div class="body-content--1b clearfix">
<!--                        <h5>Thời gian dự tính giao hàng: 20/07/2019 - 23/07/2019</h5>-->
                        <div class="col-md-6">
                            <div class="donhang">
                                <ul>
                                    <?php
                                    $total_price=0;
                                    foreach ($list_cart as $item) {
                                        if ($item[2] == 1) {
                                            $price = $data[$item[0]]->price;
                                        } else {
                                            $price = $data[$item[0]]->price_old1;
                                        }
                                        $total_price += $price * $item[1];
                                        ?>
                                        <li class="donhang-1">
                                            <a class="clearfix"
                                               href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?>">

                                                <img src="<?php echo URL_ROOT . str_replace('original', 'small', $data[$item[0]]->image); ?>"
                                                     alt="Hình ảnh"/>
                                            </a>
                                            <div class="chitiet-donhang1">
                                                <a class="clearfix"
                                                   href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?>">

                                                    <h5><?php echo $data[$item[0]]->name; ?></h5>
                                                </a>
                                                <p><?php echo FSText::_("Giá");?>: <b><?php echo format_money($price); ?></b></p>
                                                <p><?php echo FSText::_("Số lượng");?>: <strong><?php echo $item[1]; ?></strong>  <span><a
                                                                href="<?php echo FSRoute::_("index.php?module=products&view=cart") ?>">  Thay đổi</a></span></p>
<!--                                                <img src="../img/img_thanhtoan/icon-gift.png" alt="Icon">-->
                                               <?php  if (!$info_guest['same_address']) {
                                                ?>
                                                <a href="" class="btn" data-toggle="modal"
                                                   data-target="#myModal"><?php echo FSText::_("Thêm biên nhận quà tặng");?></a>
<!--                                                <strong>Sản phẩm này là quà tặng</strong>-->
<!--                                                <p><i><q>Chào Bảo, đây là quà tặng từ Hòa</q></i></p>-->
                                                <?php } ?>

                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            if ($info_guest['vanchuyen']=='nhận tại cửa hàng'){
                                ?>
                                <div class="hinhthuc-giaohang">
                                    <h5>HÌNH THỨC LẤY HÀNG</h5>
                                    <div class="list-vanchuyen clearfix">
                                        <div class="radio-vanchuyen1 clearfix">

                                            <input type="radio" name="hinhthuc" value="lấy hàng trong ngày" <?php if( $info_guest['hinhthuc']=='lấy hàng trong ngày'){
                                                echo 'checked';}?> id="one-day">
                                            <label for="one-day">
                                                <span></span>&nbsp;
                                                LẤY HÀNG TRONG NGÀY
                                                <br/>
                                                <!--                                            <small>30.000đ (Giao hàng từ 2 - 12 giờ kể từ khi nhận hàng)</small>-->
                                            </label>
                                        </div>
                                        <div class="radio-vanchuyen2 clearfix">

                                            <input type="radio" name="hinhthuc" value="lấy hàng trong 1 giờ" id="one-hour" <?php if( $info_guest['hinhthuc']=='lấy hàng trong 1 giờ'){
                                                echo 'checked'; }?>>
                                            <label for="one-hour">
                                                <span></span>&nbsp;
                                                LẤY HÀNG 1 GIỜ
                                                <br/>
                                                <!--                                            <small>50.000đ (Giao hàng trong 1 giờ kể từ khi nhận hàng)</small>-->
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="hinhthuc-giaohang">
                                    <h5>HÌNH THỨC GIAO HÀNG</h5>
                                    <div class="list-vanchuyen clearfix">
                                        <div class="radio-vanchuyen1 clearfix">

                                            <input type="radio" name="hinhthuc" value="giao hàng tiêu chuẩn" <?php if( $info_guest['hinhthuc']=='giao hàng tiêu chuẩn'){
                                                echo 'checked';}?> id="ghtktc">
                                            <label for="ghtktc">
                                                <span></span>&nbsp;
                                                GIAO HÀNG TIÊU CHUẨN
                                                <br/>
                                                <!--                                            <small>30.000đ (Giao hàng từ 2 - 12 giờ kể từ khi nhận hàng)</small>-->
                                            </label>
                                        </div>
                                        <div class="radio-vanchuyen2 clearfix">

                                            <input type="radio" name="hinhthuc" value="giao hàng nhanh" id="ghtkn" <?php if( $info_guest['hinhthuc']=='giao hàng nhanh'){
                                                echo 'checked'; }?>>
                                            <label for="ghtkn">
                                                <span></span>&nbsp;
                                                GIAO HÀNG NHANH
                                                <br/>
                                                <!--                                            <small>50.000đ (Giao hàng trong 1 giờ kể từ khi nhận hàng)</small>-->
                                            </label>
                                        </div>
                                        <div class="radio-vanchuyen2 clearfix">

                                            <input type="radio" name="hinhthuc" value="giao hàng siêu tốc" id="ghtkst" <?php if( $info_guest['hinhthuc']=='giao hàng siêu tốc'){
                                                echo 'checked'; }?>>
                                            <label for="ghtkst">
                                                <span></span>&nbsp;
                                                GIAO HÀNG SIÊU TỐC
                                                <br/>
                                                <!--                                            <small>50.000đ (Giao hàng trong 1 giờ kể từ khi nhận hàng)</small>-->
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="body-content--2a clearfix">
                        <div class="product clearfix">
                            <div class="purchase">
                                <div class="purchase-detail--price">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="purchase-detail--left">
                                                <p class="p1-left"><?php echo FSText::_("Tổng tiền sản phẩm"); ?></p>
                                                <p class="p2-left"><?php echo FSText::_("Tổng chi phí vận chuyển"); ?></p>
                                                <p class="p2-left"><?php echo FSText::_("Mã giảm giá"); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="purchase-detail--right">
                                                <p class="p1-right"><?php echo format_money($total_price); ?></p>
                                                <?php $total_price += $info_guest['feeghtk']; ?>
                                                <p class="p2-right"><span><?php echo format_money($info_guest['feeghtk']);?></span>
                                                </p>
                                                <p class="p1-right"><?php if ($info_guest['discount_money']){echo format_money($info_guest['discount_money']);}else{echo '0đ';}?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="total-price">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="total-price--left">
                                                <p><?php echo FSText::_("Số tiền cần phải trả"); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="total-price--right">
                                                <p><?php echo format_money($total_price-$info_guest['discount_money']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
<!--                    <div class="left-box-list">-->
<!--                        <div class="check-show-hide">-->
<!--                            <!--                            <input type="checkbox" name="show_add_code" id="show_add_code" > -->
<!--                            <label for="show_add_code">--><?php //echo FSText::_("Mã giảm giá/Quà tặng"); ?><!--</label>-->
<!--                        </div>-->
<!--                        <div class="code_down_price" id="code_down_price" style="display: block">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">-->
<!--                                    <input type="text" name="code_down" id="code_down" placeholder="--><?php //echo FSText::_("Nhập mã giảm giá ở đây") ?><!--"/>-->
<!--                                </div>-->
<!--                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">-->
<!--                                    <a href="javascript:void(0)" class="add_code_price"-->
<!--                                       id="add_code_price">--><?php //echo FSText::_("Đồng ý"); ?><!--</a>-->
<!--                                    <input type="hidden" name="inputcode" id="inputcode" value="0">-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="clearfix"></div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="body-content--2c">
                        <div class="rules">
                            <input type="checkbox"  id="agree" value="" checked="checked" required>
                            <label for="agree">
                                <span><?php echo FSText::_("Tôi đồng ý với")?> <a href="#"><?php echo FSText::_("điều khoản")?></a> &
                                    <a href=""><?php echo FSText::_("điều kiện")?></a><?php echo FSText::_(" giao dịch của Geni")?></span></label>
                        </div>
                        <div class="conditional-terms od">
                            <div class="order">
                                <input type="submit" value="<?php echo FSText::_("Đặt mua sản phẩm"); ?>">
                                <input type="hidden" name="module" value="products">
                                <input type="hidden" name="view" value="pay">
                                <input type="hidden" name="task" value="success">
                                <input type="hidden" name='return' value='<?php echo $return; ?>'/>
                                <input type="hidden" name='payment' value='<?php echo $info_guest['payments']; ?>'/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
<!--    modal-->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <h4 class="modal-title">TÙY CHỌN QUÀ TẶNG CỦA BẠN</h4>
                </div>
                <form method="get">
                    <div class="modal-body clearfix">
                        <div class="input-label clearfix">
                            <input type="checkbox" id="receive-gift" name="receive-gift" value="" checked="checked">
                            <label for="receive-gift"><span></span>&nbsp;Biên lai nhận quà</label>
                        </div>
                        <div class="form-group">
                            <label for="comment">Tin nhắn nhận quà</label>
                            <textarea class="form-control" rows="8" id="comment" placeholder="Nội dung tin nhắn"></textarea>
                        </div>
                        <!--                        <h5>Tin nhắn nhận quà</h5>-->
                        <!--                        <textarea name="name" rows="8" cols="80" placeholder="Nội dung tin nhắn"></textarea>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">LƯU TÙY CHỌN QUÀ TẶNG
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>