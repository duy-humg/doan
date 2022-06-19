<?php
global $tmpl, $config;
$tmpl->addStylesheet('success', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_thanhcong', 'modules/products/assets/css');
//$tmpl->addScript("success", "modules/products/assets/js");
//var_dump($_SESSION['info_guest']);
//var_dump($_GET['vnp_TxnRef']);
//var_dump($order);
?>

 <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">
                <label>
                        <?php
                       
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                echo "<span style='color:blue'>Giao dịch thành công</span>";
                            } else {
                                echo "<span style='color:red'>Giao dịch không thành công</span>";
                            }
                        } else {
                            echo "<span style='color:red'>Chu ky khong hop le</span>";
                        }
                        ?>

                    </label>
                </h3>
            </div>
            <div class="table-responsive">
               
                <div class="form-group">

                    <label >Số tiền:</label>
                    <label><?php echo  format_money($_GET['vnp_Amount']/100) ?></label>
                </div>  
                <div class="form-group">
                    <label >Nội dung thanh toán:</label>
                    <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã GD Tại VNPAY:</label>
                    <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã Ngân hàng:</label>
                    <label><?php echo $_GET['vnp_BankCode'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Thời gian thanh toán:</label>
                    <label><?php echo $time = date("i:H d-m-Y "); ?></label>
                    
                </div> 
               
            </div>
            <a class="home_a" href="<?php echo URL_ROOT ?>">
            <svg viewBox="0 0 22 17" role="img" class="stardust-icon stardust-icon-back-arrow _1aiFrB"><g stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(-3, -6)"><path d="M5.78416545,15.2727801 L12.9866648,21.7122915 C13.286114,22.0067577 13.286114,22.4841029 12.9866648,22.7785691 C12.6864297,23.0738103 12.200709,23.0738103 11.9004739,22.7785691 L3.29347136,15.0837018 C3.27067864,15.0651039 3.23845445,15.072853 3.21723364,15.0519304 C3.06240034,14.899273 2.99480814,14.7001208 3.00030983,14.5001937 C2.99480814,14.3002667 3.06240034,14.1003396 3.21723364,13.9476821 C3.23845445,13.9275344 3.2714646,13.9345086 3.29425732,13.9166857 L11.9004739,6.22026848 C12.200709,5.92657717 12.6864297,5.92657717 12.9866648,6.22026848 C13.286114,6.51628453 13.286114,6.99362977 12.9866648,7.288096 L5.78416545,13.7276073 L24.2140442,13.7276073 C24.6478918,13.7276073 25,14.0739926 25,14.5001937 C25,14.9263948 24.6478918,15.2727801 24.2140442,15.2727801 L5.78416545,15.2727801 Z"></path></g></svg>
                Về trang chủ
            </a>
         
           
        </div>  