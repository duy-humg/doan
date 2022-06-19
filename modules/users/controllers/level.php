<?php

/*
 * Huy write
 */

// controller
class UsersControllersLevel extends FSControllers {

    var $module;
    var $view;

    function __construct() {
        global $user;
        parent::__construct();
    }

    function display() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
         $user_id = $_SESSION['user_id'];

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $query_body = $model->set_query_body();
        $list_order = $model->get_list($query_body);
        $data = $model->getMember();

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }
    function add_address(){
        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/add_address.php';
    }
}

?>
