<?php
// controller

class ProductsControllersCart extends FSControllers
{

    var $module;
    var $view;

    function display()
    {
        // call models
        $model = $this->model;
        $link = FSRoute::_('index.php?module=home&view=home');

        $list_sp = $model->list_sp();

//        đây là đoạn check nếu k tồn tại sản phẩm trong giỏ hàng thì chuyển hướng về trang chủ và thông báo
        if (empty($_SESSION['cart'])) {
            $msg = FSText::_("Không có sản phẩm nào trong giỏ hàng");
            setRedirect($link, $msg, 'error');
            return;
        } // nếu tồn tại sp thì xử lý tiếp
        else {
            $list_cart = $_SESSION['cart'];
        }
    //    var_dump($list_cart);
        $data = array();
//        $data_1 = array();
//        $product_sub = array();

        foreach ($list_cart as $item) {
//            $data_1[$item[0]] = $model->getProduct_main($item[0]);
            if ($item[5] and $item[5] != 'undefined') {
                $data[$item[5]] = $model->getProduct($item[4]);
//            $product_sub[$item[0]] = $model->get_records('published = 1 and product_id=' . $item[0], 'fs_products_sub', '*');
//            var_dump($item);
            } else {
                $data[$item[0]] = $model->getProduct_main($item[0]);
            }
        }
        

//        $list_shops = $model->get_records('published = 1', 'fs_products_shop', '*');

        $list_shop = array();
        foreach ($list_cart as $item) {
            if ($item[6]) {
                if (in_array($item[6], $list_shop)) {
                } else {
                    $list_shop[] = $item[6];
                }
            }
        }
//        var_dump($list_shop);
//        var_dump($data);

        $category_id = array();
        $main_id = array();

        foreach ($data as $item) {
//            var_dump($item->category_id);
            if (in_array($item->category_id, $category_id)) {
            } else {
                $category_id[] = $item->category_id;
            }
            if (in_array($item->id, $main_id)) {
            } else {
                $main_id[] = $item->id;
            }
        }
//        var_dump($category_id);
//        var_dump($main_id);
        $str_category_id = implode(',', $category_id);
        $str_category_id = ',' . $str_category_id . ',';
        $str_main_id = implode(',', $main_id);
        $str_main_id = ',' . $str_main_id . ',';
//        var_dump($str_category_id);
//        $relate_products_list = $model->getRelateProductsList($str_category_id, $str_main_id);

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Giỏ hàng', 1 => FSRoute::_('#'));
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);


        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function edel()
    {
        $id_sub = FSInput::get('id_sub', 0, 'int');
//        $color_id = FSInput::get('color_id', 0, 'int');
//        $products_type= FSInput::get('products_type', 0, 'int');
        if ($id_sub) {
            if (isset($_SESSION['cart'])) {
                $product_list = $_SESSION['cart'];
//                var_dump($product_list);die;
                // Repeat estores
                $products_new = array();
                // Repeat products
                for ($i = 0; $i < count($product_list); $i++) {
                    $prd = $product_list[$i];
                    if ($prd[5] != $id_sub) {
                        $products_new[] = $prd;
                    }
                }
                $_SESSION['cart'] = $products_new;
            }
//            var_dump($_SESSION['cart']);die;
        }
        $link = FSRoute::_('index.php?module=products&view=cart');
        setRedirect($link);
    }

    function change()
    {
        $id_sub = FSInput::get('id_sub', 0, 'int');
//        var_dump($id_sub);
        $quantity_sub = FSInput::get('quantity_sub');
        $color_id = FSInput::get('color', 0, 'int');
//        var_dump($color_id);
        $products_type = FSInput::get('products_type', 0, 'int');
        $id_change = FSInput::get('id_change');
        $price = FSInput::get('price');
//        var_dump($id_change);
        if (!$quantity_sub) {
            echo 1;
            return;
        } else {
//            if ($id_sub) {
            if (isset($_SESSION['cart'])) {
                $product_list = $_SESSION['cart'];
//                var_dump($product_list);die;
                // Repeat estores
//                    $products_new = array();
                // Repeat products
                for ($i = 0; $i < count($product_list); $i++) {
                    $prd = $product_list[$i];
                    if ($prd[5] == $id_change) {
//                        var_dump($id_sub);
                        $product_list[$i][5] = $id_sub;
                        $product_list[$i][3] = $color_id;
                        $product_list[$i][4] = $products_type;
                        $product_list[$i][2] = $price;
                    }
                }
                $_SESSION['cart'] = $product_list;
            }
//            var_dump($_SESSION['cart']);die;
        }
//        }
        $link = FSRoute::_('index.php?module=products&view=cart');
        setRedirect($link);
    }

    function add_multi_products()
    {
        // call models
        $model = $this->model;

        $list_id = FSInput::get('list_product_add');
//        var_dump($list_id);die;
        $list_package = $model->list_products_add($list_id);
//        $price
//        var_dump($list_package);die;
        foreach ($list_package as $data) {
            if (empty($_SESSION['cart'])) {
                $product_list = array();
                if (!$data) {
                    $link = FSRoute::_('index.php?module=home&view=home');
                    $msg = FSText::_("Sản phẩm không tồn tại");
                    setRedirect($link, $msg);
                }
                $product_list[] = array($data->id, 1, 1); // prdid,quality
            } else {
                $product_list = $_SESSION['cart'];
//var_dump($product_list);
                $exist_prd = 0;
                for ($j = 0; $j < count($product_list); $j++) {
                    $prd = $product_list[$j];

                    if ($prd[0] == $data->id && $prd[2] == 1) {
                        if (1 <= 1) {
                            $product_list[$j][1] += 1;
                        } else {
                            $product_list[$j][1] = 1;
                        }
                        $product_list[$j][2] = 1;
                        $exist_prd++;
                        break;
                    }
                }
                // if not exist product
                if (!$exist_prd) {
                    $product_list[count($product_list)] = array($data->id, 1, 1);
                }
            }
            $_SESSION['cart'] = $product_list;
        }

        if (empty($_SESSION['cart'])) {
            $link = FSRoute::_('index.php?module=home&view=home');
            $msg = FSText::_("Chưa có sản phẩm nào trong giỏ hàng");
            setRedirect($link, $msg);
            return;
        } else {
            $link = FSRoute::_('index.php?module=products&view=cart');
            $list_cart = $_SESSION['cart'];
            setRedirect($link);
            return;
        }


    }

    // thanh toan vnpay
//    function payment_vnpay($order_id = '',$total = ''){
//        die(1);
//        global $config;
//        if (!$order_id) {
//            $order_id = FSInput::get('id');
//        }
////        if (!$total) {
////            $total = FSInput::get('money');
////            $total = $total + $total*$config['vnpay_fee']/100;
////        }
//        if (!$order_id && !$total) {
//            setRedirect(URL_ROOT,FSText::_('Đơn hàng không hợp lệ'));
//        }
//        //FSFactory::include_class('config_pay','includes');
//        $vnp_TmnCode = "GENIVN01"; //Mã website tại VNPAY
//        // test : JUEFOMXQCMVOVVVUDKOXLSNYOGPILTOX
//        // live : OYESGNYWIHVZICQYKRNJDIFAQOGXFLLH
//        $vnp_HashSecret = "FLLPQWRCAPSQNVBJOTMKGTNOUMDIVPLO"; //Chuỗi bí mật
//        // test : https://pay.vnpay.vn/vpcpay.html
//        // live : https://pay.vnpay.vn/vpcpay.html
////        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
//        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//        $vnp_Returnurl = FSRoute::_('index.php?module=products&view=cart&task=vnp_returnurl');
//
//        $vnp_TxnRef = $order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
//        $vnp_OrderInfo = 'Giao dịch đơn hàng: #'.str_pad($order_id, 5 , "0", STR_PAD_LEFT) .' Golfbooking.com.vn ';
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
//        if (isset($vnp_HashSecret)) {
//            $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
//            $vnp_Url .= 'vnp_SecureHashType=md5&vnp_SecureHash=' . $vnpSecureHash;
//        }
//
//        setRedirect($vnp_Url);
//    }

    // Code ReturnURL
    // URL này chỉ kiểm tra toàn vẹn dữ liệu (checksum) và hiển thị thông báo tới khách hàng
    // Không cập nhật kết quả giao dịch tại địa chỉ này
//    function vnp_returnurl(){
//
//        //FSFactory::include_class('config_pay','includes');
//        $vnp_TmnCode = "GOLFBOK1"; //Mã website tại VNPAY
//        // test : JUEFOMXQCMVOVVVUDKOXLSNYOGPILTOX
//        // live : OYESGNYWIHVZICQYKRNJDIFAQOGXFLLH
//        $vnp_HashSecret = "QSVNWCEUHDUZTTMREAADSEEALEVPSZUE"; //Chuỗi bí mật
//        // test : https://pay.vnpay.vn/vpcpay.html
//        // live : https://pay.vnpay.vn/vpcpay.html
////        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
//        // $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
//        // $vnp_Returnurl = FSRoute::_('index.php?module=users&view=users&task=vnp_returnurl');
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
//
//        // var_dump($secureHash);
//        // var_dump($_GET['vnp_ResponseCode']);die;
//        $order = $this->model -> get_orderdetail_by_orderId($orderId);
//        if ($secureHash == $vnp_SecureHash) {
//            if ($_GET['vnp_ResponseCode'] == '00') {
//                // $model = $this->model;
//                // $vnpTranId = $inputData['vnp_TransactionNo']; // Mã giao dịch tại VNPAY
//                // $vnp_BankCode = $inputData['vnp_BankCode']; // Ngân hàng thanh toán
//                // $total = $inputData['vnp_Amount']/100; // Ngân hàng thanh toán
//                // //echo "GD Thanh cong";
//                // $row = array();
//                // $row['status'] = 1;
//                // $row['requestId'] = $vnpTranId;
//                // $row['edited_time'] = date('Y-m-d H:i:s');
//                // $row['paymethod'] = $vnp_BankCode;
//                // $row['total'] = $total;
//
//                // $rs = $model->_update($row,'fs_order',' id = '.$orderId);
//                // $user_id = $_COOKIE['user_id'];
//// $model -> add_money_to_member($total,$user_id);
//                // $model -> mail_to_buyer($orderId);
//                // $model -> discount_code($orderId);
//                // die('4444');
//                // money2point($user_id, $total);
//                $message = FSText::_('Thanh toán thành công');
//                if($order && $order->source == 'app'){
//                    $link = FSRoute::_('index.php?module=products&view=cart&raw=1&task=finished_app&message='.$message);
//                    $message = '';
//                }else{
//                    $link = FSRoute::_('index.php?module=products&view=cart&task=finished&id='.$orderId);
//                }
//                setRedirect($link,$message);
//            } else {
//                //echo "GD Khong thanh cong";
//                // $model -> mail_to_buyer($orderId);
//                $link = FSRoute::_('index.php?module=home&view=home');
//                $message = FSText::_('Thanh toán thất bại');
//                if($order && $order->source == 'app'){
//                    $link = FSRoute::_('index.php?module=products&view=cart&raw=1&task=finished_app&message='.$message);
//                    $message = '';
//                }
//                setRedirect($link,$message);
//            }
//        } else {
//            //echo "Chu ky khong hop le";
//            // $model -> mail_to_buyer($orderId);
//            $link = FSRoute::_('index.php?module=home&view=home');
//            $message = FSText::_('Thanh toán thất bại,chữ ký không hợp lệ!');
//            if($order && $order->source == 'app'){
//                $link = FSRoute::_('index.php?module=products&view=cart&raw=1&task=finished_app&message='.$message);
//                $message = '';
//            }
//            setRedirect($link,$message);
//        }
//    }


    // ma VnPayIPN : cập nhật kết quả thanh toán vào Database
//    function vnp_ipn(){
//        /*
//         * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
//         * Các bước thực hiện:
//         * Kiểm tra checksum
//         * Tìm giao dịch trong database
//         * Kiểm tra tình trạng của giao dịch trước khi cập nhật
//         * Cập nhật kết quả vào Database
//         * Trả kết quả ghi nhận lại cho VNPAY
//         */
//        //FSFactory::include_class('config_pay','includes');
//        $vnp_TmnCode = "GOLFBOK1"; //Mã website tại VNPAY
//        // test : JUEFOMXQCMVOVVVUDKOXLSNYOGPILTOX
//        // live : OYESGNYWIHVZICQYKRNJDIFAQOGXFLLH
//        $vnp_HashSecret = "QSVNWCEUHDUZTTMREAADSEEALEVPSZUE"; //Chuỗi bí mật
//        // test : https://pay.vnpay.vn/vpcpay.html
//        // live : https://pay.vnpay.vn/vpcpay.html
////        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
//        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
//        $vnp_Returnurl = FSRoute::_('index.php?module=users&view=users&task=vnp_returnurl');
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
//                            $user_id = @$_COOKIE['user_id'];
//                            if ($user_id) {
//                                $model -> add_money_to_member($total,$user_id);
//                            }
//                            $model -> mail_to_buyer($orderId);
//                            $model -> discount_code($orderId);
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

    function ajax_get_districs()
    {

        $model = $this->model;

        $cities_id = FSInput::get('cities_id');
        $district_id = FSInput::get('district_id');
        $rs = $model->get_records('city_id = ' . $cities_id, 'fs_districts');
        $data = array(
            'error' => true,
            'message' => '',
            'html' => '',
            'id' => '',
        );

        $html = '<option value="">-- ' . FSText::_('Quận/Huyện') . ' --</option > ';

        if ($rs)
            foreach ($rs as $item) {
                $html .= '<option ' . ($item->id == $district_id ? 'selected = "selected"' : '') . ' value = "' . $item->id . '" > ' . $item->name . '</option > ';
            }
        echo $html;

    }

    function ajax_get_ward()
    {
        //        echo 1;die;
        $model = $this->model;


        $district_id = FSInput::get('district_id');
        $rs = $model->get_records('districts_id = ' . $district_id, 'fs_wards');
        //        $rs = $model->get_districts($cities_id);

        $data = array(
            'error' => true,
            'message' => '',
            'html' => '',
            'id' => '',
        );

        $html = '<option value="">-- ' . FSText::_('Phường/Xã') . ' --</option > ';

        if ($rs)
            foreach ($rs as $item) {
                $html .= '<option ' . ($item->id == $district_id ? 'selected = "selected"' : '') . ' value = "' . $item->id . '" > ' . $item->name . '</option > ';
            }
        echo $html;

    }

}



?>