<?php
/*
 * Huy write
 */

// controller

class UsersControllersProducts_sort extends FSControllers
{
    var $module;
    var $view;

    function __construct()
    {
        global $user;
        parent::__construct();
    }

    function display()
    {
        // call models
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];
        $model = $this->model;
        $query_body = $model->set_query();
//            $list = $model->get_list($query_body);
        $list = $model->get_favourite($query_body);
//            var_dump($list);
        $total = $model->getTotal($query_body);
        var_dump($total);
//            $total = count($list);
        $pagination = $model->getPagination($total);

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => FSText::_('Tìm kiếm'), 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->set_seo_special();

        // create breadcrumb
//			$array_breadcrumb = $model -> get_breadcrumb();
        // call views
//            var_dump(1);die;

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

    function products_hot()
    {
//        echo 1;die;
        $model = $this->model;
        $query_body = $model->set_query();
//            $list = $model->get_list($query_body);
        $list = $model->get_favourite($query_body);
//            var_dump($list);
        $total = $model->getTotal($query_body);
//            $total = count($list);
        $pagination = $model->getPagination($total);
        include 'modules/' . $this->module . '/views/' . $this->view . '/products_hot.php';

    }
function products_dis()
    {
//        echo 1;die;
        $model = $this->model;
        $query_body = $model->set_query();
//            $list = $model->get_list($query_body);
        $list = $model->get_favourite($query_body);
//            var_dump($list);
        $total = $model->getTotal($query_body);
//            $total = count($list);
        $pagination = $model->getPagination($total);
    $breadcrumbs = array();
//			$breadcrumbs[] = array(0=>$data -> category_name, 1 => 'javascript: void(0)');
    $breadcrumbs[] = array(0=>'Sản phẩm khuyến mại', 1 => FSRoute::_('index.php?module=users&view=products_sort&task=products_dis'));
    global $tmpl;
    $tmpl -> assign('breadcrumbs', $breadcrumbs);
    $tmpl->assign('title', 'Sản phẩm khuyến mại');
//    $tmpl->assign('description', $data->content);
//            $tmpl->assign('og_image', URL_ROOT . str_replace('/original/', '/tiny/', $data->image));
    // seo
//    $tmpl -> set_data_seo($data);

    include 'modules/' . $this->module . '/views/' . $this->view . '/products_dis.php';

    }
function products_coming()
    {
//        echo 1;die;
        $model = $this->model;
        $query_body = $model->set_query();
//            $list = $model->get_list($query_body);
        $list = $model->get_favourite($query_body);
//            var_dump($list);
        $total = $model->getTotal($query_body);
//            $total = count($list);
        $pagination = $model->getPagination($total);
        include 'modules/' . $this->module . '/views/' . $this->view . '/products_coming.php';

    }
function products_new()
    {
//        echo 1;die;
        $model = $this->model;
        $query_body = $model->set_query();
//            $list = $model->get_list($query_body);
        $list = $model->get_favourite($query_body);
//            var_dump($list);
        $total = $model->getTotal($query_body);
//            $total = count($list);
        $pagination = $model->getPagination($total);
        include 'modules/' . $this->module . '/views/' . $this->view . '/products_new.php';

    }

    function add_favourite()
    {
        $model = $this->model;
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];
//            var_dump($user_id);die;
        $favourite = $model->get_record('published = 1 and id =' . $user_id, 'fs_members');
//var_dump($favourite->favourite_id);
        $id = FSInput::get('id');
        $alias = FSInput::get('alias');
        $category_alias = FSInput::get('category_alias');
        if (!$favourite->favourite_id) {
            $where = ' id = ' . $user_id;
            $table = 'fs_members';
            $row = array();
            $row['favourite_id'] = ',' . $id . ',';
            $ddd = $model->_update($row, $table, $where);
        } else {
            if (strpos($favourite->favourite_id, ',' . $id . ',') == false) {
                $where = ' id = ' . $user_id;
                $table = 'fs_members';
                $row = array();
                $row['favourite_id'] = $favourite->favourite_id . $id . ',';
//                    var_dump($row);die;
                $ddd = $model->_update($row, $table, $where);
            }
        }
        $url = FSRoute::_('index.php?module=products&view=product&ccode=' . $category_alias . '&code=' . $alias . '&id=' . $id);
        if (@$ddd) {
            $msg = 'Bạn đã thêm sản phẩm yêu thích thành công.';
            setRedirect($url, $msg);
        } else {
            $msg = 'Sản phẩm đã tồn tại trong danh sách yêu thích.';
            setRedirect($url, $msg, 'error');
        }
    }
}

?>