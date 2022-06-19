<?php
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
?>
<div class="contact_form row-item">
    <form method="post" action="#" name="contact" class="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xs-12">
                <input type="text" maxlength="255"  name="contact_name" placeholder='<?php echo FSText::_("Họ và tên"); ?>' id="contact_name" value="" class="form_control" required/>
            </div>
            <div class="col-md-6 col-xs-12">
                <input type="text" maxlength="255"   name="contact_phone" id="contact_phone" placeholder="<?php echo FSText::_("Số điện thoại"); ?>" value="" class="form_control" required/>
            </div>
            <div class="col-md-6 col-xs-12">
                <input type="email" maxlength="255"  placeholder="<?php echo FSText::_("Email"); ?>" name="contact_email" id="contact_email" value="" class="form_control" required/>
            </div>
<!--            <div class="col-xs-6">-->
<!--                <input type="text" maxlength="255"  placeholder="--><?php //echo FSText::_("Địa chỉ"); ?><!--" name="contact_add" id="contact_add" value="" class="form_control" required/>-->
<!--            </div>-->
            <div class="col-xs-12">
                <textarea rows="6" cols="30" name='message' id='message' placeholder="<?php echo FSText::_("Nội dung"); ?>" required></textarea>
            </div>
            <div class="col-xs-12 send">
<!--                <input class="form-control txtCaptcha fl-left xacminh" placeholder="--><?php //echo FSText::_('Nhập mã bảo mật'); ?><!--" type="text" id="txtCaptcha" value="" name="txtCaptcha" size="5" required />-->
<!--                <a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code-view fl-left">-->
<!--                    <img id="imgCaptcha" class="fl-left" src="--><?php //echo URL_ROOT ?><!--libraries/jquery/ajax_captcha/create_image.php" required />-->
<!--                    <i class="fa fa-sync-alt fl-left"></i>-->
<!--                </a>-->
                <input type="submit" value="<?php echo FSText::_("Gửi liên hệ"); ?>">
            </div>
        </div>
        <input type="hidden" name='return' value='<?php echo $return; ?>' />
        <input type="hidden" name="module" value="contact" />
        <input type="hidden" name="task" value="save" />
        <input type="hidden" name="view" value="contact" />
        <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
    </form>
    <!--	end FORM				-->
    <div class="clear"></div>
</div>