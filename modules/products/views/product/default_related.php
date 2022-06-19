<!--	RELATE CONTENT		-->
<?php
$total_content_relate = count($relate_products_list);
//var_dump($total_content_relate);
if ($total_content_relate) {
    ?>
    <div class="list_products">
        <div class="head-block-product clearfix">
            <h3>
                <?php echo FSText::_('Sản phẩm liên quan'); ?>
            </h3>
        </div>
        <div class="box_prd">
            <div class="row list_sp">
                <?php
                for ($i = 0; $i < $total_content_relate; $i++) {
                    $item = $relate_products_list[$i];
                    $link = FSRoute::_('index.php?module=products&view=product&code=' . $item->alias . '&ccode=' . $item->category_alias . '&id=' . $item->id);
                    ?>
                    <div class="item_sp col-md-3 col-sm-6 col-xs-6 <?php if ($s==2){ ?> mg2 <?php } ?> ">
                        <a class="img" href="<?php echo $link ?>">
                            <img src="<?php echo URL_ROOT. str_replace('original', 'tiny', $item->image); ?>" alt="<?php echo $item->name ?>">
                        </a>
                        <a class="name_sp" href="<?php echo $link ?>"><?php echo $item->name ?></a>
                        <div class="money_sp">
                            <p class="text-price" ><?php echo format_money($item->price) ?></p>
                            <?php if($item->price_old){ ?>
                                <p class="text-price-old"><?php echo format_money($item->price_old) ?></p>
                                <p class="giamgia">-<?php echo $item->giamgia ?>%</p>
                            <?php } ?>

                        </div>
                        <a class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('CHỌN MUA') ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<!--	end RELATE CONTENT		-->
