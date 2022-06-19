<?php

/*
 * Huy write
 */

// controller
class UsersControllersUsers extends FSControllers {

    var $module;
    var $view;

    function __construct() {
        global $user;
        parent::__construct();
    }

    function display() {
        if($_SESSION['user_id']){
            
        }else{
            $link_ = FSRoute::_('index.php?module=users&view=formregister'); 
            setRedirect($link_);
        }
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
         $user_id = $_SESSION['user_id'];
        $_SESSION['pass_email'] = 0;

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $data = $model->getMember();
        $cities = $model->get_cities();
        //$districts  = $model -> get_districts($data -> city_id);
        $config_person_edit = $model->getConfig('person_edit');
        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    
    function email_1() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $data = $model->getMember();
        $cities = $model->get_cities();

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/email1.php';
    }
    function email_2() {
        if($_SESSION['pass_email']==1){
            $fssecurity = FSFactory::getClass('fssecurity');
            $fssecurity->checkLogin();
            $user_id = $_SESSION['user_id'];

            $global_class = FSFactory::getClass('FsGlobal');
            $model = $this->model;
            $data = $model->getMember();
            $cities = $model->get_cities();

            $breadcrumbs = array();
            $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
            global $tmpl;
            $tmpl->assign('breadcrumbs', $breadcrumbs);
            // call views
            include 'modules/' . $this->module . '/views/' . $this->view . '/email2.php';
        }else{
            $url_main =  FSRoute::_("index.php?module=users&view=users&task=email_1");
            $msg = 'Chưa nhập mật khẩu';
            setRedirect($url_main,$msg);
        }

    }

    function check_pass() {
//        echo 1;die;
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $data = $model->getcheck_pass();

        if(!$data){
            $url_main =  FSRoute::_("index.php?module=users&view=users&task=email_1");
            $msg = 'Mật khẩu không chính xác';
            setRedirect($url_main,$msg);
        }else{
            $_SESSION['pass_email'] = 1;
            $url_main =  FSRoute::_("index.php?module=users&view=users&task=email_2");
            setRedirect($url_main);
        }


        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/email2.php';
    }

    function edit_email() {
//        echo 1;die;
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];

        $email = FSInput::get('email');
       
        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $check_email = $model->check_email($email);
        // var_dump($check_email->email);die;
        if($check_email->email){
            $url_main_2 =  FSRoute::_("index.php?module=users&view=users&task=email_2");
            $msg_2 = 'Email đã tồn tại';
            setRedirect($url_main_2,$msg_2,'error');
        }

        $data = $model->edit_email();


        $url_main =  FSRoute::_("index.php?module=users&view=users");
        $msg = 'Thay đổi email thành công';
        setRedirect($url_main,$msg);




    }

    /*
     * View information of member
     */

    function detail() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();

        $model = $this->model;
        $data = $model->getMember();
        $province = $model->getProvince($data->province);
        $district = $model->getDistrict($data->district);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    /*
     * View information of member
     */

    function edit() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $data = $model->getMember();
        $cities = $model->get_cities();
        //$districts  = $model -> get_districts($data -> city_id);
        $config_person_edit = $model->getConfig('person_edit');
        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/edit.php';
    }

    function user_info() {
        global $user;

        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin tài khoản', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/user_info.php';
    }


    function login_save() {

        global $user;
//        $return = FSInput::get('return');
        $return = FSInput::get('redirect');

        $link = base64_decode($return);
//        var_dump($link);die;
        $model = $this->model;
        
        $phone = FSInput::get('dn_phone');
        $password = FSInput::get('dn_password');
//        var_dump($password);die;
//        var_dump($phone);
//        var_dump($password);
//        $check_acount = FSInput::get('check_acount');
//        if($check_acount == 'false'){
//            
//        }
        
        $loged = $user->login($phone, $password);

        if($link){
            $url_main = URL_ROOT.$link;
            $url = URL_ROOT.'dang-nhap.html';
        } else {
            $url = URL_ROOT.'dang-nhap.html';
            $url_main = URL_ROOT;
            
        }
        if ($loged) {
//            $_SESSION['telephone'] = $loged->telephone ;
            $_SESSION['username'] = FSInput::get('dk_name');
            $msg = 'Bạn đã đăng nhập thành công.';
            $link = FSRoute::_("index.php?module=users");
            setRedirect($link, $msg);
        } else {
            $msg = 'Tên đăng nhập hoặc password chưa chính xác.';
            setRedirect($url, $msg, 'error');
        }
    }

    function forget_pass() {

        $model = $this->model;
        if (isset($_SESSION['username'])) {
            $link = FSRoute::_('index.php?module=users&task=user_info&Itemid=45');
            setRedirect($link);
        }
        $config_person_login_info = $model->getConfig('login_info');

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng nhập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/forget_pass.php';
    }


    /*
     * Display form forget
     */

    function forget() {
        if (isset($_SESSION['username'])) {
            if ($_SESSION['username']) {
                $Itemid = 37;
                $link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
                setRedirect($link);
            }
        }
        $model = $this->model;
        $config_person_forget = $model->getConfig('person_forget');

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Quên mật khẩu', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/forget.php';
    }
    
    function forget_popup() {
        if (isset($_SESSION['username'])) {
            if ($_SESSION['username']) {
                $Itemid = 37;
                $link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
                setRedirect($link);
            }
        }
        $model = $this->model;

        include 'modules/' . $this->module . '/views/' . $this->view . '/forget_popup.php';
    }

    function activate() {
        $model = $this->model;
        $url = FSRoute::_('index.php?module=users&task=login&Itemid=11');
        if ($model->activate()) {
            setRedirect(URL_ROOT, 'Tài khoản của bạn đã được kích hoạt thành công');
        } else {
            setRedirect($url);
        }
    }

    function forget_save() {

        $model = $this->model;
        $link = FSRoute::_('index.php?module=users&view=formregister&Itemid=22');

        $user = $model->forget();
        if (@$user->email) {
            $resetPass = $model->resetPass($user->id);
            if (!$resetPass) {
                $msg = "Lỗi hệ thống khi reset Password";
                setRedirect($link, $msg, 'error');
            }

            if (!$model->sendMailForget($user, $resetPass)) {
                $msg = "Lỗi hệ thống khi send mail";
                setRedirect($link, $msg, 'error');
            }

            $msg = "Mật khẩu của bạn đã được thay đổi. Vui lòng kiểm tra email của bạn";
            setRedirect($link, $msg);
        } else {
            $msg = "Email của bạn không tồn tại trong hệ thống. Vui lòng kiểm tra lại!";
            setRedirect($link, $msg, 'error');
//            setRedirect("index.php?module=users&task=forget&Itemid=38", $msg, 'error');
        }
    }

    function logout() {
        global $user;
        $user->logout();
        unset($_SESSION['user_id']);
//        unset($_SESSION['fullname']);
        unset($_SESSION['user_name']);
//        unset($_SESSION['user_email']);
        $url = URL_ROOT;
        setRedirect($url);
    }

    /*
     * After login
     */

    function logged() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
//			$menus_user = $model -> getMenusUser();

        include 'modules/' . $this->module . '/views/' . $this->view . '/logged.php';
    }

    /*     * ************** EDIT ********** */

    function edit_save() {
        $model = $this->model;
        $edit_pass = FSInput::get("edit_pass");
        if ($edit_pass) {
            if (!$this->check_edit_save()) {
                $link = FSRoute::_("index.php?module=users&view=users&task=edit");
                $msg = FSText::_("Không thay đổi được!");
                setRedirect($link, '', '');
//					return false;
            }
        }
        $id = $model->edit_save();

        // if not save
        if ($id) {
            $_SESSION['user_name'] = FSInput::get('name');
            $_SESSION['name'] = FSInput::get('name');
            $_SESSION['surname'] = FSInput::get('surname');
//            $_SESSION['avatar'] = FSInput::get('avatar');
            $_SESSION['user_id'] = FSInput::get('id');
            $link = FSRoute::_("index.php?module=users&view=users");
            $msg = FSText::_("Bạn đã cập nhật thành công");
            setRedirect($link, $msg);
        } else {
            $link = FSRoute::_("index.php?module=users&view=users");
            $msg = FSText::_("");
            setRedirect($link, $msg, 'error');
        }
    }
    
    function check_edit_save() {
        FSFactory::include_class('errors');
        $model = $this->model;
        // check pass
        $old_password = FSInput::get("old_password");
        $password = FSInput::get("password");
        $re_password = FSInput::get("re-password");
        if (!$model->checkOldpass($old_password)) {
            Errors::setError(FSText::_("Mật khẩu không đúng"));
            return false;
        }
        if ($password && ($password != $re_password)) {
            Errors::setError(FSText::_("Mật khẩu không trùng nhau nhau"));
            return false;
        }
        if ($password == '' || $re_password == '') {
            Errors::setError(FSText::_("Chưa nhập mật khẩu mới"));
            return false;
        }
        return true;
    }

    /*     * ************** REGISTER ********** */
    /*
     * Resigter
     */

    function register() {

        $model = $this->model;
        $config_register_rules = $model->getConfig('register_rules');
        $config_register_info = $model->getConfig('register_info');
//			$cities  = $model -> getCity();
//			$city_id_first = $cities[0] ->id;
//			$city_current = FSInput::get('province',$city_id_first,'int');
//			$districts  = $model -> getDistricts($city_current);
//			$district_current = FSInput::get('district',$districts[0] ->id,'int');

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng ký thành viên', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/register.php';
    }

 

    function register_user() {
        global $user;
        $model = $this->model;

        $list_manager_user = $this->model->get_records('creator_id=' . $user->userID, 'fs_members');
  $get_posotion = $model->get_records('published = 1', 'fs_position');
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Tạo User', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/register_user.php';
    }

    function edit_user() {
        global $user;
        $model = $this->model;
        $id_user = FSInput::get('id');
        $list_manager_user = $this->model->get_records('creator_id=' . $user->userID, 'fs_members');
        $info_user = $this->model->get_record('id=' . $id_user, 'fs_members');
  $get_posotion = $model->get_records('published = 1', 'fs_position');
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Cập nhật User', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/edit_user.php';
    }

    function register_save() {

        $model = $this->model;
        $id = $model->save();

        // if not save
        if ($id) {
            // logged
//            $email = FSInput::get("email_register");
//            $name = explode('@', $email);
//            $_SESSION['fullname'] = $name[0];
//            $_SESSION['user_email'] = FSInput::get('email_register');
//            $_SESSION['user_id'] = $id;
//            $link = FSRoute::_("index.php?module=users&view=users");
            $link = URL_ROOT;
            $msg = "Bạn đã đăng ký tài khoản thành công";
            setRedirect($link, $msg);
        } else {
            $link = URL_ROOT;
            $msg = FSText::_("Xin lỗi. Bạn chưa đăng ký thành công.");
            setRedirect($link, $msg, 'error');
        }
    }

    function update_user() {

        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->update_save();

        // if not save
        if ($id) {
            // logged
//            $email = FSInput::get("email_register");
//            $name = explode('@', $email);
//            $_SESSION['fullname'] = $name[0];
//            $_SESSION['user_email'] = FSInput::get('email_register');
//            $_SESSION['user_id'] = $id;
            $link = FSRoute::_("index.php?module=users&task=list_user");
            $msg = "Cập nhật user thành công!";
            setRedirect($link, $msg);
        } else {
            $link = URL_ROOT;
            $msg = FSText::_("Xin lỗi. Bạn chưa cập nhật user thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function update_delegate() {

        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->delegate_save();
        // if not save
        if ($id) {
            $link = FSRoute::_("index.php?module=users&task=user_info");
            $msg = "Cập nhật user thành công!";
            setRedirect($link, $msg);
        } else {
            $link = URL_ROOT;
            $msg = FSText::_("Xin lỗi. Bạn chưa cập nhật user thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function check_register_save() {
        // check pass
        $username = FSInput::get("username");
        FSFactory::include_class('errors');
        if (!$username) {
            Errors::setError(FSText::_("Chưa nhập username"));
            return false;
        }

        $password = FSInput::get("password");
        $re_password = FSInput::get("re_password");
        if (!$password || !$re_password) {
            Errors::setError(FSText::_("Chưa nhập mật khẩu"));
            return false;
        }
        if ($password != $re_password) {
            Errors::setError(FSText::_("Mật khẩu không trùng nhau"));
            return false;
        }

        $email = FSInput::get("email");
        $re_email = FSInput::get("re-email");
        if (!$email || !$re_email) {
            Errors::setError(FSText::_("Chưa nhập email"));
            return false;
        }
        if ($email != $re_email) {
            Errors::setError(FSText::_("Email nhập lại không khớp"));
            return false;
        }

        // check captcha				
        if (!$this->check_captcha()) {
//				Errors::setError(FSText::_("Mã hiển thị chưa đúng"));
            $this->alert_error('Mã hiển thị chưa đúng');
            return false;
        }

        $model = $this->model;
        // check email and identify card
        if (!$model->check_exits_email()) {
            return false;
        }
        if (!$model->check_exits_username()) {
            return false;
        }

        return true;
    }

    function check_exits_email() {
        $model = $this->model;
        if (!$model->check_exits_email())
            return false;
        return true;
    }

    function ajax_check_exist_dcs() {

        $model = $this->model;
        if (!$model->ajax_check_exist_dcs()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    function ajax_check_exist_cmt() {

        $model = $this->model;
        if (!$model->ajax_check_exist_cmt()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    function ajax_check_exist_username() {

        $model = $this->model;
        if (!$model->ajax_check_exits_username()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
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
    function ajax_check_exist_phone() {

        $model = $this->model;
        if (!$model->ajax_check_exits_phone()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    /*
     * load District by city id. 
     * Use Ajax
     */

    function destination() {
        $model = $this->model;

        $cid = FSInput::get('cid');
        $did = FSInput::get('did');
        if ($cid) {
            $rs = $model->getDestination($cid);
        }
        if ($did) {
            $rs = $model->getDestination1($did);
        }
        $json = '[{id: 0,name: "Điểm đến"},'; // start the json array element
        $json_names = array();
        foreach ($rs as $item) {
            $json_names[] = "{id: $item->id, name: '$item->name'}";
        }
        $json .= implode(',', $json_names);
        $json .= ']'; // end the json array element
        echo $json;
    }

    function check_captcha() {
        $captcha = FSInput::get('txtcaptcha');
        if ($captcha == $_SESSION["security_code"]) {
            return true;
        } else {
            
        }
        return false;
    }

    function changepass() {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $data = $model->getMember();
        $Itemid = FSInput::get("Itemid", 1);
        include 'modules/' . $this->module . '/views/' . $this->view . '/changepass.php';
    }

    function edit_save_changepass() {
        // check logged
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);

        $link = FSRoute::_("index.php?module=users&task=user_info&Itemid=5");
        $link_err = FSRoute::_("index.php?module=users&task=changepass&Itemid=5");
        $check = $model->check_change_pass();
        if (!$check) {
            setRedirect($link_err, 'Mật khẩu cũ chưa chính xác', 'error');
        }


        $rs = $model->save_changepass();
        // if not save
//echo $rs;die;
        if ($rs) {
            $msg = FSText::_("Bạn đã thay đổi thành công");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin lỗi. Bạn chưa thay đổi thành công!");
            setRedirect($link_err, $msg, 'error');
        }
    }

    function change_email_save() {
        // check logged
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);

        $link = FSRoute::_("index.php?module=users&task=changepass&Itemid=$Itemid");
        $email_new = FSInput::get('email_new');
        if ($email_new) {

            $re_email_new = FSInput::get('re_email_new');
            if ($email_new != $re_email_new) {
                $msg = FSText::_("Email nh&#7853;p ch&#432;a kh&#7899;p!");
                setRedirect($link, $msg, 'error');
            }
            $check = $model->check_change_pass();
            if (!$check) {
                setRedirect($link, 'Email m&#7899;i c&#7911;a b&#7841;n &#273;&#227; t&#7891;n t&#7841;i trong h&#7879; th&#7889;ng. B&#7841;n ch&#432;a thay &#273;&#7893;i &#273;&#432;&#7907;c th&#244;ng tin', 'error');
            }
        }

        $rs = $model->save_changepass();
        // if not save


        if ($rs) {
            $msg = FSText::_("B&#7841;n &#273;&#227; thay &#273;&#7893;i th&#224;nh c&#244;ng");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin l&#7895;i, b&#7841;n &#273;&#227; thay &#273;&#7893;i kh&#244;ng th&#224;nh c&#244;ng!");
            setRedirect($link, $msg, 'error');
        }
    }



    function registration(){
        include 'modules/' . $this->module . '/views/' . $this->view . '/formregister.php';
        return;
    }
    function login_con(){
        include 'modules/' . $this->module . '/views/' . $this->view . '/formlogin.php';
        return;
    }
    function set_orderstatus() {
//echo 1; die;
        $model = $this->model;

        include 'modules/' . $this->module . '/views/' . $this->view . '/order_status.php';
        return;
    }
    function order_status() {
//        echo 1; die;

//        global $user;
//        $return = FSInput::get('return');
//        $link = base64_decode($return);
        $model = $this->model;

        $email = FSInput::get('email');
        $madh = FSInput::get('madh');
//        var_dump($madh, $email);
        $order= $model->get_records("published = 1 and email = '$email'", "fs_order");
//        var_dump($order);die;
        foreach ($order as $item){
            $ma_order='DH' . str_pad($item->id, 8, "0", STR_PAD_LEFT);
            if ($ma_order==$madh) {
                $order_arr = $item;
            }
        }
        if (!isset($order_arr)) {
            $msg = 'Mã đơn hàng hoặc email chưa chính xác.';
            setRedirect(FSRoute::_("index.php?module=users&view=users&task=set_orderstatus&Itemid=22"), $msg, 'error');
        } else {
            $list = $model->get_order_id($order_arr->id);
//            var_dump($list);
            include 'modules/' . $this->module . '/views/' . $this->view . '/order_status_detail.php';

        }

    }
}
?>
