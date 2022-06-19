<?php
global $config, $tmpl;
//$tmpl->addScript('form');
$tmpl->addScript('faq', 'modules/faq/assets/js');
$tmpl->addStylesheet('faq', 'modules/faq/assets/css');
$title_list = array();
?>

<div class="faq-list">
    <h1 class="title-faq">
        <?php echo FSText::_("Các câu hỏi thường gặp"); ?>
    </h1>
    <div class="list_faq_content clearfix">
    <?php
    $i = 0;
    foreach ($list as $item) {
        $i++; 
        ?>
        <div class="faqSectionFirst">             
            <h2 class=""><span><?php echo $i;?></span> <?php echo $item->question; ?></h2>
            <div class="faqTextFirst">
                <div class="content-faq">
                <?php echo $item->content; ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
