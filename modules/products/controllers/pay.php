<?php

// controller

class ProductsControllersPay extends FSControllers
{

    var $module;
    var $view;

    function display()
    {

        $redirect = base64_encode($_SERVER['REQUEST_URI']);
        //        var_dump($redirect);
        FSFactory::include_class('errors');

        $link = FSRoute::_('index.php?module=users&view=formregister&Itemid=22') . '?redirect=' . $redirect;

        $model = $this->model;
        $list_prd = FSInput::get('list_product_add');
        //        var_dump($list_prd);
        $str_list_prd = trim($list_prd, ',');
        $arr_list_prd = explode(',', $str_list_prd);

        $list_cart = $_SESSION['cart_2'];

        //        var_dump($list_cart);die;
        $list_cart_new = array();
        foreach ($list_cart as $item) {
            foreach ($arr_list_prd as $key => $val) {
                //                var_dump($item[5]);
                if ($item[5]) {
                    if ($val == $item[5]) {
                        $list_cart_new[] = $item;
                    }
                } else {
                    if ($val == $item[0]) {
                        $list_cart_new[] = $item;
                    }
                }
            }
        }
        //        var_dump($list_cart_new);
        $_SESSION['cart'] = $list_cart;

        //        var_dump($_SESSION['cart']);die;


        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');

            setRedirect($link, $msg);
            return;
        } else {
            $list_cart = $_SESSION['cart'];
        }

        $link_now = FSRoute::_('index.php?module=products&view=pay&task=step_address');
        setRedirect($link_now);

        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function step_address()
    {
        // call models
        $model = $this->model;
        $city = $model->city();
        $districts = $model->districts();
        $wards = $model->wards();
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
        //        var_dump($list_cart);
        foreach ($list_cart as $item) {
            if ($item[5]  and $item[5] != 'undefined') {
                $data[$item[5]] = $model->getProduct($item[4]);
            } else {
                $data[$item[0]] = $model->getProduct_main($item[0]);
            }
        }



        $province = $model->getProvince();
        if ($_SESSION['user_id']) {
            $member = $model->getMember();
            $address_user = $model->get_address_user($_SESSION['user_id']);
            //            var_dump(count($address_user));
        }


        $list_shop = array();
        foreach ($list_cart as $item) {
            if ($item[6]) {
                if (in_array($item[6], $list_shop)) {
                } else {
                    $list_shop[] = $item[6];
                }
            }
        }

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thanh toán');
        global $tmpl, $module_config;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/step_address.php';
    }

    function set_info()
    {
        global $tmpl, $config;
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
        $add_other = FSInput::get('add_other');
        $add_address_input = FSInput::get('add_address_input');

        $pay_book = FSInput::get('pay_book', 0, 'int');

        $data = array();

        foreach ($list_cart as $item) {
            if ($item[5]) {
                // var_dump($item[5]);
                $data[$item[5]] = $model->getProduct2($item[5]);
                // var_dump($data[$item[5]]);
            } else {
                // var_dump($item[0]);
                $data[$item[0]] = $model->getProduct_main($item[0]);
                // var_dump($data[$item[0]]);
            }
        }
        $total_price = 0;
        $total_weight = 0;
        // var_dump($list_cart);
        foreach ($list_cart as $item) {
            if ($item[5]) {
                $price = $data[$item[5]]->price_h;

                // var_dump($price);

                $weight = $data[$item[5]]->weight;
            } else {
                $price = $data[$item[0]]->price;
                // var_dump($price);
                $weight = $data[$item[0]]->weight;
            }
            $total_price += $price * $item[1];
            $total_weight += $weight * $item[1];
        }
        // var_dump( $total_price);

        // var_dump($total_price);die;

        if (FSInput::get('add_other_s') == 'add') {
            $name = addslashes(FSInput::get('name'));
            $telephone = addslashes(FSInput::get('telephone'));

            $district_id = FSInput::get('district', '', 'int');
            $wards_id = FSInput::get('ward', '', 'int');
            $province_id = FSInput::get('city', '', 'int');
            $district = $model->get_record('id=' . $district_id, 'fs_districts')->name;
            $wards = $model->get_record('id=' . FSInput::get('ward'), 'fs_wards')->name;
            $province = $model->get_record('id=' . FSInput::get('city'), 'fs_cities')->name;
            $address = addslashes(FSInput::get('address'));
        } elseif ($add_address_input == 1) {
            $name = addslashes(FSInput::get('name'));
            $telephone = addslashes(FSInput::get('telephone'));
            $district_id = FSInput::get('district', '', 'int');
            $wards_id = FSInput::get('ward', '', 'int');
            $province_id = FSInput::get('city', '', 'int');
            $district = $model->get_record('id=' . $district_id, 'fs_districts')->name;
            $wards = $model->get_record('id=' . FSInput::get('ward'), 'fs_wards')->name;
            $province = $model->get_record('id=' . FSInput::get('city'), 'fs_cities')->name;
            $address = addslashes(FSInput::get('address'));
        } else {
            //            var_dump($add_other);die;
            $add_info = $model->get_address_user_2($add_other);
            $name = $add_info->username;
            $telephone = $add_info->telephone;
            $email = $add_info->enail;
            $district = $model->get_record('id=' . $add_info->district_id, 'fs_districts')->name;
            $wards = $model->get_record('id=' . $add_info->ward_id, 'fs_wards')->name;
            $province = $model->get_record('id=' . $add_info->province_id, 'fs_cities')->name;
            $address = $add_info->content;
        }

        $info_guest = array();
        $info_guest['add_other'] = $add_other;
        //        var_dump($info_guest['add_other']);
        $info_guest['name'] = $name;
        $info_guest['telephone'] = $telephone;
        $info_guest['email'] = $email;
        $info_guest['province'] = $province;
        $info_guest['district'] = $district;
        $info_guest['wards'] = $wards;

        $info_guest['province_id'] = $province_id;
        $info_guest['district_id'] = $district_id;
        $info_guest['wards_id'] = $wards_id;

        $info_guest['address'] = $address;
        //        $info_guest['note_send'] = $note_send;
        $info_guest['payments'] = $pay_book;
        $info_guest['ord_payment_type'] = $pay_book;
        //        echo 1;die;

        //        var_dump($id);die;

        $list_shop = array();
        foreach ($list_cart as $item) {
            if ($item[6]) {
                if (in_array($item[6], $list_shop)) {
                } else {
                    $list_shop[] = $item[6];
                }
            }
        }
        $id_2 = $model->save_all();

        foreach ($list_shop as $item) {
            $get_shop = $model->get_shop($item);
            $id = $model->save($get_shop->id, $id_2);
            $loinhan = FSInput::get('note_send_' . $get_shop->id);
            $row_loinhan = array();
            $row_loinhan['content'] = $loinhan;
            $row_loinhan['order_id'] = $id;
            $row_loinhan['id_shop'] = $get_shop->id;
            $id_return = $model->_add($row_loinhan, 'fs_note_items');
        }

        if ($pay_book == 2) {
            $this->eshopcart2_vnpay($id_2, $total_price, FSInput::get('pay_item'));
        }






        if (!$id_2) {
            setRedirect(URL_ROOT, 'Có lỗi trong quá trình đặt hàng, bạn vui lòng thử lại', 'error');
        }

        //        $id = $model->save();
        unset($_SESSION['cart']);
        unset($_SESSION['check']);
        unset($_SESSION['info_guest']);
        if ($id_2) {
            $msg = FSText::_("Đặt hàng thành công");
            setRedirect($link, $msg);
        }


        //
        //
        //// call views
        //        $breadcrumbs = array();
        //        $breadcrumbs[] = array(0 => 'Thanh toán thành công');
        //        global $tmpl, $module_config;
        //        $tmpl->assign('breadcrumbs', $breadcrumbs);
        //        include 'modules/' . $this->module . '/views/' . $this->view . '/success.php';
        //        if (isset($_SESSION['info_guest'])) {
        //            $link = FSRoute::_('index.php?module=products&view=pay&task=success');
        //            setRedirect($link);
        //            return;
        //        }
    }

    function eshopcart2_vnpay($order_id, $total, $BankCode)
    {

        unset($_SESSION['cart']);
        unset($_SESSION['info_guest']);
        unset($_SESSION['check']);
        // var_dump($total);die;

        global $config;

        if (!$order_id && !$total) {
            setRedirect(URL_ROOT, FSText::_('Đơn hàng không hợp lệ'));
        }
        //FSFactory::include_class('config_pay','includes');
        $vnp_TmnCode = "VNSHOE01"; //Mã website tại VNPAY
        $vnp_HashSecret = "CVUWZKRXGOXYFQKUZZTLTZGDNSHSFDXW"; //Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=pay&task=vnp_returnurl');

        $vnp_TxnRef = $order_id;
        // var_dump($vnp_TxnRef);die;
        //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        // $vnp_OrderInfo = 'Giao dịch đơn hàng: #' . str_pad($order_id, 5, "0", STR_PAD_LEFT) . ' vinashoe.vn ';
        $vnp_OrderInfo = 'Giao dịch đơn hàng vinashoe.vn ';

        $vnp_OrderType = 'billpayment';

        $vnp_Amount = $total * 100;

        $paymethod = FSInput::get('paymethod');

        $vnp_Locale = 'vn';



        $vnp_BankCode = $BankCode; //'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        // var_dump($inputData);die;

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // var_dump( $hashdata);die;

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // $vnp_Url = $vnp_Url . "?" . $query;
        // if (isset($vnp_HashSecret)) {
        //     $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        //     $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        // }
        // echo 1;die;
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            // die();
        } else {
            echo json_encode($returnData);
        }
        // die;


        setRedirect($vnp_Url);
    }

    function vnp_returnurl()
    {



        $vnp_TmnCode = "VNSHOE01"; //Mã website tại VNPAY
        $vnp_HashSecret = "CVUWZKRXGOXYFQKUZZTLTZGDNSHSFDXW"; //Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=pay&task=vnp_returnurl');
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        // var_dump($vnp_SecureHash);
        // echo '<br>';
        $inputData = array();

        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";


        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        // echo '<br>';
        // var_dump($hashData);
        // echo '<br>';
        // echo 1;die;

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        // var_dump($secureHash);
        // $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
        // var_dump('modules/' . $this->module . '/views/pay/finish_order2.php');

        include 'modules/' . $this->module . '/views/pay/finish_order2.php';
    }

    // vnp_Amount=70000000&vnp_BankCode=NCB&vnp_Command=pay&vnp_CreateDate=20220426094303&vnp_CurrCode=VND&vnp_IpAddr=117.6.78.194&vnp_Locale=vn&vnp_OrderInfo=Giao+d%E1%BB%8Bch+%C4%91%C6%A1n+h%C3%A0ng+vinashoe.vn+&vnp_OrderType=billpayment&vnp_ReturnUrl=https%3A%2F%2Fvinashoe.vn%2Fthanh-toan-vnpay-vinashoe.html&vnp_TmnCode=VNSHOE01&vnp_TxnRef=78&vnp_Version=2.1.0

    // vnp_Amount=70000000&vnp_BankCode=NCB&vnp_BankTranNo=VNP13733491&vnp_CardType=ATM&vnp_OrderInfo=Giao+d%E1%BB%8Bch+%C4%91%C6%A1n+h%C3%A0ng+vinashoe.vn+&vnp_PayDate=20220426094053&vnp_ResponseCode=00&vnp_TmnCode=VNSHOE01&vnp_TransactionNo=13733491&vnp_TransactionStatus=00&vnp_TxnRef=79
    function vnp_returnurl2()
    {
        // echo 1;die;
        $model = $this->model;
        $vnp_TmnCode = "VNSHOE01"; //Mã website tại VNPAY
        $vnp_HashSecret = "CVUWZKRXGOXYFQKUZZTLTZGDNSHSFDXW"; //Chuỗi bí mật

        $vnp_SecureHash = $_GET['vnp_SecureHash'];

        // var_dump($vnp_SecureHash);die;
        $inputData = array();
        foreach ($_GET as $key => $value) {
            $inputData[$key] = $value;
        }
        //var_dump($_SESSION);

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        unset($inputData['Itemid']);
        unset($inputData['lang']);
        unset($inputData['module']);
        unset($inputData['view']);
        unset($inputData['task']);

        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        //        $secureHash = md5($vnp_HashSecret . $hashData);
        // $secureHash = hash_hmac('sha512', $vnp_HashSecret . $hashData);
        // $secureHash =   hash_hmac('sha512', $vnp_HashSecret, $hashData);//  
        $secureHash =   hash_hmac('sha512', $hashData, $vnp_HashSecret); //  
        $orderId = FSInput::get('vnp_TxnRef');
        $order = $model->get_record_by_id($orderId, 'fs_order');

        //        var_dump($order);
        if ($secureHash == $vnp_SecureHash) {
            if ($order->id != $_GET['vnp_TxnRef']) {
                if ($order->total_end != $_GET['vnp_Amount'] / 100) {
                    if ($_GET['vnp_ResponseCode'] == '00') {
                        //echo "GD Thanh cong";
                        $info_guest = $_SESSION['info_guest'];
                        $data = array();
                        $list_cart = $_SESSION['cart'];
                        foreach ($list_cart as $item) {
                            $data[$item[0]] = $model->getProduct($item[0]);
                        }
                        unset($_SESSION['cart']);
                        unset($_SESSION['info_guest']);
                        include 'modules/' . $this->module . '/views/pay/finish_order.php';
                    } else {
                        //echo "GD Khong thanh cong";
                        $info_guest = $_SESSION['info_guest'];
                        $data = array();
                        $list_cart = $_SESSION['cart'];
                        foreach ($list_cart as $item) {
                            $data[$item[0]] = $model->getProduct($item[0]);
                        }
                        unset($_SESSION['cart']);
                        unset($_SESSION['info_guest']);
                        include 'modules/' . $this->module . '/views/pay/finish_order.php';
                    }
                } else {
                    //echo "Đơn hàng không tồn tại";
                    $info_guest = $_SESSION['info_guest'];
                    $data = array();
                    $list_cart = $_SESSION['cart'];
                    foreach ($list_cart as $item) {
                        $data[$item[0]] = $model->getProduct($item[0]);
                    }
                    unset($_SESSION['cart']);
                    unset($_SESSION['info_guest']);
                    include 'modules/' . $this->module . '/views/pay/finish_order.php';
                    //                include 'modules/' . $this->module . '/views/pay_not/success.php';

                }
            } else {
                //echo "Số tiền không hợp lệ";
                $info_guest = $_SESSION['info_guest'];
                $data = array();
                $list_cart = $_SESSION['cart'];
                foreach ($list_cart as $item) {
                    $data[$item[0]] = $model->getProduct($item[0]);
                }
                unset($_SESSION['cart']);
                unset($_SESSION['info_guest']);
                include 'modules/' . $this->module . '/views/pay/finish_order.php';
                //                include 'modules/' . $this->module . '/views/pay_not/success.php';

            }
        } else {
            //echo "Chu ky khong hop le";
            //            $link = URL_ROOT;
            //            $message = FSText::_('Đặt hàng không thành công,chữ ký không hợp lệ!');
            //            setRedirect($link, $message);
            $info_guest = $_SESSION['info_guest'];
            $data = array();
            $list_cart = $_SESSION['cart'];
            foreach ($list_cart as $item) {
                $data[$item[0]] = $model->getProduct($item[0]);
            }
            unset($_SESSION['cart']);
            unset($_SESSION['info_guest']);
            include 'modules/' . $this->module . '/views/pay/finish_order.php';
        }
    }


    // ma VnPayIPN : cập nhật kết quả thanh toán vào Database
    function vnp_ipn()
    {
        // echo 1;die;
        // var_dump($_REQUEST);die;
        ob_start();
        $vnp_TmnCode = "VNSHOE01"; //Mã website tại VNPAY
        $vnp_HashSecret = "CVUWZKRXGOXYFQKUZZTLTZGDNSHSFDXW"; //Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=pay&task=vnp_returnurl');

        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));        

        $inputData = array();
        $returnData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];
        // var_dump($orderId);
        $model = $this->model;
        try {
            
            if ($secureHash == $vnp_SecureHash) {
                
                if ($orderId) {
                    $order = $model->get_record_by_id($orderId, 'fs_order_all');
                    //                    var_dump($order);die;
                }
                if ($order != NULL) {
                    if ($order->total_end == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                       
                        if ($order->status1 == 0) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công

                                
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                                    // $returnData['RspCode'] = '02';
                                    // $returnData['Message'] = 'Order already confirmed';
                            }

                            $row['status1'] = $Status;
                            $row['requestId1'] = $vnpTranId;
                            $row['edited_time1'] = date('Y-m-d H:i:s');
                            $row['paymethod'] = $vnp_BankCode;
                            $row['payment_message'] = $inputData['vnp_ResponseCode'];
                            $rs = $model->_update($row, 'fs_order_all', ' id = ' . $orderId);
                            $rs = $model->_update($row, 'fs_order', ' id_all = ' . $orderId);

                           
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            // echo 2;die;
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                        // var_dump($order->status1);die;
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    // echo 2;die;
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        // die;
        header("Content-type: application/json; charset=utf-8");
        //Trả lại VNPAY theo định dạng JSON
        ob_end_clean();
        // echo $returnData;
        //Trả lại VNPAY theo định dạng JSON
        // var_dump($returnData);
        echo json_encode($returnData);

        
    }

    function vnp_ipn2()
    {
        // echo 1;die;
        $vnp_TmnCode = "VNSHOE01"; //Mã website tại VNPAY
        $vnp_HashSecret = "CVUWZKRXGOXYFQKUZZTLTZGDNSHSFDXW"; //Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=pay&task=vnp_returnurl');



        $inputData = array();
        $returnData = array();
        $data = $_REQUEST;
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        //        var_dump($inputData['vnp_SecureHash'])      ;

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        unset($inputData['Itemid']);
        unset($inputData['lang']);
        unset($inputData['module']);
        unset($inputData['view']);
        unset($inputData['task']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        // $secureHash = hash('sha256', $vnp_HashSecret . $hashData);
        $Status = 0;
        $orderId = $inputData['vnp_TxnRef'];
        //echo $secureHash;
        $model = $this->model;
        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
                if ($orderId) {
                    $order = $model->get_record_by_id($orderId, 'fs_order_all');
                    //                    var_dump($order);die;
                }


                if (@$order) {
                    if ($inputData['vnp_Amount'] / 100 == $order->total_end) {
                        if ($order->status1 == 0) {

                            if ($inputData['vnp_ResponseCode'] == '00') {
                                //                            echo 1;die;
                                $model = $this->model;
                                $vnpTranId = $inputData['vnp_TransactionNo']; // Mã giao dịch tại VNPAY
                                $vnp_BankCode = $inputData['vnp_BankCode']; // Ngân hàng thanh toán
                                $total = $inputData['vnp_Amount'] / 100; // Ngân hàng thanh toán
                                //                            var_dump($total);
                                //echo "GD Thanh cong";
                                $row = array();
                                $row['status'] = 2;
                                $row['status1'] = 1;
                                $row['requestId1'] = $vnpTranId;
                                $row['edited_time1'] = date('Y-m-d H:i:s');
                                $row['paymethod'] = $vnp_BankCode;
                                $row['total_end'] = $total;
                                $row['payment_message'] = $inputData['vnp_ResponseCode'];
                                //var_dump($row);die;
                                $rs = $model->_update($row, 'fs_order', ' id_all = ' . $orderId);
                                $rs = $model->_update($row, 'fs_order_all', ' id = ' . $orderId);

                                // $model->mail_to_buyer($orderId);
                                //                            $model -> discount_code($orderId);

                            } else {
                                $row = array();
                                $row['status'] = 1;

                                $row['status1'] = 2;
                                $row['requestId1'] = $vnpTranId;
                                $row['edited_time1'] = date('Y-m-d H:i:s');
                                $row['paymethod'] = $vnp_BankCode;
                                $row['payment_message'] = $inputData['vnp_ResponseCode'];
                                //                            $returnData['RspCode'] = '00';
                                //                            $returnData['Message'] = 'Confirm Success';
                                //                            $row['payment_message'] = $inputData['vnp_ResponseCode'];
                                $rs = $model->_update($row, 'fs_order', ' id_all = ' . $orderId);
                                $rs = $model->_update($row, 'fs_order_all', ' id = ' . $orderId);
                                //                                $model->mail_to_buyer($orderId);
                            }
                            $row = array();
                            $row['edited_time1'] = date('Y-m-d H:i:s');
                            $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $row = array();
                            $row['edited_time1'] = date('Y-m-d H:i:s');
                            $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $row = array();
                        $row['edited_time1'] = date('Y-m-d H:i:s');
                        $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'Invalid amount';
                    }
                } else {
                    $row = array();
                    $row['edited_time1'] = date('Y-m-d H:i:s');
                    $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $row = array();
                $row['edited_time1'] = date('Y-m-d H:i:s');
                $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        header("Content-type: application/json; charset=utf-8");
        //Trả lại VNPAY theo định dạng JSON
        ob_end_clean();
        echo json_encode($returnData);
    }



    function pay_code()
    {
        global $config;
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
            $info_guest = $_SESSION['info_guest'];
        }
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
        }
        $member = $model->getMember();
        //        var_dump($data);

        $total_price = 0;
        $total_weight = 0;
        foreach ($list_cart as $item) {
            $price = $data[$item[0]]->price;
            //            var_dump($data[$item[0]]->weight);
            $weight = $data[$item[0]]->weight;

            $total_price += $price * $item[1];
            $total_weight += $weight * $item[1];
        }
        //        var_dump( $total_price);
        //        var_dump( $info_guest);
        if ($info_guest['hinhthuc'] == 'giao hàng tiêu chuẩn' or $info_guest['hinhthuc'] == 'giao hàng nhanh') {

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
            curl_close($curl);

            $fee = json_decode($response);
            $feeghtk = $fee->fee->fee;
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
        //        var_dump($fee);
        $transport = 'Giao hàng tiết kiệm';

        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/pay_code.php';
    }

    function order_products()
    {
        // call models
        $model = $this->model;
        $pay_book = FSInput::get('pay_book');
        $code_down = FSInput::get('code_down');
        $befor_discount_code = FSInput::get('after_discount_member');
        $after_discount_code = FSInput::get('after_discount');
        //        var_dump($after_discount);die;
        $discount_money = $befor_discount_code - $after_discount_code;
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
        }
        //        var_dump($info_guest);
        $data = array();
        foreach ($list_cart as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
        }
        $code_down = FSInput::get('code_down');
        include 'modules/' . $this->module . '/views/' . $this->view . '/order_products.php';
    }


    function success()
    {
        // echo 1;die;
        // call models
        global $config;
        $model = $this->model;
        //        $hinhthuc = FSInput::get('hinhthuc');
        $link = URL_ROOT;
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_('Không có sản phẩm trong giỏ hàng');
            //            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
            setRedirect($link, $msg, 'error');
            return;
        } else {
            $list_cart = $_SESSION['cart'];
            $info_guest = $_SESSION['info_guest'];
            //            $info_guest['hinhthuc'] = $hinhthuc;
        }

        //        var_dump($info_guest);die;
        $data = array();
        foreach ($list_cart as $item) {
            if ($item[4]) {
                $data[$item[4]] = $model->getProduct($item[4]);
            } else {
                $data[$item[0]] = $model->getProduct_main($item[0]);
            }
        }

        //        $pay_book = FSInput::get('pay_book', 0, 'int');
        //        $code_down = FSInput::get('code_down');
        $total_price = 0;
        $total_weight = 0;
        foreach ($list_cart as $item) {
            if ($item[4]) {
                $price = $data[$item[4]]->price_sub;
                //            var_dump($data[$item[0]]->weight);
                $weight = $data[$item[4]]->weight;
            } else {
                $price = $data[$item[0]]->price;
                $weight = $data[$item[0]]->weight;
            }
            $total_price += $price * $item[1];
            $total_weight += $weight * $item[1];
        }
        //        var_dump( $total_price);
        //        var_dump( $info_guest);


        $id = $model->save();

        if (!$id) {
            setRedirect(URL_ROOT, 'Có lỗi trong quá trình đặt hàng, bạn vui lòng thử lại', 'error');
        }

        $order = $model->get_record_by_id($id, 'fs_order');
        //var_dump($order);die;
        //        $member = $model->getMember();
        //        if($pay_book==3 && $id){
        //            $this->eshopcart2_momo($id,$order);
        //        }
        //        if ($order->ord_payment_type == 3) {
        ////            echo 2;die;
        ////            $this->payment_vnpay($order->id, $order->total_after_discount);
        //            $vnp_Url = "index.php?module=products&view=vnpay&task=payment_vnpay&id=" . $order->id . "&total=" . $order->total_end;
        //            setRedirect($vnp_Url);
        //        } else {
        unset($_SESSION['cart']);
        unset($_SESSION['info_guest']);


        // call views
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thanh toán thành công');
        global $tmpl, $module_config;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/success.php';
        //        }
    }

    function eshopcart2_momo($order_id, $order)
    {
        if (!$order_id)
            setRedirect(URL_ROOT, FSText::_('lỗi không cập nhật được đơn hàng của bạn.'));
        // live : https:/payment.momo.vn:443/gw_payment/transactionProcessor
        // test : https:/payment.momo.vn:18081/gw_payment/transactionProcessor
        $url = 'https://payment.momo.vn/gw_payment/transactionProcessor';
        $url = 'https://test-payment.momo.vn/gw_payment/transactionProcessor';
        $signature = '';
        // test partnerCode: MOMO
        // klerver partnerCode: PCODE_jb20171225

        // test accessKey: F8BBA842ECF85
        // klerver accessKey: FHUPKMb9lMQXjEfI
        $model = $this->model;
        $total = $order->total_after_discount + $order->fee;
        $orderInfo = 'Giao dịch đơn hàng: DH' . str_pad($order_id, 8, "0", STR_PAD_LEFT) . ' ADCBook ';
        //$orderInfo = 'abc';
        $data = array(
            'partnerCode' => 'MOMOEIAC20190108',
            'accessKey' => 'w0RrO9jtDGKQ9Gl2',
            'requestId' => '' . date('YmdHis') . '',
            'amount' => '' . $total . '',
            'orderId' => '' . $order_id . '',
            'orderInfo' => '' . $orderInfo . '',
            'returnUrl' => '' . FSRoute::_('index.php?module=products&view=pay&task=returnurl_momo') . '',
            'notifyUrl' => '' . FSRoute::_('index.php?module=products&view=pay&task=notifyurl_momo') . '',
            'requestType' => '',
            'signature' => '',
            'extraData' => 'info@adcbook.net.vn'
        );


        $string = '';
        foreach ($data as $key => $value) {
            if ($string != '')
                $string .= $value ? '&' : '';

            if ($value)
                $string .= $key . "=" . $value;
        }
        $string .= '&extraData=';

        // test Secret key:: K951B6PE1waDMi640xX08PD3vg6EkVlz
        // klerver Secret key: RwfUeQwI2uDGLj4zORSGHpT4822St43G
        $secret = 'RL5DVHhj4ArOamih2xAVileUeJhVDKyw';

        $signature = hash_hmac('sha256', $string, $secret);
        $data['signature'] = $signature;
        $data['requestType'] = 'captureMoMoWallet';

        $data_string = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type:application/json',
                'Content-Length: ' . strlen($data_string),
            )
        );

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        var_dump($result);
        die();
        if (!empty($result)) {
            if ($result->errorCode == 0) {
                setRedirect($result->payUrl);
            } else {
                $rs = $model->_remove(' id = ' . $order_id, 'fs_order');
                if ($rs) {
                    $model->_remove(' order_id = ' . $order_id, 'fs_order_items');
                }
                setRedirect(FSRoute::_('index.php?module=products&view=pay&task=pay_code'), FSText::_('Mã lỗi') . ' ' . $result->errorCode);
            }
        } else {
            $rs = $model->_remove(' id = ' . $order_id, 'fs_order');
            if ($rs) {
                $model->_remove(' order_id = ' . $order_id, 'fs_order_items');
            }
            setRedirect(FSRoute::_('index.php?module=products&view=pay&task=pay_code'), FSText::_('lỗi , Đặt hàng không thành công'));
        }

        return false;
    }

    function returnurl_momo()
    {
        $localMessage = FSInput::get('localMessage');
        $requestType = FSInput::get('requestType');
        $errorCode = FSInput::get('errorCode');
        $orderId = FSInput::get('orderId', 0, 'int');

        $model = $this->model;
        if ($errorCode == 0 && $localMessage == 'Thành công') {
            $link = FSRoute::_('index.php?module=products&view=pay&task=finished&id=' . $orderId);
            $message = FSText::_('Đặt hàng thành công');
            setRedirect($link, $message);
        } else {
            $link = FSRoute::_('index.php?module=products&view=pay&task=pay_code');
            $message = FSText::_('Đặt hàng không thành công');
            setRedirect($link, $message);
        }
    }

    // server call server
    function notifyurl_momo()
    {
        //var_dump($_REQUEST);
        $model = $this->model;
        $localMessage = FSInput::get('localMessage');
        $requestType = FSInput::get('requestType');
        $errorCode = FSInput::get('errorCode');
        $orderId = FSInput::get('orderId', 0, 'int');

        $row = array();
        $row['is_paid'] = 1;
        $row['requestId'] = FSInput::get('requestId');
        $row['edited_time'] = date('Y-m-d H:i:s');

        if ($errorCode == 0 && $localMessage == 'Thành công') {
            $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
            if ($rs) {
                //                $model->send_email($orderId,1,4);
                echo $errorCode;
            } else {
                echo FSText::_('Update vào database adc không thành công');
                echo '<br/>';
                echo $errorCode;
            }
        } else {
            echo $errorCode;
        }
    }

    function finished()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['info_guest']);
        include 'modules/' . $this->module . '/views/' . $this->view . '/finish_order.php';
    }
}
