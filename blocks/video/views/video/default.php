<?php 
    global $config,$tmpl;
    $tmpl -> addStylesheet('video','blocks/video/assets/css');
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="block_id_<?php echo $id;?>">
<div class="title-video-block">
    <h2><span><?php echo FSText::_("Video Clip"); ?></span></h2>
</div>
<div class="video-gallery row-item" >    
    <?php
    $i = 0;
    $video_id = $vid;
    $thumb_default = "http://img.youtube.com/vi/$video_id/0.jpg";
    $link_img = $thumb_default;
    ?>
    <a class="col-img col-lage" title="<?php echo $title; ?>" href="<?php echo 'https://www.youtube.com/watch?v=' . $video_id; ?>" target="_blank">
        <img class="img-responsive" src="<?php echo $link_img; ?>" alt="<?php echo $title; ?>" />
        <span></span>
        <h3><?php echo $title; ?></h3>
    </a><!-- END: col-lage -->
</div>      
</div>      
<div class="clearfix"></div>