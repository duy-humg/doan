<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersSee extends FSControllers
	{
		function display()
		{			
			// call models
			$model = $this -> model;

			global $tags_group;
                        
                        $product_list_see = $_SESSION['see_product'];
                        $id_products = '';
                        for ($j = 0; $j < count($product_list_see); $j ++) {
                            $prd = $product_list_see[$j];
                            $id_products .= ',' . $prd[0];
                        }
                        $id_products .= ',';
			$query_body = $model->set_query_body($id_products);
			$list = $model->get_list($query_body);
		
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);

			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> 'Sản phẩm bạn đã xem', 1 => FSRoute::_('#'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>