<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/mainmenu/assets/js');
$tmpl->addStylesheet('leftmenu1', 'blocks/mainmenu/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>
<div class="boxdex" id="boxdex"  style="height: 246px;"
     data-height="246">
<ul id='megamenu' class="menu <?php echo ($Itemid != 1) ? 'selected' : ''; ?> ">
    <li class="title">
        <p> SÁCH HAY NHẤT</p>
    </li>
    <?php $i = 0; ?>
    <?php foreach ($level_0 as $item): ?>
        <?php $link = $item->link ? FSRoute::_($item->link) : ''; ?>
        <?php $class = 'level_0'; ?>
        <?php $class .= $item->description ? ' long ' : ' sort' ?>
        <?php if ($arr_activated[$item->id]) $class .= ' activated '; ?>

        <li class="<?php echo $class; ?> <?php echo $item->is_type ? 'mega-menu' : '' ?>">
            <a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id; ?>"
               class="menu_item_a" title="<?php echo htmlspecialchars($item->name); ?>">
                <?php echo $item->name; ?>
                <!--                                    <i class="fal fa-angle-right fl-right"></i>-->
            </a>
        </li>
        <?php $i++; ?>
    <?php endforeach; ?>

    <!--	CHILDREN				-->
</ul>
</div>
<div class="xemthem">
    <a style="cursor: pointer;" class="details_click clickmore" data-id="boxdex"
       data-class="1"> Xem thêm...</a>
</div>

