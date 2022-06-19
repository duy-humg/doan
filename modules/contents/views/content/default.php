<?php
global $tmpl;
$tmpl->addStylesheet('detail', 'modules/contents/assets/css');
//$tmpl -> addScript('form');
//$tmpl -> addScript('main');
//$tmpl -> addScript('detail','modules/contents/assets/js');
//FSFactory::include_class('fsstring');
//$print = FSInput::get('print',0);
$tmpl->setMeta('og:image', URL_ROOT . $data->image);
?>
<div class="contents_detail row-item">
   <div class="container">
        <h1 class="title-module">
            <?php echo $data->title; ?>
        </h1>

        <summary class="contents-summary hide">
            <?php echo $data->summary; ?>
        </summary><!-- END: .contents-detail-content -->

        <?php if ($data->content) { ?>
            <div class='contents-description row-item'>
                <?php echo html_entity_decode($data->content); ?>
            </div><!-- END: .contents-detail-content -->
        <?php } ?>

        <input type="hidden" value="<?php echo $data->id; ?>" name='contents_id' id='contents_id'/>
   </div>
</div><!-- END: .contents_detail -->
