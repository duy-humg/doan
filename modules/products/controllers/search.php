<?php
/*
 * Huy write
 */

// controller

class ProductsControllersSearch
{
    var $module;
    var $view;

    function __construct()
    {

        $this->module = 'products';
        $this->view = 'search';
        include 'modules/' . $this->module . '/models/' . $this->view . '.php';
    }

    function display()
    {
        // call models
        $model = new ProductsModelsSearch();
        $query_body = $model->set_query_body();
        $list = $model->get_list($query_body);
        $total = $model->getTotal($query_body);
        $total_list = count($list);
        $pagination = $model->getPagination($total);

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => FSText::_('Tìm kiếm'), 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->set_seo_special();

        // create breadcrumb
//			$array_breadcrumb = $model -> get_breadcrumb();
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function get_ajax_search()
    {
        $result = array();
        $model = new ProductsModelsSearch();
        $list = $model->get_ajax_search();
        // $query = isset($_GET['query']) ? $_GET['query'] : FALSE;

        if ($list) {
            foreach ($list as $item) {
//                    $price = calculator_price($item->price,$item->price_hn,$item->price_hcm,$item->price_dn,$item->price_tn,$item->price_ct,$item->price_hd,$item->price_hp,$item->price_old,$item->promotion_price,$item->promotion_published,$item->date_start,$item->date_end,$item->promotion_info);
                $result[] = array(
                    'value' => FSRoute::_('index.php?module=products&view=product&code=' . $item->alias . '&id=' . $item->id . '&ccode=' . $item->category_alias),
                    'data' => array(
                        'text' => $item->name,
                        "brand" => $item->category_name,
                        "price" => format_money($item->price),
                        "image" => URL_ROOT . str_replace('/original/', '/small/', $item->image),
                    )
                );
            }
        }


        $sugges_result = array(
            'query' => FSInput::get('query'),
            'suggestions' => $result
        );
        echo json_encode($sugges_result);
    }
}

?>