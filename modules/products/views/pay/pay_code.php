<?php
global $tmpl, $config;
$tmpl->addStylesheet('pay_code', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_thanhtoan-online', 'modules/products/assets/css');
$tmpl->addScript("pay_code", "modules/products/assets/js");
$tmpl->addScript("code", "modules/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
$login_code = array(
    0 => '<i class="fa fa-exclamation-circle"></i> ' . FSText::_('Mã khuyến mại không hợp lệ'),
    1 => '<i class="fa fa-exclamation-circle"></i> ' . FSText::_('Mã khuyến mại hợp lệ'),

);
?>
<input type="hidden" id="paycode" value='<?php echo json_encode($login_code) ?>'/>
<div class="menu-list-cart">
    <div class="container clearfix pc30">
        <div class="col-md-12 cart_pc">
            <div class="_progress-bar">
                <span><i class="fa fa-shopping-cart"></i></span>
            </div>
        </div>

        <div class="col-md-12">
            <div id="nav-content">
                <ul class="clearfix">
                    <li class="choice"><a id="last-checked" href="">ĐĂNG NHẬP</a></li>
                    <li><a id="last-checked" href="">THÔNG TIN ĐẶT HÀNG</a></li>
                    <li class="choice1"><a id="checked" href="">HÌNH THỨC THANH TOÁN</a></li>
                    <li><a href="">ĐẶT MUA</a></li>
                    <li><a href="">ĐẶT HÀNG THÀNH CÔNG</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="margin-top-cat">
        <form action="<?php echo FSRoute::_('index.php?module=products&view=pay&task=success'); ?>" name="form_success"
              class="form_success" method="post">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 left-cart-pay">

                    <h3 class='title-cart-right'><?php echo FSText::_("Phương thức thanh toán"); ?></h3>
                    <div class="left-box-list">
                        <div class="list-thanh-toan">
                            <ul>
                                <li class="clearfix">
                                    <input type="radio" name="pay_book" id="cod" value="2" onclick="yesnoCheck()"
                                           checked>
                                    <label for="cod"
                                           class="tien-mat"><?php echo FSText::_("Thanh toán khi nhận hàng"); ?>
                                        <span><?php echo FSText::_("Quý khách sẽ thanh toán bằng tiền mặt hoặc thẻ khi AdcBook giao hàng cho quý khách."); ?></span></label>
                                </li>
                                <li class="clearfix">
                                    <input type="radio" name="pay_book" id="put_bank" value="1" onclick="yesnoCheck()">
                                    <label for="put_bank"
                                           class="chuyen-khoan"><?php echo FSText::_("Thanh toán bằng chuyển khoản qua ngân hàng"); ?>
                                        <span><?php echo FSText::_("Quý khách sẽ thanh toán bằng hình thức chuyển khoản qua tài khoản ngân hàng của AdcBook."); ?></span></label>
                                    <div class="info-banks-send clearfix">
                                        <?php echo $config['banks_send']; ?>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <input type="radio" name="pay_book" id="port_pay" value="3"
                                           onclick="yesnoCheck()">
                                    <label for="port_pay"
                                           class="cong-thanh-toan"><?php echo FSText::_("Thanh toán online qua cổng thanh toán"); ?>
                                        <span><?php echo FSText::_("Quý khách sẽ được chuyển đến “Tên cổng thanh toán” để thanh toán."); ?></span></label>
                                </li>

                                <!--                                <li class="clearfix">-->
                                <!--                                    <input type="radio" name="pay_book" id="port_pay" value="3" onclick="yesnoCheck()">-->
                                <!--                                    <label for="port_pay" class="cong-thanh-toan">-->
                                <?php //echo FSText::_("Thanh toán qua Momo"); ?><!--</label>-->
                                <!--                                </li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="conditional-terms condi-mb">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <p><input checked="checked" type="checkbox" class="success_us" id="success_us"
                                          required/> <label for="success_us">Tôi đồng ý với <a href="#">điều khoản &
                                            điều kiện</a> giao dịch của AdcBook</label></p>
                                <p>(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua)</p>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <input type="submit" onclick="showpre()" value="<?php echo FSText::_("Đặt Mua"); ?>">
                                <input type="hidden" name="module" value="products">
                                <input type="hidden" name="view" value="pay">
                                <input type="hidden" name="task" value="success">
                                <input type="hidden" name='return' value='<?php echo $return; ?>'/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 right-cart">
                    <h3 class='title-cart-right'><?php echo FSText::_("ĐƠN HÀNG CỦA BẠN"); ?>
                        (<?php echo count($list_cart); ?> Sản phẩm)</h3>
                    <div class="list-products-cart">
                        <div class="list-products">
                            <ul>
                                <?php
                                $total_price = 0;
                                foreach ($list_cart as $item) {
                                    if ($item[2]==1){
                                        $price = $data[$item[0]]->price;
                                    }else{
                                        $price = $data[$item[0]]->price_old1;
                                    }

                                    $total_price += $price * $item[1];
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                <a class="clearfix"
                                                   href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?>">
                                                    <img src="<?php echo URL_ROOT . str_replace('original', 'small', $data[$item[0]]->image); ?>">
                                                    <?php echo $data[$item[0]]->name; ?>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <p><?php echo format_money($price); ?></p>
                                                <p>x<?php echo $item[1]; ?></p>
                                                <p><b><?php echo format_money($price * $item[1]); ?></b></p>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="price-total">
                            <ul>
                                <li><?php echo FSText::_("Tổng tiền sản phẩm"); ?><span
                                            class="red-price"><?php echo format_money($total_price); ?></span></li>
                                <input type="hidden" value="<?php echo $total_price; ?>" name="after_discount_member"
                                       id="after_discount_member">
                                <input type="hidden" value="<?php echo $total_price; ?>" name="after_discount"
                                       id="after_discount">
                                <input type="hidden" value="<?php echo $feeghtk; ?>" name="ship"
                                       id="ship">
<!--                                <input type="hidden" value="--><?php //echo $after_discount_member; ?><!--"-->
<!--                                       name="after_discount_member" id="after_discount_member">-->
<!--                                <input type="hidden" value="--><?php //echo $after_discount_member; ?><!--" name="after_discount"-->
<!--                                       id="after_discount">-->
                                <input type="hidden" value="<?php echo $total_price; ?>" name="before_discount"
                                       id="before_discount">
                                <li><?php echo FSText::_("Tổng chi phí vận chuyển"); ?><span
                                            class="blue-price"><?php if ($feeghtk > 0) {
                                            echo format_money($feeghtk);
                                        } else echo '0đ'; ?></span></li>
<!--                                <li> --><?//= FSText::_('Đơn vị vận chuyển') ?><!--<span-->
<!--                                            class="red-price">--><?//= $transport ?><!--</span></li>-->
<!--                                <li> --><?//= FSText::_(' ADCBook hỗ trợ phí vận chuyển') ?><!--<span-->
<!--                                            class="red-price">--><?php //if ($ii == 1) {
//                                            echo $feeghtk;
//                                        } elseif ($ii == 2) {
//                                            echo format_money($config['feeAdc']);
//                                        } else
//                                            echo '0đ'; ?><!--</span></li>-->
                                <?php
                                if ($member->member_level == 1) {
                                    $discount_member = $total_price * 0;
                                } else if ($member->member_level == 2) {
                                    $discount_member = $total_price * 0.05;
                                } else if ($member->member_level == 3) {
                                    $discount_member = $total_price * 0.07;
                                }
                                ?>
                                <!--<li><?php echo FSText::_("Cấp thành viên"); ?><span><?php echo format_money_0($discount_member); ?></span></li>-->
                                <?php
                                if ($member->member_level == 1) {
                                    $after_discount_member = $total_price + $feeghtk;
                                } else if ($member->member_level == 2) {
                                    $after_discount_member = $total_price * 0.95 + $feeghtk;
                                } else if ($member->member_level == 3) {
                                    $after_discount_member = $total_price * 0.93 + $feeghtk;
                                }
                                ?>
                                <li><?php echo FSText::_("Mã giảm giá"); ?><span id="code_dis">0đ</span></li>
                            </ul>
                            <p class="clearfix"><?php echo FSText::_("Số tiền cần phải trả"); ?><span class="fred red-price"
                                                                                                      id="total_money"><?php echo format_money($after_discount_member); ?></span>
                            </p>


                        </div>
                    </div>
                    <div class="left-box-list">
                        <div class="check-show-hide">
                            <!--                            <input type="checkbox" name="show_add_code" id="show_add_code" >-->
                            <label for="show_add_code"><?php echo FSText::_("Mã giảm giá/quà tặng"); ?></label>
                        </div>
                        <div class="code_down_price" id="code_down_price" style="display: block">
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                    <input type="text" name="code_down" id="code_down"/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-center">
                                    <a href="javascript:void(0)" class="add_code_price"
                                       id="add_code_price"><?php echo FSText::_("Đồng ý"); ?></a>
                                    <input type="hidden" name="inputcode" id="inputcode" value="0">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="conditional-terms condi-mb">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <p><label>Khi click vào "đặt mua" tức là bạn đã đồng ý với <a href="#">điều khoản &
                                            điều kiện</a> giao dịch của AdcBook</label></p>
                                <p>(Xin vui lòng kiểm tra lại đơn hàng trước khi Đặt Mua)</p>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <input type="submit" onclick="showpre()" value="<?php echo FSText::_("Đặt Mua"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="conditional-terms od">
                        <div class="order">
                            <input type="submit" value="<?php echo FSText::_("Đặt mua sản phẩm"); ?>">
                            <input type="hidden" name="module" value="products">
                            <input type="hidden" name="view" value="pay">
                            <input type="hidden" name="task" value="order_products">
                            <input type="hidden" name='return' value='<?php echo $return; ?>'/>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>