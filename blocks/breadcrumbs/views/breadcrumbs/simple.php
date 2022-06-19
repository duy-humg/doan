<?php
    global $tmpl; 
    $tmpl -> addStylesheet('breadcrumbs_simple','blocks/breadcrumbs/assets/css');
    $total = count($breadcrumbs);
?>	
<div class='breadcrumbs row-item'>
    <div class="container">
        <ol class="breadcrumb row-item">
    	<?php if(isset($breadcrumbs) && !empty($breadcrumbs)){?>
    		<li  class='breadcrumb-item breadcumbs-first'>
    			<?php global $config;?>
    			<a title='<?php echo $config['site_name'] ?>' href="<?php echo URL_ROOT?>" rel='nofollow' >
                    <?php echo FSText::_("Trang chủ"); ?>
                </a>
    		</li >
    		<?php $i = 0; ?>
    			<?php foreach($breadcrumbs as $item){?>
    				<?php if(!$item[1]){?>
    					<li class="breadcrumb-item <?php echo $i==($total-1)?  'active':'' ?>" >
                            <i class="fal fa-angle-right"></i>
                            <?php echo getWord(20,$item[0]); ?>
                        </li>
    				<?php } else {?>
    					<li class="breadcrumb-item <?php echo $i==($total-1)?  'active':'' ?>">
                            <a href="<?php echo $item[1]; ?>" title="<?php echo $item[0]; ?>" >
                                <i class="fal fa-angle-right"></i>
                                <?php echo getWord(20,$item[0]); ?>
                            </a>
                        </li>
    				<?php }?>
    				<?php $i ++;?>								
    			<?php }?>
    	<?php }?>
        </ol><!-- END: .breadcrumb-content -->
    </div>
</div><!-- END: .breadcrumb -->
<div class="clear"></div>