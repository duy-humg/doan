<?php
/*
 * Huy write
 */
	// controller
	
	class DepartmentControllersDepartment extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;

			$query_body = $model->set_query_body();
			
			$list = $model->get_list($query_body);
			//echo count($list);
                         $dataCity = $model->get_city(); 
                         $info_other = $model->get_info_other(); 
                        $district = $model->get_categories_tree();
			$detect = new FSDevice; 
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Hệ thống cửa hàng'), 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
                function get_agency(){
                    $city_id = FSInput::get('district_id');
                    if($city_id==0){
                        unset($_SESSION["district"]);
                    }else{
                        $_SESSION["district"]=$city_id;
                    }
                }
                        function loadDistricts(){
			$city_id = FSInput::get('city_id');
                        $_SESSION["city"]=$city_id;
			global $config;
			
			$listDistricts = $this->model->getListDistricts($city_id);
			$html = '';
			foreach($listDistricts as $item){
				$html .= '<option  value="'.$item->id.'">'.$item->name.'</option>';
			}
			echo $html;
		}
	}
	
?>