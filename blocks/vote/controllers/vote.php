<?php

/*
 * Huy write
 */
// models 
include 'blocks/vote/models/vote.php';

class VoteBControllersVote {

    function __construct() {
        
    }

    function display($parameters, $title, $id) {
        
        $model = new VoteBModelsVote();
        
        $base = 'https://tiki.vn/nha-sach-tiki/c8322?src=mega-menu';
        $model->save($base);
        include 'blocks/vote/views/vote/default.php';
    }

}

?>