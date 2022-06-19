<?php 
	class Services_menuBModelsServices_menu
	{
		function __construct()
		{
		    $this -> table_name = FSTable::_('fs_services');
            $this -> table_name_categories = FSTable::_('fs_products_categories');
		}
		function getListCat($str_cats,$level){
            $where = '';
            if($str_cats){
                $pa=$this->getParentId($str_cats);
//                var_dump($pa);
//                $where .= ' AND ((  level='.++$level.' AND list_parents LIKE "%,'.$str_cats.',%" ) OR (level='.--$level.' AND list_parents LIKE "%,'.$pa.',%" )) AND id!='.$str_cats.' ';
                $where .= ' AND   level='.++$level.' AND list_parents LIKE "%,'.$str_cats.',%"  AND id!='.$str_cats.' ';
            }
             $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents
						  FROM ".$this -> table_name_categories." AS a
						  WHERE published = 1 ".$where." 
						  ORDER BY level desc, ordering ASC, id ASC
						 ";
//            $query2="SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents
//						  FROM ".$this -> table_name_categories." AS a
//						  WHERE published = 1 AND id= ".$str_cats;
			global $db;
			$category_list = $db->getObjectList($query);
//			$category = $db->getObjectList($query2);
//            echo '<pre>';
//            var_dump($category_list);
//            die();
            return array_merge($category_list);
			if(!$category_list)
				return;
			$tree_class  = FSFactory::getClass('tree','tree/');
			return $list = $tree_class -> indentRows( array_merge($category,$category_list));
				
		}

		function getCat($str_cats){
            $where = '';
            if($str_cats)
                $where .= ' AND id = "'.$str_cats.'" ';
            $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents
						  FROM ".$this -> table_name_categories." AS a
						  WHERE published = 1 ".$where." 
						  ORDER BY ordering ASC, id ASC
						 ";
            global $db;
            $db->query($query);
            $result = $db->getObject();
            return $result;
        }

		function getParentId($str_cats){
            $where = '';
            if($str_cats)
                $where .= ' AND id = "'.$str_cats.'" ';
            $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents
						  FROM ".$this -> table_name_categories." AS a
						  WHERE published = 1 ".$where." 
						  ORDER BY ordering ASC, id ASC
						 ";
            global $db;
            $db->query($query);
            $result = $db->getObject();
            return $result->parent_id;
        }

		
        function getListProduct()
        {
			$query = "SELECT *
						  FROM ".$this -> table_name." AS a
						  WHERE published = 1
						  ORDER BY ordering ASC, id ASC
						 ";
			global $db;
			$db->query($query);
			$product_list = $db->getObjectList();

				
		}

	}
?>