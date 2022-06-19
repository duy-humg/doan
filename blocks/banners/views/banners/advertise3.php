<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/banners/assets/js');
$tmpl->addStylesheet('advertise', 'blocks/banners/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>
<?php
//var_dump($list);
foreach ($list as $item) { ?>
    <a href="<?php echo $item->link; ?>" title="<?php echo $item->name; ?>" class="book2">
        <p><?php echo $item->name; ?></p>
        <?php if ($item->height) {
            ?>
            <img class="img-responsive"
                 src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>"
                 alt="<?php echo $item->name; ?>" style="height:<?php echo $item->height . 'px'; ?>">
            <?php
        } else {
            ?>
            <img class="img-responsive"
                 src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>"
                 alt="<?php echo $item->name; ?>">
            <?php
        }
        ?>
    </a>
<?php } ?>