<?php

class FaqModelsFaq extends FSModels {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_faq');
    }

    function get_faq_list() {
        $query = ' select * from ' . $this->table_name . ' where published = 1 ';
        global $db;
        $sql = $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function save() {
        
        
        $fullname = FSInput::get('fullname');
        $address = FSInput::get('address_faq');
        $telephone = FSInput::get('mobiphone');
        $email = FSInput::get('email_faq');

        $content = htmlspecialchars_decode(FSInput::get('content_faq'));
        $time = date("Y-m-d H:i:s");
        $published = 0;

        $sql = " INSERT INTO 
						" . $this->table_name . " (`email`,title,address,telephone,question,updated_time,created_time,published)
						VALUES ('$email','$fullname','$address','$telephone','$content','$time','$time','$published')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }

}

?>