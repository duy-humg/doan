<?php $i=1;
foreach ($list as $item) {
    $link = '';
    $class= '';
    if($i%3==0){
        $class .= 'mg3';
    }
    ?>
    <div class="item_sp col-md-4 <?php echo $class ?>">
        <a class="img" href="<?php echo $link ?>">
            <img src="<?php echo URL_ROOT. str_replace('original', 'large', $item->image); ?>" alt="<?php echo $item->title ?>">
        </a>
        <a class="name_sp" href="<?php echo $link ?>"><?php echo $item->title ?></a>
    </div>
<?php $i++; } ?>