<?php
/*
 * Huy write
 */
include 'blocks/discount/models/discount.php';

class DiscountBControllersDiscount
{
    function __construct()
    {
    }

    function display($parameters, $title)
    {
        $style = $parameters->getParams('style');
        $model = new DiscountBModelsDiscount();
        $discount_id = $parameters->getParams('discount_id');

//        $partner_c = $model->fs_partners();

        $dm_1 = $model->category_dm();
        $menuchamsoc = $model->menuchamsoc();
        $menufooter = $model->menufooter();
        $menufooter_mobile = $model->menufooter_mobile();
//        var_dump($menufooter_mobile);
        $list_news_dm = $model->list_news_dm();
        $list_news = $model->list_news();
        include 'blocks/discount/views/discount/' . $style . '.php';
//        echo 'blocks/discount/views/discount/' . $style . '.php';
    }
}

?>