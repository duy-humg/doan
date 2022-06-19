<?php
/*
 * Huy write
 */

// controller
class HomeControllersHome extends FSControllers
{
    var $module;
    var $view;

    function display()
    {
        $fstable = FSFactory::getClass('fstable');
        // call models
        $model = $this->model;

        $combo = $model->combo();
        $banner = $model->banners();
        $tienich = $model->tienich();
//        $list_sp = $model->list_sp();

//        $query_body_hang = $model->set_query_body_hang();
//        $list_sp = $model->get_list_hang($query_body_hang);

        $query_body = $model->set_query_body();
        $list_sp = $model->get_list($query_body);

        global $tmpl, $config;
        $tmpl->assign('canonical', URL_ROOT);
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function loadmore()
    {
        // call models
        $model = $this->model;


        $pagecurrent = FSInput::get('pagecurrent');
        $limit = FSInput::get('limit');


        $total_old = $pagecurrent * $limit;
        $gt = $total_old . ',' . $limit;

        $fs_table = FSFactory::getClass('fstable');

        $query_body = $model->set_query_body();
        $list_ = $model->get_list($query_body);
        if (!$list_)
            return;
//
//        if (!$list_sp){
////            $html ='';
//            return;
//        }



        include 'modules/' . $this->module . '/views/' . $this->view . '/load.php';
    }



    function save()
    {
        $model = $this->model;
        $name = FSInput::get('name');
        $email = FSInput::get('email');
        $phone = FSInput::get('phone');
        $note = FSInput::get('message');
        $where = ' published = 1';
        $table = 'fs_contact_enjicad';
        $row = array();
        $row['fullname'] = $name;
        $row['email'] = $email;
        $row['telephone'] = $phone;
        $row['message'] = $note;
        var_dump($row);
        die;
//
        $id = $model->_update($row, $table, $where);;

    }

}

?>

