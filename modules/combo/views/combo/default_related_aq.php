<?php
    global $tmpl;
    $Itemid = 2;
    $tmpl -> addStylesheet('default','blocks/faq/assets/css');
    $tmpl -> addScript('script','blocks/faq/assets/js');
    $total = count($relate_aq_list);
?>
<?php if($total){ ?>
<div class="block_faq faq-default faq__faq block">
    <h2 class="block_title">
        <a title="Câu hỏi thường gặp">Câu hỏi thường gặp</a>
    </h2>
        <?php $i=0;
            foreach($relate_aq_list as $item){
         ?>
         <div class="item-faq">
            <button class="accordion-faq"><strong><?php echo FSText::_('Hỏi') ?>:</strong> <?php echo $item->title; ?></button>
            <div class="panel-faq">
              <strong class="fl-left"><?php echo FSText::_('Trả lời') ?>: </strong><?php echo $item->content; ?>
            </div>
         </div>   
        <?php $i++; } ?>
</div>
<?php } ?>