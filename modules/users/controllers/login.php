<?php
/*
 * Huy write
 */
	// controller
	class UsersControllersLogin extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
            if(($_SESSION['user_id']) && ($_COOKIE['user_id']))
            {
                $Itemid = 45;
                $url = URL_ROOT;
                setRedirect($url,'');
            }
			// call models
			$model = $this -> model;

			// param from config_module
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
			global $tmpl;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

        function login_save()
		{
			$return = FSInput::get('return');
			$url = base64_decode ( $return );
			$model = $this -> model;

            $username = FSInput::get('username');
			$check_auto = FSInput::get('save_static',0,'int');
            
            
            $redirect = FSInput::get('redirect');
			if(!$redirect){
			     $link = FSRoute::_('index.php?module=members&view=profile&task=personal&Itemid=53');
			     $link_ = FSRoute::_('index.php?module=members&view=login&Itemid=50'); 
			}else{
			     $link = base64_decode($redirect);
                 $link_ = $link;
			}

			$user = $model -> login();

			if(!$user)
			{
			    $link_ = FSRoute::_('index.php?module=members&view=login&Itemid=35'); 
				$msg = FSText::_("Email hoặc mật khẩu không đúng !");
				setRedirect($link_,$msg,'error');
			}
            
            if($user){
            	$row = array();
            	$row['user_id'] = $user->id;
            	$row['username'] = $user->username;
            	$row['type'] = 0;
            	$row['my_ip'] = $_SERVER['REMOTE_ADDR'];
            	$time = date("Y-m-d H:i:s");
	            $row['created_time'] = $time;
            	$model -> _add($row, 'fs_members_seekers_history');
            }


			// logged
            $_SESSION['email'] = $user->email ;
            $_SESSION['telephone'] = $user->telephone ;
            $_SESSION['fullname'] = $user->full_name ;
            $_SESSION['username'] = $username ;
            $_SESSION['user_id'] = $user->id ;
            $_SESSION['avatar'] = $user->avatar ;
            $_SESSION['level'] = $user->level ;
//            var_dump($_SESSION);die;
            if($user->level!=0){
                $_SESSION['expiration_date']=$user->expiration_date;
            }

            setcookie("email", $user->email ,time() +200000000,'/');
//            setcookie("fullname", $user->full_name ,time() +200000000 ,'/');
            setcookie("username", $username ,time() +200000000,'/');
            setcookie("user_id", $user->id ,time() +200000000,'/');
            setcookie("avatar", $user->avatar ,time() +200000000,'/');
            // logged

			$msg = FSText::_("Bạn đã đăng nhập thành công");
			setRedirect(URL_ROOT,$msg);
		}

		function logout12(){
            if(($_SESSION['user_id']) && ($_COOKIE['user_id']))
            {
                session_destroy();
                setcookie('user_id','');
                setcookie('username','');
                setcookie('fullname','');
                setcookie('email','');
                $url = URL_ROOT;
                setRedirect($url,'');
            }
		}

	}

?>
