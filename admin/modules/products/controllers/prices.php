<?php
// models 
class ProductsControllersPrices extends Controllers {
	function __construct() {
           
		$this->view = 'types';
		parent::__construct ();
	}
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $this->model->get_data ();
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	
	function add() {
		$model = $this->model;
		 $calculators = array (5 => array ("5", "==" ), 6 => array ("6", ">" ), 7 => array ("7", "<" ), 8 => array ("8", ">=" ), 9 => array ("9", "<=" ), 10 => array ("10", " > value1 AND < value2" ), 11 => array ("11", " > value1 AND <= value2" ), 12 => array ("12", " >= value1 AND < value2" ), 13 => array ("13", " >= value1 AND <= value2" ) );
//		 $calculators = array (2 => array ("2", "LIKE" ), 3 => array ("3", "Null" ), 4 => array ("4", "Not Null" ), 5 => array ("5", "==" ), 6 => array ("6", ">" ), 7 => array ("7", "<" ), 8 => array ("8", ">=" ), 9 => array ("9", "<=" ), 10 => array ("10", " > value1 AND < value2" ), 11 => array ("11", " > value1 AND <= value2" ), 12 => array ("12", " >= value1 AND < value2" ), 13 => array ("13", " >= value1 AND <= value2" ) );
		$maxOrdering = $model->getMaxOrdering ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	function edit() {
		$model = $this->model;
		$ids = FSInput::get ( 'id', array (), 'array' );
		$id = $ids [0];
                $calculators = array (5 => array ("5", "==" ), 6 => array ("6", ">" ), 7 => array ("7", "<" ), 8 => array ("8", ">=" ), 9 => array ("9", "<=" ), 10 => array ("10", " > value1 AND < value2" ), 11 => array ("11", " > value1 AND <= value2" ), 12 => array ("12", " >= value1 AND < value2" ), 13 => array ("13", " >= value1 AND <= value2" ));
//                $calculators = array (2 => array ("2", "LIKE" ), 3 => array ("3", "Null" ), 4 => array ("4", "Not Null" ), 5 => array ("5", "==" ), 6 => array ("6", ">" ), 7 => array ("7", "<" ), 8 => array ("8", ">=" ), 9 => array ("9", "<=" ), 10 => array ("10", " > value1 AND < value2" ), 11 => array ("11", " > value1 AND <= value2" ), 12 => array ("12", " >= value1 AND < value2" ), 13 => array ("13", " >= value1 AND <= value2" ));
		$data = $model->get_record_by_id ( $id );
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
}
?>