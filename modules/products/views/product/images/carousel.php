<?php
global $tmpl, $config;
$tmpl->addStylesheet('slide_mobile', 'modules/products/assets/css');
$array1 = array("0" => $data);
$product_images_new = array_merge($array1, $product_images);
//$product_images_new = $product_images;
//     var_dump($product_images_new);
$total = count($product_images_new);
//    var_dump(URL_ROOT.str_replace('original','small',$data->image));
?>
<?php if ($total) { ?>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <?php if ($total > 1) { ?>
            <ol class="carousel-indicators">
                <?php
                $i = 0;
                foreach ($product_images_new as $item) { ?>
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="<?php if ($i == 0) {
                        echo 'active';
                    } ?>"></li>
                    <?php $i++;
                } ?>
            </ol>
        <?php } ?>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php
            $i = 0;
            foreach ($product_images_new as $item) { ?>
                <div class="item <?php if ($i == 0) {
                    echo 'active';
                } ?>">
                    <img class="img-responsive"
                         src="<?php echo URL_ROOT . str_replace('/original/', '/large/', $item->image) ?>"
                         alt="hình ảnh"/>
                </div>
                <?php $i++;
            } ?>
        </div>
    </div>
<?php } ?>
