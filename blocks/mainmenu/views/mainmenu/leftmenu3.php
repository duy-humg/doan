<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/mainmenu/assets/js');
$tmpl->addStylesheet('leftmenu1', 'blocks/mainmenu/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>

<ul id="lefmenu3">
    <li class="title">
        <p> ĐỌC NHIỀU NHẤT</p>
    </li>
    <?php foreach ( $favorite_author as $item) { ?>
        <li>
            <a href="#">
                <?php echo $item->author_book; ?>
                <!--                                    <i class="fal fa-angle-right fl-right"></i>-->
            </a>
        </li>
    <?php } ?>
    <li class="xemthem">
        <a href="#"> xem thêm...</a>
    </li>
    <!--	CHILDREN				-->
</ul>
