<?php

class UsersModelsLevel extends FSModels {

    function __construct() {
        parent::__construct();
        $this->limit = 20;
    }


    function set_query_body() {
        global $db, $user;
        $user_id = $_SESSION['user_id'];
        $where = ' user_id = '.$user_id;
        $order = '';


        $query = ' FROM fs_order
                  WHERE' . $where .
                ' ORDER BY ' . $order . '  id  ';
//        print_r($query);             
        return $query;
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

}

?>