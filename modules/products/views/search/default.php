<?php
global $tmpl;
$tmpl->addStylesheet('search', 'modules/products/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$keyword = FSInput::get('keyword');
?>
<input type="hidden" name="quantity" id="quantity" value="1">

<aside class="new-contents">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="title-module">
                    <h1><?php echo FSText::_("Từ khóa tìm kiếm"); ?>:<span> <?php echo $keyword; ?></span></h1>
                </div>
                <div class="list-products">
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
                                    <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $item->image); ?>"
                                         onerror="this.src='/images/not_picture.png'" class="img-responsive">
                                    <div class="title-book"><?php echo $item->name; ?></div>
                                    <div class="price-book clearfix">
                                        <?php echo format_money($item->price); ?>
                                        <?php if ($item->unit && $item->price != 0 ){?>
                                            <span>/cái</span>
                                        <?php } ?>
                                    </div>
                                </a>
                            </div>
                            <?php if (($i % 6) == 0) { ?>
                                <div class="clearfix "></div>
                            <?php } ?>

                        <?php }
                    } ?>
                    <div class="clearfix"></div>
                </div>

                <?php if ($pagination) echo $pagination->showPagination(1); ?>
            </div>
        </div>
    </div>
</aside>