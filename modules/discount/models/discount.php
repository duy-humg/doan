<?php
class DiscountModelsDiscount extends FSModels {
	
	function save() {
		$time = date ( "Y-m-d H:i:s" );
		$row['email'] = FSInput::get ( 'email' );
		$row['published'] = 1;
		$row['created_time'] = $time;
		$row['edited_time'] = $time;
		
		$fstring = FSFactory::getClass('FSString','','../');
		$row['code'] = $fstring->generateRandomString(8);
		
		$id = $this -> _add($row,'fs_discount_members');
		if(!$id)	
			return false;
		
		$email=$row['email'];
                $name="Geni";
                $mailer = FSFactory::getClass ( 'Email', 'mail' );
		$global = new FsGlobal ();
		$admin_name = $global->getConfig ( 'admin_name' );
		$admin_email = $global->getConfig ( 'admin_email' );
        $mail_register_subject = 'Geni- Thư thông báo đăng ký nhận tin';
//		var_dump($mail_register_subject);die;
        $mail_register_body = $global->getConfig ( 'mail_register_body' );
//		print_r($mail_register_body);die;
		//			global $config;
		// config to user gmail
		

//		$mailer->isHTML ( true );
		//			$mailer -> IsSMTP();
//		$mailer->setSender ( array ($admin_email, $admin_name ) );
//		$mailer->AddAddress ( $email, $name );
		//$mailer->AddBCC ( 'trangkv@finalstyle.com', 'pham van huy' );
//		$mailer->setSubject ( $mail_register_subject );		
			// body
//                $body = '<p>Cảm ơn bạn đã đăng ký nhận tin, chúng tôi sẽ cập nhật tin đến bạn sớm nhất có thể!</p>';;
//
//                $mailer->setBody ( $body );
//
//                if (! $mailer->Send()) {
//                        Errors::_ ( 'Có lỗi khi gửi mail' );
//                        return false;
//                }
                return true;
	}
	
	function update_total_member($discount_id){
		if(!$discount_id)
			return false;
		$total = $this -> get_count('discount_id = '.$discount_id.' AND published = 1 ','fs_discount_members');
		$row['total'] = $total;
		return $this -> _update($row,'fs_discount','  id = '.$discount_id);	
	}
	
	function send_mail($email,$code) {
		include 'libraries/errors.php';
		// send Mail()
		$mailer = FSFactory::getClass ( 'Email', 'mail' );
		$global = new FsGlobal ();
		$admin_name = $global->getConfig ( 'admin_name' );
		$admin_email = $global->getConfig ( 'admin_email' );
		$mail_register_subject = $global->getConfig ( 'mail_discount_subject' );
		$mail_register_body = $global->getConfig ( 'mail_discount_body' );
		
		//			global $config;
		// config to user gmail
				
		

		$mailer->isHTML ( true );
		//			$mailer -> IsSMTP();
		$mailer->setSender ( array ($admin_email, $admin_name ) );
		$mailer->AddAddress ( $email );
//		$mailer->AddBCC ( 'quynhtn@finalstyle.com', 'pham van huy' );
		$mailer->setSubject ( $mail_register_subject );
		// body
		$body = $mail_register_body;
		$body = str_replace ( '{code}', $code, $body );
		$body = str_replace ( '{email}', $email, $body );
		
		$mailer->setBody ( $body );
		
		if (! $mailer->Send ()) {
			Errors::_ ( 'Có lỗi khi gửi mail' );
			return false;
		}
		return true;
	}
	
	/*
	 * Check exist email follow discount_id
	 */
	function check_exist($email) {
		if (!$email )
			return true;
		$query = " SELECT count(*)
					  FROM fs_discount_members
					WHERE 
						email = '" . $email . "' " ;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	
	/*
	 * Check limit
	 */
	function check_limit($discount_id) {
		if (!$discount_id)
			return false;
		$limit = $this -> get_result('id = '.$discount_id,'fs_discount','`limit`');	
		$total = $this -> get_count('discount_id = '.$discount_id.' AND published = 1 ','fs_discount_members');
		return $total < $limit ? true: false;
	}
}
?>