<?php

?>
<?php
    $total_news_related = count($news_related);
    if($total_news_related){ ?>
    <div class="row-item related">
        <h4 class="block_title_related">
            <span><?php echo FSText::_('Bài viết liên quan khác'); ?></span>
        </h4>
        <div id="news-related" class="click-related">

            <?php 
    			for($i = 0; $i < $total_news_related; $i ++){
    			$item = $news_related[$i]; 
    			$link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
    		?>
            <div class="item">
                <a href="<?php echo $link ?>" title="<?php echo $item->title;?>">
                    <img width="196" height="117" onerror="this.src='/images/no-images.png'" src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image);?>" onerror="this.onerror=null;this.src='<?php echo URL_ROOT.'images/logo1lduoc.jpg'?>';" alt="<?php echo $item->title;?>" />
                </a>
                <h3 class="relate_content">  	
                    <a class="img_news" href='<?php echo $link;?>' title='<?php echo $item ->title;?>'>
                        <?php echo getWord(30,$item ->title);?>
                    </a>
                </h3>  
            </div>  
        <?php } ?>
        </div>
    </div>
<?php } ?>