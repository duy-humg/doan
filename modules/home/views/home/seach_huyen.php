<ul>
    <?php foreach ($huyen as $item){ ?>
        <li>
            <a href="javascript:void(0)" onclick="xa(<?php echo $item->id ?>)"><?php echo $item->name ?></a>
        </li>
    <?php } ?>
</ul>