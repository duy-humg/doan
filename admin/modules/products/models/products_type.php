<?php 
	class ProductsModelsProducts_type extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_type';
			parent::__construct();
		}
		

		
	}
	
?>