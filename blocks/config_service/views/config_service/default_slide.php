<?php
	global $tmpl; 
	$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl_carousel/owl-carousel');
	$tmpl -> addStylesheet('owl.theme','libraries/jquery/owl_carousel/owl-carousel');
	$tmpl -> addScript('owl.carousel','libraries/jquery/owl_carousel/owl-carousel');
	$tmpl -> addScript('default_slide','blocks/partners/assets/js');
	$tmpl -> addStylesheet('default_slide','blocks/partners/assets/css');
	FSFactory::include_class('fsstring');
	$i = 1;
	$total = count($data);
?>	
<?php if(isset($data) && !empty($data)){?>
	<div class="container">
		<h2 class="block_title_partner"><span><?php echo FSText::_("Đối tác"); ?></span></h2>	
		<div class="partners-inner">
			<div id="partners" class="owl-carousel">
			<?php foreach($data as $item){ ?>
				<?php $image = URL_ROOT.str_replace('/original/', '/original/',$item -> image);?>
				<?php $link = $item -> url;?>															
					<div class="item">
			    		<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" target="_blink">
			    			<img width="176" height="76" onerror="this.src='/images/no-images.png'" src="<?php echo $image;?>" alt="<?php $item->name;?>" />
			    		</a>
					</div>
					<?php $i ++; ?>
			<?php }?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
 <?php }?>	


