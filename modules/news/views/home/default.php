<?php
global $tmpl,$config;
$tmpl->addStylesheet('home', 'modules/news/assets/css');
//$tmpl->addStylesheet('tintuc', 'modules/news/assets/css');
$total = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
$tmpl->setMeta('og:image', URL_ROOT . $config['logo']);

?>
<h1 >Tin Tức</h1>
<div class="news_content">
    <?php foreach ($list_dm as $item_dm){
        $link_dm =FSRoute::_('index.php?module=news&view=cat&ccode=' . $item_dm->alias . '&id=' . $item_dm->id);
        $model = $this -> model;
        $list_news = $model->list_news($item_dm->id);
//        var_dump(count($list_news));
        ?>
        <?php if($list_news){ ?>
            <div class="item_dm">
                <h2>
                    <?php echo $item_dm->name ?>
                    <a href=" <?php echo $link_dm ?>"><?php echo FSText::_('Xem tất cả') ?> <i class="fal fa-chevron-right"></i></a>
                </h2>
                <div class="list_news">
                    <div class="row">
                        <div class="left_news col-md-7">
                            <a class="a-img" href="<?php echo FSRoute::_('index.php?module=news&view=news&code=' . $list_news[0]->alias . '&id=' . $list_news[0]->id); ?>">
                                <img src="<?php echo URL_ROOT . str_replace('original', 'large', $list_news[0]->image); ?>" alt="<?php echo $list_news[0]->title ?>">
                            </a>
                            <a class="a-title" href="<?php echo FSRoute::_('index.php?module=news&view=news&code=' . $list_news[0]->alias . '&id=' . $list_news[0]->id); ?>">
                                <?php echo $list_news[0]->title ?>
                            </a>
                            <p class="p-summary"> <?php echo $list_news[0]->summary ?></p>

                        </div>
                        <div class="right_news col-md-5">
                            <?php $i=1; foreach ($list_news as $item){
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
                        <?php $i=1; foreach ($list_news as $item){
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

                </div>
            </div>
        <?php } ?>

    <?php } ?>
</div>