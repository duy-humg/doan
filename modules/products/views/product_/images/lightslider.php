<?php
global $tmpl, $config;
$tmpl->addStylesheet('lightgallery.min', 'modules/products/assets/css');
$tmpl->addStylesheet('lightslider', 'modules/products/assets/css');

$tmpl->addScript('lightslider', 'modules/products/assets/js');
$tmpl->addScript('lightgallery-all.min', 'modules/products/assets/js');

$tmpl->addScript('carousel', 'modules/products/assets/js');

$i = 0;
$j = 0;

$array1 = array("0" => $data);
//$product_images_new = array_merge($array1, $product_images);
//$product_images_new = $product_images;
//     var_dump($product_images_new);
//$total = count($product_images_new);
//    var_dump(URL_ROOT.str_replace('original','small',$data->image));
?>

<?php if ($product_images) { ?>

<?php } ?>
