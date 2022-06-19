<?php
global $tmpl,$config;
$tmpl->addStylesheet('cat', 'modules/news/assets/css');
$tmpl->addScript("cat", "modules/news/assets/js");
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$tmpl->setMeta('og:image', URL_ROOT . $config['logo']);
$limit =11;

?>
<input type="hidden" id="cat_id" name="cat_id" value="<?php echo $cat->id ?>">
<aside class="new-contents">
    <h1 class="title-module"><?php echo $cat->name; ?></h1>
    <div class="list_news">
        <div class="row">
            <div class="left_news col-md-7">
                <a class="a-img" href="<?php echo FSRoute::_('index.php?module=news&view=news&code=' . $list[0]->alias . '&id=' . $list[0]->id); ?>">
                    <img src="<?php echo URL_ROOT . str_replace('original', 'large', $list[0]->image); ?>" alt="<?php echo $list[0]->title ?>">
                </a>
                <a class="a-title" href="<?php echo FSRoute::_('index.php?module=news&view=news&code=' . $list[0]->alias . '&id=' . $list[0]->id); ?>">
                    <?php echo $list[0]->title ?>
                </a>
                <p class="p-summary"> <?php echo $list[0]->summary ?></p>

            </div>
            <div class="right_news col-md-5">
                <?php $i=1; foreach ($list as $item){
                    $link = FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id);
                    ?>
                    <?php if($i==2 or $i==3){ ?>
                        <div class="item_news">
                            <a class="a-img" href="<?php echo $link ?>">
                                <img src="<?php echo URL_ROOT . str_replace('original', 'normal', $item->image); ?>" alt="<?php echo $item->title ?>">
                            </a>
                            <a class="a-title" href="<?php echo $link ?>">
                                <?php echo $item->title ?>
                            </a>
                        </div>
                    <?php } ?>
                    <?php $i++; } ?>

            </div>
            <?php $i=1; foreach ($list as $item){
                $link = FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id);
                $class_6 = '';
                if($i%6==0){
                    $class_6 .= 'mg6';
                }
                ?>
                <?php if($i==4 or $i==5 or $i==6){ ?>
                    <div class="item_news_2 col-md-4 <?php echo $class_6 ?>">
                        <a class="a-img" href="<?php echo $link ?>">
                            <img src="<?php echo URL_ROOT . str_replace('original', 'normal', $item->image); ?>" alt="<?php echo $item->title ?>">
                        </a>
                        <a class="a-title" href="<?php echo $link ?>">
                            <?php echo $item->title ?>
                        </a>
                    </div>
                <?php } ?>
                <?php $i++; } ?>
        </div>
        <div class="list_news_2">
            <h2><?php echo FSText::_('Mới nhất') ?></h2>
            <div class="ds_news">
                <?php $i=1; foreach ($list as $item){
                    $link = FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id);
                    ?>
                    <?php if($i==7 or $i==8 or $i==9 or $i==10 or $i==11){ ?>
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
                    <?php } ?>
                <?php $i++; } ?>
            </div>
            <div class="ds_news more-news c-promotions-list loas">

            </div>
            <div class="div-more">
                <?php if (count($list) >= 11) {
                    ?>
                    <div class="c-view-more bg-white is-margin">
                        <a class="load_more" href="javascript:void(0)" data-pagecurrent="1" data-nextpage="2"
                           limit="<?php echo $limit; ?>"
                        >
                            <?= FSText::_('Xem thêm bài viết mới nhất'); ?>
                            <span class="caret"></span>
                        </a>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
</aside>