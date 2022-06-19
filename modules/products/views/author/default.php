<?php
global $tmpl;
$tmpl->addStylesheet('author', 'modules/products/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
?>	
<aside class="new-contents">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="title-module">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">

                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                    <h1><?php echo $author->name; ?></h1>
                    <?php if ($author->content) { ?>
                        <div class="summary_author">
                            <?php echo $author->content; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>    
        <div class="list-products">
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
                        <?php if (($i%5) == 0) { ?>
                            <!--<div class="clearfix "></div>-->
                        <?php } ?>
                       
                    <?php }
                } ?>
                <div class="clearfix"></div>
            </div>
        
        <?php if ($pagination) echo $pagination->showPagination(3); ?>
    </div>
    </div>
</aside>