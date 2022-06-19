<?php foreach ($list_ as $item){ ?>
    <a href="<?php echo 'http://' . $htp_host . $uri . $fist . '&hang=' . $item->id . ':' . $item->alias ?>" class="a-tiem-hang  a-tiem-hang-name">
        <div class="bao-img">
            <?php if($item->image){ ?>
                <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $item->image); ?>" alt="<?php echo $item->name ?>">
            <?php }else{ ?>
               <p><?php echo $item->name ?></p>
            <?php } ?>
        </div>
    </a>
<?php } ?>