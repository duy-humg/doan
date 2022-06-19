<?php
    global $tmpl;
?>
    <ul class="col-12-ul">
        <?php
        foreach ($list_quick as $item){
            $link_search = URL_ROOT.'tim-kiem/'.encodeURIComponent(encodeURIComponent($item->name)).'.html'
        ?>
        <li class="col-12-li">
            <a href="<?php echo $link_search ?>"><?php echo $item->name ?></a>
        </li>
        <?php } ?>
    </ul>

