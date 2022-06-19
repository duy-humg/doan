<?php
global $tmpl;
$tmpl->addStylesheet('favourite', 'modules/users/assets/css');
//$total = count($list);
//$Itemid = 7;
FSFactory::include_class('fsstring');
$act = FSInput::get('sort');
$fist = "";
$prices = FSInput::get('prices');
$origin = FSInput::get('origin');
$object = FSInput::get('object');
$color = FSInput::get('color');
$producer = FSInput::get('producer');
$company = FSInput::get('company');
$sort = FSInput::get('sort');
switch ($sort) {
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
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$tmpl->addTitle($cat->name);
if ($prices || $origin || $object || $color || $producer || $company || strpos($url, '?')) {
    $fist = "";
} else
    $fist = '?';
?>
<input type="hidden" name="quantity" id="quantity" value="1">
<div class="container">
    <aside class="new-contents">
        <div class="row body1">
<!--            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 visible1 leftmb">-->
<!--                --><?php //include 'menu_user.php'; ?>
<!--            </div>-->
            <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <?php include 'menu_user.php'; ?>
            </div>
            <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="title-module">
                    <h1>Sản phẩm yêu thích</h1>
                    <p class="text-title">Nơi lưu giữ những sản phẩm yêu thích của bạn</p>
                </div>
                <div class="list-products">


                    <div class="row">
                        
                            <?php
                            $i = 0;
                            foreach ($list as $item) {
                                $model = $this->model;
                                $sp = $model->getsp($item->record_id);
                                $link = FSRoute::_('index.php?module=products&view=product&ccode=' . $sp->category_alias . '&code=' . $sp->alias . '&id=' . $sp->id);
                                $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
                                ?>
                                <?php $i++; ?>
                                <div class="image-check col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                    <a href="<?php echo $link; ?>">
                                        <img src="<?php echo URL_ROOT . str_replace('original', 'tiny', $sp->image); ?>" class="img-responsive">
                                        <p class="name_sp" href="<?php echo $link ?>"><?php echo $sp->name ?></p>
                                        <div class="money_sp-more">
                                            <div class="money_sp">

                                                <?php if($sp->price_old){ ?>
                                                    <p class="text-price-old"><?php echo format_money($sp->price_old) ?></p>
                                                <?php } ?>
                                                <p class="text-price" ><?php echo format_money($sp->price) ?></p>
                                            </div>
                                            <div class="more">
                                                <p class="a-more" href="<?php echo $link ?>"><?php echo FSText::_('Xem shop') ?></p>
                                                <p><?php echo FSText::_('Đã bán') ?> <?php echo $sp->daban ?>k</p>
                                            </div>
                                        </div>
                                        <?php if($sp->price_old){ ?>
                                            <img class="img-giamgia" src="<?php echo URL_ROOT.'images/Group.svg' ?>" alt="Group">
                                            <p class="text-giam-gia">- <?php echo $sp->giamgia ?>%</p>
                                        <?php } ?>
                                    </a>
                                    <a class="bg" href="<?php echo $link; ?>">
                                        <span>MUA NGAY</span>
                                    </a>
                                </div>
                                <?php if (($i%4) == 0) { ?>
                                    <div class="clearfix "></div>
                                <?php } ?>

                            <?php }
                         ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php if ($pagination) echo $pagination->showPagination(3); ?>
            </div>
        </div>
    </aside>
</div>