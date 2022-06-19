<?php
class ProductsModelsPrices extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = 100;
		$page = FSInput::get ( 'page' );
		$this->limit = $limit;
		$this->table_name = 'fs_products_prices';
		$this->check_alias = 1;
		$this->table_product = 'fs_products';
		parent::__construct ();
	}
	
	function setQuery() {
		// ordering
		$ordering = '';
		$where = "  ";
		if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
			$sort_field = $_SESSION [$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
		}
		
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND name LIKE '%" . $keysearch . "%' ";
			}
		}
		$query = " 	   SELECT * 
						
						  FROM " . $this->table_name . " 
						  	WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}
		/*
		 * get Tablename product
		 */
		function get_tablenames()
		{
			global $db;
			$query = " 	   SELECT DISTINCT(a.table_name) as table_name
						  FROM fs_products_tables AS a 
						 ";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
	
	/*
		 * Save into tble fs_manufactories
		 */
	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$tablename = FSInput::get ( 'tablenames', array (), 'array' );
		$operator= $_POST["operator"];
//                echo $operator;die;
                $row ['operator'] = $operator;
                $row ['field_name'] = 'price';
		$str_tables = '';
		for($i = 0; $i < count ( $tablename ); $i ++) {
			if ($i)
				$str_tables .= ',';
			$item = $tablename [$i];
			$str_tables .= $item;
		}
		if ($str_tables)
			$str_tables = ',' . $str_tables . ',';
		$row ['tablenames'] = $str_tables;
		
		
		$record_id = parent::save ( $row );
		return $record_id;
	}
}
?>