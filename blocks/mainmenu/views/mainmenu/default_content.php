<?php
global $tmpl, $config;
$tmpl->addStylesheet('leftmenu_ct', 'blocks/mainmenu/assets/css');
$url_current = $_SERVER['REQUEST_URI'];
$url_current = substr(URL_ROOT, 0, strlen(URL_ROOT) - 1) . $url_current;
//var_dump($url_current);
?>
<div class="menu_right clearfix">
    <h3><?php echo $title; ?></h3>
    <ul class="nav navbar-nav">
        <?php
        $Itemid = FSInput::get('Itemid', 1, 'int');
//        var_dump($Itemid);
        $total = count();
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
            $i ++;
        }
        ?>
    </ul><!-- nav -->
</div>
