<?php 
	class ProductsModelsOrigin extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_origin';
			parent::__construct();
		}
		

		
	}
	
?>