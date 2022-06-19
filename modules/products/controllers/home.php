<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersHome extends FSControllers
	{
		function display()
		{			
			// call models
			$model = $this -> model;

            $banner = $model->banners();
            $dm = $model->dm();
            $list_thuonghieu = $model->thuonghieu();
//            var_dump($thuonghieu);
            $list_nguoidung = $model->nguoidung();
            $list_price_ = $model->list_price();

			global $tags_group;
			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
		
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
                        
			$list_tags = $model->getListTags();
			$list_company = $model->getListCompany();
                        
			$total_pr = $model->count_total();
			$list_price = $model->getListPrice();
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Nhà sách'), 1 => FSRoute::_('index.php?module=products&view=home'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>