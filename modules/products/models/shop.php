<?php

class ProductsModelsShop extends FSModels
{

    function __construct()
    {
        parent::__construct();
        global $module_config;

//        $current_parameters = new Parameters ($module_config->params);
//        var_dump($current_parameters);die;
//        $limit = $current_parameters->getParams('limit');
        //$limit_ = FSInput::get('limit',0,'int')
//        $this->limit = !empty($limit) ? $limit : 30;
//        $this->limit = 30;
        $this->limit = 20;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name = $fs_table->getTable('fs_products');
        $this->table_cat = $fs_table->getTable('fs_products_shop');
        $this->table_company = $fs_table->getTable('fs_products_companys');
        $this->table_price = $fs_table->getTable('fs_products_prices');
        $this->table_object = $fs_table->getTable('fs_products_object');
        $this->table_color = $fs_table->getTable('fs_products_color');
        $this->table_origin = $fs_table->getTable('fs_products_origin');
        $this->table_producer = $fs_table->getTable('fs_products_producer');
        $this->table_author = $fs_table->getTable('fs_products_authors');
        $this->table_tags = $fs_table->getTable('fs_tags');
    }

    function dm($id)
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_shop
					WHERE
						published = 1  and id = $id
					 ORDER BY  id ASC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function dm_0()
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

    function list_bl()
    {
        global $db;
        $query = " SELECT *
					FROM fs_sp_properties_ds
					WHERE
						published = 1 
					 ORDER BY  id ASC
							";
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }
    function list_nd_bl($id){
        global $db;
        $query = " SELECT *
					FROM fs_products_chebien
					WHERE
						published = 1 and category_id = $id
					 ORDER BY  id ASC
							";
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

    function getshop()
    {
        $id = FSInput::get('cid');
        global $db;
        $query = " SELECT *
					FROM fs_products_shop
					WHERE
						published = 1 and id = $id
					 
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObject();
        return $list;
    }
    function listsp_shop()
    {
        $id_shop = FSInput::get('cid');
        global $db;
        $query = " SELECT *
					FROM fs_products
					WHERE
						published = 1 and id_shop = $id_shop 
					 ORDER BY  id DESC
					
							";
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function set_query_body($cid, $type_level = '')
    {

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

        $category = FSInput::get('category');
        if ($category) {
            $ob = explode(':', $category);
            $where .= " AND category_id = $ob[0]";
        }




        $query = ' FROM ' . $this->table_name . '
						  WHERE ( category_id = ' . $cid . ' 
						  	OR category_id_wrapper like "%,' . $cid . ',%" )
						  	AND published = 1
						  	' . $where .
            ' ORDER BY ' . $query_ordering ;

//        var_dump($query);

        return $query;
    }

    function set_query_body1($cid, $type_level = '')
    {

        $sort = FSInput::get('sapxep');
        if($sort){
            $sapxep = explode(':', $sort);
        }else{
            $sapxep[0] = '';
        }
        switch ($sapxep[0]) {

            case '3' :
                $query_ordering = ' daban DESC';
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
            $where .= " AND price >= $money_1 and price <= $money_2 ";
        }

        $category = FSInput::get('category');
        if ($category) {
            $ob = explode(':', $category);
            $where .= " AND category_id = $ob[0]";
        }

        $query = ' FROM ' . $this->table_name . '
						  WHERE id_shop = ' . $cid . ' 
						  	
						  	AND published = 1
						  	' . $where .
            ' ORDER BY ' . $query_ordering;
//        echo $query;

        return $query;
    }

    /*
     * get Category current
     * By Id or By code
     */
    function get_category_by_id($category_id)
    {
        if (!$category_id)
            return "";
        $query = " SELECT id,name,alias
						FROM " . $this->table_cat . "  
						WHERE id = $category_id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getCategory()
    {
        $code = FSInput::get('ccode');
        if ($code) {
            $where = " AND alias = '$code' ";
        } else {
            $id = FSInput::get('id', 0, 'int');
            if (!$id)
                die('Not exist this url');
            $where = " AND id = '$id' ";
        }
        $id = FSInput::get('cid', 0, 'int');
        if (!$id)
            die('Not exist this url');
//        $query = " SELECT id,name, icon,image, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,not_book,list_parents,level
//						FROM " . $this->table_cat . "
//						WHERE published = 1 " . $where;

        $query = " SELECT id,name, icon,image, alias,content
						FROM " . $this->table_cat . " 
						WHERE published = 1 " . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_name_cat($id)
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_shop
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObject();
        return $list;
    }

    function set_query_body_hang()
    {

        $where = "";
        $fs_table = FSFactory::getClass('fstable');
        $query = " FROM " . $fs_table->getTable('fs_products_producer') . "
                          WHERE 
                             published = 1
                            " . $where .
            " ORDER BY  id DESC 
                         ";
        return $query;
    }

    function get_list_hang($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT *";
        $query .= $query_body;
        $this->limit = 100;
//        echo $query;
        $pagecurrent = FSInput::get('pagecurrent');
        $pagecurrent++;

        $sql = $db->query_limit($query, $this->limit, $pagecurrent);

        $result = $db->getObjectList();
        return $result;
    }

    function type($id)
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_type
					WHERE
						published = 1 and category_id like '%$id%'
					 ORDER BY  ordering ASC
							";

        $db->query($query);

        $list = $db->getObjectList();
        return $list;
    }

    function gethang($id)
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_producer
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";

        $db->query($query);

        $list = $db->getObject();
        return $list;
    }

    function gettype($id)
    {
        global $db;
        $query = " SELECT *
					FROM fs_products_type
					WHERE
						published = 1 and id = $id
					 ORDER BY  id DESC
							";

        $db->query($query);

        $list = $db->getObject();
        return $list;
    }


    function getProductsList($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id,name,summary,image, created_time,category_id, category_alias, alias, price, price_old, discount, quantity,author_book, rating_count";
        $query .= $query_body;
//        echo $query;
//            $sql = $db->query_limit($query, $this->limit, $this->page);
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    function getProductsList_child($cid)
    {
        if (!$cid)
            return;

        global $db;
        $query = ' SELECT id FROM fs_products WHERE ( category_id = ' . $cid . ' 
						  	OR category_id_wrapper like "%,' . $cid . ',%" )
						  	AND published = 1 ';

//        echo $query;
//            $sql = $db->query_limit($query, $this->limit, $this->page);
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    function getProductsList_childbyprice($price)
    {
        $cid = FSInput::get('cid');
        if (!$cid || !$price)
            return;
        $where = "";
//        if ($prices) {
            $fillter_price = $this->get_about_price($price);
//            var_dump($fillter_price);
            if ($fillter_price) {
                $operator = $fillter_price->operator;
                $begin_price = $fillter_price->start;
                $end_price = $fillter_price->end;
                $where .= ' AND ';
                if ($operator == 5) {
                    $where .= 'price = ' . $begin_price;
                } else if ($operator == 6) {
                    $where .= $begin_price . ' < price ';
                } else if ($operator == 7) {
                    $where .= 'price < ' . $begin_price;
                } else if ($operator == 8) {
                    $where .= $begin_price . ' >= price';
                } else if ($operator == 9) {
                    $where .= 'price <= ' . $begin_price;
                } else if ($operator == 10) {
                    $where .= $begin_price . ' < price AND price < ' . $end_price;
                } else if ($operator == 11) {
                    $where .= $begin_price . ' < price AND price <= ' . $end_price;
                } else if ($operator == 12) {
                    $where .= $begin_price . ' <= price AND price < ' . $end_price;
                } else if ($operator == 13) {
                    $where .= $begin_price . ' <= price AND price <= ' . $end_price;
                }
            }
//        }
        global $db;
        $query = ' SELECT id FROM fs_products WHERE ( category_id = ' . $cid . ' 
						  	OR category_id_wrapper like "%,' . $cid . ',%" )
						  	AND published = 1 '. $where;
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    function getProductsList1($query_body)
    {

        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id,name,summary,image,hang_id, created_time,category_id,giamgia, category_alias, alias, price, price_old, discount, quantity,author_book, rating_count,unit,producer_id";
        $query .= $query_body;
        $this->limit = 20;
        $pagecurrent = FSInput::get('pagecurrent');
        $pagecurrent++;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();

        return $result;
    }
//    function get_cat($pid)
//    {
////        if (!$query_body)
////            return;
//
//        global $db;
//        $query = " SELECT id,name,alias, level FROM  " .$this->table_cat. " WHERE id = " .$pid." ORDER BY  id DESC";
////        echo $query;
////            $sql = $db->query_limit($query, $this->limit, $this->page);
//        $sql = $db->query($query);
//        $result = $db->getObjectList();
//
//        return $result;
//    }
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

    function getPagination_2($total)
    {
        $this->limit = 20;
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }

    function getListCompany()
    {
        $where = "";
        $query = " SELECT id,name, alias,seo_title,seo_keyword,seo_description
						FROM " . $this->table_company . " 
						WHERE published = 1 " . $where . " 
                        order BY name ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getListauthor()
    {
        $where = "";
        $query = " SELECT id,name, alias,seo_title,seo_keyword,seo_description
						FROM " . $this->table_author . " 
						WHERE published = 1 " . $where . " 
                        order BY name ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getListTags()
    {
        $where = "";
        $query = " SELECT *
						FROM " . $this->table_tags . " 
						WHERE published = 1 " . $where . "";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function count_total($cat_id)
    {
        $this->table_name = 'fs_products';
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name . "
					WHERE  published = 1 AND id_shop = $cat_id ";
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }

    function getListPrice()
    {
        $query = " SELECT name,alias,id
						FROM " . $this->table_price . " 
						WHERE published = 1 ORDER BY id ASC ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getPrice($id)
    {
        $query = " SELECT *
						FROM " . $this->table_price . " 
						WHERE published = 1 AND id=" . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getListObject()
    {
        $query = " SELECT *
						FROM " . $this->table_object . " 
						WHERE published = 1 ORDER BY ordering ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getObject($id)
    {
        $query = " SELECT *
						FROM " . $this->table_object . " 
						WHERE published = 1 AND id=" . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getListColor()
    {
        $query = " SELECT *
						FROM " . $this->table_color . " 
						WHERE published = 1 ORDER BY id ASC ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getColor($id)
    {
        $query = " SELECT *
						FROM " . $this->table_color . " 
						WHERE published = 1 AND id=" . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getListOrigin()
    {
        $query = " SELECT *
						FROM " . $this->table_origin . " 
						WHERE published = 1 ORDER BY id ASC ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getOrigin($id)
    {
        $query = " SELECT *
						FROM " . $this->table_origin . " 
						WHERE published = 1 AND id=" . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getCompany($id)
    {
        $query = " SELECT *
						FROM " . $this->table_author . " 
						WHERE published = 1 AND id=" . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getProducer($id)
    {
        $query = " SELECT *
						FROM " . $this->table_producer . " 
						WHERE published = 1 AND id=" . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getListProducer()
    {
        $query = " SELECT *
						FROM " . $this->table_producer . " 
						WHERE published = 1 ORDER BY id ASC ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_about_price($alias)
    {
        $query = " SELECT *
						FROM " . $this->table_price . " 
						WHERE published = 1 AND alias = '" . $alias . "' ORDER BY id ASC  ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }


}

?>