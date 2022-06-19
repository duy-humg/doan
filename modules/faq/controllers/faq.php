<?php

/*
 * Linh write
 */

// controller
class FaqControllersFaq extends FSControllers {

    function display() {
        $model = $this->model;

        $submitbt = FSInput::get('submitbt');
        $msg = '';
        $list = $model->get_faq_list();

//        $array_breadcrumb[] = array(0 => array('name' => FSText::_('FAQ'), 'link' => '', 'selected' => 0));
        // breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs [] = array(0 => FSText::_('Câu hỏi thường gặp'), 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->set_seo_special();
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/' . 'default.php';
    }

    function send_question() {
        $model = $this->model;

        //cấu hình thông tin do google cung cấp
        $api_url = 'https://www.google.com/recaptcha/api/siteverify';
        $site_key = '6LfckmIUAAAAAI1OFUtaAv6kFfWOBnw25KEsRqKt';
        $secret_key = '6LfckmIUAAAAAAyjnE8E_SNil6Cb6uv_I-scnWN7';


        //lấy dữ liệu được post lên
        $site_key_post = FSInput::get('g-recaptcha-response');

        //lấy IP của khach
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $remoteip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $remoteip = $_SERVER['REMOTE_ADDR'];
        }

        //tạo link kết nối
        $api_url = $api_url . '?secret=' . $secret_key . '&response=' . $site_key_post . '&remoteip=' . $remoteip;
        //lấy kết quả trả về từ google
        $response = file_get_contents($api_url);
        //dữ liệu trả về dạng json
        $response = json_decode($response);
        
        $link = FSRoute::_("index.php?module=faq&view=faq");
        
        if (!isset($response->success)) {
            $msg = FSText::_('Captcha không đúng');
            setRedirect($link, $msg);
            return;
        }
        if ($response->success == false) {
            $msg = FSText::_('Captcha không đúng');
            setRedirect($link, $msg);
            return;
        }
        

        $id = $model->save();
        $sender_name = FSInput::get('fullname');
        $sender_email = FSInput::get('email_faq');
        $return = base64_decode(FSInput::get('return'));
        if ($id) {
            if ($return) {
                $link = $return;
            } else {
                $link = FSRoute::_("index.php?module=faq&view=faq");
            }

            $msg = FSText::_("Cám ơn bạn đã đặt câu hỏi cho chúng tôi.");
//            if (!$this->send_mail($sender_name, $sender_email)) {
//                $msg = FSText::_("Cám ơn bạn đã liên lạc với chúng tôi.");
//            }
            setRedirect($link, $msg);
            return;
        } else {
            echo "<script type='text/javascript'>alert('Xin lỗi bạn không gửi được thông điệp.'); </script>";
            $this->display();
            return;
        }
    }

    function send_mail($sender_name = '', $sender_email = '', $sender_parts_name = '') {
        include 'libraries/errors.php';
        // send Mail()
        $mailer = FSFactory::getClass('Email', 'mail');
        $global = new FsGlobal();

        // sender
        $sender_title = FSInput::get('contact_title');

        // Recipient

        $to = $global->getConfig('admin_email');
        $site_name = $global->getConfig('site_name');

        global $config;
        $subject = ' - Hỏi đáp';

        $contact_fullname = FSInput::get('fullname');
        $address = FSInput::get('address_faq');
        $contact_telephone = FSInput::get('mobiphone');
        $contact_email = FSInput::get('email_faq');

        $content = htmlspecialchars_decode(FSInput::get('content_faq'));

        $mailer->isHTML(true);
        $mailer->setSender(array($sender_email, $sender_name));
        $mailer->AddAddress($to, 'admin');

        $arr_mail = explode(',', $contact_parts_email);
        if ($arr_mail && count($arr_mail)) {
            $i = 0;
            foreach ($arr_mail as $item) {
                $mailer->AddCC($item, $sender_name);
                ;
                $i ++;
            }
        }

        $mailer->setSubject('' . html_entity_decode($site_name) . ' ' . $subject . ' từ ' . $contact_fullname);
        // body

        $body = '';
        $body .= '<table border="0" cellpadding="1" cellspacing="1"><tbody>';
        $body .= '<tr><td style="width:120px;"><strong>Họ và tên:</strong></td><td>' . $contact_fullname . '</td></tr>';
        $body .= '<tr><td style="width:120px;"><strong>Email:</strong></td><td>' . $contact_email . '</td></tr>';
        $body .= '<tr><td style="width:120px;"><strong>Số điện thoại:</strong></td><td>' . $contact_telephone . '</td></tr>';
        $body .= '<tr><td style="width:120px;"><strong>Địa chỉ:</strong></td><td>' . $address . '</td></tr>';
        $body .= '<tr><td style="width:120px;"><strong>Nội dung:</strong></td><td>' . $content . '</td></tr>';
        $body .= '</tbody></table>';
        $mailer->setBody($body);
        if (!$mailer->Send())
            return false;
        return true;
    }

}

?>