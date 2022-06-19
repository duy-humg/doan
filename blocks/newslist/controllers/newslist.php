<?php

/*
 * Huy write
 */
// models 
include 'blocks/newslist/models/newslist.php';

class NewslistBControllersNewslist {

    function __construct() {
        
    }

    function display($parameters, $title, $id) {
        $cat_id = $parameters->getParams('category_id');
        $ordering = $parameters->getParams('ordering');
        $type = $parameters->getParams('type');
        $limit = $parameters->getParams('limit');
        $limit = $limit ? $limit : 6;
        $style = $parameters->getParams('style');
        // call models
        $model = new NewslistBModelsNewslist();

        $list = $model->get_list($cat_id, $ordering, $limit, $type);

        $style = $style ? $style : 'default';
        // call views
        include 'blocks/newslist/views/newslist/' . $style . '.php';
    }



}

?>