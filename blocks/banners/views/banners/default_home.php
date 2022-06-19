<?php global $tmpl;
//var_dump($list);
$tmpl->addStylesheet('banners', 'blocks/banners/assets/css');
?>
<?php $i = 0; ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-left: 0px; margin-bottom: 0;">
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($list as $item) { ?>
            <?php if ($item->type == 1) { ?>
                <?php if ($item->image) { ?>
                    <li data-target="#myCarousel" data-slide-to="<?= $i ?>" class="<?php if($i==0) echo 'active'?>"></li>
                <?php } ?>
            <?php }
            $i++;
        } ?>
    </ol>
    <!-- Wrapper for carousel items -->
    <div class="carousel-inner">
        <?php $j = 0;
        foreach ($list as $item) { ?>
            <?php if ($item->type == 1) { ?>
                <?php if ($item->image) { ?>
                    <div class="item <?php if ($j == 0) echo 'active' ?>">
                        <a class="banners-item " href="<?php echo $item->link; ?>" title='<?php echo $item->name; ?>'
                           id="banner_item_<?php echo $item->id; ?>">
                            <?php
                    if( $item -> height) {
                        ?>
                        <img class="img-responsive"
                             src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>"
                             alt="<?php echo $item->name; ?>" style="height:<?php echo $item -> height.'px';?>" >
                        <?php
                    }else {
                        ?>
                        <img class="img-responsive"
                             src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>"
                             alt="<?php echo $item->name; ?>">
                        <?php
                    }
                        ?>
                        </a>
                    </div>
                <?php } ?>
            <?php }
            $j++;
        } ?>
    </div>
    <!-- Carousel controls -->
</div>