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

    <div class="row dkdn " style="margin-top: 10px;margin-bottom: 10px">
        <div class=" col-md-12 col-sm-12 form_login">
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
<!--                        <p class="text-center login-using-sosial">-->
<!--                            <a href="--><?php //echo FSRoute::_( 'index.php?module=users&view=face&task=face_login&Itemid=10'); ?><!--">-->
<!--                                <img src="--><?php //echo URL_ROOT ?><!--templates/default/images/dn_fb.png" alt="facebook" class="img-responsive">-->
<!--                            </a>-->
<!--                            <a href="--><?php //echo FSRoute::_('index.php?module=users&view=google&task=google_login&Itemid=10'); ?><!--">-->
<!--                                <img src="--><?php //echo URL_ROOT ?><!--templates/default/images/dn_gg.png" alt="google" class="img-responsive">-->
<!--                            </a>-->
<!--                        </p>-->
                    </div>
                </div>
            </form>
        </div>
    </div>
