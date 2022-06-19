<?php
global $tmpl,$config;
//$tmpl->addScript('styles', 'blocks/mainmenu/assets/js');
//$tmpl->addStylesheet('styles', 'blocks/mainmenu/assets/css');
$tmpl->addStylesheet('news', 'blocks/discount/assets/css');
$lang = FSInput::get('lang');
$cid = FSInput::get('cid');
$module = FSInput::get('module');
$view = FSInput::get('view');

?>
<ul class="ul-cap1">

        <?php foreach ($dm_1 as $item){
            $link = FSRoute::_("index.php?module=products&view=cat&ccode=".$item->alias. "&cid=" . $item->id );
            ?>
    <li class="li-cap1">
            <a href="<?php echo $link ?>"
               title="<?php echo $item->name; ?>" class="a-menu-footer">
                <span class="c-title"><?php echo $item->name; ?></span>
            </a>
    </li>
        <?php } ?>


</ul>


