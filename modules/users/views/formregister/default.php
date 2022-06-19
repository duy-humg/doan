<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("dangky", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('dangky', 'modules/users/assets/js');
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
                        <h1>ĐĂNG KÝ</h1>
                        <div class="form-list_inp">
                            
                            <div class="clearfix">
             
                                <input type="text" placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                        class="dk_phone" id="dk_phone" name="dk_phone" autocomplete="new-password"
                                        required>
                            </div>

                            <a href="javascript:void(0)" class="submit_dk" id="submit_dk">TIẾP THEO</a>
                            <div class="or">
                                <span></span>
                                <p class="p-or">HOẶC</p>
                                <span></span>
                            </div>
                            <div class="face_gg row">
                                <div class="face col-sm-6 col-xs-6">
                                    <a href="#" class="a-face">
                                        <span>Facebook</span>
                                    </a>
                                </div>
                                <div class="gg col-sm-6 col-xs-6">
                                    <a href="#" class="a-gg">
                                        <span>Google</span>
                                    </a>
                                </div>
                                
                            </div>
                            <p class="p-dk">Bằng việc đăng kí, bạn đã đồng ý với Shopee về <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code=dieu-khoan-amp;-dieu-kien&id=27') ?>" target="_blank">Điều khoản dịch vụ</a> & <a href="#" target="_blank">Chính sách bảo mật</a></p>
                            <p class="p-dn">Bạn đã có tài khoản? <a title="Đăng nhập" href="<?php echo FSRoute::_('index.php?module=users&view=login') ?>">Đăng nhập</a></p>
                            <input type="hidden" name="module" value="users">
                            <input type="hidden" name="view" value="formregister">
                            <input type="hidden" name="task" value="check_xacminh">
                        </div>
                    </form>
                </div>
            </div>
         </div>
    </div>
</div>