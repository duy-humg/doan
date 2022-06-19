<?php 
	class ProductsModelsQuick_search extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_quick_search';
			parent::__construct();
		}
		

		
	}
	
?>