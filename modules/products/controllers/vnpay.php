<?php

// controller

class ProductsControllersVnpay extends FSControllers
{

    var $module;
    var $view;


// thanh toan vnpay
    function payment_vnpay()
    {
//        echo 1;die;+
        $order_id = FSInput::get('id');
//        echo $order_id;die;
        $total = FSInput::get('total');
        global $config;
        if (!$order_id && !$total) {
            setRedirect(URL_ROOT, FSText::_('Đơn hàng không hợp lệ'));
        }
        //FSFactory::include_class('config_pay','includes');
        $vnp_TmnCode = "GENIVNA1"; //Mã website tại VNPAY
        $vnp_HashSecret = "VOWJEJKQYXAVIPAOPEWOUUMSPZUXOUDB"; //Chuỗi bí mật
        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=vnpay&task=vnp_returnurl');

        $vnp_TxnRef = $order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Giao dịch đơn hàng: #' . str_pad($order_id, 5, "0", STR_PAD_LEFT) . ' Geni.com.vn ';

        $vnp_OrderType = '250006';

        $vnp_Amount = $total * 100;

        $paymethod = FSInput::get('paymethod');

        $vnp_Locale = 'vn';
        $lang = @$_SESSION['lang'];
        if ($lang == 'en' || $lang == 'kr') {
            $vnp_Locale = 'en';
        }

        if (!$lang) {
            $lang = FSInput::get('lang');
            if ($lang == 'en' || $lang == 'kr') {
                $vnp_Locale = 'en';
            }
        }


        $vnp_BankCode = $paymethod; //'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.0.0",
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

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
//            echo $vnpSecureHash;die;
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        setRedirect($vnp_Url);

    }

    // Code ReturnURL
    // URL này chỉ kiểm tra toàn vẹn dữ liệu (checksum) và hiển thị thông báo tới khách hàng
    // Không cập nhật kết quả giao dịch tại địa chỉ này
    function vnp_returnurl()
    {
        $model = $this->model;
        $vnp_TmnCode = "GENIVNA1"; //Mã website tại VNPAY

        $vnp_HashSecret = "VOWJEJKQYXAVIPAOPEWOUUMSPZUXOUDB"; //Chuỗi bí mật

        $vnp_SecureHash = $_GET['vnp_SecureHash'];
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
        $secureHash = hash('sha256', $vnp_HashSecret . $hashData);

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
//echo 1;die;
        $vnp_TmnCode = "GENIVNA1"; //Mã website tại VNPAY
        $vnp_HashSecret = "VOWJEJKQYXAVIPAOPEWOUUMSPZUXOUDB"; //Chuỗi bí mật


        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=vnpay&task=vnp_returnurl');

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
        $secureHash = hash('sha256', $vnp_HashSecret . $hashData);
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
                    $order = $model->get_record_by_id($orderId, 'fs_order');
//                    var_dump($order);die;
                }

                // var_dump($order);die;
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);
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
                                $row['status1'] = 1;
                                $row['requestId1'] = $vnpTranId;
                                $row['edited_time1'] = date('Y-m-d H:i:s');
                                $row['paymethod'] = $vnp_BankCode;
                                $row['total_end'] = $total;
                                $row['payment_message'] = $inputData['vnp_ResponseCode'];
//var_dump($row);die;
                                $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);

                                $model->mail_to_buyer($orderId);
//                            $model -> discount_code($orderId);

                            } else {
                                $row = array();
                                $row['status1'] = 2;
                                $row['requestId1'] = $vnpTranId;
                                $row['edited_time1'] = date('Y-m-d H:i:s');
                                $row['paymethod'] = $vnp_BankCode;
                                $row['payment_message'] = $inputData['vnp_ResponseCode'];
//                            $returnData['RspCode'] = '00';
//                            $returnData['Message'] = 'Confirm Success';
//                            $row['payment_message'] = $inputData['vnp_ResponseCode'];
                                $rs = $model->_update($row, 'fs_order', ' id = ' . $orderId);
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

//giả lập test vnpay
//    function vnp_ipn(){
//                $model = $this->model;
////echo 'hàm ipn vnpay';die;
////        $vnp_TmnCode = "GENIVNA1"; //Mã website tại VNPAY
////        $vnp_HashSecret = "VOWJEJKQYXAVIPAOPEWOUUMSPZUXOUDB"; //Chuỗi bí mật
////
////        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
////        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=vnpay&task=vnp_returnurl');
////
////        $inputData = array();
////        $returnData = array();
////
////        $data1 = $_REQUEST;
////        foreach ($data1 as $key => $value) {
////            if (substr($key, 0, 4) == "vnp_") {
////                $inputData[$key] = $value;
////            }
////        }
////
////        $vnp_SecureHash = $inputData['vnp_SecureHash'];
////        unset($inputData['vnp_SecureHashType']);
////        unset($inputData['vnp_SecureHash']);
////
////        unset($inputData['Itemid']);
////        unset($inputData['lang']);
////        unset($inputData['module']);
////        unset($inputData['view']);
////        unset($inputData['task']);
////        ksort($inputData);
////
////        $i = 0;
////        $hashData = "";
////        foreach ($inputData as $key => $value) {
////            if ($i == 1) {
////                $hashData = $hashData . '&' . $key . "=" . $value;
////            } else {
////                $hashData = $hashData . $key . "=" . $value;
////                $i = 1;
////            }
////        }
////        $vnpTranId = $inputData['vnp_TransactionNo']; // Mã giao dịch tại VNPAY
////        $vnp_BankCode = $inputData['vnp_BankCode']; // Ngân hàng thanh toán
////
////        $secureHash = md5($vnp_HashSecret . $hashData);
////        $Status = 0;
////
////        $orderId = $inputData['vnp_TxnRef'];
////
////        try {
////            //Check Orderid
////            //Kiểm tra checksum của dữ liệu
////            if ($secureHash == $vnp_SecureHash) {
//                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
//
////                Giả lập một mã đơn hàng đã thanh toán thành công bằng cách gán mặc định nó, lấy luôn giá trị trong bản fs_order
//                $orderId = '1799';
//                if ($orderId) {
//                    $order = $model->get_record_by_id($orderId,'fs_order','status1');
//                }
//
////         var_dump($order);die;
//                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
//                //Giả sử: $order = mysqli_fetch_assoc($result);
//                if (@$order) {
//                    if ($order->status1 != 1 ) {
//
////                        if ($inputData['vnp_ResponseCode'] == '00') {
//                            $model = $this->model;
//
//                            // ba thông số ở dưới là mình sẽ lấy thông tin của vnpay. t đang giả lập số linh tinh
//                            $vnpTranId = 560; // Mã giao dịch tại VNPAY
//                            $vnp_BankCode = 'NCB'; // Ngân hàng thanh toán
//                            $total = 200000; // Ngân hàng thanh toán
////                            var_dump($total);
//                            //echo "GD Thanh cong";
//                            $row = array();
//                            $row['status1'] = 1;
//                            $row['requestId1'] = $vnpTranId;
//                            $row['edited_time1'] = date('Y-m-d H:i:s');
//                            $row['paymethod'] = $vnp_BankCode;
//                            $row['total_after_discount'] = $total;
//                            $row['payment_message'] = 'thanh toán giả lập';
//                        $rs = $model->_update($row,'fs_order',' id = '.$orderId);
////                        var_dump($rs);die;
//
//                            $model -> mail_to_buyer($orderId);
////                            $model -> discount_code($orderId);
//
//                            $returnData['RspCode'] = '00';
//                            $returnData['Message'] = 'Confirm Success';
//                        }else{
//                        $returnData['RspCode'] = '00';
//                            $returnData['Message'] = 'Confirm Success';
//                            $row['payment_message'] = 'thanh toán giả lập';
//                            $rs = $model->_update($row,'fs_order',' id = '.$orderId);
//                            $model -> mail_to_buyer($orderId);
//                        }
//
//                    } else {
//                        $returnData['RspCode'] = '02';
//                        $returnData['Message'] = 'Order already confirmed';
//                    }
//                    unset($_SESSION['cart']);
//                    unset($_SESSION['info_guest']);
//                    unset($_SESSION['not_user_2']);
//                }
//
////                else {
////                    $returnData['RspCode'] = '01';
////                    $returnData['Message'] = 'Order not found';
////                }
////            } else {
////                $returnData['RspCode'] = '97';
////                $returnData['Message'] = 'Chu ky khong hop le';
////            }
////        } catch (Exception $e) {
////            $returnData['RspCode'] = '99';
////            $returnData['Message'] = 'Unknow error';
////        }
////
////        header("Content-type: application/json; charset=utf-8");
////
////        //Trả lại VNPAY theo định dạng JSON
////        echo json_encode($returnData);


}

?>