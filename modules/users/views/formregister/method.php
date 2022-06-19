<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("method", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('method', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

$email = $data->email;
$arr_email = explode('@',$email);

// var_dump($data->telephone);
// var_dump($arr_email);
// var_dump(substr($email,0,2));
?>
<div class="dangky">
    <div class="container">
         
         <div class="form">
              <p class="p-text-xacminh">
                    Đặt lại mật khẩu!
                    <a title="Đăng nhập" href="<?php echo FSRoute::_('index.php?module=users&view=login') ?>">
                      <img src="<?php echo URL_ROOT.'images/ql.svg' ?>" alt="ql">
                  </a>
                </p>
                <div class="bao_content">
                    <p class="p-text-pass">Vui lòng chọn phương thức bạn muốn đặt lại mật khẩu:</p>
                    <?php if($data->email){ ?>
                        <a class="a-email" href="javascript:void(0)">
                            <span>
                                Email(<?php echo substr($email,0,2) ?>*******@<?php echo $arr_email[1] ?>)
                            </span>
                        </a>
                    <?php } ?>
                    
                    <a class="a-phone" href="javascript:void(0)">
                        <span>
                            Số điện thoại(*******<?php echo substr($data->telephone,-3,5) ?>)
                        </span>
                    </a>
                </div>

                <form id="method_form" name="method_form" class="form_datlai" action="" method="post">
    
                    <input type="hidden" value="" id="type_method" name="type_method"> 
                    
                    <input type="hidden" value="<?php echo $data->id ?>" id="id_method" name="id_method"> 
                    <input type="hidden" value="<?php echo $data->telephone ?>" id="phone_method" name="phone_method">
                    <?php if($data->email){ ?>
                        <input type="hidden" value="<?php echo $data->email ?>" id="email_method" name="email_method"> 
                    <?php } ?> 
                    

                    <input type="hidden" value="<?php echo $get_phone  ?>" name="phone_dk">
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="formregister">
                    <input type="hidden" name="task" value="method_smt">
                </form>
                
               
         </div>
    </div>
</div>

