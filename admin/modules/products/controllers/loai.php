<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class ProductsControllersLoai extends Controllers
	{
		function __construct()
		{
			$this->view = 'products' ; 
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

            $list_tienich = $model->get_dm();
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }

        function edit() {

            $model = $this->model;
            $ids = FSInput::get('id', array(), 'array');
            $id = $ids[0];
            $list_tienich = $model->get_dm();
            $data = $model->get_record_by_id($id);

            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }
	}
	
?>