<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("user", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('register', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);
$redirect = FSInput::get('redirect');
//var_dump($redirect);
//var_dump($_SESSION);die;
?>
<div class="container">
    <div class="row dkdn">
        <div class=" col-md-6 col-sm-12 form_login">
            <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form_pay"
                  class="login_form_pay" method="post" autocomplete="off">
                <div class="body-content--1a">
                    <h4>ĐĂNG NHẬP</h4>
                    <div class="main-content--1a clearfix">
                        <div class="clearfix">
<!--                            <label for="dk_phone">--><?php //echo FSText::_("Phone"); ?><!--</label>-->
                            <input type="text" placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                   class="dn_phone"
                                   name="dn_phone" id="dn_phone" data-error="số điện thoại không đúng" required/>
                        </div>
                        <div class="clearfix">
<!--                            <label for="dk_password">--><?php //echo FSText::_("Mật khẩu"); ?><!--</label>-->
                            <input type="password" placeholder="<?php echo FSText::_("Mật khẩu"); ?>"
                                   class="dn_password"
                                   name="dn_password" id="dn_password" required/>
                        </div>
                        <input type="hidden" name="module" value="users">
                        <input type="hidden" name="view" value="users">
                        <input type="hidden" name="task" value="login_save">
<!--                        <input type="hidden" name='return' value='--><?php //echo $return; ?><!--'/>-->
                        <?php if($redirect)
                            echo "<input type='hidden' name = 'redirect' value = '$redirect' />";
                        ?>
                        <input style="font-size: 15px;color: #fff; background: #1caf4d; font-weight: bold;" class="submit1"
                               type="submit" value="<?php echo FSText::_("ĐĂNG NHẬP"); ?>">
                        <p style="padding-bottom: 10px; padding-top: 15px;" class="forget-password"><a style="color: #006cc6;" href="#"
                                                                          onclick='forget()'><?php echo FSText::_("Quên mật khẩu?"); ?></a>
                        </p>
<!--                        <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>-->
                        <p class="text-center login-using-sosial">
                            <a href="<?php echo FSRoute::_( 'index.php?module=users&view=face&task=face_login&Itemid=10'); ?>">
                                <img src="<?php echo URL_ROOT ?>templates/default/images/dn_fb.png" alt="facebook" class="img-responsive">
                            </a>
                            <a href="<?php echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10'); ?>">
                                <img src="<?php echo URL_ROOT ?>templates/default/images/dn_gg.png" alt="google" class="img-responsive">
                            </a>
                        </p>
                    </div>
                </div>
            </form>

        </div>
        <div class="form-sing-out col-md-6 col-sm-12">
            <form class="form-horizontal" method="post" action="#" name="register_form_user" id="register_form_user"  autocomplete="off">
                <h3>ĐĂNG KÝ TÀI KHOẢN</h3>
                <div class="form-list_inp">
                    <div class="clearfix">
<!--                        <label for="dk_name">--><?php //echo FSText::_("Họ và tên"); ?><!--</label>-->
                        <input type="text" placeholder="<?php echo FSText::_("họ và tên"); ?>"
                               class="dk_name"
                               id="dk_name" name="dk_name" required>
                    </div>
                    <div class="clearfix">
<!--                        <label for="dk_phone">--><?php //echo FSText::_("Email"); ?><!--</label>-->
                        <input type="text" placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                               class="dk_phone" id="dk_phone" name="dk_phone" autocomplete="new-password"
                               required>
                    </div>
                    <div class="clearfix">
                        <!--                        <label for="dk_phone">--><?php //echo FSText::_("Email"); ?><!--</label>-->
                        <input type="email" placeholder="<?php echo FSText::_("Email"); ?>"
                               class="dk_mail" id="dk_mail" name="dk_mail" autocomplete="new-password"
                               required>
                    </div>
                    <div class="clearfix">
<!--                        <label for="dk_password1">--><?php //echo FSText::_("Mật khẩu"); ?><!--</label>-->
                        <input type="password" placeholder="<?php echo FSText::_(" mật khẩu"); ?>"
                               class="dk_password" id="dk_password" name="dk_password" autocomplete="new-password" required>
                    </div>
                    <div class="clearfix">
<!--                        <label for="re_password">--><?php //echo FSText::_("Nhập lại mật khẩu"); ?><!--</label>-->
                        <input type="password" placeholder="<?php echo FSText::_("nhập lại mật khẩu"); ?>"
                               class="re_password" id="re_password" name="re_password" required>
                    </div>
                    <div class="mbm dieu_khoan">
                        <div class="rules">
                            <input type="checkbox" id="agree" value="" checked="checked" required>
                            <label for="agree">
                                <span><?php echo FSText::_("Tôi đã đọc và đồng ý với các") ?> <a
                                            href="<?php echo $config['dieu_khoan_sd'] ?>" target="_blank"><?php echo FSText::_("Điều khoản") ?></a> </span></label>
                        </div>
                        <div class="rules security">
                            <input type="checkbox" id="security" value="" checked="checked" required>
                            <label for="security">
                                <span><?php echo FSText::_("Tôi đã đọc và đồng ý với") ?> <a
                                            href="<?php echo $config['csbv'] ?>" target="_blank"><?php echo FSText::_("Chính sách bảo vệ thông tin cá nhân") ?></a> </span></label>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="submit_dk" id="submit_dk">ĐĂNG KÝ NGAY</a>

<!--                    <input type="submit" value="ĐĂNG KÝ NGAY" class="submit_dk"/>-->
                    <!--                    <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>-->
                    <!--                    <p class="text-center login-using-sosial"><a-->
                    <!--                                href="-->
                    <?php //echo FSRoute::_('index.php?module=users&view=face&task=face_login&Itemid=10'); ?><!--"></a><a-->
                    <!--                                href="-->
                    <?php //echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10'); ?><!--"></a>-->
                    <!--                    </p>-->
                    <!--                    <p class="text-center agant-login">Bạn đã có tài khoản? <a href="#" onclick='login()'>Đăng nhập</a>-->
                    <!--                        tại-->
                    <!--                        đây</p>-->
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="users">
                    <input type="hidden" name="task" value="register_save">
                </div>
            </form>
        </div>
    </div>
</div>