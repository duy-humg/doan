<?php
    global $tmpl; 
    $tmpl -> addStylesheet('partners','blocks/partners/assets/css');
    $tmpl -> addScript('jquery.grid-a-licious.min','libraries/jquery/Grid-A-Licious-master');
    $tmpl -> addScript('default','blocks/partners/assets/js');
?>
<?php if(count($array_cats)){ ?>	
<div class="block-partners row-item <?php echo $pos; ?>">
    <div class="container">
    <?php foreach($array_cats as $item){ ?>
            <h2 class="name"><a><?php echo $item->name ?></a></h2>
            <div class="row-item item-partners row">
            <?php foreach($array_partners[$item->id] as $value){  ?>
                <div class="item">
                    <h3 class="item-infomation">
                        <a href="<?php echo $value->url ?>" title="<?php echo $value->name ?>" ><?php echo $value->name ?></a>
                    </h3>
                </div>
            <?php } ?>
            </div>
    <?php } ?>
    </div>          
</div><!-- END: block-partners -->
<?php } ?>	
