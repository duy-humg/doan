<?php

/*
 * Huy write
 */

// controller

class ProductsControllersCompany extends FSControllers {

    var $module;
    var $view;

    function display() {
        // call models
        $model = $this->model;
        $company = $model->getListCompany();
        if (!$company) {
            setRedirect(URL_ROOT, 'Không tồn tại danh mục này', 'error');
        }
        global $tags_group;
//            $tags_group = $cat -> tags_group;
        
        $total_pr = $model->count_total($company->id);
        
        $query_body = $model->set_query_body($company->id);
        $list = $model->getProductsList($query_body);
        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);
        
        
        $list_company = $model->getcompany();
        
        $list_cat = $model->getListCategory();

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Nhà sách', 1 => FSRoute::_('index.php?module=products&view=home&Itemid=2'));
        $breadcrumbs[] = array(0 => $company->name, 1 => FSRoute::_('index.php?module=products&view=company&code=' . $company->alias));
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // seo
        $tmpl->set_data_seo($company);

        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

}

?>