<ul class="ul-menu_mobile row">
    <?php foreach ($menufooter_mobile as $item){
         $link = $item->link ? FSRoute::_($item->link) : '';
        ?>
        <li class="li-menu_mobile col-sm-3 col-xs-3">
            <a href="<?php echo $link ?>"
               title="<?php echo $item->name; ?>" class="a-menu-footer">
                <img src="<?php echo $item->image; ?>" alt="<?php echo $item->name; ?>">
                <span class="c-title"><?php echo $item->name; ?></span>
            </a>
        </li>
    <?php } ?>


</ul>
