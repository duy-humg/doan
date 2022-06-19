<?php
global $tmpl;

//$tmpl -> addScript('product_images_carousel','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_carousel','modules/products/assets/css');
$i=0;$j=0;
$cols=4;
$array1 = array("0" => $data);
//var_dump($array1);
//var_dump($product_images);
$result = array_merge($array1, $product);
//var_dump($result);
$total =count($result);
if($total){
    ?>

    <div class="slide-image row-item">

        <ul id="imageGallery" >
            <?php if (!$result) {?>
                <li  data-color= "color_rm" data-thumb="<?php echo URL_ROOT.str_replace('/original/', '/small/', $data -> image)?>" data-src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $data -> image)?>">
                    <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/large/', $data -> image)?>" alt="<?php echo @$data->alt ?>" title="<?php echo @$data->title ?>" />
                </li>
            <?php } ?>
            <?php foreach($result as $item){?>
                <?php if($item->image){ ?>
                    <li class="color_hide color_rm  type-<?php echo $item->id;?>" data-color="color_rm  type-<?php echo $item->id;?>" data-thumb="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item -> image)?>" data-src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $item -> image)?>">
                        <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/large/', $item -> image)?>" alt="<?php echo @$item->alt ?>" title="<?php echo @$item->title ?>" />
                    </li>
                <?php } ?>
            <?php }?>
            <?php if(@$data->video){
                $url = $data ->video;
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);

                if (!empty($matches)) {
                    $video_id = $matches[1];
                }

                $thumb_default = 'https://img.youtube.com/vi/'.$video_id.'/1.jpg';
                $view_video = URL_ROOT.'images/video.png';
                $thumb = 'https://img.youtube.com/vi/'.$video_id.'/0.jpg';
                ?>
                <li href="<?php echo $data->video; ?>" data-thumb="<?php echo $thumb_default ?>" class="video-container"  >
                    <img class="img-responsive" src="<?php echo $thumb ?>" alt="video" />
                    <img class="view_video" src="<?php echo $view_video ?>">
                </li>
            <?php } ?>
        </ul>
    </div>
<?php }?>