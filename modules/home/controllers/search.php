<?php
//echo 1;die;
/*
 * Huy write
 */
	// controller
	
	class HomeControllersSearch
	{
		var $module;
		var $view;
		function __construct()
		{

			$this->module  = 'home';
			$this->view  = 'search';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// call models
            $model = new HomeModelsSearch();
            $fstable = FSFactory::getClass('fstable');
            // call models
//            $model = $this->model;

            $banner = $model->banners();
            $tienich = $model->tienich();
            $nhomhang = $model->nhomhang();
            $danhmuc = $model->danhmuc();




            $cat = $model->get_records('published = 1 and parent_id = 0 ORDER BY ordering ASC ', $fstable->_('fs_products_categories'));
            $cat_limit = $model->get_records('published = 1 and parent_id = 0 ORDER BY ordering ASC LIMIT 5 ', $fstable->_('fs_products_categories'));
//			var_dump($cat_limit);
            $slideshow = $model->get_records('published = 1 and category_id = 1', $fstable->_('fs_slideshow'));
            $banner_thanhtuu = $model->get_records('published = 1 and category_id = 2', $fstable->_('fs_banners'));
            $partner = $model->get_records('published = 1 and category_id = 3 ORDER BY RAND() LIMIT 15', $fstable->_('fs_banners'));
            $news = $model->get_records('published = 1 and show_in_homepage = 1 order by created_time desc, ordering desc Limit 4', $fstable->_('fs_news'));

//var_dump($news);
            global $tmpl, $config;
            $tmpl->assign('canonical', URL_ROOT);
            // call views

            include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';

		}
	}
	
?>