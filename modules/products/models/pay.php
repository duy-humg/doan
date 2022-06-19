<?php

class ProductsModelsPay extends FSModels
{

    function __construct()
    {
        parent::__construct();
        global $module_config;
        $this->limit = 20;
        //$this->limit = 10;
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name = $fs_table->getTable('fs_products');
        $this->table_member = $fs_table->getTable('fs_members');
        $this->table_member_address = $fs_table->getTable('fs_members_address');
        $this->table_order = $fs_table->getTable('fs_order');
        $this->table_member_company = $fs_table->getTable('fs_members_company');
        $this->table_address = $fs_table->getTable('fs_members_address');
    }

    function getProduct($id_sub)
    {
//        var_dump($id_sub);
        $where = "";
        if($id_sub){
            $where .= " AND b.id = " . $id_sub;
        }
       
        $query = " SELECT a.id,a.name,a.alias,a.image,a.category_alias,a.category_id,a.price,a.price_old,a.quantity,a.discount,a.weight,b.color_id,b.color_name, b.size_id, b.size_name, b.id as id_sub, b.price as price_old_sub, b.price_old, b.price_h as price_sub, b.discount as discount_sub, b.image as image_sub, b.name as name_sub
						 FROM fs_products as a LEFT JOIN fs_products_sub as b ON a.id = b.product_id
						 WHERE  a.published = 1 and a.category_published = 1 and b.published = 1 " . $where;
        // echo $query;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getProduct2($id_sub)
    {
//        var_dump($id_sub);
        $where = "";
        $where .= " AND b.id = " . $id_sub;
        $query = " SELECT*
						 FROM  fs_products_sub as b 
						 WHERE  b.published = 1 " . $where;
        // echo $query;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getProduct_main($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT *
						FROM " . $this->table_name . " 
						WHERE published = 1 AND 
						" . $where . " ";
        // print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_shop($id)
    {
        $this->table_sp = 'fs_products_shop';
        $query = " SELECT *
						FROM " . $this->table_sp . " 
						WHERE published = 1 and id = $id ORDER BY id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function city()
    {

        global $db;
        $query = " SELECT *
					FROM fs_cities
					WHERE
						published = 1 
					 ORDER BY  id DESC
							";
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function districts()
    {
        $id_huyen = $_SESSION['id_city'];
        $where = '';
        if($id_huyen){
            $where = 'and city_id = '.$id_huyen;
        }


        global $db;
        $query = " SELECT *
					FROM fs_districts
					WHERE
						published = 1 $where
					 ORDER BY  id DESC
							";
//        echo $query;
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function wards()
    {
        $id_huyen = $_SESSION['id_huyen'];
        $where = '';
        if($id_huyen){
            $where = 'and districts_id = '.$id_huyen;
        }
        global $db;
        $query = " SELECT *
					FROM fs_wards
					WHERE
						published = 1 $where
					 ORDER BY  id DESC
							";
//        echo $query;
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function getMember()
    {
        global $db;
        $user_id = $_SESSION['user_id'];
        $sql = " SELECT * 
					FROM " . $this->table_member . "
					WHERE id  = $user_id ";
        $db->query($sql);
        return $db->getObject();
    }

    function get_address_user($user_id)
    {
        $where = "";
        $where .= " AND member_id = " . $user_id;
        $query = " SELECT *
						FROM " . $this->table_member_address . " 
						WHERE published = 1 " . $where . "";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_address_user_2($user_id)
    {
        $where = "";
        $where .= " AND id = " . $user_id;
        $query = " SELECT *
						FROM " . $this->table_member_address . " 
						WHERE published = 1 " . $where . "";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getProvince()
    {
        global $db;
        $sql = " SELECT id,name,alias
					FROM fs_cities ORDER BY name ASC";
//        $db->query($sql);
        return $db->getObjectList($sql);
    }

    function save_all()
    {

        global $db, $user, $config;;

        $info_guest = $_SESSION['info_guest'];
//        var_dump($info_guest);die;
        $member_id = $_SESSION['user_id'];
        // echo 1;die;
        $list_cart = $_SESSION['cart'];
        if($member_id){
            $member = $this->getMember();
        }

        $row = array();
        $fee = $info_guest['feeghtk'];
//        var_dump(FSInput::get('note_send_'.$id_shop));die;
       


        if (FSInput::get('add_other_s') == 'add') {

                // echo 1;
            $name = FSInput::get('name');
            $telephone = FSInput::get('telephone');
            $email = FSInput::get('email');
            $province = FSInput::get('city');
            $district = FSInput::get('district');
            $wards = FSInput::get('ward');
            $address = FSInput::get('address');

            $rowad = array();
            $rowad['username'] = $name;
            $rowad['telephone'] = $telephone;
            $rowad['province_id'] = $info_guest['province_id'];
            $rowad['district_id'] = $info_guest['district_id'];
            $rowad['ward_id'] = $info_guest['wards_id'];
            $rowad['content'] = $address;

            $time = date('Y-m-d H:i:s');
            $rowad['created_time'] = $time;
            $rowad['published'] = 1;

        }elseif (FSInput::get('add_address_input')==1){
            // echo 2;
            $name = addslashes(FSInput::get('name'));
            $telephone = addslashes(FSInput::get('telephone'));
            $email = addslashes(FSInput::get('email'));
            $district_id = FSInput::get('district', '', 'int');
            $wards_id = FSInput::get('ward', '', 'int');
            $province_id = FSInput::get('city', '', 'int');
            $district = $this->get_record('id=' . $district_id, 'fs_districts')->name;
            $wards = $this->get_record('id=' . FSInput::get('ward'), 'fs_wards')->name;
            $province = $this->get_record('id=' . FSInput::get('city'), 'fs_cities')->name;
            $address = addslashes(FSInput::get('address'));

        } else {

            $address = $this->get_address_user_2(FSInput::get('add_other'));
            $name = $address->username;
            $telephone = $address->telephone;
            $email = $member->email;
            $wards = $this->get_record_by_id($address->ward_id, 'fs_wards')->name;
            $district = $this->get_record_by_id($address->district_id, 'fs_districts')->name;
            $province = $this->get_record_by_id($address->province_id, 'fs_cities')->name;
            $address = $address->content;
        }

        $row['name'] = $name;
        $row['sender_name'] = $name;
        $row['sender_telephone'] = $telephone;
        $row['email'] = $email;
        $row['sender_email'] = $email;
        $row['sender_province'] = $province;
        $row['sender_district'] = $district;
        $row['sender_wards'] = $wards;
        $row['sender_address'] = $address;

        if($member_id){
            $row['user_id'] = $member->id;
        }

        $total_before_discount = 0;
        $after_discount_member = 0;
        $products_count = 0;
        $total_weight = 0;
        $prd_id_array = array();
        $prd_sub_id_array = array();
        $data = array();
//        var_dump($list_cart);



        foreach ($list_cart as $item) {
            
            if (in_array($item[0], $prd_id_array)) {
            } else {
                $prd_id_array[] = $item[0];
            }
            $prd_sub_id_array[] = $item[5];
            if ($item[5]) {
                $data = $this->getProduct($item[5]);
                $total_before_discount += $item[1] * $data->price_sub;
            } else {
                $data = $this->getProduct_main($item[0]);
                $total_before_discount += $item[1] * $data->price;
            }
            
        }
        $prd_id_str = implode(',', $prd_id_array);
        $prd_sub_id_str = implode(',', $prd_sub_id_array);
        $row['products_id'] = $prd_id_str;
        $row['products_id_sub'] = $prd_sub_id_str;
        $row['products_count'] = $products_count;
        $row['paymethod'] = str_replace('&quot;','',FSInput::get('pay_book'));

        $pay_iemt = FSInput::get('pay_book');
        if($pay_iemt==2){
            $row['payment_message'] = FSInput::get('pay_item');
        }
        $row['ord_payment_type'] = str_replace('&quot;','',FSInput::get('pay_book'));
        $row['total_before_discount'] = $total_before_discount;
        $row['total_after_discount'] = $total_before_discount;

        $row['total_end'] = $row['total_after_discount'];

        $row['code_company'] = '';
        $row['name_company'] = '';
        $row['address_company'] = '';
        $time = date("Y-m-d H:i:s");
        $row['published'] = 1;
        $row['created_time'] = $time;

        $this->table_order_all = 'fs_order_all';
        $id_2 = $this->_add($row, $this->table_order_all);

        return $id_2;
    }

    function save($id_shop,$id_all)
    {

        global $db, $user, $config;;

        $info_guest = $_SESSION['info_guest'];
//        var_dump($info_guest);die;
        $member_id = $_SESSION['user_id'];
        // echo 1;die;
        $list_cart = $_SESSION['cart'];
        if($member_id){
            $member = $this->getMember();
        }

        $row = array();
        $fee = $info_guest['feeghtk'];
//        var_dump(FSInput::get('note_send_'.$id_shop));die;
        $row['note_adc'] = FSInput::get('note_send_'.$id_shop);
        $row['note_send'] = FSInput::get('note_send_'.$id_shop);
        $row['id_shop'] = $id_shop;


        if (FSInput::get('add_other_s') == 'add') {

                // echo 1;
            $name = FSInput::get('name');
            $telephone = FSInput::get('telephone');
            $email = FSInput::get('email');
            $province = FSInput::get('city');
            $district = FSInput::get('district');
            $wards = FSInput::get('ward');
            $address = FSInput::get('address');

            $rowad = array();
            $rowad['username'] = $name;
            $rowad['telephone'] = $telephone;
            $rowad['province_id'] = $info_guest['province_id'];
            $rowad['district_id'] = $info_guest['district_id'];
            $rowad['ward_id'] = $info_guest['wards_id'];
            $rowad['content'] = $address;

//            $rowad['member_id'] = $member_id;
            $time = date('Y-m-d H:i:s');
            $rowad['created_time'] = $time;
            $rowad['published'] = 1;


        }elseif (FSInput::get('add_address_input')==1){
            // echo 2;
            $name = addslashes(FSInput::get('name'));
            $telephone = addslashes(FSInput::get('telephone'));
            $email = addslashes(FSInput::get('email'));
            $district_id = FSInput::get('district', '', 'int');
            $wards_id = FSInput::get('ward', '', 'int');
            $province_id = FSInput::get('city', '', 'int');
            $district = $this->get_record('id=' . $district_id, 'fs_districts')->name;
            $wards = $this->get_record('id=' . FSInput::get('ward'), 'fs_wards')->name;
            $province = $this->get_record('id=' . FSInput::get('city'), 'fs_cities')->name;
            $address = addslashes(FSInput::get('address'));

            $rowad = array();
            $rowad['username'] = $name;
            $rowad['telephone'] = $telephone;
            $rowad['email'] = $email;
            $rowad['province_id'] = $province_id;
            $rowad['district_id'] = $district_id;
            $rowad['ward_id'] = FSInput::get('ward');
            $rowad['member_id'] = $_SESSION['user_id'];
            $rowad['content'] = $address;
            $rowad['published'] = 1;

            $id_return = $this->_add($rowad, $this->table_address);
        } else {
            // echo 3;
            $address = $this->get_address_user_2(FSInput::get('add_other'));
            $name = $address->username;
            $telephone = $address->telephone;
            $email = $member->email;
            $wards = $this->get_record_by_id($address->ward_id, 'fs_wards')->name;
            $district = $this->get_record_by_id($address->district_id, 'fs_districts')->name;
            $province = $this->get_record_by_id($address->province_id, 'fs_cities')->name;
            $address = $address->content;
        }

        $row['name'] = $name;
        $row['sender_name'] = $name;
        $row['sender_telephone'] = $telephone;
        $row['email'] = $email;
        $row['sender_email'] = $email;
        $row['sender_province'] = $province;
        $row['sender_district'] = $district;
        $row['sender_wards'] = $wards;
        $row['sender_address'] = $address;
//        $row['note_send'] = $info_guest['note_send'];
        if($member_id){
            $row['user_id'] = $member->id;
        }

        $total_before_discount = 0;
        $after_discount_member = 0;
        $products_count = 0;
        $total_weight = 0;
        $prd_id_array = array();
        $prd_sub_id_array = array();
        $data = array();
//        var_dump($list_cart);



        foreach ($list_cart as $item) {
            if($item[6] == $id_shop) {
                if (in_array($item[0], $prd_id_array)) {
                } else {
                    $prd_id_array[] = $item[0];
                }
                $prd_sub_id_array[] = $item[5];
                if ($item[5]) {
                    $data = $this->getProduct($item[5]);
                    $total_before_discount += $item[1] * $data->price_sub;
                } else {
                    $data = $this->getProduct_main($item[0]);
                    $total_before_discount += $item[1] * $data->price;
                }
            }
        }
        $prd_id_str = implode(',', $prd_id_array);
        $prd_sub_id_str = implode(',', $prd_sub_id_array);
        $row['products_id'] = $prd_id_str;
        $row['products_id_sub'] = $prd_sub_id_str;
        $row['products_count'] = $products_count;
        $row['paymethod'] = str_replace('&quot;','',FSInput::get('pay_book'));

        $pay_iemt = FSInput::get('pay_book');
        // if($pay_iemt==2){
        //     $row['payment_message'] = FSInput::get('pay_item');
        // }
        
        $row['ord_payment_type'] = str_replace('&quot;','',FSInput::get('pay_book'));
//        var_dump();


        $row['total_before_discount'] = $total_before_discount;
        $row['total_after_discount'] = $total_before_discount;

        $row['total_end'] = $row['total_after_discount'];
        $row['id_all'] = $id_all;
        $row['code_company'] = '';
        $row['name_company'] = '';
        $row['address_company'] = '';
        $time = date("Y-m-d H:i:s");
        $row['published'] = 1;
        $row['created_time'] = $time;
        $id = $this->_add($row, $this->table_order);
        $this->save_order_items($id,$id_shop);
        return $id;
    }


    function save_order_items($order_id,$id_shop)
    {
        if (!$order_id)
            return false;

        global $db;

        // remove before update or inser
        $sql = " DELETE FROM fs_order_items
					WHERE order_id = '$order_id'";
//echo $sql;die;
        $db->query($sql);
        $rows = $db->affected_rows();
        // insert data
        $prd_id_array = array();
        // Repeat estores
        if (!isset($_SESSION['cart']))
            return false;

        $product_list = $_SESSION['cart'];
        $sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,discount,product_id_sub,id_shop)
					VALUES ";
        $array_insert = array();

        for ($i = 0; $i < count($product_list); $i++) {
            $prd = $product_list[$i];
            if($prd[6] == $id_shop){
                if ($prd[5]) {
                    $product = $this->getProduct($prd[5]);
                    $price = $product->price_sub;
//                var_dump($price);die;
                    $percent = $product->discount_sub;
                } else {
                    $product = $this->getProduct_main($prd[0]);
                    $price = $product->price;
                    $percent = $product->discount;
                    $prd[5] = 0;
                }
                // var_dump($prd[0]);die;
                $get_daban = $this->getProduct_main($prd[0]);
                $count_daban = $get_daban->daban + 1;
                $this->up_daban($prd[0],$count_daban);
                $total = $price * $prd[1];
                $array_insert[] = "('$order_id','$prd[0]','$price','$prd[1]','$total','$percent','$prd[5]','$prd[6]') ";
            }
        }
//        var_dump($array_insert);die;
        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
            $db->query($sql);
            $rows = $db->affected_rows();
            return true;
        } else {
            return;
        }
    }
    function up_daban($id,$sl)
    {
        global $db;
        $query = " UPDATE fs_products
                    SET daban = '$sl'
					WHERE
						published = 1 and id = $id
					 
							";
        $db->query($query);
        $list = $db->getObject();
        return $list;
    }

    function get_address($id)
    {
        $where = "";
        $where .= "AND a.member_id = m.id AND a.id = " . $id;
        $query = " SELECT a.id,a.username,a.province_id,a.district_id,a.ward_id,a.member_id,a.telephone,a.content,m.id,m.email
						FROM fs_members_address AS a ,fs_members AS m
						WHERE a.published = 1 " . $where . "";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }




    function save_company($code, $name, $address)
    {

        global $db, $user;
        $row = array();
        $row['name'] = $name;
        $row['code'] = $code;
        $row['address'] = $address;

        $time = date("Y-m-d H:i:s");
        $row['published'] = 1;

        $row['created_time'] = $time;
        $id = $this->_add($row, $this->table_member_company);
        return $id;
    }

    function update_number_buy($product_id)
    {
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'array_hits';

            $data_in_memcache = $fsmemcache->get($mem_key);
            if (!isset($data_in_memcache))
                $data_in_memcache = array();
            if (isset($data_in_memcache[$product_id])) {
                $data_in_memcache[$product_id]++;
            } else {
                $data_in_memcache[$product_id] = 1;
            }
            $fsmemcache->set($mem_key, $data_in_memcache, 10000);

        } else {
            if (!$product_id)
                return;

            // count
            global $db, $econfig;
            $sql = " UPDATE fs_products
                                    SET number_buy = number_buy + 1 
                                    WHERE  id = '$product_id' 
                             ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
    }

    function checkCode($code, $money)
    {
        global $db;
        $time = date('Y-m-d h:i:s');
        $sql = "SELECT * FROM fs_discount_code 
                WHERE name='$code' AND published=1 
                AND date_end > '$time' and price<= $money 
                AND price_max >=$money and count > 0";
        $rs = $db->getObject($sql);
        return $rs;
    }

    function check_address($id_member)
    {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_address . " 
					WHERE 
						member_id = '$id_member'";
        $db->query($sql);
        $count = $db->getResult();
        if (!$count) {
            return false;
        }
        return true;
    }

    function send_mail_order($id, $list_cart, $row, $email)
    {
        // body
        global $config;
        $body = '';
        $body .= $config['mail_order'];
        $body = str_replace('{name_pay}', $row['recipients_name'], $body);
        $body = str_replace('{time}', $row['created_time'], $body);
        $body = str_replace('{mail_pay}', $row['recipients_email'], $body);
        $body = str_replace('{phone_pay}', $row['recipients_telephone'], $body);
        $body = str_replace('{id_order}', 'DH' . str_pad($id, 8, "0", STR_PAD_LEFT), $body);
        $body = str_replace('{name_re}', $row['sender_name'], $body);
        $body = str_replace('{mail_re}', $row['sender_email'], $body);
        $body = str_replace('{add_re}', $row['sender_address'] . ', ' . $row['sender_wards'] . ', ' . $row['sender_district'] . ', ' . $row['sender_province'], $body);
        $body = str_replace('{phone_re}', $row['sender_telephone'], $body);
        if ($row['ord_payment_type'] == 1) {
            $payType = 'Chuyển khoản ngân hàng';
        } elseif ($row['ord_payment_type'] == 2) {
            $payType = 'Giao hàng - nhận tiền (COD)';
        } elseif ($row['ord_payment_type'] == 3) {
            $payType = 'Mua hàng trực tiếp - thanh toán tại cửa hàng';
        }
        if ($row['fee']) {
            $fee = format_money($row['fee']);
        } else
            $fee = '0 đ';
        $body = str_replace('{pay_type}', $payType, $body);
        $body = str_replace('{fee}', $fee, $body);

        if ($row['total_after_discount'] && $row['fee']) {
            $money = format_money($row['total_after_discount'] + (double)$row['fee']);
        } elseif (!$row['total_after_discount'] && $row['fee'])
            $money = format_money((double)$row['fee']);
        elseif ($row['total_after_discount'] && !$row['fee'])
            $money = format_money($row['total_after_discount']);
        elseif (!$row['total_after_discount'] && !$row['fee'])
            $money = "0 đ";

        $body = str_replace('{fee}', $fee, $body);
        $body = str_replace('{total}', format_money($row['total_before_discount']), $body);

        if ($row['discount_money']) {
            $dis_mon = format_money($row['discount_money']);
        } else
            $dis_mon = '0 đ';
        $body = str_replace('{dis}', $dis_mon, $body);
        $body = str_replace('{money}', $money, $body);

        $bodyitem2 = '<table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
										<thead>
											<tr>
												<th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Sản phẩm</th>
												<th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Đơn giá</th>
												<th align="left" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Số lượng</th>
												<th align="right" bgcolor="#02acea" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tổng tạm</th>
											</tr>
										</thead>
										<tbody bgcolor="#eee" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
										{item2}
										</tbody>
									</table>';
        $bodyitem = "";
        $i = 1;
        foreach ($list_cart as $item) {
            if ($item[2] == 1) {
                $price = 'price';
            } else {
                $price = 'price_old1';
            }
            $prd_id_array[] = $item[0];
            $data = $this->getProduct($item[0]);
            if ($i % 2 == 1) {
                $style = 'background: #fff;';
            } else
                $style = '';
            $bodyitem .= '<tr style="' . $style . '">
                                <td class="clearfix" style="padding: 5px">';
            $bodyitem .= '                  <a class="clearfix" href="' . FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $data->id) . '">';
            $bodyitem .= $data->name . '
                                    </a>
                                </td>
                                <td class="text-center" style="text-align: center">' . format_money($data->$price) . '</td>
                                <td class="text-center" style="text-align: center">' . $item[1] . '</td>
                                <td class="text-right" style="text-align: center">' . format_money($data->$price * $item[1]) . '</td>
                            </tr>';
            $i++;
        }
        $bodyitem2 = str_replace("{item2}", $bodyitem, $bodyitem2);
        $body = str_replace("<p>{item}</p>", $bodyitem2, $body);
//print_r($body);die;
        $rs = $this->send_email1("Geni - Xác nhận đơn hàng", $body, $row['recipients_name'], $email, '', 1);
        if (!$rs)
            return false;
        return true;

        //en
    }

}

?>