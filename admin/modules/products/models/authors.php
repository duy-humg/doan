<?php 
	class ProductsModelsAuthors extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'authors';
			$this -> table_name = 'fs_products_authors';
                        $this -> arr_img_paths = array(array('resized',100,100,'resize_image'),array('small',98,150,'resize_image'));
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/products/author/'.$cyear.'/'.$cmonth;
			$this -> field_img = 'image';
			parent::__construct();
		}
		

		
	}
	
?>