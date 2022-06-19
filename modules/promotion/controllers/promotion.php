<?php

/*
 * Linh write
 */

// controller
class PromotionControllersPromotion extends FSControllers {

    function display() {
        $model = $this->model;

        $list = $model->get_list();
        $list_package = array();
        foreach($list as $item){
            $list_id = $item->package_related;
            $list_package[$item->id] = $model->list_products_add($list_id);
        }

        // breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs [] = array(0 => FSText::_('Khuyến mãi'), 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->set_seo_special();
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/' . 'default.php';
    }


}

?>