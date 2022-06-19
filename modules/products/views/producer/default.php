<?php
global $tmpl;
$tmpl->addStylesheet('cat', 'modules/products/assets/css');
$Itemid = 7;
FSFactory::include_class('fsstring');
?>	
<aside class="new-contents">
<div class="row">
    <div class="main-column-left col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <div class="frame_head clearfix catmb">
            <h2><span><?php echo FSText::_("Danh mục sản phẩm"); ?></span></h2>
                <?php echo $tmpl->load_direct_blocks("product_menu", array("style" => "default")); ?>		
        </div>
        <div class="panel-info-company filmb">
            <div class="panel-heading-company">
                <h4 class="panel-title">
                    <a class="accordion-toggle" href="javascript:void(0)">
                        <?php echo FSText::_("Nhà cung cấp"); ?>
                    </a>
                </h4>
            </div>
            <div class="panel-collapse-company" style="height: 400px; overflow-y: scroll;">
                <ul class="list-group">
                    <?php foreach($list_producer as $item){ ?>
                    <li class="list-group-item">
                        <a rel="" href="<?php echo FSRoute::_('index.php?module=products&view=producer&code='.$item->alias); ?>" class="list-group-item"><?php echo $item->name; ?> <span></span></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-column-content col-lg-10 col-md-10 col-sm-12 col-xs-12">
        <div class="title-module"><h1><?php echo FSText::_($producer->name); ?></h1><p>Có <span><?php echo $total; ?> </span>sản phẩm</p></div>
        <div class="list-products">
<!--            <div class="tendency_shopping filmb">-->
<!--                <p>--><?php //echo FSText::_("Xu hướng tiêu dùng");?><!--</p>-->
<!--                <ul class="clearfix">-->
<!--                    --><?php //foreach($list_cat as $item){ ?>
<!--                    <li><a href="--><?php //echo FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias ); ?><!--">--><?php //echo $item->name; ?><!--</a></li>-->
<!--                    --><?php //} ?>
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="sort_product filmb">-->
<!--                <p>-->
<!--                    --><?php //echo FSText::_("Sắp xếp theo");?><!--: -->
<!--                    <a>--><?php //echo FSText::_("Mặc định"); ?><!--</a>-->
<!--                    <a>--><?php //echo FSText::_("Xem nhiều nhất"); ?><!--</a>-->
<!--                    <a>--><?php //echo FSText::_("Mua nhiều nhất"); ?><!--</a>-->
<!--                    <a>--><?php //echo FSText::_("Mới nhất"); ?><!--</a>-->
<!--                </p>-->
<!--            </div>-->
            <div class="row">
                <?php if ($total) { ?>
                    <?php
                    $i = 0;
                    foreach ($list as $item) {
                        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
                        $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                        ?>
                        <?php $i++; ?>
                        <div class="image-check col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $item->image); ?>" class="img-responsive">
                                <div class="title-book"><?php echo $item->name; ?></div>
                                <div class="price-book clearfix">
                                    <?php echo format_money($item->price); ?>
                                    <?php if($item->price != $item->price_old){ ?>
                                    <span class="price-regular"><?php echo format_money($item->price_old); ?></span>
                                    <?php } ?>
                                    <?php if($item->discount){ ?>
                                    <span class="sale-tag sale-tag-square"><?php echo $item->discount . ' %'; ?></span>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                        <?php if (($i%4) == 0) { ?>
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