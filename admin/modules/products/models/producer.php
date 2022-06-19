<?php 
	class ProductsModelsProducer extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'producer';
			$this -> table_name = 'fs_products_producer';
			parent::__construct();
		}
		

		
	}
	
?>