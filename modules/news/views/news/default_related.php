<?php
    $total_content_relate = count($relate_news_list);
    if($total_content_relate){ ?>
        <h4 class="title-module-related">
            <span>
                <?php echo FSText::_('Các tin tức khác:'); ?>
            </span>
        </h4>
        <div class="new-related row-item">
            <div class="row">
            <?php 
                    for($i = 0; $i < $total_content_relate; $i ++){
                        $class = '';
                        if($i%3==0){
                            $class .= 'mg3';
                        }
                    $item = $relate_news_list[$i]; 
                    $link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
                    $image_large = URL_ROOT.str_replace('original','/large/',$item->image);
                ?>
                <div class="col-md-4 item_news <?php echo $class ?>">
                    <a class="a-img" href="<?php echo $link ?>">
                        <img src="<?php echo URL_ROOT. str_replace('original', 'normal', $item->image); ?>" alt="<?php echo $item->title ?>">
                    </a>
                    <a class="a-title resized" href="<?php echo $link ?>" title="<?php echo $item->title ?>">
                        <?php echo $item->title ?>
                    </a>
                </div> 
            <?php } ?>
            </div>
        </div>
        
<?php } ?>