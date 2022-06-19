<?php

/*
 * Huy write
 */

// controller

class ProductsControllersProducer extends FSControllers {

    var $module;
    var $view;

    function display() {
        // call models
        $model = $this->model;
        $producer = $model->getListProducer();
        if (!$producer) {
            setRedirect(URL_ROOT, 'Không tồn tại danh mục này', 'error');
        }
        global $tags_group;
//            $tags_group = $cat -> tags_group;
        
//        $total_pr = $model->count_total($producer->id);
        
        $query_body = $model->set_query_body($producer->id);
        $list = $model->getProductsList($query_body);
        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);
        
        
        $list_producer = $model->getproducer();
        
        $list_cat = $model->getListCategory();

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Nhà sách', 1 => FSRoute::_('index.php?module=products&view=home&Itemid=2'));
        $breadcrumbs[] = array(0 => $producer->name, 1 => FSRoute::_('index.php?module=products&view=producer&code=' . $producer->alias));
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // seo
        $tmpl->set_data_seo($producer);

        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

}

?>