
<?php 
	class UsersModelsLogin extends FSModels
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
	
	}
	
?>