<?php 
	class ProductsModelsChebien extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'chatlieu';
			$this -> table_name = 'fs_products_chebien';
			$this -> table_category = 'fs_products_producer';
			parent::__construct();
		}

        function category()
        {
            $this->table_tienich = 'fs_products_categories';
            global $db;
            $query = " SELECT a.*
						  FROM 
						  	" . $this->table_category . " AS a
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

            $category_id = FSInput::get('category_id');

            $get_name =$this->get_name($category_id);


            $category_name = $get_name->name;
            $row['category_name'] = $category_name;
            $time = date('Y-m-d H:i:s');
            if ($id) {
                $row['updated_time'] = $time;
//            $row['author_last'] = $user->username;
//            $row['author_last_id'] = $user_id;
            } else {
                $row['created_time'] = $time;
                $row['updated_time'] = $time;
            }

            $ord = FSInput::get('ordering', 0, 'int');
            if ($ord) {
                $row['ordering'] = $ord;
            } else {
                $row['ordering'] = 0;
            }




            $id = parent::save($row);



            return $id;

        }

        function get_name($id)
        {
            global $db;
            $fs_table = FSFactory::getClass('fstable');
            $query = "SELECT * FROM " . $fs_table->getTable('fs_products_producer') . "
                                      WHERE 
                                         published = 1 and id = $id
                        ORDER BY id ASC 
                                     ";
            $db->query($query);
            $list = $db->getObject();

            return $list;
        }


    }


	
?>