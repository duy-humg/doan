<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/favourite_author/assets/css');
//$tmpl -> addScript('default','blocks/favourite_author/assets/js');
//$tmpl->addScript('styles', 'blocks/favourite_author/assets/js');
//$link_readmore =FSRoute::_("index.php?module=news&view=home");
//var_dump($title);
//var_dump($list);
?>
<div class="boxdex" id="boxdex20" style="height: 297px;"
     data-height="297">
    <div id="block_id_<?php echo $id; ?>" style="margin-top: 10px;">
        <div class="newslist-content list_menu_new ">
            <div id="home" class="tab-pane-list">
                <ul>
                    <li class="title"><p>Tác giả yêu thích</p></li>
                    <?php foreach ($list as $item) { ?>
                        <?php $link = FSRoute::_("index.php?module=products&view=author&code=" . $item->alias); ?>
                        <li class="item-news clearfix" id_data="<?php echo $item->id; ?>">
                            <a class="new-item" href='<?php echo $link ?>' title="<?php echo $item->title ?>">
                                <?php echo $item->name ?>
                                <!--                            <img class="img-responsive" src="-->
                                <?php //echo URL_ROOT. str_replace('original', 'small', $item->image); ?><!--" /><span>-->
                                <?php //echo getWord(8, $item->title); ?><!--</span>-->
                            </a>
                        </li><!-- END: item-news -->
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</div>
<div class="xemthem">
    <a style="cursor: pointer;" class="details_click clickmore" data-id="boxdex20"
       data-class="1"> Xem thêm...</a>
</div>
