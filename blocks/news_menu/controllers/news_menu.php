<?php
/*
 * Huy write
 */
// models 
include 'blocks/news_menu/models/news_menu.php';

class News_menuBControllersNews_menu {
	function __construct() {
	}
	function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
            $category_id = $parameters->getParams('category_id');
			$style = $style ? $style : 'default';
	
			// call models
			$model = new News_menuBModelsNews_menu();

                $list = $model->getListCat($category_id);
                $view=FSInput::get('view');
                if($view=='news'){
                $data = $model->getNews();
                }
			// call views
			include 'blocks/news_menu/views/news_menu/'.$style.'.php';
		}
}

?>