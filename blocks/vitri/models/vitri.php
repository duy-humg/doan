<?php 
	class VitriBModelsVitri
	{
		function __construct()
		{
            $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_('fs_partners');
            $this->table_add = $fstable->_('fs_address');
		}

        function get_huyen()
        {
            $id = $_SESSION['id_huyen'];
            global $db;
            $query = " SELECT *
					FROM fs_districts
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObject();
            return $list;
        }

        function list_xa()
        {
            $id = $_SESSION['id_huyen'];
            global $db;
            $query = " SELECT *
					FROM fs_wards
					WHERE
						published = 1 and districts_id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }


        function city()
        {
            global $db;
            $query = " SELECT *
					FROM fs_cities
					WHERE
						published = 1 and (id =1 or id = 79 or id = 31)
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function list_huyen()
        {
            $id = $_SESSION['id_city'];
            global $db;
            $query = " SELECT *
					FROM fs_districts
					WHERE
						published = 1 and city_id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

        function get_city()
        {
            $id = $_SESSION['id_city'];
            global $db;
            $query = " SELECT *
					FROM fs_cities
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
            $db->query($query);
            $list = $db->getObject();
            return $list;
        }


    }
?>