<?php
/*
 * Huy write
 */

// controller

class UsersControllersFavourite extends FSControllers
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
        $data_2 = $model->getMember();
        $query_body = $model->set_query();
//            $list = $model->get_list($query_body);
        $list = $model->get_favourite($query_body);
//            var_dump($list);die;
        $total = $model->getTotal($query_body);
// //            $total = count($list);
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

    function add_favourite_()
    {
        $model = $this->model;
        $id = FSInput::get('id');
        $user_id = $_SESSION['user_id'];
        $member = $model->get_record('published = 1 and id =' . $user_id, 'fs_members');
        $favourite = $model->get_record('published = 1 and record_id =' . $id . ' AND user_id = ' . $user_id, 'fs_products_favourite');

        if (!$favourite) {

            $table = 'fs_products_favourite';
            $row = array();
            $row['record_id'] = $id;
            $row['user_id'] = $user_id;
            $row['like_f'] = 1;
            $row['published'] = 1;
            $fvr = $model->_add($row, $table);
        }else{
            $where = ' user_id = '.$user_id.' AND record_id='.$id;
            $table = 'fs_products_favourite';
            $row = array();
            $row['like_f'] = 1;
            $fvr = $model->_update($row, $table, $where);
        }
        if ($fvr)
            $favourite_item = $model->get_records('published = 1 and record_id =' . $id . ' AND `like_f` = 1', 'fs_products_favourite');

        $html = '';
        $html .= '<a class="a-like click_fvr click2" href="javascript: void(0)" onclick="un_like()" title="bỏ thích">';
        $html .= '<i class="fas fa-heart"></i>';
        $html .= '</a>';
        $html .= '<span class="mb_span">Đã thích</span>';
        echo $html;
    }

    function un_favourite_()
    {
        $model = $this->model;
        $id = FSInput::get('id');
        $user_id = $_SESSION['user_id'];
        $member = $model->get_record('published = 1 and id =' . $user_id, 'fs_members');
        $favourite = $model->get_record('published = 1 and record_id =' . $id . ' AND user_id = ' . $user_id, 'fs_products_favourite');
//var_dump($favourite);die;
        if (!$favourite){
            return false;
        }
        if ($favourite) {
            $where = ' user_id = '.$user_id.' AND record_id='.$id;
            $table = 'fs_products_favourite';
            $row = array();
            $row['like_f'] = 0;
            $fvr = $model->_update($row, $table, $where);
        }
        if ($fvr)
            $favourite_item = $model->get_records('published = 1 and record_id =' . $id . ' AND `like_f` = 1', 'fs_products_favourite');
//        var_dump($favourite_item);die;
        $html = '';
        $html .= '<a class="click_fvr click1" href="javascript: void(0)"  onclick="like()" title="thích">';
        $html .= '<i class="fal fa-heart"></i>';
        
        $html .= '</a>';
        $html .= '<span class="mb_span">Chưa thích</span>';
        echo $html;
    }
}

?>