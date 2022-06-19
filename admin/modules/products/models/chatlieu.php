<?php 
	class ProductsModelsChatlieu extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'chatlieu';
			$this -> table_name = 'fs_products_chatlieu';
			parent::__construct();
		}
		

		
	}
	
?>