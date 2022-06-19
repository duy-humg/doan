
<?php

class Favourite_authorBModelsFavourite_author {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_products_authors');
        $this->table_categories = $fstable->_('fs_news_categories');
//            $this->table_video = $fstable->_('fs_video');
    }

    function setQuery($str_cats, $ordering, $limit, $type) {
        $ccode = FSInput::get('ccode');
        $where = '';
        $order = '';
        //    if($ccode && $type =='highlight'){
        //      $where .= ' AND category_alias_wrapper LIKE "%,'.$ccode.',%" ';  
        //    }	
        if ($str_cats)
            $where .= ' AND category_id_wrapper LIKE "%,' . $str_cats . ',%" ';

        switch ($type) {
            case 'hit_most':
                $limit_day = $limit;
                $where .= '  AND published_time >= DATE_SUB(CURDATE(), INTERVAL ' . $limit_day . ' DAY) ';
                break;
            case 'ramdom':
                $order .= ' RAND(),';
                break;
            case 'newest':
                $where .= '  AND is_new = 1 ';
                break;
            case 'home':
                $where .= '  AND show_in_homepage = 1 ';
                break;
            case 'slideshow':
                $where .= '  AND is_slide = 1 ';
                break;
            case 'new_video':
                $where .= '  AND is_new_video = 1 AND is_video = 0 ';
                break;
            case 'highlight':
                $where .= ' AND is_hot = 1';
                break;
            case 'hits':
                //$where .= '  AND is_view = 1 ';
                $order .= ' hits DESC , ';
                break;
            case 'auto':
                $order .= ' created_time DESC , ';
                break;
        }
        $order .= ' ordering DESC';
        $query = ' SELECT alias,name,id
						  FROM ' . $this->table_name . '
						  WHERE  published = 1 AND  like_author_translate = 1  ' . $where . '
						  ORDER BY  ' . $order . '
						  LIMIT ' . $limit
        ;
        //print_r($query);
        return $query;
    }

    function get_list($str_cats, $ordering, $limit, $type) {
        global $db;
        $query = $this->setQuery($str_cats, $ordering, $limit, $type);
        if (!$query)
            return;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_cats($id) {

        $where = '';
        if ($id) {
            $where .= ' AND id =' . $id;
        }
        global $db;
        $query = ' SELECT id,name, alias, list_parents,image,level,parent_id,icon
					FROM ' . $this->table_categories . ' 
					WHERE published = 1 AND' . $where . '
					ORDER BY ordering
							';
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    
    function get_data($str_cats, $ordering, $limit, $type) {

        $where = '';
        if ($str_cats) {
            $where .= ' AND category_id =' . $str_cats;
        }
        global $db;
        $query = ' SELECT title,alias,image,summary,hits,id,category_alias,is_hot,video,is_video,created_time,icon,content
					FROM ' . $this->table_name . ' 
					WHERE published = 1 ' . $where . ' AND show_in_homepage = 1
					ORDER BY created_time DESC ';
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    function get_data_show_home() {
        global $db;
        $query = ' SELECT title,alias,image,summary,hits,id,category_alias,is_hot,video,is_video,created_time,icon,content
					FROM ' . $this->table_name . ' 
					WHERE published = 1 AND show_in_homepage = 1
					ORDER BY created_time DESC LIMIT 6';
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    function get_author() {
//
//        $where = '';
//        if ($id) {
//            $where .= ' AND id =' . $id;
//        }
        global $db;
        $query = ' SELECT *
					FROM ' . $this->table_name . ' 
					WHERE published = 1 AND  like_author_translate = 1
					ORDER BY ordering
							';
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }
}

?>