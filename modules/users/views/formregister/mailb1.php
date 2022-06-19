<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("method", "modules/users/assets/css");
$tmpl->addScript('form');
// $tmpl->addScript('thanhcong', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

$arr_email = explode('@',$email_method);

?>
<div class="dangky">
    <div class="container">
         
         <div class="form">
              <p class="p-text-xacminh p-text-xacminh_form1">
                    Đặt lại mật khẩu!
                    <a title="Đăng nhập" href="<?php echo FSRoute::_('index.php?module=users&view=login') ?>">
                      <img src="<?php echo URL_ROOT.'images/ql.svg' ?>" alt="ql">
                  </a>
                </p>
                
                <form id="datlai_2" name="datlai_2" class="form_datlai form_datlai_2" action="" method="post">
                    <img src="<?php echo URL_ROOT.'images/email.svg' ?>" alt="Email">
                    <p class="p_email">
                        Mã xác minh đã được gửi đến địa chỉ email
                        <span class="span_email"><?php echo substr($email_method,0,2) ?>*******@<?php echo $arr_email[1] ?></span>
                        <span class="span_vl">Vui lòng xác minh.</span>
                    </p>
                    
                    <input  class="submit1"
                               type="submit" value="<?php echo FSText::_("OK"); ?>">

                    <input type="hidden" value="<?php echo $id_method ?>" id="id_method" name="id_method"> 
                    <input type="hidden" value="<?php echo $phone_method ?>" id="phone_method" name="phone_method">
                    <input type="hidden" value="<?php echo $email_method ?>" id="email_method" name="email_method"> 
                    <input type="hidden" value="<?php echo $type_method ?>" id="type_method" name="type_method"> 

                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="formregister">
                    <input type="hidden" name="task" value="xacminh_email">
                </form>
         </div>
    </div>
</div>

