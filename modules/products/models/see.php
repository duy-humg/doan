<?php

class ProductsModelsSee extends FSModels {

    function __construct() {
        parent::__construct();
        global $module_config;
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_products');
        $this->limit = 20;
    }

    /*
     * select cat list is children of catid
     */

    function set_query_body($id_products) {
        

        $where = " AND id IN (0" . $id_products . "0)";
        $query = " FROM " . $this->table_name . "
						  WHERE 
						  	 published = 1
						  	" . $where .
                " ORDER BY created_time DESC, id DESC ";

        return $query;
    }

    function get_list($query_body) {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id,name,summary,image, created_time,category_id, category_alias, alias, price, price_old, discount";
        $query .= $query_body;
        //print_r($query); 
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }

    /*
     * return products list in category list.
     * These categories is Children of category_current
     */

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