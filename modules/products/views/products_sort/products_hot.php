<?php
global $tmpl;
$tmpl->addStylesheet('favourite', 'modules/users/assets/css');
//$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$act = FSInput::get('sort');
$fist="";
$prices=FSInput::get('prices');
$origin=FSInput::get('origin');
$object=FSInput::get('object');
$color=FSInput::get('color');
$producer=FSInput::get('producer');
$company=FSInput::get('company');
$sort=FSInput::get('sort');
switch ($sort){
    case 'hits':
        $name_sort = "Xem nhiều nhất";
        break;
        case 'sale_of':
        $name_sort = "Khuyến mãi";
        break;
        case 'buy':
        $name_sort = "Bán chạy";
        break;
        case 'new':
        $name_sort = "Mới nhất";
        break;
        case 'up':
        $name_sort = "Giá từ thấp đến cao";
        break;
        case 'down':
        $name_sort = "Giá từ cao đến thấp";
        break;
        default:
          $name_sort = "Mặc định";
}
$url='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$tmpl-> addTitle($cat->name);
if($prices || $origin || $object || $color ||$producer || $company || strpos($url,'?')){
    $fist="";
} else
    $fist='?';

?>
<input type="hidden" name="quantity" id="quantity" value="1">

<aside class="new-contents">
    <div class="row body1">
        <div class="main-column-left col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <?php include 'menu_user.php'; ?>
        </div>
        <div class="main-column-content col-lg-10 col-md-10 col-sm-12 col-xs-12">
            <div class="title-module"><h1>Sản phẩm yêu thích</h1>
            </div>

            <div class="list-products">
                <div class="filter-items  filmb">
                    <?php
                    if($prices || $origin || $object || $color ||$producer || $company){
                        ?>
                        <h4>Tiêu chí đang chọn:</h4>
                        <?php
                        if($prices){
                            $urlp='http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkp=str_replace('&prices='.$prices,'',$urlp);
                            ?>
                            <p>Giá: <?=$pri->name?><a href="<?=$linkp?>">&#215;</a></p>
                            <?php
                        }
                        if($producer){
                            $urlpr='http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkpr=str_replace('&producer='.$producer,'',$urlpr);
                            ?>
                            <p>Thương hiệu: <?=$pro->name?><a href="<?=$linkpr?>">&#215;</a></p>
                            <?php
                        }

                        if($company){
                            $urlcm='http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkcm=str_replace('&company='.$company,'',$urlcm);
                            ?>
                            <p>Tác giả: <?=$coma->name?><a href="<?=$linkcm?>">&#215;</a></p>
                            <?php
                        }

                        if($object){
                            $urlob='http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkob=str_replace('&object='.$object,'',$urlob);
                            ?>
                            <p>Đối tượng: <?=$obj->name?><a href="<?=$linkob?>">&#215;</a></p>
                            <?php
                        }

                        if($color){
                            $urlco='http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkco=str_replace('&color='.$color,'',$urlco);
                            ?>
                            <p>Màu sắc: <?=$cor->name?><a href="<?=$linkco?>">&#215;</a></p>
                            <?php
                        }

                        if($origin){
                            $urlor='http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $linkor=str_replace('&origin='.$origin,'',$urlor);
                            ?>
                            <p>Xuất xứ: <?=$ori->name?><a href="<?=$linkor?>">&#215;</a></p>
                            <?php
                        }
                        $linkurl=explode('?',$url);
                        ?>
                        <p class="dellall">Xóa tất cả<a href="<?=$linkurl[0]?>">&#215;</a></p>
                    <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <?php if ($total) { ?>
                        <?php
                        $i = 0;
//                        var_dump($list);
                        foreach ($list as $item) {
                            $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                            $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                            ?>
                            <?php $i++; ?>
                            <div class="image-check col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <a href="<?php echo $link; ?>">
                                    <img src="<?php echo URL_ROOT.str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                                    <div class="title-book"><?php echo $item->name; ?></div>
                                    <div class="author"><?php echo getWord(4, $item->author_book); ?></div>
                                    <div class="evaluate">
                                        <img src="blocks/banners/assets/images/sao.png">
                                    </div>
                                    <div class="price-book clearfix">
                                        <?php echo format_money($item->price); ?>
                                        <?php if($item->discount){ ?>
                                            <span class="sale-tag sale-tag-square"><?php echo '- '.$item->discount . ' %'; ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="price-regular">
                                        <?php if( $item->price != $item->price_old){ ?>
                                            <?php echo format_money($item->price_old); ?>
                                        <?php } ?>

                                    </div>
                                </a>
                                <div class="p31 bottom-add-cart">
                                    <a href="#" class="a6" onclick="order(<?php echo $item->id; ?>)">
                                        <p class="buy-now"><?php echo FSText::_("Thêm vào giỏ hàng"); ?></p>
                                    </a>
                                </div>
<!--                                --><?php
//                                if(!$item->quantity){
//                                    ?>
<!--                                    <img class="hh" src="--><?//=URL_ROOT.'images/het.png'?><!--" alt="">-->
<!--                                    --><?php
//                                }
//                                ?>
                            </div>
                            <?php if (($i % 6) == 0) { ?>
                                <div class="clearfix "></div>
                            <?php } ?>

                        <?php }
                    } ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if ($pagination) echo $pagination->showPagination(3); ?>
        </div>
    </div>
</aside>