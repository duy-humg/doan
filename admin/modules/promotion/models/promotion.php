<?php

class PromotionModelsPromotion extends FSModels {

    var $limit;
    var $prefix;

    function __construct() {
        $this->limit = 20;
        $this->view = 'tags';
        $this->table_name = 'fs_promotion';
        $this->table_products = 'fs_products';
        parent::__construct();
    }

    function setQuery() {

        // ordering
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }

        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";


        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.name LIKE '%" . $keysearch . "%' ";
            }
        }

        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " .
                $where .
                $ordering . " ";
        return $query;
    }

    function ajax_get_package_related() {
        $news_id = FSInput::get('new_id', 0, 'int');
        // category_id danh muc
        $category_id = FSInput::get('category_id', 0, 'int');
        // tim kiem keyword
        $keyword = FSInput::get('keyword');
        $keyword_tag = FSInput::get('keyword_tag');
        // chuoi id tin lien quan keyword tag
        $str_related = FSInput::get('str_related');
        // id khi click vao xoa tin lien quan
        $id = FSInput::get('id', 0, 'int');

        $where = ' WHERE published = 1 AND id != ' . $news_id;

        if ($category_id) {
            $where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
        }
        if ($keyword) {
            $where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' OR author_book LIKE '%" . $keyword . "%' OR author_book_alias LIKE '%" . $keyword . "%' )";
        }
        if ($keyword_tag) {
            $keyword_tag = explode(',', $keyword_tag);
            //$keyword_tag = str_replace(',','',$keyword_tag);
            $total = count($keyword_tag);
            $where .= ' AND ( ';
            for ($i = 0; $i < $total; $i++) {
                if ($i == 0) {
                    $where .= " name LIKE '%" . $keyword_tag[$i] . "%' OR alias LIKE '%" . $keyword_tag[$i] . "%' ";
                } else {
                    $where .= " OR name LIKE '%" . $keyword_tag[$i] . "%' OR alias LIKE '%" . $keyword_tag[$i] . "%' ";
                }
            }
            $where .= ' ) ';
        }
        if ($str_related) {
            if ($id) {
                $str_related = str_replace(',' . $id, '', $str_related);
            }
            $where .= ' AND id NOT IN(0' . $str_related . '0) ';
        }

        $query_body = ' FROM ' . $this->table_products . ' ' . $where;
        $ordering = " ORDER BY created_time DESC , id DESC ";
        $query = ' SELECT id,category_id,name,category_name,image' . $query_body . $ordering . ' LIMIT 100 ';
        //print_r($query);
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    
    function get_package_related($package_related){
                if(!$package_related)
                        return;
        $query   = " SELECT id, name,image 
                                FROM ".$this -> table_products."
                                WHERE id IN (0".$package_related."0) 
					 ORDER BY POSITION(','+id+',' IN '0".$package_related."0')
                                ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    function save($row = array(), $use_mysql_real_escape_string = 1) {
        $name = FSInput::get('name');
        if (!$name)
            return false;
  
        //                     related products
        $record_relate = FSInput::get('package_record_related', array(), 'array');
        $row['package_related'] = '';
        if (count($record_relate)) {
            $record_relate = array_unique($record_relate);
            $row['package_related'] = ',' . implode(',', $record_relate) . ',';
        }

        $id = parent::save($row);
        
        return $id;
        
    }

}

?>