<?php 
	class DiscountBModelsDiscount
	{
		function __construct()
		{
            $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_('fs_partners');
            $this->table_add = $fstable->_('fs_address');
		}


        function category_dm()
        {
            global $db;
            $query = " SELECT *
					FROM fs_products_categories
					WHERE
						published = 1 and level = 0
					 ORDER BY  ordering ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function menuchamsoc()
        {
            global $db;
            $query = " SELECT *
					FROM fs_menus_items
					WHERE
						published = 1 and group_id = 2
					 ORDER BY  ordering ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function menufooter()
        {
            global $db;
            $query = " SELECT *
					FROM fs_menus_items
					WHERE
						published = 1 and group_id = 7
					 ORDER BY  ordering ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function menufooter_mobile()
        {
            global $db;
            $query = " SELECT *
					FROM fs_menus_items
					WHERE
						published = 1 and group_id = 14
					 ORDER BY  ordering ASC LIMIT 4
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function list_news()
        {
            global $db;
            $query = " SELECT *
					FROM fs_news
					WHERE
						published = 1
					 ORDER BY  hits DESC LIMIT 4
							";
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function list_news_dm()
        {
            global $db;
            $query = " SELECT *
					FROM fs_products_categories
					WHERE
						published = 1 
					 ORDER BY  ordering ASC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function get_id_dm($id)
        {
            global $db;
            $query = " SELECT *
					FROM fs_products_categories
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObject();
            return $list;
        }

        function get_name_news($id)
        {
            global $db;
            $query = " SELECT *
					FROM fs_news
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObject();
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
		
		function get_data($id){
			$where = "";
			if($id)
				$where = "AND id = ".$id."";
			$query = " SELECT *
					  FROM fs_discount
					  WHERE published = 1
					  ".$where." AND total < `limit`
					  ORDER BY id
					 ";
			global $db;
			$sql = $db->query($query);
			return  $db->getObject();
		}
        //  tỉnh thành
        function get_city_list()
        {
            $query = ' SELECT * FROM fs_local_cities WHERE published = 1 ';
            global $db;
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }


        function fs_partners()
        {
            $query = ' SELECT * FROM '.$this->table_name.' WHERE published = 1 '; // viết câu lệnh sql vừa gọi được ở navicat vào đây
            global $db; // đây là câu lệnh gọi kết nối với sql
            $sql = $db->query($query); // truyền câu query vừa khai báo đi
            $list = $db->getObjectList(); // kết quả trả về của query trên
            return $list; // trả về kêt quả
        }

        //
        function get_products()
        {
            $query = ' SELECT id,name,alias,image,summary
                        FROM fs_products 
                        WHERE published = 1 ';
            global $db;
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

    }
?>