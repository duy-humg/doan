<?php 
	class ProductsModelsLoai extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_type';
			parent::__construct();
		}


        function get_dm()
        {
            $this->table_tienich = 'fs_products_categories';
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

            $author_book_id = FSInput::get('category_id', 0, 'int');
            $author_book_id = FSInput::get('category_id', array(), 'array');
            $str_author_book_id = implode(',', $author_book_id);
            $row ['category_id'] = ',' . $str_author_book_id . ',';


            $id = parent::save($row);

            return $id;

        }

		
	}
	
?>