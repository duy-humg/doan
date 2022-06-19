<?php

/*
 * Huy write
 */
// models 
include 'blocks/products/models/products.php';

class ProductsBControllersProducts {

    function __construct() {
        
    }

    function display($parameters, $title, $id) {
        $limit = $parameters->getParams('limit');
        $type = $parameters->getParams('type');
        $style = $parameters->getParams('style');
        $category_id = $parameters->getParams('category_id');
//        var_dump($title);
        $model = new ProductsBModelsProducts();
        if($category_id){
            $cat = $model->get_cat($category_id);
        }
        $list = $model->get_list($limit,$type,$style,$category_id);
        
        include 'blocks/products/views/products/' . $style . '.php';
    }
    
    

}

?>