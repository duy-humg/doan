
<?php 
	class HomeModelsSearch extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
                    parent::__construct();
    		global $module_config;
			$limit = 13;
			$this->limit = $limit;
		}
		
		
		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */
        function get_list($cat_id){
            if (!$cat_id)
                die;
            global $db;
            $limit = 6;
//            $id = FSInput::get2('id', 0, 'int');
            $query = ' SELECT id,name,alias, category_id,updated_time ,image,category_alias,created_time,discount,price,price_old,author_book, is_hot,unit
						FROM fs_products
						WHERE  category_id_wrapper LIKE "%' . $cat_id . '%" 
							AND published = 1 
						ORDER BY  ordering ASC
						LIMIT ' . $limit;
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
        function get_ajax_loadmore()
        {
            global $db;
            $fs_table = FSFactory::getClass('fstable');

            $pagecurrent = FSInput::get('pagecurrent');
            $limit = FSInput::get('limit');
//            $type_id = FSInput::get('type_id');
            $total_old = $pagecurrent * $limit;

            $gt = $total_old . ',' . $limit;

            $sql_where = '';
//            if ($type_id)
//                $sql_where .= ' AND type_id=' . $type_id;

            $query = '  SELECT *
	                        FROM ' . $fs_table->getTable('fs_products_categories') .'
	                        WHERE published = 1 AND parent_id = 0 ' . $sql_where . '
	                        ORDER BY ordering ASC 
	                        LIMIT ' . $gt;
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }

        function category_dm()
        {
            global $db;
            $query = " SELECT *
					FROM fs_products_categories
					WHERE
						published = 1 and level = 0
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function category_dm_2($id)
        {
            global $db;
            $query = " SELECT *
					FROM fs_products_categories
					WHERE
						published = 1 and parent_id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function menuchebien()
        {
            global $db;
            $query = " SELECT id,name
					FROM fs_products_chebien
					WHERE
						published = 1
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function khoanggia()
        {
            global $db;
            $query = " SELECT id,name
					FROM fs_quick_search
					WHERE
						published = 1
					 ORDER BY  id ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function banners()
        {
            global $db;
            $query = " SELECT id,image
					FROM fs_slideshow
					WHERE
						published = 1 and category_id = 1
					 ORDER BY  id ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function tienich()
        {
            global $db;
            $query = " SELECT id,name,image,content
					FROM fs_products_tienich
					WHERE
						published = 1 
					 ORDER BY  ordering ASC
					 LIMIT 4
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function nhomhang()
        {
            global $db;
            $query = " SELECT id,name,image
					FROM fs_products_categories
					WHERE
						published = 1 and level = 1 and is_hot = 1
					 ORDER BY  ordering ASC
					 LIMIT 9
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function danhmuc()
        {
            global $db;
            $query = " SELECT id,name,image
					FROM fs_products_categories
					WHERE
						published = 1 and level = 0 
					 ORDER BY  ordering DESC
			
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function danhmuc2($i)
        {
            global $db;
            $query = " SELECT id,name,image
					FROM fs_products_categories
					WHERE
						published = 1 and level = 1 and parent_id = $i
					 ORDER BY  ordering DESC
					 LIMIT 5
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function sanpham($i)
        {
            global $db;
            $query = " SELECT *
					FROM fs_products
					WHERE
						published = 1 and category_id_wrapper like '%$i%'
					 ORDER BY  id DESC
					 LIMIT 6
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
	}
	
?>