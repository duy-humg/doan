<?php

class MembersControllersMembers extends Controllers {

    function __construct() {
        $this->view = 'members';
        parent::__construct();
    }

    function display() {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
        //$cities = $model-> get_cities_name();
        $list = $model->get_data('');
        $cities = $model->get_records('published = 1', 'fs_cities','*','name ASC');
        $field_work = $model->get_records('published = 1', 'fs_field_work');
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add() {
        $model = $this->model;
        $maxOrdering = $model->getMaxOrdering();
        $cities = $model->get_records('published = 1', 'fs_cities','*','name ASC');
//        var_dump($cities);
        $get_department = $model->get_records('published = 1', 'fs_department');
        $get_members_head = $model->get_records('published = 1 AND type=2', 'fs_members');
        $get_posotion = $model->get_records('published = 1', 'fs_position');
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit() {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $cities = $model->get_records('published = 1', 'fs_cities','*','name ASC');
        $data = $model->get_record_by_id($id);
        $get_department = $model->get_records('published = 1', 'fs_department');
        $get_members_head = $model->get_records('published = 1 AND type=2', 'fs_members');
        $get_posotion = $model->get_records('published = 1', 'fs_position');
        if (!$data)
            die('Not found url');
        //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function save() {
       
        $model = $this->model;
        $id = FSInput::get('id');
//        if (!$id) {
//            if ($model->check_exits_email()) {
//                setRedirect('index.php?module=members&view=members', FSText :: _('Email này đã có người sử dụng'), 'error');
//            }
//            if ($model->check_exits_username()) {
//                setRedirect('index.php?module=members&view=members', FSText :: _('Username này đã có người sử dụng'), 'error');
//            }
//        }
        // check password and repass
        $password = FSInput::get("password");
        $repass = FSInput::get("re-password");
       
        if (@$id) {
            $edit_pass = FSInput::get('edit_pass');
            
            if ($edit_pass) { 
                if (!$password || ($password != $repass)) {
                    setRedirect('index.php?module=members&view=members', FSText :: _('You must enter a valid password'), 'error');
                }
            }
        } else {
            if (!$password || ($password != $repass))
                setRedirect('index.php?module=members&view=members', FSText :: _('You must enter a valid password'), 'error');
        }

        // call Models to save
        $cid = $model->save();

        if ($cid) {
            setRedirect('index.php?module=members&view=members&cid=' . $cid, FSText :: _('Saved'));
        } else {
            setRedirect('index.php?module=members&view=members', FSText :: _('Not save'), 'error');
        }
    }

    function login() {
        $id = FSInput::get('id', 0, 'int');
        if (!$id)
            setRedirect('index.php?module=' . $this->module . '&view=' . $this->view, FSText::_('Đăng nhập không thành công'));

        $this->logout();

        $model = $this->model;
        $user = $model->get_record_by_id($id, 'fs_members_seekers', 'id,username,full_name,email,published_info');
        if (!$user)
            setRedirect('index.php?module=' . $this->module . '&view=' . $this->view, FSText::_('Đăng nhập không thành công'));

        $_SESSION['fullname'] = $user->full_name;
        $_SESSION['username'] = $user->username;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['published_info'] = $user->published_info;

        setcookie("email", $user->email, time() + 200000000, '/');
        setcookie("fullname", $user->full_name, time() + 200000000, '/');
        setcookie("username", $user->username, time() + 200000000, '/');
        setcookie("user_id", $user->id, time() + 200000000, '/');
        setcookie("published_info", $user->published_info, time() + 200000000, '/');

        $link = URL_ROOT;
        $msg = FSText::_(" Bạn đã đăng nhập thành công ");
        setRedirect($link, $msg);
    }

    function logout() {
        unset($_SESSION['fullname']);
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['email']);
        unset($_SESSION['published_info']);

        setcookie("email", '', time() - 200000000, '/');
        setcookie("user_id", '', time() - 200000000, '/');
        setcookie("fullname", '', time() - 200000000, '/');
        setcookie("username", '', time() - 200000000, '/');
        setcookie("published_info", '', time() - 200000000, '/');
        //session_unset();
        //if (isset($_SERVER['HTTP_COOKIE'])) {
//                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
//                foreach($cookies as $cookie) {
//                    $parts = explode('=', $cookie);
//                    $name = trim($parts[0]);
//                    setcookie($name, '', time()-200000000);
//                    setcookie($name, '', time()-200000000, '/');
//                }
//            }
        //$Itemid = FSInput::get("Itemid",1);
        //$link = FSRoute::_("index.php?module=employer&view=home&Itemid=$Itemid");
        //setRedirect($link);
    }

    function view_title($data) {
        $link = URL_ROOT . $data->username;
        return '<a target="_blink" href="' . $link . '" title="view font-end">' . $data->username . '</a>';
    }

    // Excel toàn bộ danh sách copper ra excel
    function export() {
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
    }

    function export_file() {
        FSFactory::include_class('excel', 'excel');
//			require_once 'excel.php';
        $model = $this->model;
        $filename = 'member-export';
        $list = $model->get_member_info();
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = FSExcel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . $filename . '.xls', 'out_put_xlsx' => 'export/excel/' . $filename . '.xlsx'));
            $style_header = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffff00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $style_header1 = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên truy cập');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Họ và tên');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Địa chỉ');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Điện thoại');
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->full_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->address);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->mobilephone);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
            $output = $excel->write_files();

            $path_file = PATH_ADMINISTRATOR . DS . str_replace('/', DS, $output['xls']);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=\"" . $filename . '.xls' . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($path_file));
            readfile($path_file);
        }
    }

    // Excel toàn bộ danh sách copper ra excel
    function export_excel() {
        require_once 'excel.php';
        $model = $this->model;
        $start = FSInput::get('start');
        $start = (isset($start) && !empty($start)) ? $start : 1;
        $start = $start - 1;
        $end = FSInput::get('end');
        $end = (isset($end) && !empty($end)) ? $end : 10;
        $list = $model->get_member_info($start, $end);
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = V_Excel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . 'danh_sach_' . date('H-i_j-n-Y', time()) . '.xls', 'out_put_xlsx' => 'export/excel/' . 'danh_sach_' . date('j-n-Y', time()) . '.xlsx'));
            $style_header = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffff00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $style_header1 = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên truy cập');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Họ và tên');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Địa chỉ');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Điện thoại');
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->fullname);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->address);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->mobilephone);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
            $output = $excel->write_files();
            echo URL_ROOT . 'ione_admin/' . $output['xls'];
        }
    }

    function quality_export() {
        $html = '<form id="form1" name="form1" method="post" >';
        $html.='<h1 style="color:#FF0000; text-align:center">Bạn hãy điền số thứ tự của bản ghi muốn export</h1>';
        $html.='<p style="text-align:center"><label>Bắt đầu :</label>';
        $html.='<input type="text" name="start_at" id="start_at" /><br />';
        $html.='<label>Kết thúc: </label><input type="text" name="end_at" id="end_at" /><br><span>Nếu bạn không nhập số thứ tự thì hệ thống sẽ tự export từ 1 - 10</span></p>';
        $html.='<p style="text-align:center">';
        $html.='<label>';
        $html.='<input onclick="javascript:configClickExport();" type="submit" name="submit_quality" id="submit_quality" value="Ok" />';
        $html.='</label>';
        $html.='</p>';
        $html.='</form>';
        print_r($html);
    }
    
    function ajax_check_exist_email() {

        $model = $this->model;
        if (!$model->ajax_check_exits_email()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

}

?>