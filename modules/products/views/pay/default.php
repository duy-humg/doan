<?php
global $tmpl, $config;
$tmpl->addStylesheet('pay', 'modules/products/assets/css');
$tmpl->addStylesheet('pay_login', 'modules/products/assets/css');
$tmpl->addScript("pay", "modules/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
//var_dump($_SESSION['cart']);
?>
<!--<div class="menu-list-cart">-->
<!--    <div class="container clearfix">-->
<!--        <div class="background-cart-1 col-lg-4 col-md-4 col-sm-12 col-xs-12"><span class="border-step">1</span>--><?php //echo FSText::_("Thông tin đăng nhập");?><!--</div>-->
<!--        <div class="background-cart-2 col-lg-4 col-md-4 col-sm-12 col-xs-12"><span class="border-step">2</span>--><?php //echo FSText::_("Địa chỉ nhận hàng");?><!--</div>-->
<!--        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><span class="border-step">3</span>--><?php //echo FSText::_("Thanh toán");?><!--</div>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="container">-->
<!--    <div class="margin-top-cat">-->
<!--    <div class="row">-->
<!--        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 left-cart-pay">-->
<!--            <div class="form-login clearfix">-->
<!--                <p class="tip-title">--><?php //echo FSText::_("Vui lòng nhập số điện thoại hoặc Email để tiếp tục thanh toán"); ?><!--</p>-->
<!--                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">-->
<!--<form action="--><?php //echo FSRoute::_("index.php?module=users") ?><!--" name="login_form_pay" class="login_form_pay"-->
<!--      method="post">-->
<!--    <div class="radio-check-member">-->
<!--        <p><input type="radio" class="" id="fall" name="check_acount" value="fall"><label-->
<!--                    for="fall">--><?php //echo FSText::_("Mua hàng nhanh - Không cần tài khoản"); ?><!--</label></p>-->
<!--        <p><input type="radio" class="" id="true" name="check_acount" value="true" checked><label-->
<!--                    for="true">--><?php //echo FSText::_("Mua hàng bằng tài khoản"); ?><!--</label></p>-->
<!--    </div>-->
<!--    <input type="text" placeholder="--><?php //echo FSText::_("Vui lòng nhập Email của bạn"); ?><!--" class="dk_email"-->
<!--           name="dk_email" id="dk_email" data-error="Không đúng định dạng email" required/>-->
<!--    <input type="password" placeholder="--><?php //echo FSText::_("Mật khẩu của bạn"); ?><!--" class="dk_password"-->
<!--           name="dk_password" id="dk_password" required/>-->
<!--    <input type="hidden" name="module" value="users">-->
<!--    <input type="hidden" name="view" value="users">-->
<!--    <input type="hidden" name="task" value="login_save">-->
<!--    <input type="hidden" name='return' value='--><?php //echo $return; ?><!--'/>-->
<!--    <p class="forget-password"><a href="#" onclick='forget()'>--><?php //echo FSText::_("Quên mật khẩu?"); ?><!--</a></p>-->
<!--    <input type="submit" value="--><?php //echo FSText::_("Đăng nhập để mua hàng"); ?><!--">-->
<!--    <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>-->
<!--    <p class="text-center login-using-sosial"><a-->
<!--                href="--><?php //echo URL_ROOT . 'index.php?module=users&view=face&task=face_login_pay&Itemid=10'; ?><!--"></a><a-->
<!--                href="--><?php //echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10'); ?><!--"></a>-->
<!--    </p>-->
<!--    <p class="text-center agant-login">Bạn chưa có tài khoản? <a href="#" style="font-size: 16px; font-weight: bold"-->
<!--                                                                 onclick="registration()">Đăng ký</a></p>-->
<!--</form>-->
<!--                    <form action="--><?php //echo FSRoute::_("index.php?module=products&view=pay_not&task=step_address") ?><!--" name="not_member_form_pay" class="not_member_form_pay"  method="post">-->
<!--                        <input type="text" placeholder="--><?php ////echo FSText::_("Vui lòng nhập Email của bạn"); ?><!--" class="dk_email_not" name="dk_email_not" id="dk_email_not" data-error="Không đúng định dạng email" required />-->
<!--                        <div class="radio-check-member">-->
<!--                            <p><input type="radio" class="" id="is_fall" name="check_member" value="fall" checked><label for="is_fall">--><?php //echo FSText::_("Mua hàng nhanh - Không cần tài khoản"); ?><!--</label></p>-->
<!--                            <p><input type="radio" class="" id="is_true" name="check_member" value="true"><label for="is_true">--><?php //echo FSText::_("Mua hàng bằng tài khoản"); ?><!--</label></p>-->
<!--                        </div>-->
<!--                        <input type="hidden" name="module" value="users">-->
<!--                        <input type="hidden" name="view" value="users">-->
<!--                        <input type="hidden" name="task" value="not_login">-->
<!--                        <input type="hidden" name='return' value='--><?php //echo $return; ?><!--' />-->
<!--                        <p class="forget-password"><a href="#" onclick='forget()'>--><?php //echo FSText::_("Quên mật khẩu?"); ?><!--</a></p>-->
<!--                        <input type="submit" value="--><?php //echo FSText::_("Tiến hành thanh toán"); ?><!--">-->
<!--                        <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>-->
<!--                        <p class="text-center login-using-sosial"><a href="--><?php //echo URL_ROOT.'index.php?module=users&view=face&task=face_login_pay&Itemid=10'; ?><!--"></a><a href="--><?php //echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10&pay=1'); ?><!--"></a></p>-->
<!--                        <p class="text-center agant-login">Bạn chưa có tài khoản? <a href="#" style="font-size: 16px; font-weight: bold" onclick="registration()" >Đăng ký</a></p>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 right-cart">-->
<!--            <h3 class='title-cart-right'>--><?php //echo FSText::_("ĐƠN HÀNG CỦA BẠN"); ?><!--(--><?php //echo count($list_cart); ?><!-- Sản phẩm)</h3>-->
<!--            <div class="list-products-cart">-->
<!--                <div class="list-products">-->
<!--                    <ul>-->
<!--                    --><?php //
//                    $total_price = 0;
//                        foreach($list_cart as $item){
//                            $price = $data[$item[0]]->price;
//
//                            $total_price += $price*$item[1];
//                    ?>
<!--                        <li>-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">-->
<!--                                    <a class="clearfix" href="--><?php //echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?><!--">-->
<!--                                        <img src="--><?php //echo URL_ROOT. str_replace('original', 'small', $data[$item[0]]->image); ?><!--">-->
<!--                                        --><?php //echo $data[$item[0]]->name; ?>
<!--                                    </a>-->
<!--                                </div>-->
<!--                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">-->
<!--                                    <p>--><?php //echo format_money($price); ?><!--</p>-->
<!--                                    <p>x--><?php //echo $item[1]; ?><!--</p>-->
<!--                                    <p><b>--><?php //echo format_money($price*$item[1]); ?><!--</b></p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="price-total">-->
<!--                    <ul>-->
<!--                        <li>--><?php //echo FSText::_("Tổng tiền sản phẩm"); ?><!--<span class="red-price">--><?php //echo format_money($total_price); ?><!--</span></li>-->
<!--                        <li>--><?php //echo FSText::_("Tổng chi phí vận chuyển"); ?><!--<span class="blue-price">Miễn phí</span></li>-->
<!--                        <li>--><?php //echo FSText::_("Cấp thành viên"); ?><!--<span>0đ</span></li>-->
<!--                        <li>--><?php //echo FSText::_("Mã giảm giá"); ?><!--<span>0đ</span></li>-->
<!--                    </ul>-->
<!--                    <p class="clearfix">--><?php //echo FSText::_("Số tiền cần phải trả");?><!--<span class="red-price">--><?php //echo format_money($total_price); ?><!--</span></p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="clearfix"></div>-->
<!--    </div>-->
<!--    </div>-->
<!--</div>-->

<div class="container">
    <section>
        <div class="col-md-12 cart_pc">
            <div class="_progress-bar">
                <span><i class="fa fa-shopping-cart"></i></span>
            </div>
        </div>
        <div class="col-md-12">
            <div id="nav-content">
                <ul class="clearfix">
                    <li class="choice"><a id="checked" href="">ĐĂNG NHẬP</a></li>
                    <li><a href="">THÔNG TIN ĐẶT HÀNG</a></li>
                    <li><a href="">HÌNH THỨC THANH TOÁN</a></li>
                    <li><a href="">ĐẶT MUA</a></li>
                    <li><a href="">ĐẶT HÀNG THÀNH CÔNG</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12">
            <div id="body-content">
                <div class="col-md-8 form_mb">
                    <div class="col-md-6">
                        <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form_pay"
                              class="login_form_pay" method="post">

                            <div class="body-content--1a">
                                <h4>BẠN LÀ THÀNH VIÊN CỦA GENI</h4>
                                <div class="main-content--1a clearfix">
                                    <input type="text" placeholder="<?php echo FSText::_("Vui lòng nhập Email của bạn"); ?>" class="dk_email"
                                           name="dk_email" id="dk_email" data-error="Không đúng định dạng email" required/>
                                    <input type="password" placeholder="<?php echo FSText::_("Mật khẩu của bạn"); ?>" class="dk_password"
                                           name="dk_password" id="dk_password" required/>
                                    <input type="hidden" name="module" value="users">
                                    <input type="hidden" name="view" value="users">
                                    <input type="hidden" name="task" value="login_save">
                                    <input type="hidden" name='return' value='<?php echo $return; ?>'/>
                                    <p style="padding: 0;" class="forget-password"><a style="color: #006cc6;" href="#" onclick='forget()'><?php echo FSText::_("Quên mật khẩu?"); ?></a></p>
                                    <input style="font-size: 16px;color: #ffffff; background: #f7941e;" class="submit1" type="submit" value="<?php echo FSText::_("Đăng nhập để thanh toán"); ?>">
                                    <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>
                                    <p class="text-center login-using-sosial"><a
                                                href="<?php echo URL_ROOT . 'index.php?module=users&view=face&task=face_login_pay&Itemid=10'; ?>"></a><a
                                                href="<?php echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10'); ?>"></a>
                                    </p>
                                    <p class="text-center agant-login">Bạn chưa có tài khoản? <a href="#" style="font-size: 16px;color: #006cc6;"
                                                                                                 onclick="registration()">Đăng ký</a></p>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="body-content--1b clearfix">
                            <div class="_box-text-content--1b">
                                <h4 class="not-member--1">BẠN CHƯA LÀ </h4>
                                <h4 class="not-member--2">THÀNH VIÊN CỦA GENI</h4>
                                <p>Bạn có thể là thành viên của Geni sau.</p>
                                <a href="<?php echo FSRoute::_("index.php?module=products&view=pay_not&task=step_address") ?>">
                                    <button type="button" class="btn btn-default button-purchase--nologin">Thanh toán
                                        không cần đăng nhập
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 right-cart">
                    <h3 class='title-cart-right'><?php echo FSText::_("ĐƠN HÀNG CỦA BẠN"); ?> <span
                                class="soluong"> (<?php echo count($list_cart); ?> sản phẩm)</span></h3>
                    <div class="list-products-cart">
                        <div class="list-products">
                            <ul>
                                <?php
                                $total_price = 0;
                                foreach ($list_cart as $item) {
                                    if ($item[2] == 1) {
                                        $price = $data[$item[0]]->price;
                                    } else {
                                        $price = $data[$item[0]]->price_old1;
                                    }
                                    $total_price += $price * $item[1];
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                <a class="clearfix"
                                                   href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?>">
                                                    <img class="img-responsive" src="<?php echo URL_ROOT . str_replace('original', 'small', $data[$item[0]]->image); ?>">
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
                                <li><?php echo FSText::_("Tổng chi phí vận chuyển"); ?><span
                                            class="blue-price">Liên hệ</span></li>
                                <!--                                    <li>-->
                                <?php //echo FSText::_("Cấp thành viên"); ?><!--<span>0đ</span></li>-->
                                <!--                                    <li>-->
                                <?php //echo FSText::_("Mã giảm giá"); ?><!--<span>0đ</span></li>-->
                            </ul>
                            <p class="clearfix"><?php echo FSText::_("Số tiền cần phải trả"); ?><span
                                        class="fred red-price"><?php echo format_money($total_price); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

