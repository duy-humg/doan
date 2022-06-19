<?php
    global $config,$tmpl; 
//    $tmpl -> addScript('form');
//    $tmpl -> addScript('contact','modules/contact/assets/js');
    $tmpl->addStylesheet('contact','modules/contact/assets/css'); 

//    $Itemid = FSInput::get('Itemid',0);
//    $contact_email = FSInput::get('contact_email');
//    $contact_name = FSInput::get('contact_name');
//    $contact_address = FSInput::get('contact_address');
//    $contact_group = FSInput::get('contact_group');
//    $contact_title = FSInput::get('contact_title');
//    $contact_parts = FSInput::get('contact_parts');
//    $message = htmlspecialchars_decode(FSInput::get('message'));

?>
<div class="contact-main row-item">
    <h1 class="title-module">
        <?php echo FSText::_("Liên hệ"); ?>
    </h1><!-- END: .name-contact -->    
    <div class="wapper-content-page clearfix">
        <div class="infor_contact1"><?php echo html_entity_decode($config['info_contact']); ?></div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 from">
<!--            <div>-->
<!--                --><?php //echo $config['info_contact'] ?>
<!--            </div>-->
            <?php include 'default_from.php'; ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php echo $config['map_contact']; ?>
        </div>

    </div><!-- END: .wapper-content-page -->
</div><!-- END: .contact -->
