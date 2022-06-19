<?php 
	class ProductsModelsColor extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_color';
			parent::__construct();
		}
		

		
	}
	
?>