<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/product_menu/assets/css');
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
<div class="pcc">
    <div class="row" style="padding-bottom: 15px; border-bottom: 1px solid #ccc; margin-left: 0; margin-right: 0;">
        <div class="col-md-2 top_cat">
            <p class="title_cat"> Top danh mục</p>
            <ul>
                <?php foreach ($list_hot as $item) {
                    $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                    ?>
                    <li><a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-10 other">
            <p class="title_cat">Danh mục khác</p>
            <ul class="row list_other">
                <?php foreach ($list_other as $item) {
                    $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                    ?>
                    <li class="col-md-4 other1"><a href="<?php echo $link; ?>"
                                                   title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="old_sort">
        <p class="title_cat age">Sách thiếu nhi theo độ tuổi</p>
        <ul style="margin: 0 0 5px 0;">
            <?php foreach ($list_age as $item) {
                $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                ?>
                <li class="other2"><a href="<?php echo $link; ?>"
                                      title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<li class="visible1"><a class="btnnn " data-toggle="collapse" data-target="#collapseExample100"
                       aria-expanded="false" aria-controls="collapseExample100">Top danh mục<i
                class="fa fa-angle-down"></i></a>
    <div class="collapse " id="collapseExample100">
        <ul class="child_cat">
            <?php foreach ($list_hot as $item) {
                $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                ?>
                <li class="other2"><a href="<?php echo $link; ?>"
                                      title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</li>
<li class="visible1"><a class="btnnn " data-toggle="collapse" data-target="#collapseExample110"
                       aria-expanded="false" aria-controls="collapseExample110">Danh mục khác<i
                class="fa fa-angle-down"></i></a>
    <div class="collapse " id="collapseExample110">
        <ul class="child_cat">
            <?php foreach ($list_other as $item) {
                $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                ?>
                <li class="other2"><a href="<?php echo $link; ?>"
                                      title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</li>
<li class="visible1"><a class="btnnn " data-toggle="collapse" data-target="#collapseExample120"
                       aria-expanded="false" aria-controls="collapseExample120">Sách thiếu nhi theo độ tuổi<i
                class="fa fa-angle-down"></i></a>
    <div class="collapse " id="collapseExample120">
        <ul class="child_cat">
            <?php foreach ($list_age as $item) {
                $link = FSRoute::_('index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias);
                ?>
                <li class="other2"><a href="<?php echo $link; ?>"
                                      title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</li>
<li class="visible1"><a class="btnnn " data-toggle="collapse" data-target="#collapseExample130"
                       aria-expanded="false" aria-controls="collapseExample130">Tác giả yêu thích<i
                class="fa fa-angle-down"></i></a>
    <div class="collapse " id="collapseExample130">
        <ul class="child_cat">
            <?php foreach ($list_favourite as $item) {
                $link = FSRoute::_("index.php?module=products&view=author&code=" . $item->alias); ?>
                <li class="other2"><a href="<?php echo $link; ?>"
                                      title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</li>