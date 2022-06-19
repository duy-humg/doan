 <?php
global $tmpl, $config;
$tmpl->addStylesheet('success', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_thanhcong', 'modules/products/assets/css');
//$tmpl->addScript("success", "modules/products/assets/js");
//var_dump($_SESSION['info_guest']);
?>
<div class="menu-list-cart">
    <div class="container clearfix">
        <div class="col-md-12 cart_pc">
            <div class="_progress-bar">
                <span><i class="fa fa-shopping-cart"></i></span>
            </div>
        </div>

        <div class="col-md-12 ">
            <div id="nav-content">
                <ul class="clearfix">
                    <li class="choice"><a id="last-checked" href=""><?php echo FSText::_("ĐĂNG NHẬP") ?></a></li>
                    <li><a id="last-checked" href=""><?php echo FSText::_("THÔNG TIN ĐẶT HÀNG") ?></a></li>
                    <li><a id="last-checked" href=""><?php echo FSText::_("HÌNH THỨC THANH TOÁN") ?></a></li>
                    <li><a id="last-checked" href=""><?php echo FSText::_("ĐẶT MUA") ?></a></li>
                    <li class="choice1"><a id="checked" href=""><?php echo FSText::_("ĐẶT HÀNG THÀNH CÔNG") ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container m_b">
    <div class="margin-top-cat">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mg_mb">
                <div class="icon-success">
                    <img class="img-responsive" src="<?php echo URL_ROOT.'images/img-thanhtoanthanhcong.png'; ?>">
                    <p><span>Mã đơn hàng: <?php echo 'DH'.str_pad($order->id, 8 , "0", STR_PAD_LEFT); ?></span></p>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mg_mb1">
                <p class="title_order">Đặt hàng thành công!</p>
                <?php echo $config['success']; ?>
            </div>
            <div class="clearfix"></div>
            <div class="box-list-total">
                <div class="box-list bd_not">
                    <h3 class="title-success"><?php echo FSText::_("Thông tin người nhận hàng");?></h3>
                    <p class="name-customer"><?php echo $info_guest['name'] ; ?> - <?php echo $info_guest['telephone']; ?></p>
                    <p class="address-customer"><?php echo $info_guest['address'].', '.$info_guest['wards'].', '.$info_guest['district'].', '.$info_guest['province']; ?></p>
                    <table width="100%" border="0" class="table-product-cart">
                        <thead>
                            <tr>
                                <th width="60%"><?php echo FSText::_("Tên sản phẩm");?></th>
                                <th class="text-center"><?php echo FSText::_("Đơn giá");?></th>
                                <th class="text-center"><?php echo FSText::_("Số lượng");?></th>
                                <th class="text-right"><?php echo FSText::_("Tổng tiền");?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $total_price = 0;
                                foreach($list_cart as $item){
                                    if ($item[2] == 1) {
                                        $price = $data[$item[0]]->price;
                                    } else {
                                        $price = $data[$item[0]]->price_old1;
                                    }
                                    $total_price += $price * $item[1];
                            ?>
                            <tr>
                                <td class="clearfix">
                                    <a class="clearfix" href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?>">
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <img src="<?php echo URL_ROOT. str_replace('original', 'small', $data[$item[0]]->image); ?>">
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                                        <?php echo $data[$item[0]]->name; ?>
                                        </div>
                                    </a>
                                </td>
                                <td data-label="Đơn giá" class="text-center td_mb"><?php echo format_money($price); ?></td>
                                <td data-label="Số lượng"  class="text-center td_mb"><?php echo $item[1]; ?></td>
                                <td data-label="Tổng tiền" class="text-right td_mb"><?php echo format_money($price*$item[1]); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
                <div class="total-price-list">
                    <div class="row mg1">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="info-train-left">
                                <?php if($info_guest['note_send']){ ?>
                                    <p><span><?php echo FSText::_("Lời nhắn");?>:</span> <?php echo $info_guest['note_send'] ; ?></p>
                                <?php }?>
                                <p><span><?php echo FSText::_("Hình thức giao hàng");?>:</span> <?php echo $info_guest['hinhthuc'] ; ?></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="info-price-left">
                                <div class="borde-top-price">
                                    <p class="clearfix"><?php echo FSText::_("Tổng tiền sản phẩm"); ?><span class="red-price red1"><?php echo format_money($total_price); ?></span></p>
                                    <p class="clearfix"><?php echo FSText::_("Tổng phí vận chuyển"); ?><span class="blue-price"><?php if($order->fee)
                                            {
                                                echo format_money((double)$order->fee);
                                            }else echo '0đ';?></span></p>
<!--                                    <p class="clearfix">--><?php //echo FSText::_("Đợn vị vận chuyển"); ?><!--<span class="red-price">--><?//=$order->transport; ?><!--</span></p>-->
                                    <?php 
//                                    $discount_member = 0;
//                                    if ($member->member_level == 1) {
//                                        $discount_member = $total_price * 0;
//                                    } else if ($member->member_level == 2) {
//                                        $discount_member = $total_price * 0.05;
//                                    } else if ($member->member_level == 3) {
//                                        $discount_member = $total_price * 0.07;
//                                    }
                                    ?>
<!--                                    <p class="clearfix">--><?php //echo FSText::_("Chương trình khuyến mại"); ?><!--<span class="blue-price">--><?//=$order->discount_title?><!--</span></p>-->
<!--                                    <p class="clearfix">--><?php //echo FSText::_("Giảm giá"); ?><!--<span class="blue-price">--><?//=$order->discount_money?><!--</span></p>-->
                                    <!--
                                    <!--<p class="clearfix"><?php echo FSText::_("Cấp thành viên"); ?><span class="blue-price"><?php echo format_money_0($discount_member); ?></span></p>-->
                                </div>
                                <p class="clearfix"><?php echo FSText::_("Số tiền cần phải trả"); ?><span class="red-price red2">
                                          <?php if($order->total_after_discount && $order->fee){
                                              echo format_money( $order->total_after_discount+(double)$order->fee);
                                          } elseif(!$order->total_after_discount && $order->fee)
                                              echo format_money( (double)$order->fee);
                                          elseif($order->total_after_discount && !$order->fee)
                                              echo format_money( $order->total_after_discount);
                                          elseif (!$order->total_after_discount && !$order->fee)
                                              echo "0 đ";
                                          ?>
<!--                                        --><?php //echo format_money($total_price); ?>
                                    </span></p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="tieptuc-muahang">
                <a href="<?php echo URL_ROOT;?>"><button type="button" class="btn btn-default" name="button">TIẾP TỤC MUA HÀNG</button></a>
            </div>
            </div>
        </div>
    </div>
</div>