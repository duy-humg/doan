<?php
global $tmpl, $config;
$tmpl->setTitle("Đăng nhập");
$tmpl->addStylesheet("users_login", "modules/users/assets/css");
$tmpl->addScript("form");
$tmpl->addScript("login", "modules/users/assets/js");
$Itemid = FSInput::get('Itemid', 1);
$redirect = FSInput::get('redirect');
$username = FSInput::get('username');
if (!$username) {
    $username = "Username";
}
$password = "Password";
?>
<div class="container_login container-fluid">
    <div class="head_login rows clearfix">
        <div class="head_left col-md-6">
            <div class="logo_ col-md-6">
                <img src="<?php echo URL_ROOT ?>modules/users/assets/images/login_01.png" alt=""/>
            </div>
            <div class="text_lg col-md-6" style="color:#fff !important;">
                <?php echo $config['slogan'] ?>
            </div>
        </div>
        <div class="head_right col-md-6">
            <div class="hotline col-md-6">
                <p class="r_text">Tổng đài hỗ trợ</p>
                <p class="number_hot">1800 8001</p>
            </div>
            <div class="email_ col-md-6">
                <p class="r_text">Email</p>
                <p>manhlinh@finalstyle.com</p>
            </div>
        </div>
    </div>
    <div class="login_contai rows clearfix">
        <div class="l-left col-md-6">
            <!--<img src="<?php echo URL_ROOT . 'modules/users/assets/images/bg-login_05.jpg' ?>"/>-->
        </div>
        <div class="l-form col-md-6">
            <div id="login-form" class ="login-form" >
                <form  name="login_form" id="frm_forget_pass" class="login_form fff-form"  action="<?php echo FSRoute::_('index.php?module=users&view=users&task=forget_save'); ?>" method="post">
                    <p class="col-title_username">Tên đăng nhập hoặc Email</p>
                    <input id="username" class="form-control input_login" type="text" size="30" name="username"  placeholder="Username...." />
                    </br>
                    <a class="link_login" style="width: 140px;margin: 0 auto;margin-top: 10px;background: #cc0000;color: #fff;display: block;padding: 5px;text-align: center;" onclick="validateForgot();" href="javascript:void(0);" title="Lấy lại mật khẩu">Lấy lại mật khẩu</a>
                    <p class="copy_right">© 2017. Copyright by ManhLinh</p>
                                                  <input type="hidden" name="module" value="users"/>
                                <input type="hidden" name="task" value="forget_save"/>
                                <input type="hidden" name="view" value="users"/>
                                <input type="hidden" name="redirect" value="<?php echo FSInput::get('redirect', URL_ROOT); ?>" />
                    <?php
                    if ($redirect)
                        echo "<input type='hidden' name = 'redirect' value = '$redirect' />";
                    ?>
                </form>              
            </div><!--  END: #login-form -->    

        </div>
    </div>
</div>




