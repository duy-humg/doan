<ul>
    <?php foreach ($city as $item){ ?>
        <li>
            <a href="javascript:void(0)" onclick="huyen(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
        </li>
    <?php } ?>
</ul>