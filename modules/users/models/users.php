<?php

class UsersModelsUsers extends FSModels
{

    function __construct()
    {
        parent::__construct();
        $fstable = FSFactory::getClass('fstable');
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        $this->limit = 20;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_order = $fs_table->getTable('fs_order');
        $this->table_order_item = $fs_table->getTable('fs_order_items');
        $this->table_products = $fs_table->getTable('fs_products');
        $this->type = 'members';
        $this->img_folder = 'images/' . $this->type . '/' . $cyear . '/' . $cmonth;
        $this->field_img = 'avatar';
        $this-> table_name = $fstable->_('fs_members_seekers');
        $this->arr_logo_paths = array(
            array('small', 100, 100, 'cut_image'),
            array('large', 200, 200, 'cut_image'),
            array('resized', 100, 100, 'resize_image')
        );

    }

    function getConfig($name)
    {
        global $db;
        $sql = " SELECT value FROM fs_config 
				WHERE name = '$name' ";
        $db->query($sql);
        return $db->getResult();
    }

    function set_query_body()
    {
        global $db, $user;
        $where = ' 1=1';
        $order = '';

        if ($user->userInfo->type == 2) {
            $where .= ' AND creator_id=' . $user->userID . ' ';
        }

        $head_id = FSInput::get('head_id');
        if ($user->userInfo->type == 1 && $head_id) {
            $where .= ' AND creator_id=' . $head_id . '';
        }
        $status = FSInput::get('status');

        if ($status) {
            if ($status == 1) {
                $where .= ' AND published=1 ';
            } else if ($status == 2) {
                $where .= ' AND published=0';
            } else {
                $where .= ' AND (published=1 OR published=0) ';
            }

        }
        $keyword = FSInput::get2('keyword');

        if ($keyword) {
            $where .= " AND ( username LIKE '%" . $keyword . "%' OR name LIKE '%" . $keyword . "%' OR id LIKE '%" . $keyword . "%' ) ";
        }

        $query = ' FROM fs_members
                  WHERE' . $where .
            ' ORDER BY ' . $order . '  ordering  ';
//        print_r($query);             
        return $query;
    }

    //get danh sách user thuộc head quản lý lịch sử học
    function set_query_body_2()
    {
        global $db, $user;
        $where = ' 1=1';
        $keyword = FSInput::get2('keyword');
        $type_exam = FSInput::get2('type_exam');

        if ($keyword) {
            $where .= " AND ( username LIKE '%" . $keyword . "%' OR name LIKE '%" . $keyword . "%' OR id LIKE '%" . $keyword . "%' ) ";
        }
        if ($user->userInfo->type == 2) {
            $where .= " AND m.creator_id=" . $user->userID . "";
        }
        $head_id = FSInput::get('head_id');
        if ($user->userInfo->type == 1 && $head_id) {
            $where .= ' AND creator_id=' . $head_id . '';
        }
        $status = FSInput::get('status');
        if ($user->userInfo->type == 1 && $status) {
            if ($status == 1) {
                $where .= ' AND m.published=1 ';
            } else if ($status == 2) {
                $where .= ' AND m.published=0';
            } else {
                $where .= ' AND (m.published=1 OR m.published=0) ';
            }

        }

        if ($type_exam) {
            $where .= ' AND e.type_exam=' . intval($type_exam) . '';
        }

        $month_to = FSInput::get('month_to', 0, 'int');
        $year_to = FSInput::get('year_to', 0, 'int');
        $month_from = FSInput::get('month_from', 0, 'int');
        $year_from = FSInput::get('year_from', 0, 'int');

        if ($month_to && $year_to && $month_from && $year_from) {
            $start = mktime(0, 0, 0, $month_to, 1, $year_to);
            $from = mktime(0, 0, 0, $month_from, 31, $year_from);
            $where .= ' AND e.start_time >=' . $start . ' AND e.start_time <= ' . $from . ' ';
        }

        $query = "FROM fs_members as m, fs_exam as e,fs_position as p
					WHERE " . $where . " AND m.id=e.userid AND m.position=p.id
					GROUP BY e.userid
ORDER BY m.id DESC";
        return $query;
    }

//danh sach bai thi
    function set_query_body_3()
    {
        global $db, $user;
        $where = ' ';
        $order = '';
        $type_exam = FSInput::get2('type_exam');
        if ($type_exam) {
            $where .= ' AND e.type_exam=' . $type_exam . '';
        }
//        if ($user->userInfo->type == 2) {
//            $where .=' AND creator_id='. $user->userID . ' ';
//        }
//
//        $head_id = FSInput::get('head_id');
//        if ($user->userInfo->type == 1 && $head_id) {
//            $where .=' AND creator_id='. $head_id . '';
//        }

        $keyword = FSInput::get2('keyword');

        if ($keyword) {
            $where .= " AND ( username LIKE '%" . $keyword . "%' OR name LIKE '%" . $keyword . "%' OR id LIKE '%" . $keyword . "%' ) ";
        }

        $month_to = FSInput::get('month_to', 0, 'int');
        $year_to = FSInput::get('year_to', 0, 'int');
        $month_from = FSInput::get('month_from', 0, 'int');
        $year_from = FSInput::get('year_from', 0, 'int');

        if ($month_to && $year_to && $month_from && $year_from) {
            $start = mktime(0, 0, 0, $month_to, 1, $year_to);
            $from = mktime(0, 0, 0, $month_from, 31, $year_from);
            $where .= ' AND e.start_time >=' . $start . ' AND e.start_time <= ' . $from . ' ';
        }

        $query = ' FROM fs_exam as e
                  WHERE userid=' . $user->userID . ' ' . $where .
            ' ORDER BY ' . $order . '  id DESC  ';
//        print_r($query);             
        return $query;
    }

    function get_list($query_body)
    {

        if (!$query_body)
            return;

        global $db;
        $query = "SELECT *";
        $query .= $query_body; // echo $query;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();

        return $result;
    }

    function get_list_2($query_body)
    {

        if (!$query_body)
            return;

        global $db;
        $query = "SELECT m.creator_name,m.id,m.name,m.code_dcs,m.position,p.name AS vi_tri,m.published,count(e.userid) as num_exam, ROUND(AVG(e.point)) as DTB ";
        $query .= $query_body;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        $result = $db->getObjectList();

        return $result;
    }

    //get danh sách user thuộc head quản lý
    function get_list_user()
    {
        global $db, $user;
        $where = ' 1=1';

        if ($user->userInfo->type == 2) {
            $where .= ' AND creator_id="' . $user->userID . '" ';
        }

        $head_id = FSInput::get('head_id');
        if ($user->userInfo->type == 1 && $head_id) {
            $where .= ' AND creator_id="' . $head_id . '" ';
        }

        $keyword = FSInput::get2('keyword');

        if ($keyword) {
            $where .= " AND ( username LIKE '%" . $keyword . "%' OR name LIKE '%" . $keyword . "%' OR id LIKE '%" . $keyword . "%' ) ";
        }
        $sql = " SELECT *
					FROM fs_members
					WHERE " . $where . "
					ORDER BY ordering";
        $db->query($sql);
        return $db->getObjectList();
    }

    /*     * ******** REGISTER ********** */
    /*
     * save register
     */

    function save()
    {

        global $db, $user;
        $row = array();
        $user_ho = FSInput::get("dk_ho");
        $username = FSInput::get("dk_name");
        $password = FSInput::get("dk_password");
//        $re_password = FSInput::get("re_password");
//        var_dump($re_password);die;
        $phone = FSInput::get("dk_phone");
        $email = FSInput::get("dk_mail");


  
        $row['username'] = $username;
        $row['name'] = $username;
        $row['surname'] = $user_ho;
        $row['telephone'] = $phone;
        $row['email'] = $email;
        $row['type'] = 3;

        $time = date("Y-m-d H:i:s");
        $row['password'] = md5($password);
        $row['published'] = 1;
        $fstring = FSFactory::getClass('FSString', '', '../');
        $row['code'] = $fstring->generateRandomString(32);
        $activated_code = $row['code'];
        $row['created_time'] = $time;
        $row['lastedit_date'] = $time;

//        var_dump($row);die;
//        if ($password == $re_password){
        $id = $this->_add($row, 'fs_members');
//        }
//        if ($id) {
//            $this->send_mail_activated_user($username, $password, $activated_code, $id, $email);
//        }
        return $id;
    }

    function update_save()
    {
        global $db, $user;

        $row = array();
        $id = FSInput::get('id');
        $info_user = $this->get_record('id=' . $id, 'fs_members');
        $username = FSInput::get("username");
        $password = FSInput::get("password");
        $name = FSInput::get("name");
        $sex = FSInput::get("sex");
        $dcs_code = FSInput::get("dcs_code");
        $cmt = FSInput::get("cmt");
        $telephone = FSInput::get("telephone");
        $email = FSInput::get("email");
        $position = FSInput::get("position");
        $published = FSInput::get("published");

        $row['username'] = $username;
        $row['name'] = $name;
        $row['sex'] = $sex;
        $row['code_dcs'] = $dcs_code;
        $row['cmt'] = $cmt;
        $row['email'] = $email;
        $row['telephone'] = $telephone;
        $row['position'] = $position;

        $row['type'] = 3;

        $time = date("Y-m-d H:i:s");

        if ($password != $info_user->password) {
            $row['password'] = md5($password);
        } else {
            $row['password'] = $info_user->password;
        }

        $row['published'] = $published;
        $fstring = FSFactory::getClass('FSString', '', '../');
        $row['code'] = $fstring->generateRandomString(32);

        $row['lastedit_date'] = $time;

        $row['creator_name'] = $user->userInfo->username;
        $row['creator_id'] = $user->userID;

        $id = $this->_update($row, 'fs_members', 'id=' . $id);
        return $id;
    }

    function delegate_save()
    {
        global $db, $user;

        $row = array();

        $delegate_name = FSInput::get("delegate_name");
        $delegate_phone = FSInput::get("delegate_phone");
        $delegate_email = FSInput::get("delegate_email");


        $row['delegate_name'] = $delegate_name;
        $row['delegate_phone'] = $delegate_phone;
        $row['delegate_email'] = $delegate_email;

        $time = date("Y-m-d H:i:s");
        $row['lastedit_date'] = $time;
        $id = $this->_update($row, 'fs_members', 'id=' . $user->userID);
        return $id;
    }

    function update_account($username, $user_id, $address_book_id)
    {
        $row = array('user_id' => $user_id, 'username' => $username);
        $this->_update($row, 'fs_address_book', 'WHERE id = ' . $address_book_id);
    }

    /*
     * Register addressbook
     */

    function register_address_book()
    {
        $time = date("Y-m-d H:i:s");
        $data_address = array(
            'category_id' => FSInput::get('cat_code'),
            'name' => FSInput::get('name_address'),
            'business_license' => FSInput::get('business_license'),
            'activity_filed' => FSInput::get('activity_filed'),
            'main_areas' => FSInput::get('main_areas'),
            'partner' => FSInput::get('partner'),
            'partner_country_id' => FSInput::get('partner_country_id'),
            'revenue' => FSInput::get('revenue'),
            'quantity_staff' => FSInput::get('quantity_staff'),
            'working_time_from' => FSInput::get('working_time_from'),
            'working_time_to' => FSInput::get('working_time_to'),
            'lunch_break_from' => FSInput::get('lunch_break_from'),
            'lunch_break_to' => FSInput::get('lunch_break_to'),
            'holiday_week' => FSInput::get('holiday_week'),
            'country_id' => FSInput::get('address_country_id'),
            'city_id' => FSInput::get('address_city_id'),
            'district_id' => FSInput::get('address_district_id'),
            'commune_id' => FSInput::get('address_commune_id'),
            'street' => FSInput::get('address_street'),
            'house' => FSInput::get('address_house'),
            'region_phone' => FSInput::get('address_region_phone'),
            'phone' => FSInput::get('address_phone'),
            'region_fax' => FSInput::get('address_region_fax'),
            'fax' => FSInput::get('address_fax'),
            'hotline' => FSInput::get('address_hotline'),
            'email_baokim' => FSInput::get('email_baokim'),
            'website' => FSInput::get('address_website'),
            'published' => 1,
            'created_time' => $time,
            'edited_time' => $time,
        );
        $certificate = FSInput::get('certificate', array(), 'array');
        $object_service = FSInput::get('object_service', array(), 'array');
        if (!empty($certificate) && is_array($certificate)) {
            $data_address['certificate'] = ',' . implode(',', $certificate) . ',';
        }
        if (!empty($object_service) && is_array($object_service)) {
            $data_address['object_service'] = ',' . implode(',', $object_service) . ',';
        }
        // Lấy thông tin bổ sung về danh mục (loại hình hoạt động)
        $categories = $this->get_record_by_id(FSInput::get('cat_code'), 'fs_address_book_categories');
        $category_name = $categories->name;
        $data_address['category_name'] = $categories->name;
        $data_address['category_alias'] = $categories->alias;
        $data_address['category_alias_wrapper'] = $categories->alias_wrapper;
        $data_address['category_id_wrapper'] = $categories->list_parents;

        // partner country
        $detail = $this->get_record_by_id(FSInput::get('partner_country_id', 0, 'int'), 'fs_countries');
        $data_address['partner_country_name'] = $detail->name;
        $data_address['partner_country_flag'] = $detail->flag;

        // country for address book
        if ($detail = $this->get_record_by_id(FSInput::get('address_country_id'), 'fs_countries')) {
            $country_name = $detail->name;
            $data_address['country_name'] = $country_name;
            $data_address['country_flag'] = $detail->flag;
        }
        //	city for address book
        if ($detail = $this->get_record_by_id(FSInput::get('address_city_id', 0, 'int'), 'fs_cities')) {
            $city_name = $detail->name;
            $data_address['city_name'] = $city_name;
        }
        //	district for address book			
        if ($detail = $this->get_record_by_id(FSInput::get('address_district_id', 0, 'int'), 'fs_districts')) {
            $district_name = $detail->name;
            $data_address['district_name'] = $district_name;
        }
        //	commune for address book	
        if ($detail = $this->get_record_by_id(FSInput::get('address_commune_id', 0, 'int'), 'fs_commune')) {
            $commune_name = $detail->name;
            $data_address['commune_name'] = $commune_name;
        }
        // Kiểm tra xem đăng ký mới hay sửa danh bạ
        $address_book_id = FSInput::get('address_book_id');
        if (!empty($address_book_id)) {
            return $address_book_id;
        } else {
            //update content_search
            $fsstring = FSFactory::getClass('FSString', '');
            $content_search = $fsstring->removeHTML($category_name . ' ' . FSInput::get('name_address') . ' ' . FSInput::get('main_areas') . ' ' . FSInput::get('activity_filed') . ' ' . $country_name . ' ' . $city_name . ' ' . $district_name . ' ' . $commune_name);

            $data_address['content_search'] = $fsstring->convert_utf8_to_telex($content_search) . ' ' . $fsstring->remove_viet_sign($content_search);
            $address_book_id = $this->_add($data_address, 'fs_address_book');
            return $address_book_id;
        }
    }

    function upload_avatar()
    {
        $avatar = $_FILES["avatar"]["name"];
        if (!$avatar)
            return;
        $fsFile = FSFactory::getClass('FsFiles');
        $img_folder = 'images/avatar/original/';
        $path = str_replace('/', DS, $img_folder);
        $path = PATH_BASE . $path;

        $avatar = $fsFile->uploadImage('avatar', $path, 2000000, '_' . time());
        if (!$avatar)
            return;
        // resize avatar : 50x50
        $path_resize = str_replace(DS . 'original' . DS, DS . 'resized' . DS, $path);
        if (!$fsFile->resized_not_crop($path . $avatar, $path_resize . $avatar, 130, 140))
            return false;
        return $img_folder . $avatar;
    }

    function save_estore($user_id)
    {
        if (!$user_id)
            return false;
        global $db;
        $username = FSInput::get("username");
        $cpn_name = FSInput::get("cpn_name");
        $estore_name = $cpn_name;

        $fsstring = FSFactory::getClass('FSString', '');
        $estore_alias = $fsstring->stringStandart($cpn_name);
        $estore_name_not_sign = $fsstring->remove_viet_sign($cpn_name);

        $cpn_telephone = FSInput::get("cpn_telephone");
        $cpn_mobilephone = FSInput::get("cpn_mobilephone");
        $cpn_fax = FSInput::get("cpn_fax");
        $cpn_website = FSInput::get("cpn_website");
        $cpn_province = FSInput::get("province");
        $cpn_district = FSInput::get("district");
        $cpn_address = FSInput::get("cpn_address");
        $cpn_intro = strip_tags($_POST["cpn_intro"]);


        $time = date("Y-m-d H:i:s");
        $published = 0;
        $activated = 0;

        $sql = " INSERT INTO 
						fs_estores (user_id,`username`,estore_name,estore_alias,estore_name_not_sign,telephone,mobilephone,fax,website
						,created_time,edited_time,published,`activated`,`address`,`estore_intro`,`city_id`,`district_id`,`etemplate`)
						VALUES ('$user_id','$username','$cpn_name','$estore_alias','$estore_name_not_sign','$cpn_telephone','$cpn_mobilephone','$cpn_fax','$cpn_website',
						'$time','$time','$published','$activated','$cpn_address','$cpn_intro','$cpn_province','$cpn_district','default') 
					";
        $db->query($sql);

        $id = $db->insert();

        return $id;
    }

    function edit_save()
    {
        global $db;
        $update = "";
        $password = FSInput::get("password");
        if ($password) {
            $password = md5($password);
            $sql_pwd = "password = '$password'";
        } else
            $sql_pwd = "";


        $surname = FSInput::get("ho");
        $surname = (!empty($surname)) ? "surname = '$surname'" : "";
        $update = $surname;



        $name = FSInput::get("name");
        $name = (!empty($name)) ? "name = '$name'" : "";
        $update = $name;

//        $surname = FSInput::get("ho");
//        $surname = (!empty($surname)) ? "surname = '$surname'" : "";
//        $update = $surname;


        $surname = FSInput::get("ho");
        $surname = (!empty($surname)) ? "surname = '$surname'" : "";
        $update = (!empty($surname) && !empty($update)) ? "$update,$surname" : $update . $surname;

        $birth_day = FSInput::get("birth_day");
        $birth_month = FSInput::get("birth_month");
        $birth_year = FSInput::get("birth_year");
        if (!empty($birth_day) && !empty($birth_month) && !empty($birth_year)) {
            $birthday = date("Y-m-d", mktime(0, 0, 0, $birth_month, $birth_day, $birth_year));
        }
        $birthday = (!empty($birthday)) ? "birthday = '$birthday'" : "";
        $update = (!empty($birthday) && !empty($update)) ? "$update,$birthday" : $update . $birthday;

        $email = FSInput::get("email");
        $email = (!empty($email)) ? "email = '$email'" : "";
        $update = (!empty($email) && !empty($update)) ? "$update,$email" : $update . $email;

        $image = $_FILES['avatar']["name"];
        if($image){
            $image = $this -> upload_image('avatar','_'.time(),2000000,$this -> arr_logo_paths,$this-> img_folder);
            if($image){
                $_SESSION['avatar'] = $image;
                $row['avatar']=$image;
                $image = (!empty($image)) ? "avatar = '$image'" : "";
                $update = (!empty($image) && !empty($update)) ? "$update,$image" : $update . $image;
            }
        }



        $sex = FSInput::get("sex");
        $sex = (!empty($sex)) ? "sex = '$sex'" : "";
        $update = (!empty($sex) && !empty($update)) ? "$update,$sex" : $update . $sex;

        $update = (!empty($sql_pwd) && !empty($update)) ? "$update,$sql_pwd" : $update . $sql_pwd;

        if (!empty($update)) {
            $sql = " UPDATE  fs_members SET 
								" . $update . "
								
							WHERE id = 	" . $_SESSION['user_id'] . " 
					";
//            var_dump($sql);die;
            $rows = $db->affected_rows($sql);
//            var_dump($rows);die;
            if ($rows) {
                return $rows;
            }
        } else {
            return false;
        }
    }

    /*
     * check exist username
     * Sim must active
     * published == 1: OK.  not use
     * published != 1: not OK
     */

    function checkUsername($username)
    {
        global $db;
        $username = FSInput::get("username");
        if (!$username) {
            Errors::setError("H&#227;y nh&#7853;p s&#7889; username");
            return false;
        }
        $sql = " SELECT count(*)
					FROM fs_members
					WHERE 
						username = '$username'
					";
        $db->query($sql);
        $count = $db->getResult();
        if (!$count) {
            Errors::setError("Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ tÃƒÂ¡Ã‚Â»Ã¢â‚¬Å“n tÃƒÂ¡Ã‚ÂºÃ‚Â¡i");
            return false;
        }
        return true;
    }


    /*
      /*
     * function forget
     */

    function forget()
    {
        global $db;
        $email = FSInput::get('email');
//        var_dump($phone);die;
        if (!$email)
            return false;
        $sql = " SELECT email, username, id ,name,activated_code, telephone
					FROM fs_members
					WHERE email = '$email'
					 ";
//        echo $sql;die;
        $db->query($sql);
        return $db->getObject();
    }

    function getcheck_pass()
    {
        global $db;
        $pass = FSInput::get('pass');
        if (!$pass)
            return false;
        $newpass_encode = md5($pass);
        $user_id = $_SESSION['user_id'];
        $sql = " SELECT *
					FROM fs_members
					WHERE password = '$newpass_encode' and id = $user_id
					 ";
//        echo $sql;die;
        $db->query($sql);
        return $db->getObject();
    }

    function edit_email()
    {
        global $db;
        $email = FSInput::get('email');
        if (!$email)
            return false;

        $user_id = $_SESSION['user_id'];
        $sql = " UPDATE  fs_members SET 
						email = '$email'
						WHERE 
						id = $user_id
				";
//        echo $sql;die;
        $db->query($sql);
        return $db->getObject();
    }



    function resetPass($userid)
    {
        $fstring = FSFactory::getClass('FSString', '', '../');
        $newpass = $fstring->generateRandomString(8);
        $newpass_encode = md5($newpass);
        global $db;
        $sql = " UPDATE  fs_members SET 
						password = '$newpass_encode'
						WHERE 
						id = $userid
				";
        $db->query($sql);
        $rows = $db->affected_rows();
        if (!$rows) {
            return false;
        }
        return $newpass;
    }

    /* save building */

    function save_changepass()
    {
        global $db, $user;
        $text_pass_new = FSInput::get("text_pass_new");
        if (!$text_pass_new)
            return false;

        $username = $user->userInfo->username;

        $password_old_buid = md5(FSInput::get("text_pass_old"));
        $password_new_buid = md5(FSInput::get("text_pass_new"));

        $sql = "UPDATE fs_members SET password='" . $password_new_buid . "'  WHERE `username`='" . $username . "' and password='" . $password_old_buid . "'";

        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
    }

    /*
     * check duplicate email
     */

    function check_change_pass()
    {
        global $db, $user;
        $password_old_buid = FSInput::get("text_pass_old");

        if (!$password_old_buid)
            return false;
        $password_old_buid = md5($password_old_buid);

        $username = $user->userInfo->username;

        $sql = "SELECT count(*) as count FROM fs_members
				WHERE `username` = '" . $username . "'
						AND `password` = '$password_old_buid' ";

        $db->query($sql);
        $rs = $db->getResult();

        return $rs;
    }

    /*
     * check old pass
     * 
     */

    function checkOldpass($old_pass)
    {
        global $db;
        $username = $_SESSION['user_name'];
        $old_pass = md5($old_pass);
        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
						AND password   = '$old_pass'
					";
        $db->query($sql);
        $count = $db->getResult();
        if (!$count) {
            return false;
        }
        return true;
    }

    /*
     * check exist email and identify card.
     */

    function checkExistUsers()
    {
        global $db;
        $email = FSInput::get("email");
        $username = FSInput::get("username");
        if (!$email || !$username) {
            Errors::setError("BÃƒÂ¡Ã‚ÂºÃ‚Â¡n phÃƒÂ¡Ã‚ÂºÃ‚Â£i nhÃƒÂ¡Ã‚ÂºÃ‚Â­p Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚ÂºÃ‚Â§y Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã‚Â§ thÃƒÆ’Ã‚Â´ng tin vÃƒÆ’Ã‚Â o trÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã¯Â¿Â½ng email vÃƒÆ’Ã‚Â  username");
            return false;
        }
        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
						OR username = '$username'
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            Errors::setError("Email hoÃƒÂ¡Ã‚ÂºÃ‚Â·c Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ Ãƒâ€žÃ¢â‚¬ËœÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Â£c sÃƒÂ¡Ã‚Â»Ã‚Â­ dÃƒÂ¡Ã‚Â»Ã‚Â¥ng");
            return false;
        }
        return true;
    }

    /*
     * check exist email .
     */

    function check_exits_email()
    {
        global $db;
        $email = FSInput::get("email");
        $id = FSInput::get("id");
        $where = '';
        if ($id) {
            $where .= ' AND id <>' . $id . ' ';
        }

        if (!$email) {
            return false;
        }
        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE email = '$email' '$where' ";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            $this->alert_error('Email này đã có người sử dụng');
            return false;
        }
        return true;
    }

    /*
     * check exist username .
     */

    function check_exits_username()
    {
        global $db;
        $username = FSInput::get("username");
        if (!$username) {
            return false;
        }
        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            $this->alert_error('Username này đã có người sử dụng');
            return false;
        }
        return true;
    }

    function ajax_check_exist_dcs()
    {

        global $db;
        $code_dcs = FSInput::get("code_dcs");

        if (!$code_dcs) {
            return false;
        }

        $id = FSInput::get("id");
        $where = '';
        if ($id) {
            $where .= ' AND id <>' . $id . ' ';
        }

        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						code_dcs = '$code_dcs' $where
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            return false;
        }
        return true;
    }

    function ajax_check_exist_cmt()
    {

        global $db;
        $cmt_dcs = FSInput::get("cmt");

        if (!$cmt_dcs) {
            return false;
        }

        $id = FSInput::get("id");
        $where = '';
        if ($id) {
            $where .= ' AND id <>' . $id . ' ';
        }

        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						cmt = '$cmt_dcs' $where
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            return false;
        }
        return true;
    }

    function ajax_check_exits_username()
    {

        global $db;
        $username = FSInput::get("username");

        if (!$username) {
            return false;
        }


        $id = FSInput::get("id");
        $where = '';
        if ($id) {
            $where .= ' AND id <>' . $id . ' ';
        }

        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username' $where
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            return false;
        }
        return true;
    }

    function ajax_check_exits_email()
    {
        global $db;
        $email = FSInput::get("email_register");
//        var_dump($email);die;
        if (!$email) {
            return false;
        }

        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            return false;
        }
        return true;
    }
    function ajax_check_exits_phone()
    {
        global $db;
        $phone = FSInput::get("phone_register");
//        var_dump($email);die;
        if (!$phone) {
            return false;
        }

        $sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						telephone = '$phone'
					";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            return false;
        }
        return true;
    }
    /*     * ********** LOGGED ************* */
    /*
     * get menu have group = usermenu
     */

    function getMenusUser()
    {
        global $db;
        $sql = " SELECT id,link, name, images 
					FROM fs_menus_items
					WHERE published  = 1
						AND group_id = 5 
					ORDER BY ordering";
        $db->query($sql);
        return $db->getObjectList();
    }

//get danh sách head 
    function get_list_head()
    {
        global $db, $user;
        $where = ' 1=1';
        $keyword = FSInput::get('keyword');

        if ($keyword) {
            $where .= " AND ( username LIKE '%" . $keyword . "%' OR name LIKE '%" . $keyword . "%' OR id LIKE '%" . $keyword . "%' ) ";
        }
        $sql = " SELECT *
					FROM fs_members
					WHERE " . $where . " AND type=2
					ORDER BY ordering";
        $db->query($sql);
        return $db->getObjectList();
    }


    /*     * ******** DETAIL INFORMATION OF MEMBER * */

    function getMember()
    {
        global $db;
        $user_id = $_SESSION['user_id'];
        $sql = " SELECT * 
					FROM fs_members
					WHERE id  = $user_id ";
        $db->query($sql);
        return $db->getObject();
    }

    function getProvince($provinceid)
    {
        global $db;
        $sql = " SELECT name
					FROM fs_cities
					WHERE id   = '$provinceid' ";
        $db->query($sql);
        return $db->getResult();
    }

    function getDistrict($districtid)
    {
        global $db;
        $sql = " SELECT name
					FROM fs_districts
					WHERE id   = '$districtid'";
        $db->query($sql);
        return $db->getResult();
    }

    function getUserByUsername($username)
    {
        global $db;

        $sql = " SELECT full_name, id FROM fs_members WHERE username = '$username'";
        $db->query($sql);
        return $db->getObject();
    }

    function getUserById($userid)
    {
        global $db;

        $sql = " SELECT full_name,id 
					FROM fs_members WHERE id = '$userid'";
        $db->query($sql);
        return $db->getObject();
    }

    function check_email($email)
    {
        global $db;

        $sql = " SELECT *
					FROM fs_members WHERE email = '$email'";
        $db->query($sql);
        return $db->getObject();
    }

    /*
     * Createa folder when create user
     */

    function create_folder_upload($id)
    {
        $fsFile = FSFactory::getClass('FsFiles', '');
        $path = PATH_BASE . 'uploaded' . DS . 'estores' . DS . $id;
        return $fsFile->create_folder($path);
    }

    function send_mail_activated_user($name, $password_de, $activated_code, $user_id, $email)
    {

        $global = new FsGlobal();

        $mail_register_subject = $global->getConfig('mail_register_subject');
        $mail_register_body = $global->getConfig('mail_register_body');

        $url_activated = URL_ROOT . 'index.php?module=users&view=users&task=activate&code=' . $activated_code . '&id=' . $user_id;
// body
        $body = $mail_register_body;
        $body = str_replace('{name}', $name, $body);
        $body = str_replace('{email}', $email, $body);
        $body = str_replace('{pass}', $password_de, $body);
        $body = str_replace('{url_activated}', '<a href="' . $url_activated . '">' . FSText::_('Link active') . '</a>', $body);

        $this->send_email1("Geni - Xác nhận đăng ký tài khoản", $body, $name, $email, '', 1);
        return true;

        //en
    }

    /*
      /*
     * function forget
     */

    function activate()
    {
        global $db;
        $code = FSInput::get('code');
        $id = FSInput::get('id', 0, 'int');
        if (!$code || !$id)
            return false;
        $sql = " SELECT username,id,published
					FROM fs_members
					WHERE 
						id = '$id'
						 AND code = '$code'
						 AND published <> 1
					 ";

        $rs = $db->getObject($sql);
        include 'libraries/errors.php';
        if (!$rs) {
            Errors::_('Không kích hoạt tài khoản thành công');
            return false;
        }
        if ($rs->published) {
            Errors::_('Tài khoản này đã kích hoạt từ trước.');
            return false;
        }
        $time = date("Y-m-d H:i:s");
        $row['published'] = 1;
        $row['published_time'] = $time;
//        var_dump($row);die;
        $i = $this->_update($row, 'fs_members', ' id = "' . $id . '" AND code = "' . $code . '" ');
        if (!$i) {
            Errors::_('Không kích hoạt tài khoản thành công.');
            return false;
        }
        return true;
    }

    /* ==================================================
     * ================== ADDRESS BOOK  =================
      ================================================== */

    function get_address_book_by_key()
    {
        $key = FSInput::get('key');
        if (!$key)
            return;
        $sql = "SELECT id,name,country_name,category_alias,alias
					FROM fs_address_book
					WHERE published = 1
					AND content_search like '%$key%'
					ORDER BY hits DESC,created_time DESC
					LIMIT 60	";
        global $db;
        $db->query($sql);
        return $db->getObjectList();
    }

    function get_address_book_properties()
    {
        $sql = "SELECT id,name,type
					FROM fs_address_book_property
					WHERE published = 1
					ORDER BY type ASC ,ordering ASC
					LIMIT 60	";
        global $db;
        $db->query($sql);
        return $db->getObjectList();
    }

    function add_point($user_id, $bitly_count)
    {
        $sql = " UPDATE  fs_members SET 
			 				bitly = " . $bitly_count . "
						WHERE  id = " . base64_decode($user_id) . "
							
					";
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
    }

    function get_gift()
    {
        $point = FSInput::get('point');
        if (!$point)
            return;
        global $db;
        $query = "  SELECT *
					FROM fs_gift AS a
					WHERE
						point <= $point  
					";
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    /* save building */

    function save_order_gift()
    {
        global $db;

        $user_id = $_SESSION['user_id'];
        $fullname = $_SESSION['fullname'];

        $gift_id = FSInput::get('gift_id');
        $gift = $this->get_record_by_id($gift_id, 'fs_gift');
        $time = date("Y-m-d H:i:s");
        $published = 1;
        $name_gift = $gift->name;
        $image_gift = $gift->image;
        $point_gift = $gift->point;

        $sql = " INSERT INTO 
						fs_redeem_points (user_id,gift_id,created_time,edited_time,published,name_gift,image_gift, point_gift,`fullname`)
						VALUES ('$user_id','$gift_id','$time','$time','$published','$name_gift','$image_gift','$point_gift','$fullname') 
					";
        $db->query($sql);

        $id = $db->insert();

        return $id;
    }

    function get_DTB()
    {
        global $db, $user;
        $query = "  SELECT ROUND(AVG(point)) as TB
					FROM fs_exam
					WHERE userid='$user->userID'
					";
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getTotal($query_body)
    {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total)
    {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }

    function sendMailForget($user, $resetPass)
    {
        // body
        $body = '';
        $body .= '<div>Chào bạn!</div>';
        $body .= '<div>Bạn đã sử dụng chức năng lấy lại mật khẩu</div>';
        $body .= '<div>Mật khẩu đăng nhập mới của bạn là: <strong>' . $resetPass . '</strong> (Vui lòng thay đổi mật khẩu ngay sau khi đăng nhập).</div>';
        $body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';

//            $url_activated = URL_ROOT.'index.php?module=members&view=register&task=activate&code='.$activated_code.'&id='.$user_id;
        // body

//             $body = str_replace('{url_activated}', '<a href="'.$url_activated.'">'.FSText::_('Link active').'</a>', $body);
        $rs = $this->send_email1("VPP Tân Tiến - Lấy lại mật khẩu", $body, $user->username, $user->email, '', 1);
        return $rs;
    }

    function get_order_id($id)
    {
        $query = " SELECT a.*,b.name as product_name, b.alias as product_alias,b.category_alias, b.image as image,b.id as product_id
					FROM " . $this->table_order_item . " AS a
					INNER JOIN " . $this->table_products . " AS b on a.product_id = b.id 
						WHERE a.order_id = " . $id;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

}

?>