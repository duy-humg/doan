<a href="javascript:void(0)" id="close-cart">
    <img src="<?php echo URL_ROOT . 'images/close-cart.png'; ?>" alt="close cart" />
</a>
<div class="form-sing-in">
    <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form" class="login_form fff-form"  method="post">
        <h3 class="text-center">Đăng nhập tài khoản</h3>
        <div class="form-list_inp">
            <div class="clearfix">
            <label for="dk_email"><?php echo FSText::_("Địa chỉ Email");?></label>
            <input type="email" placeholder="<?php echo FSText::_("Vui lòng nhập Email của bạn");?>" class="dk_email" name="dk_email" id="dk_email" data-error="Không đúng định dạng email" required>
            </div>
            <div class="clearfix">
            <label for="dk_email"><?php echo FSText::_("Mật khẩu");?></label><span class="mrrgin-chose"><a href="#" onclick='forget()'><?php echo FSText::_("Quên mật khẩu?");?></a></span>
            <input type="password" placeholder="<?php echo FSText::_("Vui lòng nhập Mật khẩu");?>" class="dk_password" name="dk_password" id="dk_password" required>
            </div>
            <input type="submit" value="Đăng nhập ngay" class="submit_dk"/>
            <p class="login-order text-center"><span>Hoặc đăng nhập bằng</span></p>
            <p class="text-center login-using-sosial"><a href="<?php echo URL_ROOT.'index.php?module=users&view=face&task=face_login&Itemid=10';?>"></a><a href="<?php echo URL_ROOT.'index.php?module=users&view=google&task=google_login&Itemid=10';?>"></a></p>
            <p class="text-center agant-login">Bạn chưa có tài khoản? <a href="#" onclick='registration()'>Đăng ký</a></p>
            <input type="hidden" name="module" value="users">
            <input type="hidden" name="view" value="users">
            <input type="hidden" name="task" value="login_save">
        </div>
    </form>
</div>