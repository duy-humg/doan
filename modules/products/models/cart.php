<?php

class ProductsModelsCart extends FSModels {

    function __construct() {
        parent::__construct();
        global $module_config;
        $this->limit =  20;
        //$this->limit = 10;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name = $fs_table->getTable('fs_products');
    }

    function getProduct($id_sub) {
//        var_dump($id_sub);
        $where = "";
        if($id_sub){
            $where .= " AND b.id = ".$id_sub ;
        }
        
        
        $query = " SELECT a.id,a.name,a.alias,a.image,a.category_alias,a.category_id,a.price,a.price_old,a.quantity,a.discount,b.color_id,b.color_name, b.size_id, b.size_name, b.id as id_sub, b.price as price_old_sub, b.price_old, b.price_h as price_sub, b.discount as discount_sub, b.quantity as quantity_sub, b.image as image_sub, b.name as name_sub
						 FROM fs_products as a LEFT JOIN fs_products_sub as b ON a.id = b.product_id
						 WHERE  a.published = 1 and a.category_published = 1 and b.published = 1 ".$where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    function getProduct_main($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT *
						FROM " . $this->table_name . " 
						WHERE published = 1 AND 
						" . $where . " ";
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    function list_products_add($id_products) {
        global $db;
         $query   = " SELECT id,name,alias, category_id,updated_time ,image,category_alias,created_time,discount,price,price_old
                                FROM ".$this -> table_name."
                                WHERE id IN (0".$id_products."0) 
					 ORDER BY POSITION(','+id+',' IN '0".$id_products."0')
                                ";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    function getRelateProductsList($cid,$id)
    {
        if (!$cid)
            die;

        global $db;
        $limit = 6;
//        echo $id;
        $query = ' SELECT id,name,alias, category_id,updated_time ,image,category_alias,created_time,discount,price,price_old,author_book, is_hot,unit
						FROM ' . $this->table_name . '
						WHERE category_id IN (0' . $cid . '0)
							AND published = 1 AND is_hot = 1 AND id NOT IN (0' . $id . '0)
						ORDER BY  created_time DESC, ordering DESC
						LIMIT ' . $limit;
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function list_sp()
    {
        $this->table_sp = 'fs_products';
        $query = " SELECT *
						FROM " . $this->table_sp . " 
						WHERE published = 1 ORDER BY id ASC LIMIT 5";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
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
}

?>