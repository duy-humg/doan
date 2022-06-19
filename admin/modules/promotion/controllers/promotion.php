<?php

class PromotionControllersPromotion extends Controllers {

    function __construct() {
        $this->view = 'tags';
        parent::__construct();
    }

    function display() {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $list = $model->get_data();

        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function edit() {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $data = $model->get_record_by_id($id);
        $package_related = $model->get_package_related($data->package_related);
        // data from fs_news_categories
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function ajax_get_package_related() {
        $model = $this->model;
        $data = $model->ajax_get_package_related();
        $str_related = FSInput::get('str_related');
        $id = FSInput::get('id', 0, 'int');
        $html = $this->package_genarate_related($data, $str_related, $id);
        echo $html;
        return;
    }

    function package_genarate_related($data, $str_related = 0, $id) {
        $str_exist = FSInput::get('str_exist');
//        $error_img = "this.src='/images/1443089194_picture-01.png'";
        if ($str_related) {
            if ($id) {
                $str_related = str_replace(',' . $id, '', $str_related);
            }
        }

        $html = '';
        $html .= '<div class="package_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red package_related_item  package_related_item_' . $item->id . '" onclick="javascript: set_package_related(' . $item->id . ')" style="display:none" >';
                $html .= $item->name;
//                $html .= '<img onerror="' . $error_img . '" src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '">';
                $html .= '</div>';
            } else {
                $html .= '<div class="package_related_item  package_related_item_' . $item->id . '" onclick="javascript: set_package_related(' . $item->id . ')">';
                $html .= $item->name;
//                $html .= '<img onerror="' . $error_img . '" src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        $html .= '<input type="hidden" value="' . $str_related . '" id="str_related" name="str_related" />';
        return $html;
    }

}

?>