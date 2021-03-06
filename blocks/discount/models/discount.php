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
        //  t???nh th??nh
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
            $query = ' SELECT * FROM '.$this->table_name.' WHERE published = 1 '; // vi???t c??u l???nh sql v???a g???i ???????c ??? navicat v??o ????y
            global $db; // ????y l?? c??u l???nh g???i k???t n???i v???i sql
            $sql = $db->query($query); // truy???n c??u query v???a khai b??o ??i
            $list = $db->getObjectList(); // k???t qu??? tr??? v??? c???a query tr??n
            return $list; // tr??? v??? k??t qu???
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