<?php
//print_r($_REQUEST);
global $tmpl,$config;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("thanhcong", "modules/users/assets/css");
$tmpl->addStylesheet("line", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('thanhcong', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);
$id = FSInput::get('id');
$startTime = date("Y-m-d H:i:s");
$cenvertedTime = date('Y-m-d H:i:s',strtotime(' +0 seconds',strtotime($startTime)));
$arr_email = explode('@',$email_method);
?>
<input type="hidden" value="<?php echo FSRoute::_('index.php?module=users&view=login') ?>" id="link_home">
<div class="dangky dangky2">
    <div class="container">
         <div class="form">
              <p class="p-text-xacminh">
                    Mật khẩu đã được đặt lại thành công!
                </p>
                <img src="<?php echo URL_ROOT.'images/thanh_cong.svg' ?>" alt="Thành công">
                <p class="p-text-phone">
                    Bạn đã thành công đặt lại mật khẩu cho tài khoản 
                    
                    <?php if($type_method==1){ ?>
                        <span>bằng email <?php echo substr($email_method,0,2) ?>*******@<?php echo $arr_email[1] ?></span>
                    <?php }else{ ?>
                        <span>bằng số điện thoại *******<?php echo substr($phone_method,-3,5) ?></span>
                    <?php } ?>
                </p>
                <p class="p-text-time">
                    Bạn sẽ được chuyển hướng đến trang đăng nhập
                    <span class="giay time">12 giây.</span>
                </p>
                <a class="a-ql-thanhcong" href="<?php echo FSRoute::_('index.php?module=users&view=login') ?>">
                    OK
                </a>
         </div>
    </div>
</div>

<script>
    var countDownDate = new Date("<?php echo date('M d Y H:i:s', strtotime($cenvertedTime)) ?>").getTime();
    var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)+24*days);
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("giay").innerHTML = "EXPIRED";
            $('.time_title').hide();
            $('.time_sec').hide();
        } else {
            // document.getElementsByClassName("ngay").innerHTML = days;
            // document.getElementById("gio").innerHTML = hours;
            $('.ngay').html(days);
            $('.gio').html(hours);
            $('.phut').html(minutes);
            $('.giay').html(seconds+' giây.');

            $('.span_gio').html(hours);
            $('.span_min').html(minutes);
            $('.span_s').html(seconds);
            // document.getElementById("phut").innerHTML = minutes;
            // document.getElementById("giay").innerHTML = seconds;
        }
    }, 1000);
</script>