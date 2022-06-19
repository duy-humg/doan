<?php

class NewsModelsCat extends FSModels {

    function __construct() {
        parent::__construct();
        global $module_config;
        $limit = '';
        FSFactory::include_class('parameters');
        if (!empty($module_config->params)) {
            $current_parameters = new Parameters($module_config->params);
            $limit = $current_parameters->getParams('limit');
        }

        $this->limit = $limit ? $limit : 11;
        //$this->limit = 10;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name = $fs_table->getTable('fs_news');
        $this->table_cat = $fs_table->getTable('fs_news_categories');
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
						  WHERE ( category_id = ' . $cid . ' 
						  	OR category_id_wrapper like "%,' . $cid . ',%" )
						  	AND published = 1
						  	' . $where .
                ' ORDER BY ' . $order . '  created_time DESC,ordering DESC
						 ';
//        print_r($query);
        return $query;
    }

    /*
     * get Category current
     * By Id or By code
     */

    function getCategory() {
        $fs_table = FSFactory::getClass('fstable');
        $code = FSInput::get('ccode');
        if ($code) {
            $where = " AND alias = '$code' ";
        } else {
            $id = FSInput::get('id', 0, 'int');
            if (!$id)
                die('Not exist this url');
            $where = " AND id = '$id' ";
        }
        $query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description
						FROM " . $fs_table->getTable('fs_news_categories') . " 
						WHERE published = 1 " . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getNewsList($query_body) {
        if (!$query_body)
            return;
        $this->limit =11;

        global $db;
        $query = " SELECT *";
        $query .= $query_body;

        $pagecurrent = FSInput::get('pagecurrent');
        $pagecurrent++;

        $sql = $db->query_limit($query, $this->limit, $pagecurrent);
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

}

?>