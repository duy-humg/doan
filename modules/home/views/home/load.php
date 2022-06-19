<?php if($list_){ ?>
    <?php $s=1; foreach ($list_ as $item_sp){
        $class3 = '';
        if($s%3==0){
            $class3 .= 'mg3';
        }
        $class4 = '';
        if($s%4==0){
            $class4 .= 'mg4';
        }
        $class5 = '';
        if($s%5==0){
            $class5 .= 'mg5';
        }
        $class6 = '';
        if($s%6==0){
            $class6 .= 'mg6';
        }
        $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $item_sp->category_alias . '&code=' . $item_sp->alias . '&id=' . $item_sp->id);
        ?>
        <div class="image-check col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <a href="<?php echo $link; ?>">
                <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $item_sp->image); ?>" class="img-responsive">
                <p class="name_sp" href="<?php echo $link ?>"><?php echo $item_sp->name ?></p>
                <div class="money_sp-more">
                    <div class="money_sp">

                        <?php if($item_sp->price_old){ ?>
                            <p class="text-price-old"><?php echo format_money($item_sp->price_old) ?></p>
                        <?php } ?>
                        <p class="text-price" ><?php echo format_money($item_sp->price) ?></p>
                    </div>
                    <div class="more">
                        <p class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('Xem shop') ?></p>
                        <p><?php echo FSText::_('Đã bán') ?> <?php echo $item_sp->daban ?>k</p>
                    </div>
                </div>
                <?php if($item_sp->price_old){ ?>
                    <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                    <p class="text-giam-gia">- <?php echo $item_sp->giamgia ?>%</p>
                <?php } ?>
            </a>
            <a class="bg" href="<?php echo $link; ?>">
                <span>MUA NGAY</span>
            </a>
        </div>
    <?php $s++; } ?>
<?php } ?>
