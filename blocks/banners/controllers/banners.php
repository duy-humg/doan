<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/banners/models/banners.php';
	
class BannersBControllersBanners {
	function __construct() {
	}
	function display($parameters, $title, $id = null) {
		$style = $parameters->getParams ( 'style' );
		$suffix = $parameters->getParams ( 'suffix' );
		$have_border = $parameters->getParams ( 'have_border' );
                
                if($have_border == 'have'){
                    $class_bboder = 'border-image';
                } else {
                    $class_bboder = '';
                }
		$category_id = $parameters->getParams ( 'category_id' );
//                var_dump($category_id);
		$text_pos = $parameters->getParams ( 'text_pos' );

		$out_id = $parameters->getParams ( 'id' );
			
		$style = $style ? $style : 'default';
	
		// call models
		$model = new BannersBModelsBanners();
		$list = $model->getList($category_id);
//		var_dump($list);
		if(!$list)
			return;
		// call views
		include 'blocks/banners/views/banners/'.$style.'.php';
		}
	}
	
?>