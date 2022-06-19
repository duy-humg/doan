<?php
/*
 * Huy write
 */
include 'blocks/vitri/models/vitri.php';

class VitriBControllersVitri
{
    function __construct()
    {
    }

    function display($parameters, $title)
    {
        $style = $parameters->getParams('style');
        $model = new VitriBModelsVitri();
        $discount_id = $parameters->getParams('discount_id');

//        $partner_c = $model->fs_partners();

        $city = $model->city();
        if($_SESSION['id_city'] ){
            $get_city = $model->get_city();
            $huyen = $model->list_huyen();
        }
        if($_SESSION['id_huyen'] ){
            $get_huyen = $model->get_huyen();

            $ward = $model->list_xa();
        }


        include 'blocks/vitri/views/vitri/' . $style . '.php';
//        echo 'blocks/discount/views/discount/' . $style . '.php';
    }
}

?>