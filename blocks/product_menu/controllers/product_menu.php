<?php

/*
 * Huy write
 */
// models 
include 'blocks/product_menu/models/product_menu.php';

class Product_menuBControllersProduct_menu {

    function __construct() {
        
    }

    function display($parameters, $title) {
        $cat_id = $parameters->getParams('catid');
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';
        // call models
        $model = new Product_menuBModelsProduct_menu();


        $module = FSInput::get('module');
        $view = FSInput::get('view');
        $cid = FSInput::get('cid');

        $ccode = FSInput::get('ccode');
        
        $list = $model->getListCat($cid);

        $list1 = $model->getListCat();
//        var_dump($list1);
        $list_hot = $model->getListCat_hot();
        $list_other = $model->getListCat_other();
        $list_age = $model->getListCat_age();
        $list_all = $model->getListCat_all();
        $list_favourite = $model->getListCat_favourite();
//var_dump($list1);
        $filter_request = FSInput::get('filter');
        $arr_filter_request = $filter_request ? explode(',', $filter_request) : null;

            // need_chek
            $module = FSInput::get('module');
            $ccode = FSInput::get('ccode');
            $need_check = 0;
            $root_parrent_activated = 0;
            

        // call views
        include 'blocks/product_menu/views/product_menu/' . $style . '.php';
    }

    function get_filters_has_calculate($cat) {
        $model = new Product_menuBModelsProduct_menu();
        return $list = $model->get_filters_has_calculate($cat);
    }
}

?>