<?php

class MainMenuBModelsMainMenu {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_products');
    }

    function getList($group) {
        if (!$group)
            return;
        global $db;

        $fstable = FSFactory:: getClass('fstable');
        $table_name = $fstable->_('fs_menus_items');

        $sql = " SELECT id,image,link, name, level, parent_id as parent_id, 
                            target, description,is_type,is_link,summary,bk_color
					        FROM " . $table_name . "
					        WHERE published  = 1
						    AND group_id = $group 
					        ORDER BY ordering
                    ";

        $db->query($sql);
        $result = $db->getObjectList();
        $tree_class = FSFactory::getClass('tree', 'tree/');
        return $list = $tree_class->indentRows($result, 3);
    }

    function getListmb($group) {
        if (!$group)
            return;
        global $db;

        $fstable = FSFactory:: getClass('fstable');
        $table_name = $fstable->_('fs_menus_items');

        $sql = " SELECT id,image,link, name, level, parent_id as parent_id, 
                            target, description,is_type,is_link,summary,bk_color
					        FROM " . $table_name . "
					        WHERE published  = 1
						    AND group_id = $group AND parent_id=0 
					        ORDER BY ordering
                    ";

        $db->query($sql);
        $result = $db->getObjectList();
        $tree_class = FSFactory::getClass('tree', 'tree/');
        return $list = $tree_class->indentRows($result, 3);
    }

    function list_products_see($id_products) {
        global $db;
        $query = " SELECT id,name,alias, category_id,updated_time ,image,category_alias,created_time,discount,price,price_old
                                FROM " . $this->table_name . "
                                WHERE id IN (0" . $id_products . "0) 
					 ORDER BY created_time DESC, id DESC LIMIT 13
                                ";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    function getfavorite_author() {
        global $db;
        $query = " SELECT *
                                FROM fs_products
                                WHERE  like_author_translate =1
					 ORDER BY ordering DESC ";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    function get_list_quick()
    {
        $query = "SELECT name,alias,id
						  FROM fs_quick_search AS a
						  WHERE published = 1 
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
//


    }
}

?>