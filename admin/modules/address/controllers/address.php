<?php
	class AddressControllersAddress extends Controllers
	{
		function __construct()
		{
			$this->view = 'address' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$pagination = $model->getPagination();
                        $province = $model->get_categories_tree2();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
                
		function add()
		{
			$model = $this -> model;
			$dataCity = $model->get_city(); 
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		function edit(){
			$id = FSInput::get('id');
			$model  = $this -> model;
			$data = $model->get_record_by_id($id);
                        $dataCity = $model->get_city(); 
                        $categories = $model->get_categories_tree();
                        $days = $model -> get_days($data -> id);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
                 function loadDistricts(){
			$city_id = FSInput::get('city_id');
			global $config;
			
			$listDistricts = $this->model->getListDistricts($city_id);
			$html = '';
			foreach($listDistricts as $item){
				$html .= '<option  value="'.$item->id.'">'.$item->name.'</option>';
			}
			echo $html;die;
		}
	}
	
?>