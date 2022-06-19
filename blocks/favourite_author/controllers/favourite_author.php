<?php

/*
 * Huy write
 */
// models 
include 'blocks/favourite_author/models/favourite_author.php';

class Favourite_authorBControllersFavourite_author {

    function __construct() {
        
    }

    function display($parameters, $title, $id) {
        $cat_id = $parameters->getParams('category_id');
        $ordering = $parameters->getParams('ordering');
        $type = $parameters->getParams('type');
        $limit = $parameters->getParams('limit');
        $limit = $limit ? $limit : 100;
        $style = $parameters->getParams('style');
        // call models
        $model = new Favourite_authorBModelsFavourite_author();

        $list = $model->get_list($cat_id, $ordering, $limit, $type);
//        var_dump($list);
//        $list_author = $model->get_list($cat_id, $ordering, $limit, $type);

        $style = $style ? $style : 'default';
        // call views
        include 'blocks/favourite_author/views/favourite_author/' . $style . '.php';
    }

}

?>