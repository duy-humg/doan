<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/newslist/assets/css');
//$tmpl -> addScript('default','blocks/newslist/assets/js');
//$link_readmore =FSRoute::_("index.php?module=news&view=home");
?>

<div  id="block_id_<?php echo $id;?>">
    <div class="newslist-content list_menu_new">
        <h3 class="title-left-menu"><?php echo $title; ?></h3>
        <div id="home" class="tab-pane-list">
          <ul>
                <?php foreach ($list as $item) { ?>
                    <?php $link = FSRoute::_("index.php?module=news&view=news&id=" . $item->id . "&code=" . $item->alias . "&ccode=" . $item->category_alias); ?>
                    <li class="item-news clearfix" id_data="<?php echo $item->id; ?>">
                        <a class="new-item" href='<?php echo $link ?>' title="<?php echo $item->title ?>"  >
                            <img class="img-responsive" src="<?php echo URL_ROOT. str_replace('original', 'small', $item->image); ?>" /><span><?php echo getWord(8, $item->title); ?></span>
                        </a>
                    </li><!-- END: item-news -->        
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

