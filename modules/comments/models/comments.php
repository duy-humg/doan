<?php

class CommentsModelsComments extends FSModels
{
    function __construct()
    {
        $limit = 20;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->page = $page;
        $this->module = FSInput::get('cmt_module');
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name = $fs_table->getTable('fs_' . $this->module . '_comments');


    }

    function set_query_body()
    {
        $id = FSInput::get('id', 1, 'int');
        $rating_cmt = FSInput::get('rating_cmt');
        $rating_prd = FSInput::get('rating_prd');
//        var_dump($rating_cmt);die;
        $where = '';
        $where1 = '';
        if ($rating_cmt) {
            if ($rating_cmt == 2) {
                $where1 .= ' ORDER BY  created_time  ASC' ;
            } elseif($rating_cmt == 1) {
                $where1 .= ' ORDER BY  created_time  DESC ';
            }
        }
        if ($rating_prd) {
            $where .= ' AND rating=' . $rating_prd;
        }
//        echo $where;
//        die;
        $query = " FROM $this->table_name
						  WHERE  record_id = $id 
								AND published = 1 AND parent_id = 0 " . $where . $where1;
        //print_r($query);
        return $query;
    }

    function get_list($query_body)
    {
        if (!$query_body)
            return;
        $this->page = FSInput::get('page');
        $query_select = 'SELECT name,created_time,id,email,comment,parent_id,level,record_id,admin_reply,rating,useful,report,title ';
        $query = $query_select;
        $query .= $query_body;
//        echo $query;die;
        global $db;
        $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();
        return $result;
    }

    function getTotal($query_body)
    {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total)
    {
        FSFactory::include_class('AjaxPagination');
        $pagination = new AjaxPagination($this->limit, $this->page, $total);
        return $pagination;

    }

    function get_comments_child($parent_id)
    {
        global $db;
        if (!$parent_id)
            return;
        $query = " SELECT name,created_time,id,email,comment,parent_id,level,record_id,admin_reply,rating,useful,report
							FROM $this->table_name
							WHERE parent_id = $parent_id 
								AND published = 1 
							ORDER BY  created_time  DESC
							";
        $db->query($query);
        $result = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
}

?>