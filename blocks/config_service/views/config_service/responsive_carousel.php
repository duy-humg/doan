<?php
    global $tmpl;
    $tmpl -> addStylesheet('owl.carousel','libraries/owl.carousel.2.0.0-beta.2.4/assets');
    $tmpl -> addScript('owl.carousel.min','libraries/owl.carousel.2.0.0-beta.2.4');

    $tmpl -> addStylesheet('responsive_carousel','blocks/partners/assets/css'); 
    $tmpl -> addScript('partners','blocks/partners/assets/js');
?>
<?php if(isset($data) && !empty($data)){?>
<div class="info row-item">
    <p class="title"><?php echo FSText::_('Liên kết'); ?></p>
    <p class="in">
        <?php echo FSText::_('Với hơn 50 đối tác lớn trong nước và quốc tế'); ?>
    </p>
</div>
<div id="partners" class="row-item" >
          <div id="owl-partners" class="owl-carousel">
            <?php
                $i=0;
                foreach($data as $item){
                $link = $item -> url;
            ?>
                <div class="item">
                    <a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>">
                        <img alt="<?php echo $item->name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/original/',$item->image);?>" <?php  if($item -> url){?>onclick="window.open('<?php echo $link;?>','_blank')" <?php }?> />
                    </a>
                </div>
             <?php $i++; } ?>
          </div><!-- END: #owl-demo" -->
</div><!-- END: #demo -->
 <?php }?>	