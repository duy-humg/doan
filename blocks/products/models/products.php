<?php

class ProductsBModelsProducts {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name  = $fstable->_('fs_products');	
        $this->table_categories  = $fstable->_('fs_products_categories');	
    }
    function setQuery($limit,$type,$style,$str_cats) {
        $ccode = FSInput::get('ccode');
        $where = '';
        $order = '';
        if ($str_cats)
            $where .= ' AND category_id_wrapper LIKE "%,' . $str_cats . ',%" ';

        switch ($type) {
            case 'home':
                $where .= '  AND show_in_homepage = 1 ';
                break;
            case 'hot':
                $where .= ' AND is_hot = 1 ';
                $order .= ' ordering DESC , created_time DESC, ';
                break;
            case 'new':
                $where .= ' AND is_news = 1 ';
                $order .= ' ordering DESC , created_time DESC, ';
                break;
            case 'sale':
                $where .= ' AND is_sale = 1 ';
                $order .= ' ordering DESC , created_time DESC, ';
                break;
            case 'coming':
                $where .= ' AND coming_soon = 1 ';
                $order .= ' ordering DESC , created_time DESC, ';
                break;
        }
        $order .= ' id DESC';
         $query = ' SELECT name,price_old,price,discount,id,alias,category_id,image,category_alias,quantity,author_book,is_hot, unit 
						  FROM ' . $this->table_name . '
						  WHERE  published = 1 ' . $where . '
						  ORDER BY  id DESC  
						  LIMIT ' . $limit
        ;
        return $query;
    }

    function get_list($limit,$type,$style,$str_cats) {
        global $db;
        $query = $this->setQuery($limit,$type,$style,$str_cats);
        if (!$query)
            return;
        $sql = $db->query($query);
//        echo $query;
        $result = $db->getObjectList();
        return $result;
    }
    
    function get_cat($id){
        $where = '';
        if ($id) {
            $where .= ' AND id =' . $id;
        }
        global $db;
        $query = ' SELECT id,name, alias, list_parents,image,level,parent_id,icon
					FROM ' . $this->table_categories . ' 
					WHERE published = 1 ' . $where . '
					ORDER BY ordering
							';
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }
}
?>
