<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersAuthor extends FSControllers
	{
		function display()
		{			
			// call models
			$model = $this -> model;

			global $tags_group;
			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
		
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
                        
			$author = $model->getAuthor();
                        if(!$author){
                            setRedirect(URL_ROOT, 'Không có tác giả này', 'error');
                        }
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> $author->name, 1 => FSRoute::_('#'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>