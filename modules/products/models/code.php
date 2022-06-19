<?php

class ProductsModelsCode extends FSModels
{

    function __construct()
    {
        parent::__construct();
        global $module_config;
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_discount_code');
    }

    /*
     * select cat list is children of catid
     */

    function checkCode()
    {
        global $db;
        $money = FSInput::get('total');
//        var_dump($money);
        $code = FSInput::get('val');
        $ship = FSInput::get('ship');
//        var_dump($ship);die;
        $time = date('Y-m-d h:i:s');
        $sql = "SELECT * FROM fs_discount_code 
                WHERE name='$code' AND published=1 
                AND date_end > '$time' and price<= $money 
                AND price_max >=$money and count > 0";
//        echo $sql;die;
        $rs = $db->getObject($sql);
        return $rs;
    }

}

?>