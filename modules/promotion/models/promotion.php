<?php

class PromotionModelsPromotion extends FSModels {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_promotion');
        $this->table_products = $fstable->_('fs_products');
    }

    function get_list() {
        $query = ' select * from ' . $this->table_name . ' where published = 1 ORDER BY ordering ';
        global $db;
        $sql = $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }
    
    function list_products_add($id_products) {
        global $db;
        $query   = " SELECT id,name,alias, category_id,updated_time ,image,category_alias,created_time,discount,price,price_old
                                FROM ".$this -> table_products."
                                WHERE published = 1 AND  id IN (0".$id_products."0) 
					 ORDER BY POSITION(','+id+',' IN '0".$id_products."0')
                                ";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }
    

}

?>