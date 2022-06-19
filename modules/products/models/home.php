<?php

class ProductsModelsHome extends FSModels {

    function __construct() {
        parent::__construct();
        global $module_config;
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_products');
        $this->table_category = $fstable->_('fs_products_categories');
        $this->table_company = $fstable->_('fs_products_companys');
        $this->table_price = $fstable->_('fs_products_prices');
        $this->table_tags= $fstable->_('fs_tags');
        $this->limit = 20;
    }

    function banners()
    {
        global $db;
        $query = " SELECT id,image
					FROM fs_slideshow
					WHERE
						published = 1 and category_id = 3
					 ORDER BY  id ASC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function dm()
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_categories
					WHERE
						published = 1 and level = 0
					 ORDER BY  id ASC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function thuonghieu()
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_chebien
					WHERE
						published = 1 and category_id = 292
					 ORDER BY  id ASC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }
    function nguoidung()
        {
            global $db;
            $query = " SELECT *
                        FROM fs_products_chebien
                        WHERE
                            published = 1 and category_id = 293
                         ORDER BY  id ASC
                                ";
    //            var_dump($query);
            $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

    function list_price()
    {
        global $db;
        $query = " SELECT *
                        FROM fs_quick_search
                        WHERE
                            published = 1 
                         ORDER BY  id ASC
                                ";
        //            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function get_price($id)
    {
        global $db;
        $query = " SELECT *
                        FROM fs_quick_search
                        WHERE
                            published = 1 and id = $id
                         ORDER BY  id ASC
                                ";
        //            var_dump($query);
        $db->query($query);
        $list = $db->getObject();
        return $list;
    }

    /*
     * select cat list is children of catid
     */

    function set_query_body() {

        $sort = FSInput::get('sapxep');
        if($sort){
            $sapxep = explode(':', $sort);
        }else{
            $sapxep[0] = '';
        }
        switch ($sapxep[0]) {

            case '3' :
                $query_ordering = ' ABS(daban) DESC';
                break;
            case '2' :
                $query_ordering = ' id DESC';
                break;
            case '1' :
                $query_ordering = ' hits DESC';
                break;
            default:
                $query_ordering = ' id DESC ';
                break;
        }




        $prices = FSInput::get('price');
        if($prices){
            $khoanggia = explode(':', $prices);
        }else{
            $khoanggia[0] = '';
        }
        $where = "";

        if($khoanggia[0]){
            $get_kg = $this->get_price($khoanggia[0]);
            $money_1 = $get_kg->money_1;
            $money_2 = $get_kg->money_2;
            if($get_kg->id==28 or $get_kg->id==29){
                if($get_kg->id==28){
                    $query_ordering = ' price ASC ';
                }else{
                    $query_ordering = ' price DESC ';
                }
               
               
            }else{
                $where .= " AND price >= $money_1 and price <= $money_2 ";
            }
           
        }


        $thuonghieu = FSInput::get('thuonghieu');
        if ($thuonghieu) {
            $ob = explode(':', $thuonghieu);
            $where .= " AND extend LIKE '%," . $ob[0] . "%' ";
        }

        $nguoidung = FSInput::get('nguoidung');
        if ($nguoidung) {
            $ob_n = explode(':', $nguoidung);
            $where .= " AND extend LIKE '%," . $ob_n[0] . "%' ";
        }

        $query = " FROM " . $this->table_name . "
						  WHERE 
						  	 published = 1
						  	" . $where .
                " ORDER BY  ".$query_ordering;

    //    var_dump($query);

        return $query;
    }

    function get_list($query_body) {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id,name,summary,image,daban, created_time,category_id, category_alias, alias, price, price_old, discount";
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
    
    function getListTags() {
        $where = "";
        $query = " SELECT *
						FROM " . $this->table_tags . " 
						WHERE published = 1 " . $where."";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    function getListCompany() {
        $where = "";
        $query = " SELECT id,name, alias,seo_title,seo_keyword,seo_description
						FROM " . $this->table_company . " 
						WHERE published = 1 " . $where . " LIMIT 5";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    
    function count_total() {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name . "
					WHERE  published = 1 ";
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }
    
    function getListPrice() {
        $query = " SELECT *
						FROM " . $this->table_price . " 
						WHERE published = 1 ORDER BY id ASC ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    function get_about_price($alias) {
        $query = " SELECT *
						FROM " . $this->table_price . " 
						WHERE published = 1 AND alias = '".$alias."' ORDER BY id ASC  ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }


}

?>