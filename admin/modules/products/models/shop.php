<?php 
	class ProductsModelsShop extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'producer';
			$this -> table_name = 'fs_products_shop';
            $this->arr_img_paths = array(
                array('large', 80, 80, 'resize_image'),
                array('resized', 80, "", 'resize_image'),
                array('small', 80, 80, 'cut_image')
            );

			parent::__construct();
		}


		

		
	}
	
?>