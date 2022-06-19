<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("xacminh", "modules/users/assets/css");
$tmpl->addStylesheet("line", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('thietlap', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

$arr_email = explode('@',$email_method);

?>

<div class="dangky dangky2">
    <div class="container">
         
         <div class="form">
              <p class="p-text-xacminh">
                    Thiết lập mật khẩu
                  <a title="Đăng ký" href="<?php echo FSRoute::_('index.php?module=users&view=login') ?>">
                      <img src="<?php echo URL_ROOT.'images/ql.svg' ?>" alt="ql">
                  </a>
                </p>
                
                <form id="thiet_lap" name="thiet_lap" class="form_thietlap" action="" method="post">
                    <p class="p-text-thietlap">
                        Tạo mật khẩu mới cho 
                        <?php if($type_method==1){ ?>
                            <span><?php echo substr($email_method,0,2) ?>*******@<?php echo $arr_email[1] ?></span>
                        <?php }else{ ?>
                            <span>*******<?php echo substr($phone_method,-3,5) ?></span>
                        <?php } ?>
                        
                    </p>
                    <div class="input-box">
                        <input type="password" placeholder="<?php echo FSText::_(" mật khẩu"); ?>"
                               class="dk_password" id="dk_password" name="dk_password" required>
                       
                    </div>
                    <p class="p-text">Ít nhất một ký tự viết thường.</p>
                    <p class="p-text">Ít nhất một ký tự viết hoa.</p>
                    <p class="p-text">8-16 ký tự.</p>
                    <p class="p-text">Chỉ các chữ cái, số và ký tự phổ biến mới có thể được sử dụng.</p>

                    <a class="btn-member btn-login" onclick="validateOtp();" href="javascript:void(0);">
                        <?php echo FSText::_('XÁC NHẬN') ?>
                    </a>
                    <input type="hidden" value="<?php echo $id_method ?>" id="id_method" name="id_method"> 
                    <input type="hidden" value="<?php echo $phone_method ?>" id="phone_method" name="phone_method">
                    <input type="hidden" value="<?php echo $email_method ?>" id="email_method" name="email_method"> 
                    <input type="hidden" value="<?php echo $type_method ?>" id="type_method" name="type_method"> 

                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="formregister">
                    <input type="hidden" name="task" value="pass_thanhcong">

                </form>
         </div>
    </div>
</div>

