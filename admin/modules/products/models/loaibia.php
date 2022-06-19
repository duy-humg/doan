<?php 
	class ProductsModelsLoaibia extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_loai_bia';
			parent::__construct();
		}
		

		
	}
	
?>