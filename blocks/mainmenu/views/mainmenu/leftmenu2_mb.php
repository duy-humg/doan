<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/mainmenu/assets/js');
$tmpl->addStylesheet('leftmenu1', 'blocks/mainmenu/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>
<div class="boxdex" id="boxdes"  style="height: 256px;"
     data-height="256">
<ul id="lefmenu2">
    <li class="title">
        <p> ĐỌC NHIỀU NHẤT</p>
    </li>
    <?php foreach ( $list as $item) {?>
        <li class="<?php echo $class; ?> <?php echo $item->is_type ? 'mega-menu' : '' ?>">
            <a href="#" id="menu_item_<?php echo $item->id; ?>"
               class="menu_item_a" title="<?php echo htmlspecialchars($item->name); ?>">
                <?php echo $item->name; ?>
                <!--                                    <i class="fal fa-angle-right fl-right"></i>-->
            </a>
        </li>
    <?php } ?>
    <!--	CHILDREN				-->
</ul>
</div>
<div class="xemthem">
    <a style="cursor: pointer;" class="details_click clickmore" data-id="boxdes"
       data-class="1"> Xem thêm...</a>
</div>