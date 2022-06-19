<?php

class Product_menuBModelsProduct_menu
{
    function __construct()
    {
    }

    function getListCat($str_cats)
    {
        $where = '';
        if ($str_cats)
            $where .= ' AND list_parents LIKE "%,' . $str_cats . ',%" ';
        $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,image,show_in_homepage,icon
						  FROM fs_products_categories AS a
						  WHERE published = 1 " . $where . " 
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $category_list = $db->getObjectList();

        if (!$category_list)
            return;
        $tree_class = FSFactory::getClass('tree', 'tree/');
        return $list = $tree_class->indentRows2($category_list, 3);
//			return $list = $tree_class -> indentRows($category_list,3);


    }

    function getListCat_hot()
    {
        $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,image,show_in_homepage,icon
						  FROM fs_products_categories AS a
						  WHERE published = 1 AND parent_id = 0 AND is_hot = 1 
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
//


    }

    function getListCat_level1($cat_id)

    {
//        var_dump($cat_id);
        $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,image,show_in_homepage,icon
						  FROM fs_products_categories AS a
						  WHERE published = 1 AND parent_id = ".$cat_id."
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
//


    }

    function getListCat_other()
    {
        $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,image,show_in_homepage,icon
						  FROM fs_products_categories AS a
						  WHERE published = 1 AND parent_id = 0 
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
//


    }

    function getListCat_age()
    {
        $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,image,show_in_homepage,icon
						  FROM fs_products_categories AS a
						  WHERE published = 1 AND is_age = 1 
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
//


    }

    function getListCat_all()
    {
        $query = "SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,image,show_in_homepage,icon
						  FROM fs_products_categories AS a
						  WHERE published = 1 AND parent_id = 0  
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
//


    }

    function getListCat_favourite()
    {
        $query = "SELECT name,alias,id
						  FROM fs_products_authors
						  WHERE published = 1 AND like_author_translate = 1  
						  ORDER BY ordering DESC, id DESC
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