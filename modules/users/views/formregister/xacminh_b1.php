<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("xacminh", "modules/users/assets/css");
$tmpl->addStylesheet("line", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('xacminh', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);
$get_phone = FSInput::get('id');
$alert_info = array(
    0 => FSText::_('Please enter the otp code'),
);

$startTime = date("Y-m-d H:i:s");
// $time = date("Y-m-d H:i:s");

$cenvertedTime_2 = date('Y-m-d H:i:s',strtotime(' +45 seconds',strtotime($startTime)));
$b = mt_rand(100000, 999999);
// var_dump($cenvertedTime );
?>


<script>
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.which === 8) {
                    inputs[i].value = '';
                    if (i !== 0)
                        inputs[i - 1].focus();
                }
            })
        }
    }
    $(document).ready(function () {
        OTPInput();
        $(".otp_input").keyup(function () {
            if (this.value.length === this.maxLength) {
                $(this).next('.otp_input').focus();
            }
        });

    })
</script>
<input type="hidden" value="<?php echo $b ?>" id="input_opt_code">
<div class="dangky">
    <div class="container">
         <div class="buoc_dk">
            <div class="b1 b_dk active">
                <p class="p-b ">1</p>
                <h1 class="p-text">
                    Xác minh số điện thoại
                </h1>
            </div>
            <div class="line">
                <i class="fa fa-chevron-right"></i>
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="b2 b_dk">
                <p class="p-b">2</p>
                <p class="p-text">
                    Tạo mật khẩu
                </p>
            </div>
            <div class="line">
                <i class="fa fa-chevron-right"></i>
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="b3 b_dk">
                <p class="p-b">3</p>
                <p class="p-text">
                    Hoàn thành
                </p>
            </div>
         </div>
         <div class="form">
              <p class="p-text-xacminh">
                  Vui Lòng Nhập Mã Xác Minh
                  <a title="Đăng ký" href="<?php echo FSRoute::_('index.php?module=users&view=formregister') ?>">
                      <img src="<?php echo URL_ROOT.'images/ql.svg' ?>" alt="ql">
                  </a>
                </p>
                
                <p class="p-phone">
                    Mã xác minh của bạn sẽ được gửi bằng tin nhắn đến
                    <br>
                    <span><?php echo $get_phone ?></span>
                    
                </p>
                <form id="frmOtp" name="frmOtp" action="" method="post">
                    <div class="input-box">
                        <div id="otp">
                            <input maxlength="1" id="otp_code1" type="text" class="form-control otp_input" name="otp_code1" placeholder="<?php echo FSText::_('') ?>">
                            <input maxlength="1" id="otp_code2" type="text" class="form-control otp_input" name="otp_code2" placeholder="<?php echo FSText::_('') ?>">
                            <input maxlength="1" id="otp_code3" type="text" class="form-control otp_input" name="otp_code3" placeholder="<?php echo FSText::_('') ?>">
                            <input maxlength="1" id="otp_code4" type="text" class="form-control otp_input" name="otp_code4" placeholder="<?php echo FSText::_('') ?>">
                            <input maxlength="1" id="otp_code5" type="text" class="form-control otp_input" name="otp_code5" placeholder="<?php echo FSText::_('') ?>">
                            <input maxlength="1" id="otp_code6" type="text" class="form-control otp_input" name="otp_code6" placeholder="<?php echo FSText::_('') ?>">
                            <p class="p-error-otp" style="display: none;">Vui lòng nhập mã otp</p>
                            <p class="p-error-otp2" style="display: none;">Mã OPT nhập không đúng</p>
                        </div>
                       
                    </div>
                    <div class="input-box input-box-p">
                    <p class="p-time" style="color: #333;text-align: center;margin-bottom: 5px;">Mã OPT của bạn là : <?php echo $b ?></p>
                        <p class="p-time-count">Vui lòng chờ <span class="giay_2 time">60</span> giây để gửi lại.</p>
                        
                        <p class="p-2-code" style="display: none;"><?php echo FSText::_('Bạn không nhận được mã?') ?> <a id="resend_code" class="resend_code" href="javascript:void(0)" ><?php echo FSText::_('Gửi lại') ?></a></p>
                    </div>
                    <a class="btn-member btn-login" onclick="validateOtp();" href="javascript:void(0);">
                        <?php echo FSText::_('XÁC NHẬN') ?>
                    </a>
                    <input type="hidden" value="<?php echo $get_phone  ?>" name="phone_dk">
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="view" value="formregister">
                    <input type="hidden" name="task" value="check_xacminhb2">


                    <input type="hidden" name="active1" id="active1" value="<?php echo FSInput::get('mail_active') ?>">
                    <input type="hidden" name="active2" id="active2" value="<?php echo FSInput::get('tel_active') ?>">

                </form>
         </div>
    </div>
</div>

<script>
    var countDownDate = new Date("<?php echo date('M d Y H:i:s', strtotime($cenvertedTime_2)) ?>").getTime();
    var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)+24*days);
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("giay_2").innerHTML = "EXPIRED";
            $('.time_title').hide();
            $('.time_sec').hide();
        } else {
            // document.getElementsByClassName("ngay").innerHTML = days;
            // document.getElementById("gio").innerHTML = hours;
            $('.ngay').html(days);
            $('.gio').html(hours);
            $('.phut').html(minutes);
            $('.giay_2').html(seconds);

            $('.span_gio').html(hours);
            $('.span_min').html(minutes);
            $('.span_s').html(seconds);
            // document.getElementById("phut").innerHTML = minutes;
            // document.getElementById("giay").innerHTML = seconds;
        }
    }, 1000);
</script>