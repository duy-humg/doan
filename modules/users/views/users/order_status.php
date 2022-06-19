<?php
//global $tmpl;
//$tmpl->addStylesheet('order_status', 'modules/users/assets/css');
global $tmpl;
//$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("order_status", "modules/users/assets/css");

//$tmpl->addStylesheet("order", "modules/users/assets/css");
//echo 1; die;
//$total = count($list);
$Itemid = 22;
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<section>
    <div class="container">
        <div class="col-md-12">
            <div id="body-content">
                <h3>TRẠNG THÁI ORDER</h3>
                <hr/>
                <div class="main-content">
                    <form action="<?php echo FSRoute::_("index.php?module=users&view=users&task=order_status&Itemid=22 "); ?>" method="post" name="form" id="form">
                        <label for="madh">Mã đơn hàng<span>*</span></label>
                        <input type="text" name="madh" id="madh" required="">
                        <small>Bạn có thể tìm thấy điều này trong email xác nhận đơn hàng mà chúng tôi gửi khi bạn đặt
                            hàng
                        </small>
                        <label for="email">Email sử dụng để đặt hàng<span>*</span></label>
                        <input type="email" name="email" id="email" required>
                        <small>Các email bạn đã sử dụng cho đơn hàng</small>
                        <input type="submit" class="btn btn-default" value="Xem trạng thái">
<!--                        <input type="hidden" name="module" value="users" >-->
<!--                        <input type="hidden" name="view" value="users" >-->
<!--                        <input type="hidden" name="task" value="order_status" >-->
<!--                        <input type="hidden" name="Itemid" value="22">-->
                        <p>Khi nào đơn hàng của tôi sẽ đến?</p>
                        <p>Chúng tôi có một số lần ước tính để đến trong <span><a href="">Trợ giúp</a></span></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>