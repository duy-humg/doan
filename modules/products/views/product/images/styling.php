<?php
global $tmpl;

$tmpl->addScript('owl.carousel.min', 'libraries/jquery/owl_carousel/owl-carousel');
$tmpl->addStylesheet('magiczoomplus', 'libraries/jquery/magiczoomplus');
$tmpl->addScript('magiczoomplus', 'libraries/jquery/magiczoomplus');
$tmpl->addStylesheet('owl-theme', 'modules/products/assets/css');
$tmpl->addStylesheet('owl.carousel', 'modules/products/assets/css');
$array1 = array("0" => $data);
$result = array_merge($array1, $product_images);
$total = count($result);
?>
<?php if ($total) { ?>
    <div class="thumb-pro">
        <ul id="thumb-pro">
            <?php foreach ($result as $item) { ?>
                <li class="item">
                    <a href="<?php echo URL_ROOT . str_replace('/original/', '/original/', $item->image); ?>" class="Selector"  rel="zoom-id:Zoomer" rev="<?php echo URL_ROOT . str_replace('/original/', '/large/', $item->image); ?>">
                        <img src="<?php echo URL_ROOT . str_replace('/original/', '/small/', $item->image); ?>" >
                    </a>
                </li> 
            <?php } ?>
        </ul>
    </div>
    <div class="main-img">
        <a id="Zoomer" href="<?php echo URL_ROOT . str_replace('/original/', '/original/', $data->image); ?>" class="MagicZoomPlus" rel="pan-zoom: false; rightClick: true; hint: false;zoom-position: right;show-loading:false;zoom-distance:0;zoom-width:400px; zoom-height:400px;" data-options="rightClick: true">
            <img class="img-responsive" src="<?php echo URL_ROOT . str_replace('/original/', '/large/', $data->image); ?>" >
        </a>
        <!--        <div id="clickndrag" style="text-align: left;">
                    <img border="0" src="<?php echo URL_ROOT . 'images/click-here.png' ?>">
                </div>-->
    </div>

<?php } ?>