<?php
class UsersModelsFace extends FSModels{
    function __construct(){
        parent::__construct();
        $this->table_name = 'fs_members';
    }
 	function checkExitsEmail($id_face)
    {
        global $db;

        if (!$id_face)
        {
            return false;
        }
        $sql = 'SELECT *
    			FROM fs_members 
    			WHERE id_face = '.$id_face;
        //$db->query($sql);
		return $db->getObject($sql);
    }

    function check_exits_email($email_fase)
    {
        global $db ;
        if(!$email_fase){
            return false;
        }
        $sql = " SELECT * 
                FROM fs_members
                WHERE 
                    email = '$email_fase'
                ";
        return $db->getObject($sql);
    }

    function save($user)
    {
        global $db;
        $row = array();
        $row['email'] = $user->email;
    	$username = explode( '@', $user->email);
		if($this -> check_exist($username[0], '', 'username', 'fs_members')){
			$row['username'] = $this -> genarate_username_news($username[0],'','fs_members');
		}else{
			$row['username'] = $username[0];
		}
        $row['type'] = '0';
        $row['is_type'] = 'face';
        $row['id_face'] = $user->id; 
        $row['username'] = $user->name;
        $row['name_type'] = 1;
        $row['sex'] = $user->gender;
        $row['avatar'] ='https://graph.facebook.com/'. $user->id .'/picture?width=190&height=190';
        $row['published'] = 1;
        $row['created_time'] = date("Y-m-d H:i:s");

        $row['is_send'] = 0;
        $row['time_send'] = date("Y-m-d 00:00:00");
        $row['time_plan'] = date("Y-m-d 00:00:00");
        
        $fstring = FSFactory::getClass('FSString', '', '../');
        $row['code'] =  $fstring->generateRandomString(32);
        $row['password']= $fstring->generateRandomString(32);
        $id = $this->_add($row, 'fs_members');
        
        return $id;
    }

    function genarate_username_news($value,$id = '',$table_name = ''){
        if(!$value)
            return false;
        if(!$table_name)
            $table_name = 'fs_members_seekers';
        $i = 1;
        while(true){
            $value_news = $value.'_'.$i; 
            if(!$this -> check_exist($value_news,$id,'username',$table_name)){
                return $value_news;
            }
            $i ++;
        }
    }

    function edit()
    {
        global $db;
        
        $file = $this->upload_avatar();
        
        $row = array();
        $row['full_name'] = FSInput::get("full_name");
        $row['avatar'] = $file;
        //$row['lastname'] = FSInput::get("lastname");        
        $row['sex'] = FSInput::get("sex");
		$row['show_sex'] = FSInput::get("show_sex");
		$row['days'] = FSInput::get("days");
		$row['month'] = FSInput::get("month");
		$row['year'] = FSInput::get("year");
		$row['birthday'] = $row['days'].'/'.$row['month'].'/'.$row['year'];
		$row['show_birthday'] = FSInput::get("show_birthday");
		$row['city_id'] = FSInput::get("city_id");		
		$row['show_city'] = FSInput::get("show_city");		 
        $row['mobile'] = FSInput::get("mobile");
		
		$row['contactname'] = FSInput::get("contactname");
		$row['contactaddress'] = FSInput::get("contactaddress");
		$row['contactphone'] = FSInput::get("contactphone");
		$row['contactemail'] = FSInput::get("contactemail");
		$row['is_newsletter'] = FSInput::get("is_newsletter");		
        $row['published'] = 1;
        $fstring = FSFactory::getClass('FSString', '', '../');
        $id = $this->_update($row, 'fs_members', 'id='.$_SESSION['user_id']);
        return $id;
    }
    
    function checkExitsUsername()
    {
        global $db;
        if(isset($_SESSION['user_id'])) /* Sửa thông tin */
            return true;
        $email = FSInput::get("email");
        if (!$email)
        {
            return false;
        }
        $sql = 'SELECT count(id) 
    			FROM  fs_members
                WHERE email = \''.$email.'\'';
        $db->query($sql);
        $count = $db->getResult();
        if ($count)
        {
            $this->alert_error('Tên đăng nhập này đã có người sử dụng');
            return false;
        }
        return true;
    }
    
   
    
    function getListCities(){
        global $db;
        $query = '  SELECT id, name
                    FROM fs_local_cities 
                    WHERE published = 1
                    ORDER BY ordering';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    
    function getListDistricts($city_id = 1){
        global $db;
        $query = '  SELECT id, name
                    FROM fs_local_districts 
                    WHERE published = 1 AND city_id = '.$city_id.'
                    ORDER BY ordering';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    function login()
    {
        global $db;
        $email = FSInput::get('lemail');
        $password = md5(FSInput::get('lpassword'));
        $sql = "SELECT *
    			FROM fs_members
    			WHERE email = '$email' AND password = '$password'";
        $db->query($sql);
        return $db->getObject();
    }
    
    function getUserInfo(){
        global $db;
        if(!isset($_SESSION['email']))
            return false;
        $sql = 'SELECT m.*,
                    (SELECT name FROM fs_local_cities AS c WHERE c.id = m.city_id LIMIT 1) AS city 
    			FROM fs_members AS m
    			WHERE email = \''.$_SESSION['email'].'\'';
        $db->query($sql);
        return $db->getObject();
    }
    
    function getJobsave($userid){
        global $db;
        if(!isset($userid))
            return false;
        $query = 'SELECT count(id) AS countjob,user_id
    			FROM fs_products_favorite
    			WHERE user_id = \''.$userid.'\'';
        $sql = $db->query($query);
		$result = $db->getObject();
		return $result;
    }
    
    function checkPass(){
        global $db;
        if(!isset($_SESSION['user_id'])) /* Sửa thông tin */
            return false;
        $password = FSInput::get("password");
        if (!$password)
        {
            return false;
        }
        $sql = 'SELECT count(id) 
    			FROM  fs_members
                WHERE password = \''.md5($password).'\' AND id = '.$_SESSION['user_id'];
        $db->query($sql);
        $count = $db->getResult();
        if ($count)
        {
            return true;
        }
        $this->alert_error('Mật khẩu hiện tại không đúng');
        return false;
    }
    
    function changepass(){
        global $db;
        $row = array();
        $row['password'] = md5(FSInput::get("new_password"));
        $id = $this->_update($row, 'fs_members', 'id='.$_SESSION['user_id']);
        return $id;
    }
    
    function getListOrder(){
        global $db;
        if(!isset($_SESSION['user_id']))
            return false;
        $query = '  SELECT *
                    FROM fs_order 
                    WHERE status = 1 AND user_id = '.$_SESSION['user_id'].'
                    ORDER BY id DESC';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    
    function getOrder($id){
        global $db;
        $query = '  SELECT *
                    FROM fs_order 
                    WHERE id = '.$id.'
                    ORDER BY id DESC
                    LIMIT 1';
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
    }
    
    function getProductsOrder($id){
        global $db;
        $query = '  SELECT name, alias, category_alias, image, o.*
                    FROM fs_products AS p
                        INNER JOIN fs_order_items AS o ON o.product_id = p.id
                    WHERE order_id = '.$id;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
    }
    
    function getProductsFavorite(){
        global $db;
        if(!isset($_SESSION['user_id']))
            return false;
        $query = '  SELECT *
                    FROM fs_products
                        INNER JOIN fs_products_favorite ON fs_products.id = fs_products_favorite.product_id
                    WHERE fs_products.published = 1 AND user_id = '.$_SESSION['user_id'].'
                    ORDER BY fs_products_favorite.created_time DESC';
		$sql = $db->query($query);
        return $db->getObjectList();
    }
    // Lay thong tin nha tuyen dung
    function getRecruiters($recruiters_id = 0){
        global $db;
        $query = '  SELECT *
                    FROM fs_products_recruiters 
                    WHERE id = '.$recruiters_id.'
                    LIMIT 1';
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}
    
    // Lay noi lam viec
    function getCity($city_id = 0){
        global $db;
        $query = '  SELECT *
                    FROM fs_local_cities 
                    WHERE id = '.$city_id.'
                    LIMIT 1';
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}
    
    // Lấy thông tin user. Tham số truyền vào là email
    function getUserforgotpassword($email){
        global $db;          
        $query = '  SELECT *
                    FROM fs_members 
                    WHERE email = "'.$email.'" LIMIT 1';
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}
    
    // thay đổi password
    function changepassforgot($id,$password){
        global $db;
        $row = array();
        $row['password'] = md5($password);
        $id = $this->_update($row, 'fs_members', 'id='.$id);
        return $id;
    }
    
    
}