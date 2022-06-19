<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("email", "modules/users/assets/css");
$tmpl->addStylesheet("email_2", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('users', 'modules/users/assets/js');
$tmpl->addScript('check_email', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

//var_dump($_SESSION);
?>
<div class="container">
    <div class="users row">
        <!--        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 visible1 leftmb">-->
        <!--            --><?php //include 'menu_user.php'; ?>
        <!--        </div>-->
        <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php include 'menu_user.php'; ?>
        </div>
        <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="cat_title clearfix mt10">
                <div class="inner">
                    <h1><?php echo FSText::_("Đổi hộp thư"); ?></h1>
                    <p class="p-inner">Vui lòng nhập địa chỉ email mới. Thư xác nhận sẽ được gửi đến hộp thư của bạn</p>
                </div>

            </div>
            <div class="arrow-right">
                <form id="form-user-edit" class="form_email"
                      action="<?php echo FSRoute::_("index.php?module=users&view=users&task=edit_save"); ?>"
                      method="post" name="form-user-edit" enctype="multipart/form-data">
                    <div class="form-pass">
                        <p><?php echo FSText::_("Địa Chỉ Hộp Thư Mới"); ?></p>
                        <input type="text" id="email" name="email" value="" required>
                    </div>
                    <div class="bot-but">
                        <input class="button-submit-edit button_email button" name="submit" type="submit"
                               value="<?php echo FSText::_("xác nhận"); ?>"/>
                        <a class="a-ql" href="<?php echo FSRoute::_("index.php?module=users") ?>"><?php echo FSText::_("Trở lại"); ?></a>
                        <input type="hidden" name="module" value="users">
                        <input type="hidden" name="view" value="users">
                        <input type="hidden" name="task" value="edit_email">
                        <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>