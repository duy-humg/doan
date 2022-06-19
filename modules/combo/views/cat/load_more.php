<?php $i=1; foreach ($list as $item){
    $link = FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id);
    ?>
    <div class="item_news">
        <div class="div-img">
            <a class="a-img" href="<?php echo $link ?>">
                <img src="<?php echo URL_ROOT. str_replace('original', 'normal', $item->image); ?>" alt="<?php echo $item->title ?>">
            </a>
        </div>
        <div class="info-news">
            <a class="a-title" href="<?php echo $link ?>"><?php echo $item->title ?></a>
            <p class="p-time"><i class="fal fa-clock"></i> <?php echo date('H:i d/m/Y', strtotime($item->created_time)); ?></p>
            <p class="p-summary"><?php echo $item->summary ?></p>
        </div>
    </div>
<?php $i++; } ?>