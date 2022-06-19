<?php
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("changepass", "modules/users/assets/css");
$tmpl->addScript('form1');
$tmpl->addScript('users_changepass', 'modules/users/assets/js');
?>
<div class="container">
    <div class="users row">

        <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php include 'menu_user.php'; ?>
        </div>
        <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="body_add">
                <div class="cat_title clearfix mt10">
                    <div class="inner">
                        <span><?php echo FSText::_("Đổi mật khẩu"); ?></span>

                    </div>
                </div>
                <div class="arrow-right">
                    <form action="<?php echo FSRoute::_("index.php?module=users&task=edit_save_changepass"); ?>" onsubmit="javascript:return checkFormsubmit();" name="frm_repassword_gh" method="post" id="frm_repassword_gh"  class="form-horizontal">
                        <div class="form-group">
                            <label for="text_pass_old" class="control-label col-xs-4">Mật khẩu cũ </label>
                            <div class="col-xs-4">
                                <input class="form-control infor_input" type="password" name="text_pass_old" id="text_pass_old" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="text_pass_new" class="control-label col-xs-4">Nhập mật khẩu mới </label>
                            <div class="col-xs-4">
                                <input class="form-control infor_input" type="password" name="text_pass_new" id="text_pass_new"  value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="text_re_pass_new" class="control-label col-xs-4">Xác nhận mật khẩu mới </label>
                            <div class="col-xs-4">
                                <input class="form-control infor_input" type="password" name="text_re_pass_new" id="text_re_pass_new" value="" />
                                <span class="valid_" style="color:#ff0000;display:block;padding-top: 10px;" id="valid_pass"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text_pass_new" class="control-label col-xs-4"></label>
                            <div class="col-xs-4">
                                <input type="submit" value="<?php echo FSText::_("Xác nhận"); ?>" name="submitbt" id="submitbt"  class='button-submit-edits'/>
                                <input type="hidden" name = "module" value = "users" />
                                <input type="hidden" name = "task" value = "edit_save_changepass" />
                                <input type="hidden" name = "Itemid" value = "<?php echo FSInput::get('Itemid'); ?>" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


