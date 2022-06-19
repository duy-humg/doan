<ul id='hot_news'>
	<?php $i=0;
		foreach($list as $item){
			$i++;
			$link_news = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&Itemid=$Itemid");
	?>
		<?php if($i < 5){?>
			<li>
				<a href="<?php echo $link_news; ?>" >
					<img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image); ?>" onerror="this.onerror=null;this.src='<?php echo URL_ROOT.'images/logo1lduoc.jpg'?>';" alt='<?php echo $item -> title?>' />
				</a>
				<h3 class="heading"><a href="<?php echo $link_news; ?>" ><?php echo cutString($item->title, 50, '...'); ?></a></h3>
			</li>
		<?php }else{?>
			<li class="video">
				<a class="bg-click" href="<?php echo $link_news;?>" title="<?php echo $item -> title?>">&nbsp;</a>
				<a href="<?php echo $link_news; ?>" >
					<img width="100%" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $item->image); ?>" onerror="this.onerror=null;this.src='<?php echo URL_ROOT.'images/logo1lduoc.jpg'?>';" alt='<?php echo $item -> title?>' />
				</a>
			</li>
		<?php }?>
	<?php }?>
</ul>