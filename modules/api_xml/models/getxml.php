<?php

class Api_xmlModelsGetxml extends FSModels
{
    function __construct()
    {
        parent::__construct();
    }
    function update_book($sql){
        global $db;
        $result=$db->affected_rows($sql);
        return $result;
    }
}
?>

<?php
/**
 * Created by PhpStorm.
 * User: Lucky Boy
 * Date: 04/03/2019
 * Time: 09:43
 */