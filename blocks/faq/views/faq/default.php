<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/faq/assets/css');
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
?>
<?php
$site_key    = '6LfckmIUAAAAAI1OFUtaAv6kFfWOBnw25KEsRqKt';
$secret_key  = '6LfckmIUAAAAAAyjnE8E_SNil6Cb6uv_I-scnWN7';
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="block_id_<?php echo $id; ?>">
    <div class="title-form-block">
        <h2><i class="fas fa-share-square"></i><?php echo FSText::_("Gửi câu hỏi của bạn"); ?></h2>
    </div>
    <div class="faq_form" >    
        <?php $link = FSRoute::_('index.php?module=faq&view=faq'); ?>
        <form class="search-form row-item" action="<?php echo $link; ?>" id="mainFormFaq" method="post" name="mainFormFaq">
            <input type="text" name="fullname" placeholder="<?php echo FSText::_("Họ và tên*"); ?>" required>
            <input type="text" name="mobiphone" placeholder="<?php echo FSText::_("Điện thoại*"); ?>" required>
            <input type="text" name="email_faq" placeholder="<?php echo FSText::_("Email*"); ?>" required>
            <input type="text" name="address_faq" placeholder="<?php echo FSText::_("Địa chỉ"); ?>">
            <textarea placeholder="<?php echo FSText::_("Nội dung câu hỏi*"); ?>" name="content_faq" rows="4" required></textarea>	
            <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>" style="width: 100%; margin-bottom: 10px;"></div>
            <input type="submit" value="<?php echo FSText::_("Gửi câu hỏi");?>">
            <input type="reset" value="<?php echo FSText::_("Làm lại");?>">
            <input type='hidden'  name="module" value="faq"/>
            <input type='hidden'  name="view" value="faq"/>
            <input type='hidden'  name="task" value="send_question"/>
            <input type="hidden" name='return' value='<?php echo $return; ?>' />
        </form>
    </div>      
</div>      

<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="clearfix"></div>