<?php
//https://developers.facebook.com/apps/
/**
 * @author ndson
 * @category controller
 */
class UsersControllersFace extends FSControllers{
    function __construct(){
        parent::__construct();
	}

    function face_login(){
		$strHTML = '';
		// $app_id = "1957691521224039";
		// $app_secret = "40a00b28a679a37c760ed8ccdad21636";
		$app_id = "298968428552993";
		$app_secret = "22b9125f7122c09ef21037e13277f985";
		$my_url = FSRoute::_('index.php?module=users&view=face&task=face_login&Itemid=10');

		if(FSInput::get('pay')){
			$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
		}else
			$link=URL_ROOT;
		$permission = "email,public_profile";
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:'';
		if(empty($code)) {
			$strHTML = '';
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			//$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
			//$strHTML  = '<script type="text/javascript">';
			//$strHTML .= '	top.location.href="'.$dialog_url.'"';
			//$strHTML .= '</script>';
		}

		$S_State =isset($_SESSION['state'])?$_SESSION['state']:'';
		$R_State = isset($_REQUEST['state'])?$_REQUEST['state']:'';
		if( $S_State && ($S_State == $R_State)) {
    		$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&redirect_uri='.urlencode($my_url).'&client_secret='.$app_secret.'&code='.$code;
     		$response = file_get_contents($token_url);
            $response = json_decode($response);
     		//$params = null;
     	 	//parse_str($response, $params);
            $_SESSION['access_token'] = $response->access_token;

     		$graph_url = "https://graph.facebook.com/me?fields=email,id,name,gender&access_token=" . $response->access_token;
	 		$data = file_get_contents($graph_url);
     		$user = json_decode($data);
//     		var_dump($user);
//     		die();
			if(empty($user->email) && !$user->email){
                $msg = FSText::_("Tài khoản Facebook của bạn hiện đang không đăng nhập bằng email, bạn vui lòng đăng ký bằng tài khoản Facebook có email hoặc đăng ký thành viên.");
                $token = $_SESSION["access_token"];
                if($token)
                {
                    $graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=".$token;
                    $result = json_decode(file_get_contents($graph_url));
                }
				if(FSInput::get('pay')){
					$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
				}else
					$link=URL_ROOT;
                setRedirect($link, $msg);
            }
			if (!empty($user)){
				$data = $this->model->checkExitsEmail($user->id);
				//testVar($data); echo 'aaa';die;
				if ($data)
				{
		           	// neu ton tai thi cho dang nhap luon, ko quan tam tk mail nay dang ky thu cong hay bang face
					$_SESSION['face'] = 1;
					$_SESSION['fullname'] = $data->full_name;
					$_SESSION['user_name'] = $data->username;
					$_SESSION['email'] 		= $data->email;
                    $_SESSION['id_face']   = $data->id_face;
                    $_SESSION['avatar']   = $data->avatar;
                    //setcookie("email", $data->email ,time() +20000000000);
                    setcookie("fullname", $data->full_name ,time() +20000000000);
                    setcookie("user_name", $data->username ,time() +20000000000);
                    setcookie("user_id", $data->id ,time() +20000000000);
                    setcookie("avatar", $data->avatar ,time() +20000000000);
                    setcookie("email", $data->email ,time() +20000000000);

                    unset($_SESSION['el_email']);
					unset($_SESSION['el_full_name'] );
					unset($_SESSION['el_user_name']);
					unset($_SESSION['el_user_id']);
					unset($_SESSION['el_published_info']);
					unset($_SESSION['el_avatar']);

		            // luu lich su
					$row = array();
	            	$row['user_id'] = $data->id;
	            	$row['username'] = $data->full_name;
	            	$row['type'] = 1;
	            	$row['my_ip'] = $_SERVER['REMOTE_ADDR'];
	            	$time = date("Y-m-d H:i:s");
		            $row['created_time'] = $time;
	            	$this->model -> _add($row, 'fs_members_history');


					$_SESSION['user_id'] = $data->id;
					//$_SESSION['avatar'] = 'https://graph.facebook.com/'.$user->id.'/picture?type=small'; //square,small,normal,large
                    $_SESSION['avatar'] = $data->avatar;
					$_SESSION['user'] = $data;
						$return['error'] 	= true;
						$return['url']		=  FSRoute::_('index.php?module=users&Itemid=22');//URL_ROOT;
                        $return['msg']		=  FSText::_(" Bạn đã đăng nhập thành công ");
                        $return['msg']		=  FSText::_(" Bạn đã đăng nhập thành công ");
						$strHTML  = '<script type="text/javascript">';
						$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
						$strHTML .= '	window.close();';
						$strHTML .= '</script>';
						//echo $strHTML;
						
						// $link = URL_ROOT;
//						$link = FSRoute::_('index.php?module=users&Itemid=22');
					if(FSInput::get('pay')){
						$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
					}else
						$link=URL_ROOT;
						$msg = FSText::_("Bạn đã đăng nhập thành công");
						setRedirect($link, $msg);
				}else{
					$id = $this->model->save($user);
					if($id){
						$_SESSION['face'] = 1;
						$_SESSION['user_name'] = $user->name;
						$_SESSION['email'] 	   = $user->email;
                        $_SESSION['id_face']   = $user->id;
                        $_SESSION['avatar']   = $user->avatar;
                        //setcookie("user_id", $id ,time() +20000000000);
						$_SESSION['user_id']   = $id;
                        setcookie("user_id", $id ,time() +20000000000);
                        setcookie("user_name", $user->name ,time() +20000000000);
                        setcookie("email", $user->email ,time() +20000000000);
                        setcookie("avatar", $user->avatar ,time() +20000000000);
						//$_SESSION['avatar'] = 'https://graph.facebook.com/'.$user->id.'/picture?type=small'; //square,small,normal,large
                        $_SESSION['avatar'] = 'https://graph.facebook.com/'. $user->id .'/picture?width=190&height=190';
						$_SESSION['user'] = $user;
						$_SESSION['fslogin'] = 1;

					}

					unset($_SESSION['el_email']);
					unset($_SESSION['el_full_name'] );
					unset($_SESSION['el_user_name']);
					unset($_SESSION['el_user_id']);
					unset($_SESSION['el_published_info']);
					unset($_SESSION['el_avatar']);

					setcookie("el_email", '' ,time() - 200000000,'/');
			        setcookie("el_full_name", '' ,time() - 200000000,'/');
			        setcookie("el_user_name", '' ,time() - 200000000,'/');
			        setcookie("el_user_id", '',time() - 200000000,'/');
			        setcookie("el_published_info", '' ,time() -200000000,'/');
			        setcookie("el_avatar", '' ,time() -200000000,'/');

			        // luu lich su
					$row = array();
	            	$row['user_id'] = $user->id;
	            	$row['username'] = $user->name;
	            	$row['type'] = 1;
	            	$row['my_ip'] = $_SERVER['REMOTE_ADDR'];
	            	$time = date("Y-m-d H:i:s");
		            $row['created_time'] = $time;
	            	$this->model -> _add($row, 'fs_members_history');

					// $link = FSRoute::_('index.php?module=members&view=edit&Itemid=50');//URL_ROOT;
					// $link = URL_ROOT;
//					$link = FSRoute::_('index.php?module=users&Itemid=22');
					if(FSInput::get('pay')){
						$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
					}else
						$link=URL_ROOT;
                    $msg = FSText::_(" Bạn đã đăng nhập thành công ");
					setRedirect($link, $msg);
				}
			}else {
				$strHTML = '';
				$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
				$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
				$strHTML  = '<script type="text/javascript">';
				$strHTML .= 'top.location.href="'.$dialog_url.'"';
				$strHTML .= '</script>';
			}
   		}else {
    		$strHTML = '';
			$error_reason = FSInput::get('error_reason','');
			if(FSInput::get('pay')){
				$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
			}else
				$link=URL_ROOT;
			if($error_reason && $error_reason == 'user_denied')
				setRedirect($link, FSText::_('Bạn đã hủy xác thực đăng nhập Facebook'));

			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
			$strHTML  = '<script type="text/javascript">';
			$strHTML .= 'top.location.href="'.$dialog_url.'"';
			$strHTML .= '</script>';
   		}
		echo $strHTML;
		//require(PATH_BASE.'modules/'.$this->module.'/views/face/login-face.php');
     }
    function face_login_pay(){
		$strHTML = '';
		// $app_id = "1957691521224039";
		// $app_secret = "40a00b28a679a37c760ed8ccdad21636";
		$app_id = "1501429543359712";
		$app_secret = "8b683a83b0aa14d26db8ce9373fb1858";
		$my_url = FSRoute::_('index.php?module=users&view=face&task=face_login&Itemid=10');

		$permission = "email,public_profile";
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:'';
		if(empty($code)) {
			$strHTML = '';
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			//$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
			//$strHTML  = '<script type="text/javascript">';
			//$strHTML .= '	top.location.href="'.$dialog_url.'"';
			//$strHTML .= '</script>';
		}

		$S_State =isset($_SESSION['state'])?$_SESSION['state']:'';
		$R_State = isset($_REQUEST['state'])?$_REQUEST['state']:'';
		if( $S_State && ($S_State == $R_State)) {
    		$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&redirect_uri='.urlencode($my_url).'&client_secret='.$app_secret.'&code='.$code;
     		$response = file_get_contents($token_url);
            $response = json_decode($response);
     		//$params = null;
     	 	//parse_str($response, $params);
            $_SESSION['access_token'] = $response->access_token;

     		$graph_url = "https://graph.facebook.com/me?fields=email,id,name,gender&access_token=" . $response->access_token;
	 		$data = file_get_contents($graph_url);
     		$user = json_decode($data);
//     		var_dump($user);
//     		die();
			if(empty($user->email) && !$user->email){
                $msg = FSText::_("Tài khoản Facebook của bạn hiện đang không đăng nhập bằng email, bạn vui lòng đăng ký bằng tài khoản Facebook có email hoặc đăng ký thành viên.");
                $token = $_SESSION["access_token"];
                if($token)
                {
                    $graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=".$token;
                    $result = json_decode(file_get_contents($graph_url));
                }
					$link=URL_ROOT;
                setRedirect($link, $msg);
            }
			if (!empty($user)){
				$data = $this->model->checkExitsEmail($user->id);
				//testVar($data); echo 'aaa';die;
				if ($data)
				{
		           	// neu ton tai thi cho dang nhap luon, ko quan tam tk mail nay dang ky thu cong hay bang face
					$_SESSION['face'] = 1;
					$_SESSION['fullname'] = $data->full_name;
					$_SESSION['user_name'] = $data->username;
					$_SESSION['email'] 		= $data->email;
                    $_SESSION['id_face']   = $data->id_face;
                    $_SESSION['avatar']   = $data->avatar;
                    //setcookie("email", $data->email ,time() +20000000000);
                    setcookie("fullname", $data->full_name ,time() +20000000000);
                    setcookie("user_name", $data->username ,time() +20000000000);
                    setcookie("user_id", $data->id ,time() +20000000000);
                    setcookie("avatar", $data->avatar ,time() +20000000000);
                    setcookie("email", $data->email ,time() +20000000000);

                    unset($_SESSION['el_email']);
					unset($_SESSION['el_full_name'] );
					unset($_SESSION['el_user_name']);
					unset($_SESSION['el_user_id']);
					unset($_SESSION['el_published_info']);
					unset($_SESSION['el_avatar']);

		            // luu lich su
					$row = array();
	            	$row['user_id'] = $data->id;
	            	$row['username'] = $data->full_name;
	            	$row['type'] = 1;
	            	$row['my_ip'] = $_SERVER['REMOTE_ADDR'];
	            	$time = date("Y-m-d H:i:s");
		            $row['created_time'] = $time;
	            	$this->model -> _add($row, 'fs_members_history');


					$_SESSION['user_id'] = $data->id;
					//$_SESSION['avatar'] = 'https://graph.facebook.com/'.$user->id.'/picture?type=small'; //square,small,normal,large
                    $_SESSION['avatar'] = $data->avatar;
					$_SESSION['user'] = $data;
						$return['error'] 	= true;
						$return['url']		=  FSRoute::_('index.php?module=users&Itemid=22');//URL_ROOT;
                        $return['msg']		=  FSText::_(" Bạn đã đăng nhập thành công ");
                        $return['msg']		=  FSText::_(" Bạn đã đăng nhập thành công ");
						$strHTML  = '<script type="text/javascript">';
						$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
						$strHTML .= '	window.close();';
						$strHTML .= '</script>';
						//echo $strHTML;

						// $link = URL_ROOT;

						$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
						$msg = FSText::_("Bạn đã đăng nhập thành công");
						setRedirect($link, $msg);
				}else{
					$id = $this->model->save($user);
					if($id){
						$_SESSION['face'] = 1;
						$_SESSION['user_name'] = $user->name;
						$_SESSION['email'] 	   = $user->email;
                        $_SESSION['id_face']   = $user->id;
                        $_SESSION['avatar']   = $user->avatar;
                        //setcookie("user_id", $id ,time() +20000000000);
						$_SESSION['user_id']   = $id;
                        setcookie("user_id", $id ,time() +20000000000);
                        setcookie("user_name", $user->name ,time() +20000000000);
                        setcookie("email", $user->email ,time() +20000000000);
                        setcookie("avatar", $user->avatar ,time() +20000000000);
						//$_SESSION['avatar'] = 'https://graph.facebook.com/'.$user->id.'/picture?type=small'; //square,small,normal,large
                        $_SESSION['avatar'] = 'https://graph.facebook.com/'. $user->id .'/picture?width=190&height=190';
						$_SESSION['user'] = $user;
						$_SESSION['fslogin'] = 1;

					}

					unset($_SESSION['el_email']);
					unset($_SESSION['el_full_name'] );
					unset($_SESSION['el_user_name']);
					unset($_SESSION['el_user_id']);
					unset($_SESSION['el_published_info']);
					unset($_SESSION['el_avatar']);

					setcookie("el_email", '' ,time() - 200000000,'/');
			        setcookie("el_full_name", '' ,time() - 200000000,'/');
			        setcookie("el_user_name", '' ,time() - 200000000,'/');
			        setcookie("el_user_id", '',time() - 200000000,'/');
			        setcookie("el_published_info", '' ,time() -200000000,'/');
			        setcookie("el_avatar", '' ,time() -200000000,'/');

			        // luu lich su
					$row = array();
	            	$row['user_id'] = $user->id;
	            	$row['username'] = $user->name;
	            	$row['type'] = 1;
	            	$row['my_ip'] = $_SERVER['REMOTE_ADDR'];
	            	$time = date("Y-m-d H:i:s");
		            $row['created_time'] = $time;
	            	$this->model -> _add($row, 'fs_members_history');

					// $link = FSRoute::_('index.php?module=members&view=edit&Itemid=50');//URL_ROOT;
					// $link = URL_ROOT;
//					$link = FSRoute::_('index.php?module=users&Itemid=22');
					$link=FSRoute::_('index.php?module=products&view=pay&task=step_address&Itemid=23');
                    $msg = FSText::_(" Bạn đã đăng nhập thành công ");
					setRedirect($link, $msg);
				}
			}else {
				$strHTML = '';
				$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
				$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
				$strHTML  = '<script type="text/javascript">';
				$strHTML .= 'top.location.href="'.$dialog_url.'"';
				$strHTML .= '</script>';
			}
   		}else {
    		$strHTML = '';
			$error_reason = FSInput::get('error_reason','');

				$link=URL_ROOT;
			if($error_reason && $error_reason == 'user_denied')
				setRedirect($link, FSText::_('Bạn đã hủy xác thực đăng nhập Facebook'));

			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
			$strHTML  = '<script type="text/javascript">';
			$strHTML .= 'top.location.href="'.$dialog_url.'"';
			$strHTML .= '</script>';
   		}
		echo $strHTML;
		//require(PATH_BASE.'modules/'.$this->module.'/views/face/login-face.php');
     }
}
?>
