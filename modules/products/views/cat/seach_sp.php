<div class="row list_prd">

        <?php
        $i = 1;
        foreach ($list_ as $item) {
            $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id);
            $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
            ?>

            <div class="image-check item_sp <?php if($i<=4){ ?> mg-top <?php } ?>  col-lg-3 col-md-3 col-sm-6 col-xs-6">
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

        <?php $i++; } ?>

</div>