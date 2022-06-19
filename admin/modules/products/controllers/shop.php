<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class ProductsControllersShop extends Controllers
	{
		function __construct()
		{
			$this->view = 'tienich' ;
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$list = $this -> model->get_data();
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

        function add() {
            $model = $this->model;

//            $list_tienich = $model->get_tienich();
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }

        function edit() {

            $model = $this->model;
            $ids = FSInput::get('id', array(), 'array');
            $id = $ids[0];
//            $list_tienich = $model->get_tienich();
            $data = $model->get_record_by_id($id);

            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }
	}
	
?>