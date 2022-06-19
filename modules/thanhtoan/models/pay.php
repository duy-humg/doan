<?php

class ThanhtoanModelsPay extends FSModels
{
    function __construct()
    {
        parent::__construct();
        global $module_config;
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_order_post', 0);
    }

    function saveOrder($nl_result)
    {
        global $db;
        $row = array();

        $row['code'] = $nl_result->order_code;
        $row['user_id'] = $_SESSION['user_id'];
        $row['created_time'] = date("Y-m-d H:i:s");
        $row['published'] = 1;
        $row['name'] = $nl_result->buyer_fullname;
        $row['mobilephone'] = $nl_result->buyer_mobile;
        $row['email'] = $nl_result->buyer_email;
        $row['address'] = $nl_result->buyer_address;
        $row['total'] = $nl_result->total_amount;
        $row['token'] = $nl_result->token;
        if ($nl_result->token) {
            $row['status'] = 1;
        }

        $row2 = array();

        $infor = $this->get_infor();

        $t = $_SESSION['xu'];
        if ($t == 1) {
            $row2['point_cents'] = 50000 + $infor->point_cents;
            $row['xu']=50000;
        } elseif ($t == 2) {
            $row2['point_cents'] = 110000 + $infor->point_cents;
            $row['xu']=110000;
        } elseif ($t == 3) {
            $row2['point_cents'] = 170000 + $infor->point_cents;
            $row['xu']=170000;
        } elseif ($t == 4) {
            $row2['point_cents'] = 250000 + $infor->point_cents;
            $row['xu']=250000;
        } else {
            $row2['point_cents'] = 0;
            setRedirect(URL_ROOT, 'ERORR', 'error');
        }

        $rs = $this->_add($row, $this->table_name, 1);
        unset($_SESSION['xu']);
        $mb=$this->_update($row2, 'fs_members', 'id= "' . $_SESSION['user_id'] . '"');
        return $rs;
    }


    function get_infor()
    {
        global $db;
        $id = $_SESSION['user_id'];
        $sql = "SELECT *
                    FROM  fs_members
                    WHERE
                    id = " . $id . " AND published = 1
                    ";
        $db->query($sql);
        return $db->getObject();

    }

}

?>


<?php
/**
 * Created by PhpStorm.
 * User: Lucky Boy
 * Date: 07/09/2018
 * Time: 16:40
 */