<?php 
	class ProductsModelsSize extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_size';
			parent::__construct();
		}
		

		
	}
	
?>