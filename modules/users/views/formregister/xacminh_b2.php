<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("xacminh", "modules/users/assets/css");
$tmpl->addStylesheet("line", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('thietlap', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);
$get_phone = FSInput::get('id');


?>

<div class="dangky">
    <div class="container">
         <div class="buoc_dk">
            <div class="b1 b_dk active">
                <p class="p-b ">1</p>
                <P class="p-text">
                    Xác minh số điện thoại
                </P>
            </div>
            <div class="line line_active">
                <i class="fa fa-chevron-right"></i>
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="b2 b_dk active">
                <p class="p-b">2</p>
                <h1 class="p-text">
                    Tạo mật khẩu
                </h1>
            </div>
            <div class="line">
                <i class="fa fa-chevron-right"></i>
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="b3 b_dk">
                <p class="p-b">3</p>
                <p class="p-text">
                    Hoàn thành
                </p>
            </div>
         </div>
         <div class="form">
              <p class="p-text-xacminh">
                    Thiết lập mật khẩu
                  <a title="Đăng ký" href="<?php echo FSRoute::_('index.php?module=users&view=formregister') ?>">
                      <img src="<?php echo URL_ROOT.'images/ql.svg' ?>" alt="ql">
                  </a>
                </p>
                
                <form id="thiet_lap" name="thiet_lap" class="form_thietlap" action="" method="post">
                    <p class="p-text-thietlap">Bước cuối! Thiết lập mật khẩu để hoàn tất việc đăng ký.</p>
                    <div class="input-box">
                        <input type="password" placeholder="<?php echo FSText::_(" mật khẩu"); ?>"
                               class="dk_password" id="dk_password" name="dk_password" autocomplete="new-password" required>
                       
                    </div>
                    <p class="p-text">Ít nhất một ký tự viết thường.</p>
                    <p class="p-text">Ít nhất một ký tự viết hoa.</p>
                    <p class="p-text">8-16 ký tự.</p>
                    <p class="p-text">Chỉ các chữ cái, số và ký tự phổ biến mới có thể được sử dụng.</p>

                    <a class="btn-member btn-login" onclick="validateOtp();" href="javascript:void(0);">
                        <?php echo FSText::_('XÁC NHẬN') ?>
                    </a>
                    <input type="hidden" value="<?php echo $get_phone  ?>" name="phone_dk">
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="formregister">
                    <input type="hidden" name="task" value="check_xacminhb3">

                </form>
         </div>
    </div>
</div>

