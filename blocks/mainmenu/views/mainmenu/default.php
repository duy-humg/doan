<?php
global $tmpl, $config;
$tmpl->addStylesheet('leftmenu', 'blocks/mainmenu/assets/css');
$url_current = $_SERVER['REQUEST_URI'];
$url_current = substr(URL_ROOT, 0, strlen(URL_ROOT) - 1) . $url_current;
//var_dump($url_current);
?>
<div class="menu_right_hd clearfix">
    <h3>
        Menu
        <a class="a-close" onclick="no_moblie()" href="javascript:void(0)">
            <i class="fal fa-times-circle"></i>
        </a>
    </h3>
    <ul class="nav navbar-nav_hd">
        <li class="item item-home"><a href="<?php echo URL_ROOT ?>"><i class="fas fa-home"></i></a></li>
        <?php
        $Itemid = FSInput::get('Itemid', 1, 'int');
//        var_dump($Itemid);
        $total = count($list);
        $i = 0;
        $count_children = 0;
        $summner_children = 0;
        foreach ($list as $item) {
            //$class =  $item -> id ==  $Itemid ? 'active':'';
            $link = $item->link ? FSRoute::_($item->link) : '';
//            var_dump($link);
            $class = '';
            if ($link == $url_current) {
                $class = 'active';
            }
//		 		if($i == 0)
//		 			  $class .= ' first-item';
            if ($i == ($total - 1))
                $class .= ' last-item';

            $count_children ++;

            if ($count_children == $summner_children && $summner_children)
                $class .= ' last-item';



            echo "<li class='item $class ' ><a target='" . $item->target . "' href='" . $link . "' >" . $item->name . "</a></li>";

            // sepa
            //if($i < $total - 1)
            //echo "<li class='sepa' ><span>&nbsp;</span></li>";
            $i ++;
        }
        ?>

<!--        --><?php //if (isset($_SESSION['user_name'])) { ?>
<!--            <li><a class="icon_remember  style"-->
<!--                   href="--><?php //echo FSRoute::_('index.php?module=users'); ?><!--"><i class="fa fa-user-circle"></i>-->
<!--                    --><?php //echo $_SESSION['user_name']; ?><!--</a>-->
<!--         -->
<!--            </li>-->
<!--        --><?php //} else { ?>
<!--            <li><a class="icon_remember  style"-->
<!--                   href="--><?php //echo FSRoute::_('index.php?module=users&view=formregister')?><!--"><i class="fa fa-user-circle"></i>--><?php //echo FSText::_("Thành viên"); ?><!--</a>-->
<!--             -->
<!--            </li>-->
<!--        --><?php //} ?>
    </ul>
</div>
