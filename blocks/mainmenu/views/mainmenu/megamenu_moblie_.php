<?php
global $tmpl, $config;
$Itemid = FSInput::get('Itemid', 1, 'int');
//$tmpl->addStylesheet('jquery.mmenu.all', 'blocks/mainmenu/assets/css');
$tmpl->addStylesheet('megamenu_moblie', 'blocks/mainmenu/assets/css');
//$tmpl->addScript('jquery.mmenu.min.all', 'blocks/mainmenu/assets/js');
//$tmpl->addScript('mobile_menu', 'blocks/mainmenu/assets/js');
$tmpl->addScript('megamenu_moblie', 'blocks/mainmenu/assets/js');

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
?>
<nav id="navigation-menu">
    <div class="tab-content">
        <ul>
            <!--        <li class="level_1 _home">-->
            <!--            <a class="actives" title='--><?php //echo $config['site_name'] ?><!--' href="-->
            <?php //echo URL_ROOT; ?><!--"-->
            <!--               rel='nofollow'>--><?php //echo FSText::_('Trang chủ') ?><!--</a>-->
            <!--        </li>-->
            <?php $url = $_SERVER['REQUEST_URI']; ?>
            <?php $url = substr($url, strlen(URL_ROOT_REDUCE)); ?>
            <?php $url = URL_ROOT . $url; ?>
            <?php if (isset($list) && !empty($list)) { ?>
                <?php $t = 0; ?>
                <?php foreach ($arr_root as $item) { ?>
                    <?php $link = FSRoute::_($item->link); ?>
                    <?php $class = ''; ?>
                    <?php
                    $attr = '';
                    if ($item->target == '_blank')
                        $attr .= ' target="_blank " ';
                    ?>
                    <?php if ($url == $link) $class = 'active'; ?>
                    <?php if (isset($arr_children[$item->id]) && count($arr_children[$item->id])) {
                        $class = 'class="icon_hover"';
                    } else {
                        $class = '';
                    } ?>
                    <li class=" level_1 <?php echo $class; ?> ">
                        <?php if (isset($arr_children[$item->id]) && count($arr_children[$item->id])) { ?>
                            <a <?php echo $attr ?>  data-toggle="collapse" href="#collapseExample<?php echo $item->id; ?>" <?php echo $class; ?>  role="button"
                                                   aria-expanded="false" aria-controls="collapseExample<?php echo $item->id; ?>"
                                                   title="<?php echo $item->name; ?>"><?php echo $item->name; ?>
                            <i class="fal fa-chevron-down"></i>
                            <i class="fal fa-chevron-up"></i>
                            </a>
                        <?php } else { ?>
                            <a <?php echo $attr ?> href="<?php echo $link; ?>" <?php echo $class; ?>
                                                   title="<?php echo $item->name; ?>"><?php echo $item->name; ?>
                            </a>
                        <?php } ?>
                        <?php
                        //                    var_dump($arr_children[$item->id]);
                        if (isset($arr_children[$item->id]) && count($arr_children[$item->id])) { ?>

                            <ul class="me-float collapse" id="collapseExample<?php echo $item->id; ?>">
                                <?php foreach ($arr_children[$item->id] as $child) { ?>
                                    <?php $link_child = FSRoute::_($child->link); ?>
                                    <li><a <?php echo $attr ?> href="<?php echo $link_child; ?>"
                                                               title="<?php echo $child->name; ?>"
                                                               rel="<?php // echo $child->rel; ?>"><?php echo $child->name; ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } // end foreach($list as $item)?>
            <?php }  // end if(isset($list) && !empty($list)) ?>
        </ul>
    </div>
</nav>