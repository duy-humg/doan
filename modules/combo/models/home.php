<?php

class ComboModelsHome extends FSModels {

    function __construct() {
        parent::__construct();
        global $module_config;
        FSFactory::include_class('parameters');
        $current_parameters = new Parameters($module_config->params);
        $limit = $current_parameters->getParams('limit');
        $limit = 15;
        $this->limit = $limit;
    }

    /*
     * select cat list is children of catid
     */

    function list_dm()
    {
        global $db;
        $query = " SELECT *
					FROM fs_news_categories
					WHERE
						published = 1
					 ORDER BY  ordering ASC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function list_news($id)
    {
        global $db;
        $query = " SELECT *
					FROM fs_news
					WHERE
						published = 1 and category_id = $id
					 ORDER BY  id ASC LIMIT 6
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function set_query_body() {
        $date1 = FSInput::get("date_search");
        $where = "";
        $fs_table = FSFactory::getClass('fstable');
        $query = " FROM " . $fs_table->getTable('fs_combo') . "
						  WHERE 
						  	 published = 1
						  	" . $where .
                " ORDER BY created_time DESC, id DESC 
						 ";

        return $query;
    }

    function get_list($query_body) {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT *";
        $query .= $query_body;
        //print_r($query); 
        $pagecurrent = FSInput::get('pagecurrent');
        $pagecurrent++;

        $sql = $db->query_limit($query, $this->limit, $pagecurrent);
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

    function getNews($id) {
        if ($id) {
            $where = " id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT id,title,content,category_id,category_alias, summary,hits, video, is_video,
                        alias, tags, created_time, updated_time,seo_title,image,optimal_seo,
                        seo_keyword,seo_description,news_related,author_id,products_related
						FROM " . $fs_table->getTable('fs_news') . " 
						WHERE
						" . $where . " ";
        //print_r($query) ;   
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function banners()
    {
        global $db;
        $query = " SELECT id,image
					FROM fs_slideshow
					WHERE
						published = 1 and category_id = 2
					 ORDER BY  id ASC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

}

?>