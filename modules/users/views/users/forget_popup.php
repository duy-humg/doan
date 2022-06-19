<?php
global $tmpl;
?> 
<a href="javascript:void(0)" id="close-cart">
    <img src="<?php echo URL_ROOT . 'images/close-cart.png'; ?>" alt="close cart" />
</a>
<div id="login-form" class ="form-sing-in" >
    <form action="" name="forget_form" class="forget_form fff-form fff-form-i forgot-password-form " method="post">
        <h3 class="text-center">Quên mật khẩu</h3>
        <div class="form-list_inp">
            <div class="foget fff-form-group fff-form-small">
                <label class="title_sdt" for="user_phone">Vui lòng nhập email khi đăng ký thành viên.</label>
                <div class="clearfix">
<!--                    <label for="dk_email">--><?php //echo FSText::_("Email"); ?><!--</label>-->
                    <input id="user_mail" class=" txtinput email-field" placeholder="Email" type="email" name="email" required>
                </div>
            </div>
            <div class="fff-form-group fff-form-small">
                <button class="submit_dk" type="submit" name="button">Đồng ý</button>
            </div>
            <input type="hidden" name = "module" value = "users" />
            <input type="hidden" name = "view" value = "users" />
            <input type="hidden" name = "task" value = "forget_save" />
        </div>
    </form> 
</div>    
