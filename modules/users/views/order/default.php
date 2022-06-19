<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("order", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('users', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);
$model = $this->model;
?>
<div class="container">
    <div class="users row">
<!--        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 visible1 leftmb">-->
<!--            --><?php //include 'menu_user.php'; ?>
<!--        </div>-->
        <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php include 'menu_user.php'; ?>
        </div>
        <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="body_order">
                <div class="cat_title clearfix mt10">
                    <div class="inner">
                        <span><?php echo FSText::_("quản lý đơn hàng"); ?></span>
                    </div>
                </div>
                <div class="rmb">
                    <?php if($list_order){ ?>
                        <div class="arrow-right">
                            <?php
                            foreach ($list_order as $item) {
                                $get_shop = $model->get_shop($item->id_shop);
                                $list_sp = $model->list_sp($item->id);
                                ?>
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
                                                    <input type="hidden"
                                                            name="quantity_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="quantity_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="<?php echo $item_sp->count ?>">
                                                    <input type="hidden"
                                                        name="id_shop_<?php echo $item->id?>_<?php echo $o?>"
                                                        id="id_shop_<?php echo $item->id?>_<?php echo $o?>"
                                                        value="<?php echo $get_shop->id ?>">
                                                    
                                                    <?php if($item_sp->product_id_sub != 0){ ?>
                                                        <input type="hidden"
                                                                name="price_<?php echo $item->id?>_<?php echo $o?>"
                                                                id="price_<?php echo $item->id?>_<?php echo $o?>"
                                                                value="<?php echo $sp->price_h ?>">
                                                        <input type="hidden"
                                                            name="size_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="size_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="<?php echo $sp->size_id ?>">
                                                        <input type="hidden"
                                                            name="color_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="color_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="<?php echo $sp->color_id ?>">
                                                        <input type="hidden"
                                                            name="id_sub_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="id_sub_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="<?php echo $sp->id ?>">
                                                        <input type="hidden"
                                                            name="id_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="id_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="<?php echo $img->id ?>">
                                                    <?php }else{ ?>
                                                        <input type="hidden"
                                                                name="price_<?php echo $item->id?>_<?php echo $o?>"
                                                                id="price_<?php echo $item->id?>_<?php echo $o?>"
                                                                value="<?php echo $sp->price ?>">
                                                        <input type="hidden"
                                                            name="size_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="size_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="">
                                                        <input type="hidden"
                                                            name="color_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="color_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="">
                                                        <input type="hidden"
                                                            name="id_sub_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="id_sub_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="">
                                                        <input type="hidden"
                                                            name="id_<?php echo $item->id?>_<?php echo $o?>"
                                                            id="id_<?php echo $item->id?>_<?php echo $o?>"
                                                            value="<?php echo $img->id ?>">
                                                    <?php } ?>
                                                </div>
                                            <?php $o++; } ?>
                                        </div>
                                        <p class="p_total_end"><span class="span_1">Tổng số tiền:</span> <span class="span_2"><?php echo format_money($item->total_end) ?></span>
                                        <div class="clearfix"></div>
                                        <div class="btn-shop"> 
                                            <a href="<?php echo FSRoute::_("index.php?module=users&view=order&task=show_order&id=".$item->id) ?>" class="a-chitiet">Xem chi tiết</a>
                                            <a href="javascript:void(0)" onclick="mualai(<?php echo $get_shop->id ?>)"  class="a-mualai">mua lại</a>
                                        </div>
                                    </div>
                                    <input type="hidden"name="id_order" value="<?php echo $item->id ?>">
                                    <input type="hidden" name="sl_sp" value="<?php echo count($list_sp) ?>" />
                                    <input type="hidden" name="module" value="products" />
                                    <input type="hidden" name="view" value="product" />
                                    <input type="hidden" name="task" value="mualai" />
                                </form>
                                
                            <?php  } ?>
                            <input type="hidden" name="quantity" id="quantity" value="1">

                        </div>
                    <?php }else{ ?>
                        <div class="cart-null">
                            <img src="<?php echo URL_ROOT.'images/cart.svg' ?>" alt="cart">
                            <p class="text-null-cart"><?php echo FSText::_("Chưa có đơn hàng"); ?></p>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <?php if ($pagination) echo $pagination->showPagination(3); ?>
        </div>
    </div>
</div>