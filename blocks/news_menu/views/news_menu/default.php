<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/news_menu/assets/css');
$url_current = $_SERVER['REQUEST_URI'];
//var_dump($url_current);
$url_current = substr(URL_ROOT, 0, strlen(URL_ROOT) - 1) . $url_current;
//var_dump($url_current);
?>
<div class="list_menu_new">
    <h3 class="title-left-menu">Danh mục tin tức</h3>
    <ul class="tab-content">

        <?php
        foreach ($list as $item) {
            $link= FSRoute::_('index.php?module=news&view=cat&ccode='.$item->alias.'&id='.$item->id);
            $class = '';
            if ($link == $url_current or $item->id == $data->category_id) {
                $class = 'active';
            }
            ?>
        <li class="item <?php echo $class;?>"><a href="<?php echo $link;?>"><?php echo $item->name; ?></a></li>
        <?php } ?>
    </ul>
</div>