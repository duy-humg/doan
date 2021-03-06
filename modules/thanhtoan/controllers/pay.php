<?php
/*
 * Huy write
 */

// controller

class ThanhtoanControllersPay extends FSControllers
{

    function __construct()
    {
        parent::__construct();

    }

    function display()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        global $nlcheckout;
        $t = FSInput::get('xu');
        $_SESSION['xu']=$t;
        if ($t == 1) {
            $total_amount = 50000;
        } elseif ($t == 2) {
            $total_amount = 100000;
        } elseif ($t == 3) {
            $total_amount = 150000;
        } elseif ($t == 4) {
            $total_amount = 200000;
        } else {
            $total_amount = 0;
            setRedirect(URL_ROOT, 'ERORR', 'error');
        }

        $array_items[0] = array('item_name1' => 'Product name',
            'item_quantity1' => 1,
            'item_amount1' => $total_amount,
            'item_url1' => 'http://nganluong.vn/');

        $array_items = array();
        $payment_method = $_POST['option_payment'];
        $bank_code = @$_POST['bankcode'];
        $order_code = "bingo_" . time();

        $payment_type = '';
        $discount_amount = 0;
        $order_description = '';
        $tax_amount = 0;
        $fee_shipping = 0;
        $return_url = 'http://kqxs.phongcachso.com/payment-success.html';
        $cancel_url = urlencode('http://localhost/nganluong.vn/checkoutv3?orderid=' . $order_code);

        $buyer_fullname = FSInput::get('usr');
        $buyer_email = FSInput::get('email');
        $buyer_mobile = FSInput::get('phone');

        $buyer_address = '';

        if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
            if ($payment_method == "VISA") {

                $nl_result = $nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount,
                    $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                    $buyer_address, $array_items, $bank_code);

            } elseif ($payment_method == "NL") {
                $nl_result = $nlcheckout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount,
                    $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                    $buyer_address, $array_items);

            } elseif ($payment_method == "ATM_ONLINE" && $bank_code != '') {
                $nl_result = $nlcheckout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount,
                    $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                    $buyer_address, $array_items);
            } elseif ($payment_method == "NH_OFFLINE") {
                $nl_result = $nlcheckout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            } elseif ($payment_method == "ATM_OFFLINE") {
                $nl_result = $nlcheckout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

            } elseif ($payment_method == "IB_ONLINE") {
                $nl_result = $nlcheckout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
            } elseif ($payment_method == "CREDIT_CARD_PREPAID") {

                $nl_result = $nlcheckout->PrepaidVisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
            }
//            var_dump($nl_result->error_code); die;
            if ($nl_result->error_code == '00') {
                //C???p nh??t order v???i token  $nl_result->token ????? s??? d???ng check ho??n th??nh sau n??y
                ?>
                <script type="text/javascript">
                    <!--
                    window.location = "<?php echo (string)$nl_result->checkout_url; // .'&lang=en' chuy???n m???c ?????nh ti???ng anh  ?>"
                    //-->
                </script>
                <?PHP
            } else {
                echo $nl_result->error_message;
            }

        } else {
            echo "<h3> B???n ch??a nh???p ????? th??ng tin kh??ch h??ng </h3>";
        }
    }

    function payment_success()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        global $nlcheckout;
        $nl_result = $nlcheckout->GetTransactionDetail($_GET['token']);
        if ($nl_result) {
            $nl_errorcode = (string)$nl_result->error_code;
            $nl_transaction_status = (string)$nl_result->transaction_status;
            if ($nl_errorcode == '00') {
                if ($nl_transaction_status == '00') {
                    //tr???ng th??i thanh to??n th??nh c??ng

                    $model = $this->model;
                    $data = $model->saveOrder($nl_result);
                    if ($data) {
//                        echo "<pre>";
//                        print_r($nl_result);
//                        echo "</pre>";
                        setRedirect(URL_ROOT, 'B???n ???? n???p xu th??nh c??ng, c???m ??n b???n ???? s??? d???ng d???ch v??? c???a ch??ng t??i!');
                    }

                }
            } else {
                echo $nlcheckout->GetErrorMessage($nl_errorcode);
            }
        }
    }

}

?>
<?php
/**
 * Created by PhpStorm.
 * User: Lucky Boy
 * Date: 07/09/2018
 * Time: 16:24
 */