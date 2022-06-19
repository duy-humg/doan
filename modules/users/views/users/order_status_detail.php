<?php
//global $tmpl;
//$tmpl->addStylesheet('order_status', 'modules/users/assets/css');
global $tmpl;
//$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("order_status_detail", "modules/users/assets/css");

//$tmpl->addStylesheet("order", "modules/users/assets/css");
//echo 1; die;
//$total = count($list);
$Itemid = 22;
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//var_dump($order_arr);
if ($order_arr->transport == 'giao hàng siêu tốc' or $order_arr->transport == 'lấy hàng trong ngày' or $order_arr->transport == 'lấy hàng trong 1 giờ') {
    $date = 'Sẽ được chuyển đến vào ngày ' . date('d/m/Y', strtotime($order_arr->created_time));
} else if ($order_arr->transport == 'giao hàng tiêu chuẩn') {
    $date = 'Sẽ được chuyển đến sau khoảng 1-3 ngày kể từ khi đơn hàng được xử lý';
} else {
    $date = 'Sẽ được chuyển đến sau khoảng 1-2 ngày kể từ khi đơn hàng được xử lý';
}
if ($order_arr->status == 0 or $order_arr->status == 1) {
    $status = '<strong>Đã đặt hàng</strong>';
} else if ($order_arr->status == 2 or $order_arr->status == 3) {
    $status = '<strong>Đang chờ chuyển hàng</strong>';
} else if ($order_arr->status == 4) {
    $status = '<strong>Đã chuyển hàng cho đơn vị vận chuyển</strong>';
} else if ($order_arr->status == 5) {
    $status = '<strong>' . $date . '</strong>';
} else if ($order_arr->status == 6) {
    $status = '<strong>Đã hủy</strong>';
}
?>
<section>
    <div class="container">
        <div class="col-md-12">
            <div id="body-content">
                <div class="title">
                    <h3>THEO DÕI ĐƠN HÀNG</h3>
                    <div class="link-xemchitiet">
                        <a href="<?php echo FSRoute::_('index.php?module=users&view=order&task=show_order&id=' . $order_arr->id); ?>">
                            <p>Xem chi tiết đơn hàng <span><i class="fa fa-angle-right"></i></span></p></a>
                    </div>
                </div>
                <hr/>
                <div class="main-content">
                    <div class="donhang clearfix">
                        <?php
                        foreach ($list as $key) {
                            $image = URL_ROOT . str_replace('original', 'tiny', $key->image);
                            ?>
                            <img src="<?php echo $image; ?>" alt="Hình ảnh" class="img_pc"
                                 onerror="this.src='/images/not_picture.png'">
                        <?php } ?>
                        <!--                        <img class="img-responsive img_mb" src="-->
                        <?php //echo URL_ROOT.'images/img-thanhtoanthanhcong.png'?><!--">-->
                        <div class="text-donhang clearfix">
                            <p>Đơn hàng <?php echo 'DH' . str_pad($order_arr->id, 8, "0", STR_PAD_LEFT); ?></p>
                            <!--                            <strong>--><?php //echo $date ?><!--</strong>-->
                            <?php echo $status; ?>
                        </div>
                    </div>
                    <?php if ($order_arr->status != 6) { ?>
                        <?php if ($order_arr->status == 0 or $order_arr->status == 1) { ?>
                            <div class="progress">
                                <div class="progress-bar bar1" role="progressbar" aria-valuenow="15" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                                <div class="progress-bar bar2" role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                                <div class="progress-bar bar2_1" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                                <div class="progress-bar bar3" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        <?php } else if ($order_arr->status == 2 or $order_arr->status == 3) { ?>
                            <div class="progress">
                                <div class="progress-bar bar4" role="progressbar" aria-valuenow="15" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                                <div class="progress-bar bar2_1" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                                <div class="progress-bar bar3" role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        <?php } else if ($order_arr->status == 4) { ?>
                            <div class="progress">
                                <div class="progress-bar bar2_2" role="progressbar" aria-valuenow="15" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                                <div class="progress-bar bar3" role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        <?php } else if ($order_arr->status == 5) { ?>
                            <div class="progress">
                                <div class="progress-bar bar5" role="progressbar" aria-valuenow="15" aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($order_arr->status != 6) { ?>

                        <div class="text-under-progress">
                            <div class="text1">
                                <h5>Đã đặt hàng</h5>
                                <p><?php echo date('d/m/Y', strtotime($order_arr->created_time)); ?></p>
                            </div>
                            <div class="text1_1">
                                <h5>Đang chờ chuyển hàng</h5>
                            </div>
                            <div class="text2">
                                <h5>Đã chuyển đến đơn vị vận chuyển</h5>
                                <!--                            <p>-->
                                <?php //if ($order_arr->status){ echo date('d/m/Y', strtotime($order_arr->edited_time)); }?><!--</p>-->
                            </div>
                            <div class="text3">
                                <h5><?php echo $date ?></h5>
                                <p><?php echo $order_arr->sender_address . ', ' . $order_arr->sender_wards . ', ' . $order_arr->sender_district . ', ' . $order_arr->sender_province; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>