<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("order_detail", "modules/users/assets/css");
//$tmpl->addScript('form');
$tmpl->addScript('order_detail', 'modules/users/assets/js');
//$Itemid = FSInput::get('Itemid', 1);
//var_dump($data);
if ($data->transport == 'giao hàng siêu tốc' or $data->transport == 'lấy hàng trong ngày' or $data->transport == 'lấy hàng trong 1 giờ') {
    $date = ':(Sẽ được chuyển đến vào ngày ' . date('d/m/Y', strtotime($data->edited_time)) . ')';
} else if ($data->transport == '(giao hàng tiêu chuẩn)') {
    $date = ':(Sẽ được chuyển đến sau khoảng 1-3 ngày kể từ khi đơn hàng được xử lý)';
} else {
    $date = ':(Sẽ được chuyển đến sau khoảng 1-2 ngày kể từ khi đơn hàng được xử lý)';
}
$get_shop = $model->get_shop($data->id_shop);
$list_sp = $model->list_sp($data->id);
// echo 2;
?>
<div class="container">
    <div class="users row">
        <?php if ($data->user_id) { ?>
            <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <?php include 'menu_user.php'; ?>
            </div>
        <?php } ?>
        <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12 <?php if (!$data->user_id) {
            echo 'not_member';
        } ?>">
            <div class="cat_title clearfix mt10">
                <div class="inner">
                    <div class="a-ql">
                        <a href="<?php echo FSRoute::_('index.php?module=users&view=order&Itemid=22 ') ?>">Quay lại</a>
                    </div>
                    <div class="inner-right">
                        <div class="bao-right">
                        <h1>ID ĐƠN HÀNG. <?php echo '#DH' . str_pad($data->id, 8, "0", STR_PAD_LEFT); ?></h1>
                        <p class="p-time"><?php echo date('H:i d/m/Y', strtotime($data->created_time)) ?></p>
                        <p class="p-status">
                            <?php if ($data->status == 0) {
                                echo 'Đã đặt hàng';
                            } elseif ($data->status == 1) {
                                echo 'Đã tiếp nhận đơn hàng';
                            } elseif ($data->status == 2) {
                                echo 'Đang chờ lấy hàng';
                            } elseif ($data->status == 3) {
                                echo 'Đang chờ chuyển hàng';
                            } elseif ($data->status == 4) {
                                echo 'Đã chuyển đến đơn vị vận chuyển';
                            } elseif ($data->status == 5) {
                                echo 'Giao hàng thành công';
                            } elseif ($data->status == 6) {
                                echo 'Đã hủy đơn hàng';
                            } ?>
                        </p>
                        </div>
                    </div>
                </div>
                <div class="inner_2">
                    <h2>Địa chỉ nhận hàng</h2>
                    <div class="row">
                        <div class="col-md-4 info-address">
                            <p class="p-name"><?php echo $data->sender_name; ?></p>
                            <p class="p-phone"><?php echo $data->sender_telephone; ?></p>
                            <p class="p-address"> 
                                <span><?php echo FSText::_("Địa chỉ"); ?>
                                    :</span> <?php echo $data->sender_address . ', ' . $data->sender_wards . ', ' . $data->sender_district . ', ' . $data->sender_province; ?>
                            </p>
                        </div>
                        <div class="col-md-4 vc">
                            <p class="p-title-vc">Vận chuyển</p>
                            <p class="content-vc">Nhanh - Shopee Express VN016874214569</p>
                        </div>
                        <div class="pay-order col-md-4 ">
                            <p class="p-title">Hình thức thanhh toán</p>
                            <p class="content-pay">
                                <?php if($data->ord_payment_type==1){ ?>
                                    Thanh toán khi nhận hàng
                                <?php }elseif($data->ord_payment_type==2){ ?>
                                    Thẻ ATM/Internet banking
                                <?php }elseif($data->ord_payment_type==3){ ?>
                                    Ví điện tử
                                <?php }elseif($data->ord_payment_type==4){ ?>
                                    Thẻ Tín dụng/Ghi nợ
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="arrow-right">
                <div  class="list_order_sp">
                    <form method="post" action="#" id="mualai_<?php echo $get_shop->id ?>" name="mualai_<?php echo $get_shop->id ?>" class="form" enctype="multipart/form-data">
                        <div class="item_order">
                            <div class="header_item">
                                <div class="name-shop-chat">
                                    <div class="name_shop">
                                        <a href="<?php echo  FSRoute::_('index.php?module=products&view=shop&cid=' . $item->id_shop . '&ccode=' . $get_shop->alias) ?>" target="_blank">
                                            <?php echo $get_shop->name ?>
                                        </a>
                                    </div>
                                    <div class="chat_shop">
                                        <a href="#">Chat ngay</a>
                                    </div>
                                </div>
                                <div class="status_item">
                                    <?php if ($item->status == 0) { ?>
                                        <p>Đã đặt hàng</p>
                                    <?php }elseif ($item->status == 1){ ?>
                                        <p>Đã tiếp nhận đơn hàng</p>
                                    <?php }elseif ($item->status == 2){ ?>
                                        <p>Đang chờ lấy hàng</p>
                                    <?php }elseif ($item->status == 3){ ?>
                                        <p>Đang chờ chuyển hàng</p>
                                    <?php }elseif ($item->status == 4){ ?>
                                        <p>Đã chuyển đến đơn vị vận chuyển</p>
                                    <?php }elseif ($item->status == 5){ ?>
                                        <p>Đã giao <span>Giao hàng thành công</span></p>
                                    <?php }elseif ($item->status == 6){ ?>
                                        <p>Đã hủy đơn hàng</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="list_order_sp">
                                <?php $o=1; foreach ($list_sp as $item_sp){
                                    if($item_sp->product_id_sub != 0){
                                        $sp = $model->sp_sub($item_sp->product_id_sub);
                                    }else{
                                        $sp = $model->sp($item_sp->product_id);
                                    }
                                    $img =  $model->sp($item_sp->product_id);
                                    $image = URL_ROOT . str_replace('/original/', '/tiny/', $img->image);
                                    ?>
                                    <div class="item-order-sp">
                                        <div class="img-sp">
                                            <img src="<?php echo $image ?>" alt="">
                                        </div>
                                        <div class="info-sp">
                                            <div class="name-sp">
                                                <p><?php echo $img->name ?></p>
                                            </div>
                                            <?php if($item_sp->product_id_sub){ ?>
                                                <div class="pl">
                                                    <p>Loại: <?php if($sp->color_id){ ?><?php echo $sp->color_name ?>, <?php } ?> <?php if($sp->size_id){ ?><?php echo $sp->size_name ?><?php } ?></p>
                                                </div>
                                            <?php } ?>
                                            <div class="price-item-m">
                                                <?php if($item_sp->product_id_sub){ ?>
                                                    <p class="price-sp">
                                                        <?php if($sp->price){ ?>
                                                            <span class="price_old"><?php echo format_money($sp->price)  ?>
                                                            </span>
                                                        <?php } ?>
                                                        <?php echo format_money($sp->price_h ) ?></p>
                                                <?php }else{ ?>
                                                    <p class="price-sp">
                                                        <?php if($sp->price_old){ ?>
                                                            <span class="price_old"><?php echo format_money($sp->price_old)  ?></span>
                                                        <?php } ?>
                                                        <?php echo format_money($sp->price)  ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="count-sp">
                                                <p>x<?php echo $item_sp->count ?></p>
                                            </div>
                                        </div>
                                        <div class="price-item">
                                            <?php if($item_sp->product_id_sub){ ?>
                                                <p class="price-sp">
                                                    <?php if($sp->price){ ?>
                                                        <span class="price_old"><?php echo format_money($sp->price)  ?>
                                                        </span>
                                                    <?php } ?>
                                                    <?php echo format_money($sp->price_h ) ?></p>
                                            <?php }else{ ?>
                                                <p class="price-sp">
                                                    <?php if($sp->price_old){ ?>
                                                        <span class="price_old"><?php echo format_money($sp->price_old)  ?></span>
                                                    <?php } ?>
                                                    <?php echo format_money($sp->price)  ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <input type="hidden"
                                            name="quantity_<?php echo $data->id?>_<?php echo $o?>"
                                            id="quantity_<?php echo $data->id?>_<?php echo $o?>"
                                            value="<?php echo $item_sp->count ?>">
                                    <input type="hidden"
                                        name="id_shop_<?php echo $data->id?>_<?php echo $o?>"
                                        id="id_shop_<?php echo $data->id?>_<?php echo $o?>"
                                        value="<?php echo $get_shop->id ?>">
                                    
                                    <?php if($item_sp->product_id_sub != 0){ ?>
                                        <input type="hidden"
                                                name="price_<?php echo $data->id?>_<?php echo $o?>"
                                                id="price_<?php echo $data->id?>_<?php echo $o?>"
                                                value="<?php echo $sp->price_h ?>">
                                        <input type="hidden"
                                            name="size_<?php echo $data->id?>_<?php echo $o?>"
                                            id="size_<?php echo $data->id?>_<?php echo $o?>"
                                            value="<?php echo $sp->size_id ?>">
                                        <input type="hidden"
                                            name="color_<?php echo $data->id?>_<?php echo $o?>"
                                            id="color_<?php echo $data->id?>_<?php echo $o?>"
                                            value="<?php echo $sp->color_id ?>">
                                        <input type="hidden"
                                            name="id_sub_<?php echo $data->id?>_<?php echo $o?>"
                                            id="id_sub_<?php echo $data->id?>_<?php echo $o?>"
                                            value="<?php echo $sp->id ?>">
                                        <input type="hidden"
                                            name="id_<?php echo $data->id?>_<?php echo $o?>"
                                            id="id_<?php echo $data->id?>_<?php echo $o?>"
                                            value="<?php echo $img->id ?>">
                                    <?php }else{ ?>
                                        <input type="hidden"
                                                name="price_<?php echo $data->id?>_<?php echo $o?>"
                                                id="price_<?php echo $data->id?>_<?php echo $o?>"
                                                value="<?php echo $sp->price ?>">
                                        <input type="hidden"
                                            name="size_<?php echo $data->id?>_<?php echo $o?>"
                                            id="size_<?php echo $data->id?>_<?php echo $o?>"
                                            value="">
                                        <input type="hidden"
                                            name="color_<?php echo $data->id?>_<?php echo $o?>"
                                            id="color_<?php echo $data->id?>_<?php echo $o?>"
                                            value="">
                                        <input type="hidden"
                                            name="id_sub_<?php echo $data->id?>_<?php echo $o?>"
                                            id="id_sub_<?php echo $data->id?>_<?php echo $o?>"
                                            value="">
                                        <input type="hidden"
                                            name="id_<?php echo $data->id?>_<?php echo $o?>"
                                            id="id_<?php echo $data->id?>_<?php echo $o?>"
                                            value="<?php echo $img->id ?>">
                                    <?php } ?>
                                <?php $o++; } ?>
                            </div>
                            <p class="p_total_end"><span class="span_1">Tổng số tiền:</span> <span class="span_2"><?php echo format_money($data->total_end) ?></span>
                            <div class="clearfix"></div>
                            <div class="btn-shop"> 
                                <?php if ($data->status == 0 || $data->status == 1) { ?>
                                    <a class="a-chitiet cancel_order"
                                            href="index.php?module=users&view=order&task=cancel_order&raw=1&order_id=<?php echo $data->id ?>">Hủy
                                            đơn hàng</a>
                                <?php } ?>
                                <a href="javascript:void(0)"  onclick="mualai(<?php echo $get_shop->id ?>)" class="a-mualai">mua lại</a>
                            </div>
                        </div>
                        <input type="hidden"name="id_order" value="<?php echo $data->id ?>">
                        <input type="hidden" name="sl_sp" value="<?php echo count($list_sp) ?>" />
                        <input type="hidden" name="module" value="products" />
                        <input type="hidden" name="view" value="product" />
                        <input type="hidden" name="task" value="mualai" />
                    </form>
                </div> 
            </div>  
        </div>
    </div>
</div>