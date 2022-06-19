<?php 
	class ProductsModelsTienich extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'producer';
			$this -> table_name = 'fs_products_tienich';
            $this->arr_img_paths = array(
                array('large', 32, 32, 'resize_image'),
                array('resized', 32, "", 'resize_image'),
                array('small', 32, 32, 'cut_image')
            );

			parent::__construct();
		}

        function get_tienich()
        {
            $this->table_tienich = 'fs_tienich_categories';
            global $db;
            $query = " SELECT a.*
						  FROM 
						  	" . $this->table_tienich . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }

        function save($row = array(), $use_mysql_real_escape_string = 1)
        {
            $name = FSInput::get('name');
            if (!$name)
                return false;

            $id = FSInput::get('id', 0, 'int');
            $image_name_icon = $_FILES["icon"]["name"];
            if($image_name_icon){
                $image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
                if($image_icon){
                    $row['icon'] = $image_icon;
                }
            }


            $id = parent::save($row);

            return $id;

        }
		

		
	}
	
?>