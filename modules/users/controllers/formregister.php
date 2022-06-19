<?php
/*
 * Huy write
 */
	// controller
	class UsersControllersFormregister extends FSControllers
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
			$tmpl->assign('title', 'Đăng ký');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function check_xacminh() {
			$phone = FSInput::get('dk_phone');
			$fssecurity = FSFactory::getClass('fssecurity');
		
		
	
			$global_class = FSFactory::getClass('FsGlobal');
			$model = $this->model;

			$check_phone = $model->check_phone();

			if($check_phone){
				$link_ = FSRoute::_('index.php?module=users&view=formregister'); 
				$msg = FSText::_("Số điện thoại đã tồn tại!");
				setRedirect($link_,$msg,'error');
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=xacminh&id='.$phone); 
				// var_dump($link_);die;
				setRedirect($link_);
			}
		}

		function check_xacminhb2() {
			$phone = FSInput::get('phone_dk');
			// var_dump($phone);die;
			// echo 1;die;

			if($phone){
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=thietlap&id='.$phone); 
				// var_dump($link_);die;
				setRedirect($link_);
			
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister'); 
				$msg = FSText::_("Số điện thoại đã tồn tại!");
				setRedirect($link_,$msg,'error');
			}
		}

		function check_xacminhb3() {
			$phone = FSInput::get('phone_dk');
			$pass = FSInput::get('dk_password');
			// var_dump($phone);die;
			// echo 1;die;

			if($phone and $pass){


				$model = $this->model;
				$id = $model->save_dk();
				// var_dump($id);die;

				if($id){
					$link_ = FSRoute::_('index.php?module=users&view=formregister&task=thanhcong&id='.$id); 
					// var_dump($link_);die;
					setRedirect($link_);
				}else{
					$link_ = FSRoute::_('index.php?module=users&view=formregister'); 
					
					setRedirect($link_);
				}
				
			
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister'); 
				setRedirect($link_);
			}
		}

		function xacminh() {
			$model = $this -> model;
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
			global $tmpl;
			$tmpl->assign('title', 'Đăng ký');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/xacminh_b1.php';
		}
		function thietlap() {
			$model = $this -> model;
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
			global $tmpl;
			$tmpl->assign('title', 'Đăng ký');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/xacminh_b2.php';
		}

		function thanhcong() {
			$model = $this -> model;
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
			$data=$model->get_data();
			// var_dump($data);
			global $tmpl;
			$tmpl->assign('title', 'Đăng ký thành công');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/thanhcong.php';
		}

		function pass_reset() {
			$model = $this -> model;
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
			
		
			global $tmpl;
			$tmpl->assign('title', 'Đặt lại mật khẩu');
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/pass_reset.php';
		}

		function method() {

			$giatri = FSInput::get('giatri');
			
			if($giatri){
				$model = $this -> model;
				$data =$model->get_check_reset_pass();
				if($data){
					$breadcrumbs = array();
					$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
					
				
					global $tmpl;
					$tmpl->assign('title', 'Phương thức quên mật khẩu');
					$tmpl -> assign('breadcrumbs', $breadcrumbs);
					$tmpl -> set_seo_special();
		
					// call views
					include 'modules/'.$this->module.'/views/'.$this->view.'/method.php';
				}else{
					$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
					$msg = FSText::_("Số điện thoại hoặc emal không tồn tại!");
					setRedirect($link_,$msg,'error');
					
				}
				

				
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
					
				setRedirect($link_);
			}
			
		}

		function method_smt() {
			
			$type_method = FSInput::get('type_method');
			if(!$type_method){
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
				setRedirect($link_);
			}

			if($type_method==1){

				$id_method = FSInput::get('id_method');
				$phone_method = FSInput::get('phone_method');
				$email_method = FSInput::get('email_method');
				$model = $this -> model;
				$breadcrumbs = array();
				$breadcrumbs[] = array(0=> FSText::_('Thành viên'), 1 => '');
				$this->send_mail($email_method);
			
				global $tmpl;
				$tmpl->assign('title', 'Đặt lại mật khẩu');
				$tmpl -> assign('breadcrumbs', $breadcrumbs);
				$tmpl -> set_seo_special();
				include 'modules/'.$this->module.'/views/'.$this->view.'/mailb1.php';
			}else{

				$id_method = FSInput::get('id_method');
				$phone_method = FSInput::get('phone_method');
				$email_method = FSInput::get('email_method');
				include 'modules/'.$this->module.'/views/'.$this->view.'/xacminh_phone.php';
			}
			
		}
		function xacminh_email() {

			$id_method = FSInput::get('id_method');
			$phone_method = FSInput::get('phone_method');
			$email_method = FSInput::get('email_method');
			$type_method = FSInput::get('type_method');
			if($phone_method){
				include 'modules/'.$this->module.'/views/'.$this->view.'/xacminh_email.php';
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
				setRedirect($link_);
			}	
		}

		function resend_code_email() {

			$id_method = FSInput::get('id_method');
			$phone_method = FSInput::get('phone_method');
			$email_method = FSInput::get('email_method');
			$type_method = FSInput::get('type_method');
			if($phone_method){
				$this->send_mail($email_method);
				include 'modules/'.$this->module.'/views/'.$this->view.'/xacminh_email.php';
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
				setRedirect($link_);
			}
			
			
		}

		function doimatkhau() {

			$id_method = FSInput::get('id_method');
			$phone_method = FSInput::get('phone_method');
			$email_method = FSInput::get('email_method');
			$type_method = FSInput::get('type_method');
			if($phone_method){
				include 'modules/'.$this->module.'/views/'.$this->view.'/doimatkhau.php';
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
				setRedirect($link_);
			}
			
			
		}

		function pass_thanhcong() {
			$pass = FSInput::get('dk_password');
		
			if(!$pass){
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
				setRedirect($link_);
			}

			$id_method = FSInput::get('id_method');
			$phone_method = FSInput::get('phone_method');
			$email_method = FSInput::get('email_method');
			$type_method = FSInput::get('type_method');
			unset($_SESSION['code_email_pass']);

			$model = $this -> model;
			$id =$model->reset_passs();

			


			if($id){
				include 'modules/'.$this->module.'/views/'.$this->view.'/pass_thanhcong.php';
			}else{
				$link_ = FSRoute::_('index.php?module=users&view=formregister&task=pass_reset'); 
				$msg = FSText::_("Đổi mật khẩu không thành công");
				setRedirect($link_,$msg,'error');
			}
			
			
		}

		function send_mail($sender_email)
		{
			include 'libraries/errors.php';
	
			$mailer = FSFactory::getClass('Email', 'mail');
			$global = new FsGlobal();

		
			$sender_title = FSInput::get('contact_title');

			$to = $global->getConfig('admin_email');
			$site_name = $global->getConfig('site_name');

			global $config;
			$subject = 'Mã xác minh';

			$a = mt_rand(100000, 999999);
			$_SESSION['code_email_pass'] = $a;
		

			$mailer->isHTML(true);
			$mailer->setSender(array('', ''));
			$mailer->AddAddress($sender_email, 'admin');

			$mailer->setSubject('Mã xác minh');
			// body

			$body = '';
			$body .= '<p align="left">' . FSText::_('Mã xác minh của bạn là: ') . ' '.$_SESSION['code_email_pass'].'</p>';
			
			$mailer->setBody($body);
			if (!$mailer->Send())
				return false;
			return true;
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
