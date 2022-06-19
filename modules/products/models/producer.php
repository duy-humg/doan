<?php

class ProductsModelsProducer extends FSModels {

    function __construct() {
        parent::__construct();
        global $module_config;
        $this->limit =  20;
        //$this->limit = 10;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name = $fs_table->getTable('fs_products');
        $this->table_cat = $fs_table->getTable('fs_products_categories');
        $this->table_company = $fs_table->getTable('fs_products_producer');
    }

    function set_query_body($cid) {
        $date1 = FSInput::get("date_search");
        $where = "";
        $order = '';
        $type = !empty($_SESSION['type']) ? $_SESSION['type'] : '';
        if ($type)
            $order = $type . ' DESC, ';
        //$fs_table = FSFactory::getClass('fstable');
        $query = ' FROM ' . $this->table_name . '
						  WHERE producer_id = ' . $cid . '
						  	AND published = 1
						  	' . $where .
                ' ORDER BY ' . $order . '  created_time DESC,ordering DESC
						 ';
        //print_r($query);             
        return $query;
    }

    /*
     * get Category current
     * By Id or By code
     */

    function getproducer() {

        $query = " SELECT id,name, alias,seo_title,seo_keyword,seo_description
						FROM " . $this->table_company . " 
						WHERE published = 1 ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getProductsList($query_body) {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id,name,summary,image, created_time,category_id, category_alias, alias, price, price_old, discount";
        $query .= $query_body;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();

        return $result;
    }

    function getTotal($query_body) {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total) {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }
    
    function getListProducer() {
        $code = FSInput::get('code');
        if ($code) {
            $where = " AND alias = '$code' ";
        } else {
            $id = FSInput::get('id', 0, 'int');
            if (!$id)
                die('Not exist this url');
            $where = " AND id = '$id' ";
        }
        $query = " SELECT id,name, alias,seo_title,seo_keyword,seo_description
						FROM " . $this->table_company . " 
						WHERE published = 1 " . $where . "";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    
        function getListCategory() {
        $where = "";
        $query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description
						FROM " . $this->table_cat . " 
						WHERE published = 1 " . $where ." LIMIT 15";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree_class  = FSFactory::getClass('tree','tree/');
        return $list = $tree_class -> indentRows($result,3);
    }
    
    function count_total($cat_id) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name . "
					WHERE  published = 1 AND company_ex_id = " . $cat_id ;
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }

}

?>