<?php

class ProductsModelsPay_not extends FSModels
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
    }

    function getProduct($id)
    {
        $where = "";
        $where .= " AND id = " . $id;
        $query = " SELECT id,name, alias,price,price_old,price_old1,image,category_alias,discount,weight
						FROM " . $this->table_name . " 
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
        $db->query($sql);
        return $db->getObjectList();
    }

    function save()
    {

        global $db, $user, $config;

        $hinhthuc = FSInput::get('hinhthuc');

//        $pay_book = FSInput::get('pay_book');
        $info_guest = $_SESSION['info_guest'];
//        if(FSInput::get('inputcode')){
//            $code_down = FSInput::get('code_down');
//        }

//        var_dump($info_guest);die;
        $member_id = 0;
        $list_cart = $_SESSION['cart'];

//        $member = $this->getMember();


        $row = array();

//        dia chi moi
//        if($info_guest['add_other'] == 'add'){
        $name = $info_guest['name'];
        $telephone = $info_guest['telephone'];
        $email = $info_guest['email'];
        $province = $info_guest['province'];
        $district = $info_guest['district'];
        $wards = $info_guest['wards'];
        $address = $info_guest['address'];
        $fee = $info_guest['feeghtk'];
        $vanchuyen = $info_guest['vanchuyen'];

        $pay_book= FSInput::get('payment');
//        } else {
//            $id_address = $info_guest['add_other'];
//            $address = $this->get_address($id_address);
//            $name = $address->username;
//            $telephone =  $address->telephone;
//            $email =  $member->email;
//            $province =     $address->province_id;
//            $district =     $address->district_id; 
//            $wards =     $address->ward_id;
//            $address =     $address->content;
//        }

        $row['name'] = $name;
        $row['sender_name'] = $name;
        $row['sender_telephone'] = $telephone;
        $row['email'] = $email;
        $row['sender_email'] = $email;
        $row['sender_province'] = $province;
        $row['sender_district'] = $district;
        $row['sender_wards'] = $wards;
        $row['sender_address'] = $address;
        $row['note_send'] = $info_guest['note_send'];
        $row['user_id'] = 0;
        $row['ord_payment_type'] = $pay_book;
        $row['fee'] = $fee;


//        $row['same_address'] =     $info_guest['same_address'];

//        thong tin mua hang
        if ($info_guest['same_address']) {
            $row['recipients_name'] = $name;
            $row['recipients_telephone'] = $telephone;
            $row['recipients_email'] = $email;
            $row['recipients_province'] = $province;
            $row['recipients_district'] = $district;
            $row['recipients_wards'] = $wards;
            $row['recipients_address'] = $address;
        } else {
            $row['recipients_name'] = $info_guest['re_name'];
            $row['recipients_telephone'] = $info_guest['re_telephone'];
            $row['recipients_email'] = $info_guest['re_email'];
            $row['recipients_province'] = $info_guest['re_province'];
            $row['recipients_district'] = $info_guest['re_district'];
            $row['recipients_wards'] = $info_guest['re_wards'];
            $row['recipients_address'] = $info_guest['re_address'];
        }


        $row['transport'] = $hinhthuc;
        $row['type_trans'] = $vanchuyen;
        $row['ord_payment_type'] = $pay_book;

        $total_before_discount = 0;
        $after_discount_member = 0;
        $products_count = 0;
        $total_weight = 0;

        foreach ($list_cart as $item) {
            $prd_id_array[] = $item[0];
            $data = $this->getProduct($item[0]);
            $weight = str_replace('g', '', $data->weight);

            if($item[2]==1){
                $total_before_discount += $item[1] * $data->price;
            }else{
                $total_before_discount += $item[1] * $data->price_old1;
            }
            $products_count += $item[1];
            $total_weight += $item[1]*$weight;
        }

//        $datal = array(
//            "pick_province" => "Hà Nội",
//            "pick_district" => "Quận Hà Đông",
//            "pick_address" => "103",
//            "pick_street" => "Phố Vạn Phúc",
//            "province" => $info_guest['province'],
//            "district" => $info_guest['district'],
//            "ward" => $info_guest['wards'],
//            "address" => $info_guest['address'],
//            "weight" => $total_weight,
//            "value" => $total_before_discount,
//            "transport" => "road"
//        );
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/fee?" . http_build_query($datal),
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_HTTPHEADER => array(
//                "Token: EAcCB1967892A7a036A5b7E4F50568DB670d9cfa",
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        curl_close($curl);
//
//        $fee = json_decode($response);
//        $fee = $fee->fee->fee;

//        if ($total_before_discount >= (double)$config['minMoney']) {
//            $row['feeAdc']=(double)$config['feeAdc'];
//            $row['fee'] = (double)$fee - (double)$config['feeAdc'];
//            $row['message'] = "Geni hỗ trợ phí vận chuyển";
//            $row['stDis'] = 2;
//        } else{
//            $row['fee'] = (double)$fee;
//        }
//
//        if ($fee <= 0) {
//            $row['fee'] = 0;
//        }
//
//        if($info_guest['province']=='Hà Nội' && $total_before_discount >= (double)$config['minMoneyHN']){
//            $row['fee'] = 0;
//            $row['feeAdc']=-1;
//            $row['stDis'] = 1;
//            $row['message'] = "ADCBook hỗ trợ phí vận chuyển";
//        }elseif ($info_guest['province']!='Hà Nội' && $total_before_discount >= (double)$config['minMoneyTK']){
//            $row['fee'] = 0;
//            $row['feeAdc']=-1;
//            $row['stDis'] = 1;
//            $row['message'] = "ADCBook hỗ trợ phí vận chuyển";
//        }
//        $row['transport'] = 'Giao hàng tiết kiệm';
        $prd_id_str = implode(',', $prd_id_array);
        $row['products_id'] = $prd_id_str;
        $row['products_count'] = $products_count;

        $row['total_before_discount'] = $total_before_discount;


        $after_discount_member = $total_before_discount * 1;
//       var_dump($after_discount_member);die;
        if ($info_guest['code_down']) {
            $dis = $this->checkCode($info_guest['code_down'], $after_discount_member);
//            var_dump($dis);die;
            $row['discount_id'] = $dis->id;
            $row['discount_code'] = $dis->name;
            $row['discount_title'] = $dis->title;
            if ($dis->type) {
                $row['discount_money'] = $after_discount_member * ($dis->val / 100);
                $money = $after_discount_member - $after_discount_member * ($dis->val / 100);
            } else {
                $row['discount_money'] = $dis->val;
                $money = $after_discount_member - $dis->val;
            }
//            var_dump($money);die;
        }
        if ($money > 0) {
            $row['total_after_discount'] = $money;
            $sql = "UPDATE fs_discount_code SET count=count-1 WHERE `name`='".$info_guest['code_down']."'";
//            echo $sql;die;
            $db->affected_rows($sql);
        } elseif ($money <= 0 && $dis) {
            $row['total_after_discount'] = 0;
        } elseif (!isset($money)) {
            $row['total_after_discount'] = $after_discount_member;
        }
        if(!$row['total_after_discount']){
            $row['total_after_discount']=$row['total_before_discount'];
        }
        $row['total_end']=$row['total_after_discount']+$row['fee'];

//var_dump($row['total_end']);die;
//        $row['expost'] =      $info_guest['expost'];
        if ($info_guest['expost']) {
            $row['code_company'] = $info_guest['code_tax'];
            $row['name_company'] = $info_guest['name_company'];
            $row['address_company'] = $info_guest['address_company'];

            if ($info_guest['save_company']) {
//                $row['save_company'] = 1;
                $id_company = $this->save_company($info_guest['code_tax'], $info_guest['name_company'], $info_guest['address_company']);
            } else {
//                $row['save_company'] = 0;
            }
        } else {
            $row['code_company'] = '';
            $row['name_company'] = '';
            $row['address_company'] = '';
//            $row['save_company'] =  0;
        }

        $time = date("Y-m-d H:i:s");
        $row['published'] = 1;

        $row['created_time'] = $time;
//        echo '<pre>';
//        var_dump($row);
        $id = $this->_add($row, $this->table_order);

        $this->save_order_items($id);
        if ($id && $row['ord_payment_type']!=3) {
            $this->send_mail_order($id, $list_cart, $row, $email);
        }
        return $id;

    }


    function save_order_items($order_id)
    {
        if (!$order_id)
            return false;

        global $db;

        // remove before update or inser
        $sql = " DELETE FROM fs_order_items
					WHERE order_id = '$order_id'";

        $db->query($sql);
        $rows = $db->affected_rows();


        // insert data
        $prd_id_array = array();
        // Repeat estores
        if (!isset($_SESSION['cart']))
            return false;

        $product_list = $_SESSION['cart'];
        $sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,discount)
					VALUES ";

        $array_insert = array();


        // Repeat products
        for ($i = 0; $i < count($product_list); $i++) {
            $prd = $product_list[$i];
            $product = $this->getProduct($prd[0]);
            $this->update_number_buy($prd[0]);

            $total = $product->price * $prd[1];
            $price = $product->price;
            $percent = $product->discount;

            $array_insert[] = "('$order_id','$prd[0]','$price','$prd[1]','$total','$percent') ";
        }
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

    function get_address($id)
    {
        $where = "";
        $where .= " AND id = " . $id;
        $query = " SELECT *
						FROM " . $this->table_member_address . " 
						WHERE published = 1 " . $where . "";
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

    function get_record($where = '', $table_name = '', $select = '*')
    {
        if (!$where)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT " . $select . "
						  FROM " . $table_name . "
						  WHERE " . $where;
        global $db;
        $db->query($query);
        $result = $db->getObject();
        return $result;
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

        $bodyitem2='<table border="0" cellpadding="0" cellspacing="0" style="background:#f5f5f5" width="100%">
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
        $bodyitem="";
        $i=1;
        foreach ($list_cart as $item) {
            if($item[2]==1){
                $price='price';
            }else{
                $price='price_old1';
            }
            $prd_id_array[] = $item[0];
            $data = $this->getProduct($item[0]);
            if($i%2==1){
                $style='background: #fff;';
            }else
                $style='';
            $bodyitem .= '<tr style="'.$style.'">
                                <td class="clearfix" style="padding: 5px">';
            $bodyitem .= '                  <a class="clearfix" href="' . FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $data->id) . '">';
            $bodyitem .=   $data->name . '
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