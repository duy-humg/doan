
<?php 
	class UsersModelsFormregister extends FSModels
	{
		function __construct()
		{
		  $fstable = FSFactory::getClass('fstable');
		  $this->table_members  = 'fs_members_seekers';
		}
        
        /*
		 * function login 
		 */
		function login()
		{
			global $db;
            
			$username = FSInput::get('username');

			$password = md5(FSInput::get('password'));
            
			$sql = ' SELECT id, username,full_name,block,telephone,published,email,published_info,is_type,avatar,`level`,expiration_date
					 FROM fs_members
					 WHERE published = 1 AND (username = "'.$username.'" OR `email` = "'.$username.'" ) AND password = "'.$password.'" AND block <> 1
				  ';
            $rs = $db -> getObject($sql);
			return $rs;
		}

		function get_data()
		{
			global $db;
            
			$id = FSInput::get('id');

			
            
			$sql = ' SELECT id,telephone,published
					 FROM fs_members
					 WHERE published = 1 AND id = '.$id.'
				  ';
            $rs = $db -> getObject($sql);
			return $rs;
		}

	

		function reset_passs()
		{
			global $db, $user;
	
			$row = array();
			$id = FSInput::get('id_method');
		
	
			$row['password'] = md5(FSInput::get('dk_password'));
			
	
			$id = $this->_update($row, 'fs_members', 'id=' . $id);
			return $id;
		}
	

		function get_check_reset_pass()
		{
			global $db;
            
			$giatri = FSInput::get('giatri');

			
            
			$sql = ' SELECT id,telephone,published,email
					 FROM fs_members
					 WHERE published = 1 AND ( telephone = '.$giatri.' or email = '.$giatri.' )
				  ';
            $rs = $db -> getObject($sql);
			return $rs;
		}

		function check_phone()
		{
			global $db;
            
			$phone = FSInput::get('dk_phone');
            
			$sql = ' SELECT *
					 FROM fs_members
					 WHERE published = 1 AND (telephone = "'.$phone.'" ) 
				  ';
            $rs = $db -> getObject($sql);
			return $rs;
		}

		function save_dk()
    {

        global $db, $user;
        $row = array();
        



		$phone = FSInput::get('phone_dk');
		$pass = FSInput::get('dk_password');
  
       
        $row['telephone'] = $phone;
      
     

        $time = date("Y-m-d H:i:s");
        $row['password'] = md5($pass);
        $row['published'] = 1;
        $fstring = FSFactory::getClass('FSString', '', '../');
        $row['code'] = $fstring->generateRandomString(32);
        $activated_code = $row['code'];
        $row['created_time'] = $time;
        $row['lastedit_date'] = $time;

        $id = $this->_add($row, 'fs_members');

        return $id;
    }
	
	}
	
?>