<a href="javascript:void(0)" id="close-cart">
    <img src="<?php echo URL_ROOT . 'images/close-cart.png'; ?>" alt="close cart"/>
</a>
<div>
    <div class="row dkdn">
        <div class=" col-md-6 col-sm-12">
            <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form_pay"
                  class="login_form_pay" method="post">
                <div class="body-content--1a">
                    <h4>ĐĂNG NHẬP</h4>
                    <div class="main-content--1a clearfix">
                        <div class="clearfix">
                            <label for="dk_email"><?php echo FSText::_("Email"); ?></label>
                            <input type="text" placeholder="<?php echo FSText::_("Nhập email"); ?>"
                                   class="dk_email"
                                   name="dk_email" id="dk_email" data-error="Không đúng định dạng email" required/>
                        </div>
                        <div class="clearfix">
                            <label for="dk_password"><?php echo FSText::_("Mật khẩu"); ?></label>
                            <input type="password" placeholder="<?php echo FSText::_("Mật khẩu từ 6 đến 32 ký tự"); ?>"
                                   class="dk_password"
                                   name="dk_password" id="dk_password" required/>
                        </div>
                        <input type="hidden" name="module" value="users">
                        <input type="hidden" name="view" value="users">
                        <input type="hidden" name="task" value="login_save">
                        <input type="hidden" name='return' value='<?php echo $return; ?>'/>
                        <p style="padding-bottom: 10px; padding-top: 0;" class="forget-password"><a style="color: #006cc6;" href="#"
                                                                          onclick='forget()'><?php echo FSText::_("Quên mật khẩu?"); ?></a>
                        </p>
                        <input style="font-size: 16px;color: #ffffff; background: #f7941e;" class="submit1"
                               type="submit" value="<?php echo FSText::_("ĐĂNG NHẬP"); ?>">
                        <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>
                        <p class="text-center login-using-sosial mg"><a
                                    href="<?php echo FSRoute::_( 'index.php?module=users&view=face&task=face_login&Itemid=10'); ?>"></a><a
                                    href="<?php echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10'); ?>"></a>
                        </p>
                    </div>
                </div>
            </form>

        </div>
        <div class="form-sing-out col-md-6 col-sm-12">
            <form class="form-horizontal" method="post" action="#" name="register_form_user">
                <h3>TẠO TÀI KHOẢN MỚI</h3>
                <div class="form-list_inp">
                    <div class="clearfix">
                        <label for="dk_name"><?php echo FSText::_("Họ và tên"); ?></label>
                        <input type="text" placeholder="<?php echo FSText::_("Vui lòng nhập họ và tên"); ?>"
                               class="dk_name"
                               id="dk_name" name="dk_name" required>
                    </div>
                    <div class="clearfix">
                        <label for="dk_email1"><?php echo FSText::_("Email"); ?></label>
                        <input type="email" placeholder="<?php echo FSText::_("Vui lòng nhập email của bạn"); ?>"
                               class="dk_email" id="dk_email1" name="dk_email1" data-error="Không đúng định dạng email"
                               required>
                    </div>
                    <div class="clearfix">
                        <label for="dk_password1"><?php echo FSText::_("Mật khẩu"); ?></label>
                        <input type="password" placeholder="<?php echo FSText::_("Vui lòng nhập mật khẩu"); ?>"
                               class="dk_password" id="dk_password1" name="dk_password1" required>
                    </div>
                    <div class="clearfix">
                        <label for="re_password"><?php echo FSText::_("Nhập lại mật khẩu"); ?></label>
                        <input type="password" placeholder="<?php echo FSText::_("Vui lòng nhập lại mật khẩu"); ?>"
                               class="re_password" id="re_password" name="re_password" required>
                    </div>
                    <input type="submit" value="Tạo tài khoản" class="submit_dk"/>
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