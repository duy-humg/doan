<?php
class Api_xmlControllersGetxml extends FSControllers
{
    var $module;
    var $view;

    function display() {
        // call models
        $model = $this->model;
        $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
        $url = 'http://117.6.161.220:14332/api/Stock/40';
        $xml = file_get_contents($url, false, $context);
        $xml = simplexml_load_string($xml);
        $i=0;
        $x=0;
        $sql="UPDATE fs_products
              SET quantity = CASE ma_kho_tiki ";
        $sku="";
        foreach($xml->children() as $books) {
            $i++;
            $sql.="WHEN '$books->MAVT' THEN ".$books->LG_TON." ";
            $sku.="'$books->MAVT',";
        }
        $sku=rtrim($sku, ",");
        $sku=" IN(".$sku.")";
        $sql.=" ELSE quantity
                      END
                WHERE ma_kho_tiki ".$sku;
        $re=$model->update_book($sql);
        echo "sucsess";

//        echo '<pre>';
//        print_r($xml);
//        var_dump($xml);
    }
    function user() {
        // call models
        $model = $this->model;
        $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
        $url = 'http://117.6.161.220:14332/api/PhoneNumberVip';
        $xml = file_get_contents($url, false, $context);
        $xml = simplexml_load_string($xml);
        $i=0;
        $x=0;
        $sql="UPDATE fs_products
              SET quantity = CASE ma_kho_tiki ";
        $sku="";
        foreach($xml->children() as $books) {
            $i++;
            $sql.="WHEN '$books->MAVT' THEN ".$books->LG_TON." ";
            $sku.="'$books->MAVT',";
        }
        $sku=rtrim($sku, ",");
        $sku=" IN(".$sku.")";
        $sql.=" ELSE quantity
                      END
                WHERE ma_kho_tiki ".$sku;
        $re=$model->update_book($sql);
        echo "sucsess";

//        echo '<pre>';
//        print_r($xml);
//        var_dump($xml);
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