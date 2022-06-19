<?php
/**
 * @author ndson
 * @category controller
 */
class UsersControllersGoogle extends FSControllers{
    function __construct(){
        $model = $this -> model;
        parent::__construct();
    }

    function google_login(){
        
        global $user;
        $strHTML = '';
        require(PATH_BASE.'libraries'.DS.'google-api-php'.DS.'config.php');
        $redirect_uri = URL_ROOT.'index.php?module=users&view=google&raw=1&task=google_login';
        $client_id = '582203957755-oogk24k4mpo3e9ktn0691ist31e7c10i.apps.googleusercontent.com';
        $client_secret = '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';
//        $client_id = '397567209187-gnh51kd9r5tnns0c8l0tvt1o8386hf5v.apps.googleusercontent.com';
//        $client_secret = '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';
        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setScopes('email');
        
       
        if (isset($_GET['code'])) {
            
            $client->authenticate($_GET['code']);
            $_SESSION['access_token']  = $client->getAccessToken();
            $access_token = json_decode($_SESSION['access_token']);
            
            $token_url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$access_token->access_token;
            $token_data = file_get_contents($token_url);
            $guser = json_decode($token_data);
            if (!empty($guser)){
                $data = $user->checkExitsEmail($guser->email);
                if ($data){
                    $user->loginMailOnly($guser->email);
                    $return['error'] 	= true;
                    $return['url']		=  URL_ROOT;
                    $return['msg']		=  "Bạn đã đăng nhập thành công";
                    $link = substr($_SESSION['current_uri'], 1);
                    $msg = FSText::_("Bạn đã đăng nhập thành công");
                    setRedirect(URL_ROOT . $link);
                }else{
                    $fs_string = FSFactory::getClass('FSString', '', '../');
                    $row['email'] = $guser->email;
                    $row['avatar'] = $guser->picture;
                    $row['name'] = explode('@', $guser->email)[0];
                    $row['password'] = md5($fs_string->generateRandomString(8));
                    $row['type'] = 'google';
                    $id = $user->insertUser($row);
                    if($id){
                        $user->updateUser(array('code' => 'CVN'.str_pad($id, 6, "0", STR_PAD_LEFT)), $id);
                        $user->loginMailOnly($guser->email);
                        $return['error'] 	= true;
                        $return['url']		=  URL_ROOT;
                        $return['msg']		=  "Lưu thành viên thành công";
                        $link = substr($_SESSION['current_uri'], 1);
                        $msg = FSText::_("Bạn đã đăng nhập thành công");
                        setRedirect(URL_ROOT . $link);
                    }//end: if($id)
                }//end: if ($data)
            }else{
                unset($_SESSION['access_token']);
            }//end: if (!empty($guser))
}
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            unset($_SESSION['access_token']);
            $this->google_login();
            // unset($_SESSION['access_token']);
        } else {
            // echo 3;die;
            $authUrl = $client->createAuthUrl();
            $strHTML  = '<script type="text/javascript">';
            $strHTML .= '	top.location.href="'.$authUrl.'"';
            $strHTML .= '</script>';
        }
        echo $strHTML;
    }
    
    
    
} 
?>