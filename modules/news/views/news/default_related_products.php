<!--	RELATE CONTENT		-->
<?php
	$total_content_relate = count($products_related);
	if($total_content_relate){ ?>
       <h3 class="relate_title">
            <span><?php echo FSText::_('Sản phẩm liên quan'); ?></span>
       </h3>
       <div class="row">    
        <?php 
			for($i = 0; $i < $total_content_relate; $i ++){
			$item = $products_related[$i]; 
			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
		?>	
            <div class="col-sm-3 col-xs-6">
                    <div class="item-product" >
                        <a class="item-image" href="<?php echo $link; ?>" title="<?php echo $item->name ?>">
                            <img class="img-responsive img_news" alt="<?php echo $item ->name;?>" src="<?php echo URL_ROOT.str_replace('/original/', '/large/', $item->image);?>" />
                        </a>
                        <h3 class="name-pro">
                            <a href="<?php echo $link; ?>" title="<?php echo $item->name ?>"><?php echo getWord(12,$item->name) ?></a>
                        </h3>
                        <del class="price_old-pro"><?php echo $item->discount? format_money($item->price_old,'vnđ'):'&nbsp;'; ?></del>
                        <p class="price-pro"><?php echo format_money($item->price,'vnđ') ?></p>
                        <a class="buy-medicine" href="<?php echo $link; ?>" title="<?php echo FSText::_('Đặt thuốc') ?>"><?php echo FSText::_('Đặt thuốc') ?></a>
                    </div>
            </div>
             <?php //echo ($i+1)%4==0? '<div class="clearfix"></div>':'' ?>      
		<?php } ?>
        </div>
<?php } ?>
<!--	end RELATE CONTENT		-->
