<?php
    global $tmpl;
    $tmpl -> addStylesheet('owl.carousel.min','libraries/OwlCarousel2-2.2.1/assets');
    $tmpl -> addStylesheet('owl.theme.default.min','libraries/OwlCarousel2-2.2.1/assets');
    $tmpl -> addScript('owl.carousel.min','libraries/OwlCarousel2-2.2.1');

    $tmpl -> addStylesheet('responsive_carousel','blocks/partners/assets/css'); 
    $tmpl -> addScript('partners','blocks/partners/assets/js');
?>
<?php if(isset($data) && !empty($data)){?>
  <div id="owl-partners" class="owl-carousel">
    <?php
        $i=0;
        foreach($data as $item){
        $link = $item -> url;
    ?>
        <?php if($item->image){ ?>
        <div class="item">
            <a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>">
                <img alt="<?php echo $item->name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/original/',$item->image);?>" <?php  if($item -> url){?>onclick="window.open('<?php echo $link;?>','_blank')" <?php }?> />
            </a>
        </div>
         <?php }?>
     <?php $i++; } ?>
  </div><!-- END: #owl-demo" -->
 <?php }?>	