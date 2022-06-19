<?php
global $tmpl;
$tmpl->addStylesheet('cat', 'modules/news/assets/css');
$keyword = FSInput::get('keyword');
$page = FSInput::get('page');
$title = 'Tìm kiếm với từ khóa "' . $keyword . '"';
if (!$page)
    $tmpl->addTitle($title);
else
    $tmpl->addTitle($title . ' - Trang ' . $page);

$total = count($list);

$str_meta_des = $keyword;

for ($i = 0; $i < $total; $i ++) {
    $item = $list[$i];
    $str_meta_des .= ',' . $item->title;
}
$tmpl->addMetakey($str_meta_des);
$tmpl->addMetades($str_meta_des);
$Itemid = 4;
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <aside class="new-contents">
        <h1 class="title-module">
            <span><?php echo FSText::_('Kết quả tìm kiếm cho từ khóa') . ' "' . $keyword . '"'; ?></span>
        </h1>
        <div class='list-news row-item'>
            <div class="row">
                <?php
                if ($total) {
                    foreach ($list as $item) {
                        $link = FSRoute::_('index.php?module=news&view=news&code='.$item->alias.'&id='.$item->id);
                        $image = URL_ROOT.str_replace('original','small',$item->image);
                        $image_large = URL_ROOT.str_replace('original','large',$item->image);
                        $image_resized = URL_ROOT.str_replace('original','resized',$item->image);
                        ?>
                        <div class="col-xs-12">
                
                    <a class="item small" href="<?php echo $link ?>" title="<?php echo $item->title ?>">
                        <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <img class="img-responsive" src="<?php echo $image_resized ?>" onerror="this.onerror=null;this.src='<?php echo URL_ROOT.'images/logo1lduoc.jpg'?>';" alt="<?php echo $item->title ?>" />
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="content-item">
                                <h3 class="title"><?php echo $item->title ?></h3>
                                <time>
                                    <?php echo date('d/m/Y',strtotime($item->created_time)); ?>
                                </time>
                                <summary class="summary"><?php echo getWord(50,$item->summary) ?></summary>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                         </div>
                    </a>
               
                </div>
                        <?php
                    }
                    if ($pagination)
                        echo $pagination->showPagination(3);
                } else {
                    echo "Không có kết quả nào cho từ khóa <strong>" . $keyword . "</strong>";
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
    </aside>
</div>