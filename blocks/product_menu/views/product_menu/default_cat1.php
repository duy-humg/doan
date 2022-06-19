<?php
global $tmpl;
$tmpl->addStylesheet('cat', 'blocks/product_menu/assets/css');
?>
<!--	CONTENT -->

<!--    --><?php
//    $Itemid = 5; // config
//    $num_child = array();
//    $parant_close = 0;
//    $i = 0;
//    $count_children = 0;
//    $summner_children = 0;
//    $id = 0;
//    if ($need_check)
//        $id = FSInput::get('id', 0, 'int');
//
//    $total = count($list1);
//    foreach ($list1 as $item) {
//        $class = '';
//        if ($need_check) {
//            $class = $item->alias == $ccode ? 'activated' : '';
//        }
//        $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias );
//
//        $class .= ' level_' . $item->level;
//        if ($i == 0)
//            $class .= ' first-item';
//        if ($i == ($total - 1))
//            $class .= ' last-item';
//
//        if($item->icon){
//            $icon = "<img src=" .URL_ROOT. str_replace('original', 'resized', $item->icon). " class='img-responsive'>";
//        } else {
//            $icon = '';
//        }
//
//        if ($item->level) {
//            $count_children ++;
//            if ($count_children == $summner_children && $summner_children)
//                $class .= ' last-item';
//
//            echo "<li class=' $class child_" . $item->parent_id . "' ><a href='" . $link . "'  > ".$icon." " . $item->name . "</a> ";
//        } else {
//            $count_children = 0;
//            $summner_children = $item->children;
//
//            echo "<li class=' $class  ' id='pr_" . $item->id . "' >";
//            echo "<a href='" . $link . "' > ".$icon." " . $item->name . "</a> ";
//        }
//        ?>
<!--        --><?php
//        $num_child[$item->id] = $item->children;
//        if ($item->children > 0) {
//            if ($item->level)
//                echo "<ul id='c_" . $item->id . "' class='wrapper_children wrapper_children_level" . $item->level . "'>";
//            else
//                echo "<ul id='c_" . $item->id . "' class='wrapper_children_level" . $item->level . "' >";
//        }
//
//        if (@$num_child[$item->parent_id] == 1) {
//            // if item has children => close in children last, don't close this item
//            if ($item->children > 0) {
//                $parant_close ++;
//            } else {
//                $parant_close ++;
//                for ($i = 0; $i < $parant_close; $i++) {
////                      echo "<li class='sub-footer'></li></ul>";
//                    echo "</ul>";
//                }
//                $parant_close = 0;
//                $num_child[$item->parent_id] --;
//            }
//
//            if (( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id > 0 ) ) || !$item->children) {
//                echo "</li>";
//            }
//            if (@$num_child[$item->parent_id] >= 1)
//                $num_child[$item->parent_id] --;
//        }
//
//
//        if (isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] == 1))
//            echo "</ul>";
//        if (isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1))
//            $num_child[$item->parent_id] --;
//    }
//    ?>

<!--	end CONTENT -->


<!--top category-->
<?php
$Itemid = 5; // config
$num_child = array();
$parant_close = 0;
$i = 0;
$count_children = 0;
$summner_children = 0;
$id = 0;
if ($need_check)
    $id = FSInput::get('id', 0, 'int');

$total = count($list1);
//var_dump($list_hot);
?>
<div class="pcc container">
<!--    <div class="row list_other">-->
    <div class="list_other">
        <?php
        $j=0;
        foreach ($list_other as $item) {
            $j++;
            $cat1 = $model->getListCat_level1($item->id);
//            var_dump($cat1);
            $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
            ?>
<!--            <div class="col-md-3 other1">-->
            <div class=" other1">
                <a class="cat_pr" href="<?php echo $link; ?>"
                   title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a>
                <div class="list_child">
                    <?php for ($i=0; $i < count($cat1); $i++) {
                        $key = $cat1[$i];
                        $link1 = FSRoute::_('index.php?module=products&view=cat&cid=' . $key->id . '&ccode=' . $key->alias);
                        ?>
                        <a href="<?php echo $link1; ?>" class="cat_child"
                           title="<?php echo $key->name; ?>"><?php echo $key->name; ?></a>
                        <?php if ($i < count($cat1)-1){?>
                            <span> | </span>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
<!--            --><?php //if ($j % 4 == 0){?>
<!--                <div class="clearfix"></div>-->
<!--            --><?php //} ?>
        <?php } ?>
    </div>

</div>
<script>
    $(document).ready(function() {
        var $container = $('.pcc');
        $container.masonry({
            itemSelector: '.other1'
        });
    })
</script>