<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("method", "modules/users/assets/css");
$tmpl->addScript('form');
// $tmpl->addScript('thanhcong', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);



?>
<div class="dangky">
    <div class="container">
         
         <div class="form form_1">
              <p class="p-text-xacminh p-text-xacminh_form1">
                    Đặt lại mật khẩu!
                    <a title="Đăng nhập" href="<?php echo FSRoute::_('index.php?module=users&view=login') ?>">
                      <img src="<?php echo URL_ROOT.'images/ql.svg' ?>" alt="ql">
                  </a>
                </p>
                <form id="datlai" name="datlai" class="form_datlai" action="" method="post">
    
                    <div class="input-box">
                        <input type="text" placeholder="<?php echo FSText::_("Email / Số điện thoại"); ?>"
                               class="giatri" id="giatri" name="giatri" required>
                    </div>
                    
                    <input  class="submit1"
                               type="submit" value="<?php echo FSText::_("ĐĂNG NHẬP"); ?>">
                    <input type="hidden" value="<?php echo $get_phone  ?>" name="phone_dk">
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="formregister">
                    <input type="hidden" name="task" value="method">
                </form>
         </div>
    </div>
</div>

