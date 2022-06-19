<?php
global $tmpl, $config;
$Itemid = FSInput::get('Itemid', 1, 'int');
//$tmpl->addStylesheet('jquery.mmenu.all', 'blocks/mainmenu/assets/css');
$tmpl->addStylesheet('megamenu_moblie', 'blocks/mainmenu/assets/css');
//$tmpl->addScript('jquery.mmenu.min.all', 'blocks/mainmenu/assets/js');
$tmpl->addScript('megamenu_moblie', 'blocks/mainmenu/assets/js');
//var_dump($style);
//echo 1;die;
?>
<?php
$arr_root = array();
$arr_children = array();
$current_root = 0;
foreach ($list as $item) {
    if ($item->level == 0) {
        $arr_root[] = $item;
        $current_root = $item->id;
    } else if ($item->level == 1) {
        if (!isset($arr_children[$item->parent_id]))
            $arr_children[$item->parent_id] = array();
        $arr_children[$item->parent_id][] = $item;
    } else {
        $arr_children[$current_root][] = $item;
    }
}
var_dump($list);
?>
<nav id="navigation-menu">
<!--    <ul class="nav nav-tabs tab1">-->
<!--        <li class="active"><a data-toggle="tab" href="#home">Cửa hàng</a></li>-->
<!--        <li><a data-toggle="tab" href="#menu1">Tài khoản & hỗ trợ</a></li>-->
<!--    </ul>-->
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <ul>
                <li><a href="<?php echo URL_ROOT; ?>">Trang chủ</a></li>

                    <?php echo $tmpl->load_direct_blocks('product_menu', array('style' => 'default_cat')); ?>

                <li>
                    <a href="<?php echo FSRoute::_('index.php?module=users&view=products_sort&task=products_hot&Itemid=17'); ?>">Bán
                        chạy nhất</a>
                </li>
                <li>
                    <a href="<?php echo URL_ROOT . 'index.php?module=users&view=products_sort&task=products_coming&Itemid=17' ?>">Sắp
                        ra mắt</a>
                </li>
                <li>
                    <a href="<?php echo FSRoute::_('index.php?module=users&view=products_sort&task=products_new&Itemid=17') ?>">Sách
                        mới</a>
                </li>
                <li>
                    <a class="fire"
                       href="<?php echo FSRoute::_('index.php?module=users&view=products_sort&task=products_dis&Itemid=17') ?>">Khuyến
                        mại HOT</a>
                </li>
            </ul>

        </div>
    </div>
</nav>