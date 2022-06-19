<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/mainmenu/assets/js');
$tmpl->addStylesheet('styles', 'blocks/mainmenu/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
$total_cart = 0;
if (isset($_SESSION['cart'])) {
    $product_list = $_SESSION['cart'];
    foreach ($product_list as $prd) {
        $total_cart += $prd[1];
    }
}
?>
<div id='cssmenu' class="row-item">
    <div class="container">
        <div class="list-item-menu">
            <!--            <div class="row">-->
            <div class="categori" id="list_menu">
                <div class="list-menu-product-show">
                    <div class="title-menu-top">
                        <?php echo FSText::_("Danh mục sản phẩm"); ?><i class="fas fa-angle-down"></i>
                    </div>
                    <div id='megamenu' class="menu selected">
                        <?php echo $tmpl->load_direct_blocks('product_menu', array('style' => 'default_cat')); ?>
                    </div>
                </div>
            </div>
            <div class="categori1">
                <a href="<?php echo FSRoute::_('index.php?module=users&view=products_sort&task=products_hot&Itemid=17');?>">Bán chạy nhất</a>
            </div>
            <div class="categori1">
                <a href="<?php echo  FSRoute::_('index.php?module=users&view=products_sort&task=products_coming&Itemid=17');?>">Sắp ra mắt</a>
            </div>
            <div class="categori1">
                <a href="<?php echo FSRoute::_('index.php?module=users&view=products_sort&task=products_new&Itemid=17')?>">Sách mới</a>
            </div>
            <div class="categori1">
                <a class="fire"  href="<?php echo FSRoute::_('index.php?module=users&view=products_sort&task=products_dis&Itemid=17')?>">Khuyến mại HOT</a>
            </div>
<!--            <div class="cart-top-head fl-right">-->
<!--                <a class="link-cat"-->
<!--                   href="--><?php //echo FSRoute::_('index.php?module=products&view=cart'); ?><!--">--><?php //echo FSText::_("Giỏ hàng"); ?>
<!--                    <span style="padding: 0 0 0 10px; font-size: 16px; font-weight: bold;">--><?php //echo $total_cart; ?><!--</span></a>-->
<!--                <a class="product" style="display: inline-block;" href="">Sản phẩm</a>-->
<!---->
<!--            </div>-->

            <!--                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">-->
            <!--                    <div class="row">-->
            <!--                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
            <!--                            <div class="see-products-menu">-->
            <!--                                -->
            <?php //echo FSText::_("Sản phẩm bạn đã xem"); ?><!--<i class="fal fa-angle-down"></i>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
            <!--                            <div class="menu-head-icon design-product" style="display: none;">-->
            <!--                                --><?php //echo FSText::_("Tất cả các sản phẩm"); ?>
            <!--                                <p>--><?php //echo FSText::_("thiết kế bởi AdcBook"); ?><!--</p>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
            <!--                            <div class="menu-head-icon free-all" style="display: none;">-->
            <!--                                <b>--><?php //echo FSText::_("Miễn phí giao hàng"); ?><!--</b>-->
            <!--                                <p>--><?php //echo FSText::_("Tận nơi-Toàn quốc"); ?><!--</p>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
            <!--                            <div class="menu-head-icon change-dreitag" style="display: none;">-->
            <!--                                <b>--><?php //echo FSText::_("Đổi trả trong 3 ngày"); ?><!--</b>-->
            <!--                                <p>--><?php //echo FSText::_("Dễ dàng và thuận lợi"); ?><!--</p>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--              </div>-->
            <!--            </div>-->
        </div>
    </div>
</div>


<div class="show_list_see_pr">
    <div class="container">
        <div class="content-list-pro">
            <?php if (isset($list_see)) { ?>
                <ul>
                    <?php
                    foreach ($list_see as $item) {
                        ?>
                        <li>
                            <a href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->alias . '&id=' . $item->id); ?>"
                               title="<?php echo $item->name; ?>">

                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a class="view_all_see"
                           href="<?php echo FSRoute::_('index.php?module=products&view=see'); ?>"><?php echo FSText::_("Xem thêm"); ?></a>
                    </li>
                </ul>
            <?php } else { ?>
                <ul>
                    <li class="text-center"><b><?php echo FSText::_("Bạn chưa xem sản phẩm nào"); ?></b></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>
<?php $i = 0; ?>





<?php //foreach ($level_0 as $item): ?>
<!--    --><?php //$link = $item->link ? FSRoute::_($item->link) : ''; ?>
<!--    --><?php //$class = 'level_0'; ?>
<!--    --><?php //$class .= $item->description ? ' long ' : ' sort' ?>
<!--    --><?php //if ($arr_activated[$item->id]) $class .= ' activated '; ?>
<!---->
<!--    <li class="--><?php //echo $class; ?><!-- --><?php //echo $item->is_type ? 'mega-menu' : '' ?><!--">-->
<!--        <a href="--><?php //echo $link; ?><!--" id="menu_item_--><?php //echo $item->id; ?><!--"-->
<!--           class="menu_item_a" title="--><?php //echo htmlspecialchars($item->name); ?><!--">-->
<!--            --><?php //echo $item->name; ?>
<!--            <i class="fal fa-angle-right fl-right"></i>-->
<!--        </a>-->
<!--                                        	LEVEL 1-->
<!--        --><?php //if (isset($children[$item->id]) && count($children[$item->id])) { ?>
<!--        <ul>-->
<!--            --><?php //} ?>
<!--            --><?php //if (isset($children[$item->id]) && count($children[$item->id])) { ?>
<!--                --><?php //$j = 0; ?>
<!--                --><?php //foreach ($children[$item->id] as $key => $child) { ?>
<!--                    --><?php //$link = $child->link ? FSRoute::_($child->link) : ''; ?>
<!--                    <li class='sub-menu-level1 --><?php //if ($arr_activated[$child->id]) $class .= ' activated '; ?><!-- '>-->
<!--                        <a href="--><?php //echo $link; ?><!--" class="sub-menu-item"-->
<!--                           id="menu_item_--><?php //echo $child->id; ?><!--"-->
<!--                           title="--><?php //echo htmlspecialchars($child->name); ?><!--">-->
<!--                            --><?php //echo $child->name; ?>
<!--                        </a>-->
<!--                    </li>-->
<!--                    --><?php //$j++; ?>
<!--                --><?php //} ?>
<!--            --><?php //} ?>
<!--            --><?php //if (isset($children[$item->id]) && count($children[$item->id])) { ?>
<!--        </ul>-->
<!--    --><?php //} ?>
<!--    </li>-->
<!--    --><?php //$i++; ?>
<?php //endforeach; ?>
<!--CHILDREN-->