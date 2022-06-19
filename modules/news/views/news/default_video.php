<?php   
    $tmpl -> addScript('jwplayer','libraries/jquery/jwplayer_6.8');
    $tmpl -> addScript('detail_video','modules/news/assets/js');
?>
<div class="link-item" style="margin-bottom: 20px;">
    <div class="video-item video-item-first">
        <div id="video_detail_area_player"></div>
        <input type="hidden" id='video_detail_link' value="<?php echo $data->video ?>"/>
        <?php if($data -> image!=""){?>
         <input type="hidden" id='img_detail_link' value="<?php echo URL_ROOT.str_replace('/original/','/original/', $data->image) ?>"/>
        <?php }else{?>
         <input type="hidden" id='img_detail_link' value=""/>
        <?php } ?> 
    </div>
</div>
<div class="clear"></div>