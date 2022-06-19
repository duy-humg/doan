<?php

// controller

class ProductsControllersPay_not extends FSControllers
{

    var $module;
    var $view;

    function display()
    {
        // call models
        $model = $this->model;
        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
            setRedirect($link, $msg);
            return;
        } else {
            $list_cart = $_SESSION['cart'];
        }
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
        }
        if (!isset($_SESSION['not_user'])) {
            $link_now = FSRoute::_('index.php?module=products&view=pay');
            setRedirect($link_now);
        }
        // call views			
//        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function step_address()
    {
        // call models
        $model = $this->model;
        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
            setRedirect($link, $msg, 'error');
            return;
        } else {
            $list_cart = $_SESSION['cart'];
        }
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
        }
        $province = $model->getProvince();
        $store = $model->get_records("published=1 order by ordering asc", "fs_store");
        $store_infor = $model->get_record("published=1", "fs_store");
//        var_dump($store);


        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/step_address.php';
    }

    function set_info()
    {

        $model = $this->model;

        $name = FSInput::get('name');
        $telephone = FSInput::get('telephone');
        $email = FSInput::get('email');
        $district_id = FSInput::get('district');
        $store_id = FSInput::get('store');
//        var_dump($store_id);die;

        $district = $model->get_record('id=' . $district_id, 'fs_districts')->name;
        $wards = $model->get_record('id=' . FSInput::get('wards'), 'fs_wards')->name;
        $province = $model->get_record('id=' . FSInput::get('province'), 'fs_cities')->name;
        if ($store_id) {
            $store = $model->get_record('id=' . FSInput::get('store'), 'fs_store');
            $store_name = $store->name;
            $store_address = $store->address;
        }
//        var_dump($store_address);die;

        $address = addslashes(FSInput::get('address'));

        $note_send = addslashes(FSInput::get('note_send'));

        $same_address = FSInput::get('same_address');
        if (!$same_address) {
            $re_name = FSInput::get('re_name');
            $re_telephone = FSInput::get('re_telephone');
            $re_email = FSInput::get('re_email');
            $re_province = $model->get_record('id=' . FSInput::get('re_province'), 'fs_cities')->name;
            $re_district = $model->get_record('id=' . FSInput::get('re_district'), 'fs_districts')->name;;
            $re_wards = $model->get_record('id=' . FSInput::get('re_wards'), 'fs_wards')->name;
            $re_address = addslashes(FSInput::get('re_address'));
        } else {
            $re_name = '';
            $re_telephone = '';
            $re_email = '';
            $re_province = '';
            $re_district = '';
            $re_wards = '';
            $re_address = '';
        }

        $hinhthuc = FSInput::get('hinhthuc');
        $vanchuyen = FSInput::get('vanchuyen');
//var_dump($vanchuyen);die;
//var_dump($thanhtoan);die;
        $expost = FSInput::get('expost');
        if ($expost) {
            $code_tax = FSInput::get('code_tax');
            $name_company = FSInput::get('name_company');
            $address_company = FSInput::get('address_company');
            $save_company = FSInput::get('save_company');
        } else {
            $code_tax = '';
            $name_company = '';
            $address_company = '';
            $save_company = '';
        }
        $store_id = FSInput::get('store');
//        var_dump($store_id);die;
        if ($store_id) {
            $store = $model->get_record('id=' . FSInput::get('store'), 'fs_store');
            $store_name = $store->name;
            $store_address = $store->address;
        }
        $info_guest = array();
        $info_guest['add_other'] = $add_other;
        $info_guest['name'] = $name;
        $info_guest['telephone'] = $telephone;
        $info_guest['email'] = $email;
        $info_guest['province'] = $province;
        $info_guest['district'] = $district;
        $info_guest['wards'] = $wards;
        $info_guest['address'] = $address;
        $info_guest['note_send'] = $note_send;
        $info_guest['same_address'] = $same_address;
        $info_guest['re_name'] = $re_name;
        $info_guest['re_telephone'] = $re_telephone;
        $info_guest['re_email'] = $re_email;
        $info_guest['re_province'] = $re_province;
        $info_guest['re_district'] = $re_district;
        $info_guest['re_wards'] = $re_wards;
        $info_guest['re_address'] = $re_address;
        $info_guest['hinhthuc'] = $hinhthuc;
        $info_guest['expost'] = $expost;
        $info_guest['code_tax'] = $code_tax;
        $info_guest['name_company'] = $name_company;
        $info_guest['address_company'] = $address_company;
        $info_guest['save_company'] = $save_company;
        $info_guest['store_name'] = $store_name;
        $info_guest['store_address'] = $store_address;
        $info_guest['vanchuyen'] = $vanchuyen;
        $_SESSION['info_guest'] = $info_guest;
//        var_dump($info_guest);die;

        if (isset($_SESSION['info_guest'])) {
            $link = FSRoute::_('index.php?module=products&view=pay_not&task=pay_code');
            setRedirect($link);
            return;
        }
    }

    function pay_code()
    {
        // call models
        global $config;
        $model = $this->model;
        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
            setRedirect($link, $msg, 'error');
            return;
        } else {
            $list_cart = $_SESSION['cart'];
            $info_guest = $_SESSION['info_guest'];
        }
//var_dump($info_guest);
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
//            var_dump($data[$item[0]]);
        }
//        $member = $model->getMember();


        $total_price = 0;
        $total_weight = 0;
        foreach ($list_cart as $item) {
            $price = $data[$item[0]]->price;
//            var_dump($data[$item[0]]->weight);
            $weight = str_replace('g', '', $data[$item[0]]->weight);

            $total_price += $price * $item[1];
            $total_weight += $weight * $item[1];
//            var_dump($weight);

        }

//        var_dump($total_weight);die;
        if ($info_guest['hinhthuc'] == 'giao hàng tiêu chuẩn' or $info_guest['hinhthuc'] == 'giao hàng nhanh') {
//        var_dump( $total_price);
//        var_dump( $info_guest);
            if ($info_guest['hinhthuc'] == 'giao hàng tiêu chuẩn') {
                $trans = 'road';
            } else {
                $trans = 'fly';
            }
            $datal = array(
                "pick_province" => "Hà Nội",
                "pick_district" => "Quận Đống Đa",
                "pick_address" => "4",
                "pick_street" => "Phố Phương Mai",
                "province" => $info_guest['province'],
                "district" => $info_guest['district'],
                "ward" => $info_guest['wards'],
                "address" => $info_guest['address'],
                "weight" => $total_weight,
                "value" => $total_price,
                "transport" => $trans
            );
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/fee?" . http_build_query($datal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => array(
                    "Token: EAcCB1967892A7a036A5b7E4F50568DB670d9cfa",
                ),
            ));

            $response = curl_exec($curl);
//        echo $response ; die;
            curl_close($curl);

            $fee = json_decode($response);
//        print_r($fee);die;
            $feeghtk = $fee->fee->fee;

//        var_dump($feeghtk);
//        var_dump($total_price);
//        var_dump((double)$config['minMoneyHN']);
//        if ($total_price >= (double)$config['minMoney']) {
//            $fee = (double)$feeghtk - (double)$config['feeAdc'];
//            $ii=2;
//        } else{
//            $fee = (double)$feeghtk;
//        }
//
//        if ($fee <= 0) {
//            $fee = 0;
//        }
//
//        if($info_guest['province']=='Hà Nội' && $total_price >= (double)$config['minMoneyHN']){
//            $ii=1;
//            $fee = 0;
//        }elseif ($info_guest['province']!='Hà Nội' && $total_price >= (double)$config['minMoneyTK']){
//            $ii=1;
//            $fee = 0;
//        }
        } else if ($info_guest['hinhthuc'] == 'giao hàng siêu tốc') {
            $feeghtk = $config['Super_speed'];
        } else if ($info_guest['hinhthuc'] == 'lấy hàng trong ngày') {
            $feeghtk = $config['pickup_day'];
        } else {
            $feeghtk = $config['pickup_hours'];
        }
        $info_guest['feeghtk'] = $feeghtk;
//        $info_guest['fee'] = $fee;
        $_SESSION['info_guest'] = $info_guest;
//print_r($_SESSION['info_guest']);
//        var_dump($info_guest);
        $transport = 'Giao hàng tiết kiệm';

        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/pay_code.php';
    }

    function order_products()
    {
        // call models
        $model = $this->model;

        $code_down = FSInput::get('code_down');
        $befor_discount_code = FSInput::get('after_discount_member');
        $after_discount_code = FSInput::get('after_discount');
//        var_dump($after_discount);die;
        $discount_money = $befor_discount_code - $after_discount_code;
        $pay_book = FSInput::get('pay_book');
        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
            setRedirect($link, $msg, 'error');
            return;
        } else {
            $list_cart = $_SESSION['cart'];
            $info_guest = $_SESSION['info_guest'];
            $info_guest['payments'] = $pay_book;
            $info_guest['befor_discount_code'] = $befor_discount_code;
            $info_guest['after_discount_code'] = $after_discount_code;
            $info_guest['discount_money'] = $discount_money;
            $info_guest['code_down'] = $code_down;
            $_SESSION['info_guest'] = $info_guest;

//            var_dump($info_guest);

        }
//        var_dump($info_guest);
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
        }

//        $pay_book = FSInput::get('pay_book');
//        $code_down = FSInput::get('code_down');
//        $id = $model->save();
//        if(!$id){
//            setRedirect(URL_ROOT,'Có lỗi trong quá trình đặt hàng, bạn vui lòng thử lại','error');
//        }
//        $order=$model->get_record_by_id($id,'fs_order');
//        $member = $model->getMember();

//        unset($_SESSION['cart']);
//        unset($_SESSION['info_guest']);
//        unset($_SESSION['not_user_2']);

        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/order_products.php';
    }
// thanh toan vnpay
//    function payment_vnpay($order_id = '',$total = ''){
////        echo 1;die;
//        global $config;
//        if (!$order_id && !$total) {
//            setRedirect(URL_ROOT,FSText::_('Đơn hàng không hợp lệ'));
//        }
//        //FSFactory::include_class('config_pay','includes');
//        $vnp_TmnCode = "GENIVN01"; //Mã website tại VNPAY
//        $vnp_HashSecret = "FLLPQWRCAPSQNVBJOTMKGTNOUMDIVPLO"; //Chuỗi bí mật
//        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=pay_not&task=vnp_returnurl');
//
//        $vnp_TxnRef = $order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
//        $vnp_OrderInfo = 'Giao dịch đơn hàng: #'.str_pad($order_id, 5 , "0", STR_PAD_LEFT) .' Golf.vn ';
//
//        $vnp_OrderType = '250006';
//
//        $vnp_Amount = $total*100;
//
//        $paymethod = FSInput::get('paymethod');
//
//        $vnp_Locale = 'vn';
//        $lang = @$_SESSION['lang'];
//        if ($lang == 'en' || $lang == 'kr') {
//            $vnp_Locale = 'en';
//        }
//
//        if (!$lang) {
//            $lang = FSInput::get('lang');
//            if ($lang == 'en' || $lang == 'kr') {
//                $vnp_Locale = 'en';
//            }
//        }
//
//
//        $vnp_BankCode = $paymethod; //'NCB';
//        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//
//        $inputData = array(
//            "vnp_Version" => "2.0.0",
//            "vnp_TmnCode" => $vnp_TmnCode,
//            "vnp_Amount" => $vnp_Amount,
//            "vnp_Command" => "pay",
//            "vnp_CreateDate" => date('YmdHis'),
//            "vnp_CurrCode" => "VND",
//            "vnp_IpAddr" => $vnp_IpAddr,
//            "vnp_Locale" => $vnp_Locale,
//            "vnp_OrderInfo" => $vnp_OrderInfo,
//            "vnp_OrderType" => $vnp_OrderType,
//            "vnp_ReturnUrl" => $vnp_Returnurl,
//            "vnp_TxnRef" => $vnp_TxnRef,
//        );
//
//        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
//            $inputData['vnp_BankCode'] = $vnp_BankCode;
//        }
//
//        ksort($inputData);
//        $query = "";
//        $i = 0;
//        $hashdata = "";
//        foreach ($inputData as $key => $value) {
//            if ($i == 1) {
//                $hashdata .= '&' . $key . "=" . $value;
//            } else {
//                $hashdata .= $key . "=" . $value;
//                $i = 1;
//            }
//            $query .= urlencode($key) . "=" . urlencode($value) . '&';
//        }
//
//        $vnp_Url = $vnp_Url . "?" . $query;
////        if (isset($vnp_HashSecret)) {
////            $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
////            $vnp_Url .= 'vnp_SecureHashType=md5&vnp_SecureHash=' . $vnpSecureHash;
////        }
//        if (isset($vnp_HashSecret)) {
//            $vnpSecureHash = hash('sha256',$vnp_HashSecret . $hashdata);
//            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
//        }
//        setRedirect($vnp_Url);
//    }

    // Code ReturnURL
    // URL này chỉ kiểm tra toàn vẹn dữ liệu (checksum) và hiển thị thông báo tới khách hàng
    // Không cập nhật kết quả giao dịch tại địa chỉ này
//    function vnp_returnurl(){
//
//        $vnp_TmnCode = "GENIVN01"; //Mã website tại VNPAY
//
//        $vnp_HashSecret = "FLLPQWRCAPSQNVBJOTMKGTNOUMDIVPLO"; //Chuỗi bí mật
//
//        $vnp_SecureHash = $_GET['vnp_SecureHash'];
//        $inputData = array();
//        foreach ($_GET as $key => $value) {
//            $inputData[$key] = $value;
//        }
//
//
//        unset($inputData['vnp_SecureHashType']);
//        unset($inputData['vnp_SecureHash']);
//
//        unset($inputData['Itemid']);
//        unset($inputData['lang']);
//        unset($inputData['module']);
//        unset($inputData['view']);
//        unset($inputData['task']);
//
//        ksort($inputData);
//        $i = 0;
//        $hashData = "";
//        foreach ($inputData as $key => $value) {
//            if ($i == 1) {
//                $hashData = $hashData . '&' . $key . "=" . $value;
//            } else {
//                $hashData = $hashData . $key . "=" . $value;
//                $i = 1;
//            }
//        }
//
//        $secureHash = md5($vnp_HashSecret . $hashData);
//        $orderId = FSInput::get('vnp_TxnRef');
//        include 'modules/' . $this->module . '/views/' . $this->view . '/success.php';
//
//    }


    // ma VnPayIPN : cập nhật kết quả thanh toán vào Database
//    function vnp_ipn(){
//die(12);
//        $vnp_TmnCode = "GENIVN01"; //Mã website tại VNPAY
//
//        $vnp_HashSecret = "FLLPQWRCAPSQNVBJOTMKGTNOUMDIVPLO"; //Chuỗi bí mật
//
//        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=pay_not&task=vnp_returnurl');
//
//        $inputData = array();
//        $returnData = array();
//
//        $data = $_REQUEST;
//        foreach ($data as $key => $value) {
//            if (substr($key, 0, 4) == "vnp_") {
//                $inputData[$key] = $value;
//            }
//        }
//
//        $vnp_SecureHash = $inputData['vnp_SecureHash'];
//        unset($inputData['vnp_SecureHashType']);
//        unset($inputData['vnp_SecureHash']);
//
//        unset($inputData['Itemid']);
//        unset($inputData['lang']);
//        unset($inputData['module']);
//        unset($inputData['view']);
//        unset($inputData['task']);
//        ksort($inputData);
//
//        $i = 0;
//        $hashData = "";
//        foreach ($inputData as $key => $value) {
//            if ($i == 1) {
//                $hashData = $hashData . '&' . $key . "=" . $value;
//            } else {
//                $hashData = $hashData . $key . "=" . $value;
//                $i = 1;
//            }
//        }
//        $vnpTranId = $inputData['vnp_TransactionNo']; // Mã giao dịch tại VNPAY
//        $vnp_BankCode = $inputData['vnp_BankCode']; // Ngân hàng thanh toán
//
//        $secureHash = md5($vnp_HashSecret . $hashData);
//        $Status = 0;
//
//        $orderId = $inputData['vnp_TxnRef'];
//
//        $model = $this->model;
//        try {
//            //Check Orderid
//            //Kiểm tra checksum của dữ liệu
//            if ($secureHash == $vnp_SecureHash) {
//                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
//                if ($orderId) {
//                    $order = $model->get_record_by_id($orderId,'fs_order','status');
//                }
//
//                // var_dump($order);die;
//                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
//                //Giả sử: $order = mysqli_fetch_assoc($result);
//                if (@$order) {
//                    if ($order->status != 1 ) {
//
//                        if ($inputData['vnp_ResponseCode'] == '00') {
//                            $model = $this->model;
//                            $vnpTranId = $inputData['vnp_TransactionNo']; // Mã giao dịch tại VNPAY
//                            $vnp_BankCode = $inputData['vnp_BankCode']; // Ngân hàng thanh toán
//                            $total = $inputData['vnp_Amount']/100; // Ngân hàng thanh toán
//                            //echo "GD Thanh cong";
//                            $row = array();
//                            $row['status'] = 1;
//                            $row['requestId'] = $vnpTranId;
//                            $row['edited_time'] = date('Y-m-d H:i:s');
//                            $row['paymethod'] = $vnp_BankCode;
//                            $row['total'] = $total;
//                            $row['payment_message'] = $inputData['vnp_ResponseCode'];
//
//                            $rs = $model->_update($row,'fs_order',' id = '.$orderId);
//
//                            $model -> mail_to_buyer($orderId);
////                            $model -> discount_code($orderId);
//
//                            $returnData['RspCode'] = '00';
//                            $returnData['Message'] = 'Confirm Success';
//                        }else{
//                            $returnData['RspCode'] = '00';
//                            $returnData['Message'] = 'Confirm Success';
//                            $row['payment_message'] = $inputData['vnp_ResponseCode'];
//                            $rs = $model->_update($row,'fs_order',' id = '.$orderId);
//                            $model -> mail_to_buyer($orderId);
//
//                        }
//
//                    } else {
//                        $returnData['RspCode'] = '02';
//                        $returnData['Message'] = 'Order already confirmed';
//                    }
//
//                } else {
//                    $returnData['RspCode'] = '01';
//                    $returnData['Message'] = 'Order not found';
//                }
//            } else {
//                $returnData['RspCode'] = '97';
//                $returnData['Message'] = 'Chu ky khong hop le';
//            }
//        } catch (Exception $e) {
//            $returnData['RspCode'] = '99';
//            $returnData['Message'] = 'Unknow error';
//        }
//
//        header("Content-type: application/json; charset=utf-8");
//
//        //Trả lại VNPAY theo định dạng JSON
//        echo json_encode($returnData);
//    }

    function success()
    {
        global $config;
        // call models
        $model = $this->model;
        $hinhthuc = FSInput::get('hinhthuc');

        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
            setRedirect($link, $msg, 'error');
            return;
        } else {
            $list_cart = $_SESSION['cart'];
            $info_guest = $_SESSION['info_guest'];
            $info_guest['hinhthuc'] = $hinhthuc;

//        var_dump($info_guest);die;
        }
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
        }
        $pay_book = FSInput::get('pay_book');
        $code_down = FSInput::get('code_down');
        $total_price = 0;
        $total_weight = 0;
        foreach ($list_cart as $item) {
            $price = $data[$item[0]]->price;
//            var_dump($data[$item[0]]->weight);
            $weight = str_replace('g', '', $data[$item[0]]->weight);

            $total_price += $price * $item[1];
            $total_weight += $weight * $item[1];
        }
        if ($info_guest['hinhthuc'] == 'giao hàng tiêu chuẩn' or $info_guest['hinhthuc'] == 'giao hàng nhanh') {
//        var_dump( $total_price);
//        var_dump( $info_guest);
            if ($info_guest['hinhthuc'] == 'giao hàng tiêu chuẩn') {
                $trans = 'road';
            } else {
                $trans = 'fly';
            }
            $datal = array(
                "pick_province" => "Hà Nội",
                "pick_district" => "Quận Đống Đa",
                "pick_address" => "4",
                "pick_street" => "Phố Phương Mai",
                "province" => $info_guest['province'],
                "district" => $info_guest['district'],
                "ward" => $info_guest['wards'],
                "address" => $info_guest['address'],
                "weight" => $total_weight,
                "value" => $total_price,
                "transport" => $trans
            );
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/fee?" . http_build_query($datal),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => array(
                    "Token: EAcCB1967892A7a036A5b7E4F50568DB670d9cfa",
                ),
            ));

            $response = curl_exec($curl);
//        echo $response ; die;
            curl_close($curl);

            $fee = json_decode($response);
//        print_r($fee);die;
            $feeghtk = $fee->fee->fee;
        } else if ($info_guest['hinhthuc'] == 'giao hàng siêu tốc') {
            $feeghtk = $config['Super_speed'];
        } else if ($info_guest['hinhthuc'] == 'lấy hàng trong ngày') {
            $feeghtk = $config['pickup_day'];
        } else {
            $feeghtk = $config['pickup_hours'];
        }
        $info_guest['feeghtk'] = $feeghtk;
//        $info_guest['fee'] = $fee;
        $_SESSION['info_guest'] = $info_guest;
//print_r($info_guest);die;
        $transport = 'Giao hàng tiết kiệm';
        $id = $model->save();
//        echo $id;die;
        if (!$id) {
            setRedirect(URL_ROOT, 'Có lỗi trong quá trình đặt hàng, bạn vui lòng thử lại', 'error');
        }
        $order = $model->get_record_by_id($id, 'fs_order');
//        var_dump($order);die;
//        $member = $model->getMember();
        if ($order->ord_payment_type == 3) {
//            echo 2;die;
//            $this->payment_vnpay($order->id, $order->total_after_discount);
            $vnp_Url = "index.php?module=products&view=vnpay&task=payment_vnpay&id=" . $order->id . "&total=" . $order->total_end;
            setRedirect($vnp_Url);
        } else {
            unset($_SESSION['cart']);
            unset($_SESSION['info_guest']);
            unset($_SESSION['not_user_2']);

            // call views
            include 'modules/' . $this->module . '/views/' . $this->view . '/success.php';
        }
    }

}

?>