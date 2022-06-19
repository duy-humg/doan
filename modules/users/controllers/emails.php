<?php
/*
 * Huy write
 */
	// controller
	
	class UsersControllersEmails
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'emails';
		}
		
		function sendMailForget($user,$resetPass)
		{
			include 'libraries/errors.php';
            // send Mail()
            $mailer = FSFactory::getClass('Email', 'mail');
            $global = new FsGlobal();
				// send Mail()

//				$mailer = FSFactory::getClass('Email','mail/');
//				$global = new FsGlobal();
				$admin_name = $global -> getConfig('admin_name');
				$admin_email = $global -> getConfig('admin_email');
				global $config;

				$mailer -> isHTML(true);
				$mailer -> setSender(array($admin_email,$config['site_name']));
				$mailer -> AddBCC('noreply@adcbook.net.vn','1234567@');
				$mailer -> AddAddress($user->email,$user->username);
				$mailer -> setSubject("http://" . str_replace("www.","",$config['site_name'])." Khôi phục mật khẩu");

				// body
				$body = '';
				$body .= '<div>Chào bạn!</div>';
				$body .= '<div>Bạn đã sử dụng chức năng lấy lại mật khẩu</div>';
				$body .= '<div>Mật khẩu đăng nhập mới của bạn là: <strong>'.$resetPass.'</strong> (Vui lòng thay đổi mật khẩu ngay sau khi đăng nhập).</div>';
				$body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';

				$mailer -> setBody($body);

				if(!$mailer ->Send()){
				    return false;
                }
				return true;
		}
		
		
		
	}
	
?>
