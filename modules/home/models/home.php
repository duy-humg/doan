
<?php 
	class HomeModelsHome extends FSModels
	{
		/*
		 * select cat list is children of catid
		 */
		function __construct()
		{
            parent::__construct();
            global $module_config;
            $fstable = FSFactory::getClass('fstable');
            $this->limit =20;
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
            $query = " SELECT id,image,name,category,icon
					FROM fs_products_tienich
					WHERE
						published = 1 and category = 1927
					 ORDER BY  id ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

//        function list_sp()
//        {
//            global $db;
//            $query = " SELECT *
//					FROM fs_products
//					WHERE
//						published = 1
//					 ORDER BY  id DESC
//							";
//            $db->query($query);
//            $list = $db->getObjectList();
//            return $list;
//        }

    function set_query_body()
    {
//            var_dump($this->table_hv);
        $date1 = FSInput::get("date_search");
        $where = "";
        $fs_table = FSFactory::getClass('fstable');
        $query = " FROM " . $fs_table->getTable('fs_products') . "
                          WHERE 
                             published = 1
                            " . $where .
            " ORDER BY  ordering DESC,created_time DESC, id DESC 
                         ";
//            echo $query;die;
        return $query;
    }
    function get_list($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT *";
        $query .= $query_body;
//        echo $query;
        $pagecurrent = FSInput::get('pagecurrent');
        $pagecurrent++;

        $sql = $db->query_limit($query, $this->limit, $pagecurrent);

        $result = $db->getObjectList();
        return $result;
    }
        function combo()
        {
            global $db;
            $query = " SELECT *
					FROM fs_combo
					WHERE
						published = 1 
					 ORDER BY  id DESC
					
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
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
	}
	
?>