<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("dangky", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('register', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);
$redirect = FSInput::get('redirect');
//var_dump($redirect);
//var_dump($_SESSION);die;
?>
<div class="dangky">
    <div class="container">
         <div class="row">
            <div class="left_dangky col-md-6 col-sm-6 col-xs-6">
                <div class="logo_text">
                    <img src="<?php echo URL_ROOT.'images/logo_user.svg' ?>" alt="logo_user">
                    <p class="p-text">CÔNG TY CỔ PHẦN PHÁT TRIỂN NGÀNH DA GIÀY VIỆT NAM</p>
                </div>
            </div>
            <div class="right_dangky col-md-6 col-sm-6 col-xs-6">
                <div class="form_dk">
                    <form class="form-horizontal" method="post" action="#" name="register_form_user" id="register_form_user"  autocomplete="off">
                        <h1>ĐĂNG NHẬP</h1>
                        <div class="form-list_inp">
                            
                            <div class="clearfix">
             
                                <input type="text" placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                        class="dn_phone" id="dn_phone" name="dn_phone" autocomplete="new-password"
                                        required>
                            </div>
                            <div class="clearfix">
                         
                                <input type="password" placeholder="<?php echo FSText::_("Mật khẩu"); ?>"
                                        class="dn_password"
                                        name="dn_password" id="dn_password" required/>
                            </div>

                            <input  class="submit1"
                               type="submit" value="<?php echo FSText::_("ĐĂNG NHẬP"); ?>">
                            <a class="a-quen" href="<?php echo FSRoute::_('index.php?module=users&view=formregister&task=pass_reset') ?>"> Quên mật khẩu?</a>
                            <div class="or">
                                <span></span>
                                <p class="p-or">HOẶC</p>
                                <span></span>
                            </div>
                            <div class="face_gg row">
                                <div class="face col-sm-6 col-xs-6">
                                    <a href="<?php echo FSRoute::_('index.php?module=users&view=face&task=face_login') ?>" class="a-face">
                                        <span>Facebook</span>
                                    </a>
                                </div>
                                <div class="gg col-sm-6 col-xs-6">
                                    <a href="<?php echo FSRoute::_('index.php?module=users&view=google&raw=1&task=google_login') ?>" class="a-gg">
                                        <span>Google</span>
                                    </a>
                                </div>
                                
                            </div>
                            <p class="p-dk">Bằng việc đăng kí, bạn đã đồng ý với Shopee về <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code=dieu-khoan-amp;-dieu-kien&id=27') ?>" target="_blank">Điều khoản dịch vụ</a> & <a href="#" target="_blank">Chính sách bảo mật</a></p>
                            <p class="p-dn">Bạn mới đến Vinashoe? <a href="<?php echo FSRoute::_('index.php?module=users&view=formregister') ?>">Đăng ký</a></p>
                            <input type="hidden" name="module" value="users">
                            <input type="hidden" name="view" value="users">
                            <input type="hidden" name="task" value="login_save">
                        </div>
                    </form>
                </div>
            </div>
         </div>
    </div>
</div>