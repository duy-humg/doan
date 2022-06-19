<?php

class UsersModelsOrder extends FSModels {

    function __construct() {
        parent::__construct();
        $this->limit = 3;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_order = $fs_table->getTable('fs_order');
        $this->table_order_item = $fs_table->getTable('fs_order_items');
        $this->table_products = $fs_table->getTable('fs_products');
    }


    function set_query_body() {
        global $db, $user;
        $user_id = $_SESSION['user_id'];
        $where = ' user_id = '.$user_id;
        $order = '';


        $query = ' FROM fs_order
                  WHERE' . $where .
                ' ORDER BY ' . $order . '  id DESC ';
//        print_r($query);             
        return $query;
    }

    function get_shop($id)
    {
        $this->table_sp = 'fs_products_shop';
        $query = " SELECT *
						FROM " . $this->table_sp . " 
						WHERE published = 1 and id = $id ORDER BY id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function sp($id)
    {
        $this->table_sp = 'fs_products';
        $query = " SELECT *
						FROM " . $this->table_sp . " 
						WHERE published = 1 and id = $id ORDER BY id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function sp_sub($id)
    {
        $this->table_sp = 'fs_products_sub';
        $query = " SELECT *
						FROM " . $this->table_sp . " 
						WHERE published = 1 and id = $id ORDER BY id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function list_sp($id)
    {
        $this->table_sp = 'fs_order_items';
        $query = " SELECT *
						FROM " . $this->table_sp . " 
						WHERE order_id = $id ORDER BY id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
   
    function get_list($query_body) {
    
        if (!$query_body)
            return;

        global $db;
        $query = "SELECT *";
        $query .= $query_body; // echo $query;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
       
        return $result;
    }
  
    function getMember() {
        global $db;
        $user_id = $_SESSION['user_id'];
        $sql = " SELECT * 
					FROM fs_members
					WHERE id  = $user_id ";
        $db->query($sql);
        return $db->getObject();
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
    
    function get_order_id($id) {
       $query = " SELECT a.*,b.name as product_name, b.alias as product_alias,b.category_alias, b.image as image,b.id as product_id
					FROM ".$this->table_order_item." AS a
					INNER JOIN ".$this->table_products." AS b on a.product_id = b.id 
						WHERE a.order_id = ".$id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    
    function get_order() {
        
        $id = FSInput::get('id');
//        var_dump($id);
        $query = " SELECT *
					FROM ".$this->table_order." 
						WHERE id = ".$id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

}

?>