<?php
global $tmpl, $config;
$tmpl->addStylesheet('detail', 'modules/news/assets/css');
$tmpl->setMeta('og:image', URL_ROOT . $data->image);
?>
<div class="news_detail row-content">
    <div class="block-news-1">
        <a href="<?php echo FSRoute::_('index.php?module=news&view=home') ?>"><?php echo FSText::_('Tin tức') ?></a>
        <i class="fal fa-chevron-right"></i>
        <a href="<?php echo FSRoute::_('index.php?module=news&view=cat&ccode=' . $category->alias . '&id=' . $category->id); ?>"><?php echo $category->name ?></a>
        <i class="fal fa-chevron-right"></i>
        <span><?php echo $data->title ?></span>
    </div>
    <div class="block-news-2">
        <h1 class="news-title"><?php echo $data->title; ?></h1>
        <div class="row time-share">
            <div class="time col-md-8 col-sm-12">
                <p class="p-member"><?php echo $data->member; ?></p>
                <p class="p-time"><?php echo date('H:i | d/m/Y', strtotime($data->created_time)); ?></p>
            </div>

            <div class="share1 fl-right col-md-4 col-sm-12">
                <span><?php echo FSText::_('Chia sẻ') ?>:</span>
                <a class="share_face" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo FSRoute::_("index.php?module=news&view=news&code=".$data->alias. "&id=" . $data->id ) ?>" target="_blank">
                    <img src="<?php echo URL_ROOT.'images/face.png' ?>" alt="facebook">
                </a>
<!--                <a class="share_popup share_face" target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=--><?php //echo FSRoute::_("index.php?module=news&view=news&code=".$data->alias. "&id=" . $data->id ) ?><!--">-->
<!--                    <img src="--><?php //echo URL_ROOT.'images/ins.png' ?><!--" alt="linkedin">-->
<!--                </a>-->

                <a class="share_popup" target="_blank" href="https://twitter.com/share?url=<?php echo FSRoute::_("index.php?module=news&view=news&code=".$data->alias. "&id=" . $data->id ) ?>">
                    <img src="<?php echo URL_ROOT.'images/t.png' ?>" alt="linkedin">
                </a>
            </div>
        </div>
        <?php if ($data->summary) {?>
        <summary class="contents-summary">
            <?php echo $data->summary; ?>
        </summary><!-- END: .contents-detail-content -->
        <?php }?>
        <div class='description row-item'>
            <?php echo $data->content; ?>
        </div><!-- END: .news-detail-content -->
    </div>
    <?php include 'default_related.php'; ?>
    <?php //include 'default_related_cat.php'; ?>
</div><!-- END: .news_detail -->