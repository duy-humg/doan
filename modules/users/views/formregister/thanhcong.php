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

?>
<input type="hidden" value="<?php echo URL_ROOT ?>" id="link_home">
<div class="dangky">
    <div class="container">
         <div class="buoc_dk">
            <div class="b1 b_dk active">
                <p class="p-b ">1</p>
                <P class="p-text">
                    Xác minh số điện thoại
                </P>
            </div>
            <div class="line line_active">
                <i class="fa fa-chevron-right"></i>
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="b2 b_dk active">
                <p class="p-b">2</p>
                <p class="p-text">
                    Tạo mật khẩu
                </p>
            </div>
            <div class="line line_active">
                <i class="fa fa-chevron-right"></i>
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="b3 b_dk active">
                <p class="p-b">3</p>
                <h1 class="p-text">
                    Hoàn thành
                </h1>
            </div>
         </div>
         <div class="form">
              <p class="p-text-xacminh">
                    Đăng ký thành công!
                </p>
                <img src="<?php echo URL_ROOT.'images/thanh_cong.svg' ?>" alt="Thành công">
                <p class="p-text-phone">
                    Bạn đã tạo thành công tài khoản Vinashoe với số
                    <span><?php echo $data->telephone ?></span>
                </p>
                <p class="p-text-time">
                    Bạn sẽ được chuyển hướng đến Vinashoe trong
                    <span class="giay time">12 giây .</span>
                </p>
                <a class="a-ql-thanhcong" href="<?php echo URL_ROOT ?>">
                    Quay Lại Vinashoe
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