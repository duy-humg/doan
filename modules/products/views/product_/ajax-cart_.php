<?php
$total_quan = 0;
foreach ($product_list as $prd) {
    $total_quan += $prd[1];
}

?>
<style>
    @media (max-width: 575.98px) {

        td:nth-of-type(1) {
            min-height: 113px;
        }

        td:nth-of-type(1):before {
            content: "";
        }

        td:nth-of-type(2):before {
            content: "Đơn giá:";
        }

        td:nth-of-type(3):before {
            content: "Số lượng:";
        }

        td:nth-of-type(4):before {
            content: "Thành tiền:";
        }
    }
</style>

    <a href="javascript:void(0)" id="close-cart"><img src="<?php echo URL_ROOT . 'images/close-cart.png'; ?>"
                                                      alt="close cart"/></a>
    <div class="title-popup">Giỏ hàng của bạn (<?php echo $total_quan; ?> sản phẩm)</div>
    <div class="wrapper-tb-pop">
        <form id="order_form" name="order_form" method="post"
              action="<?php echo FSRoute::_('index.php?module=products&view=cart'); ?>">
            <div class="table-responsive">
                <table width="100%" border="0" class="table-product-pack table" cellpadding="6">
                    <thead>
                    <tr class="head-tr">
                        <th class="th-column" width='50%'>Sản phẩm</th>
                        <th class="text-center" width='15%'>Đơn giá</th>
                        <th class="text-center" width='15%'>Số lượng</th>
                        <th class="text-right" width='20%'>Thành tiền</th>
                    </tr>
                    </thead>
                    <tbody id="popup-cart">

                    <!--  Product list -->
                    <?php
                    if (isset($_SESSION['cart'])) {
                        $product_list = $_SESSION['cart'];
                        if (count($product_list)) {
                            // echo '</pre>';
                            $i = 0;
                            $total = 0;
                            if ($product_list) {
                                foreach ($product_list as $prd) {
                                    $i++;
                                    $product = $this->get_product_by_id($prd[0]);
//                                    var_dump($product);
                                    if (!$product)
                                        continue;

                                    $price = $product->price_old;
                                    $price_new = $product->price;
                                    $price_old = $product->price_old1;
                                    if($prd[2]==1){
                                        if ($product->discount) {
                                            $total += $price_new * $prd[1];
                                        } else {
                                            $total += $price_new * $prd[1];
                                        }
                                    }else{
                                        $total += $price_old * $prd[1];
                                    }

                                    $link_del_prd = FSRoute::_('index.php?module=products&view=cart&task=edel&id=' . $prd[0] . '&Itemid=65');
                                    $link_view = FSRoute::_('index.php?module=products&view=product&code=' . $product->alias . '&id=' . $product->id . '&ccode=' . $product->category_alias);
                                    $image = URL_ROOT.str_replace('/original/', '/tiny/', $product->image);
//var_dump($image);
                                    ?>
                                    <tr class="<?php echo "tr-pop-" . $i; ?>">
                                        <td width='50%' class="name-product">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 imb">
                                                <a class="pull-left" href="<?php echo $link_view; ?>">
                                                    <img class="img-responsive" src="<?php echo $image; ?>"
                                                         alt="<?php echo htmlspecialchars($product->name); ?>">
                                                </a>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-4 col-xs-8 nmb">
                                                <h4 class="media-heading">
                                                    <a href="<?php echo $link_view ?>"><?php echo $product->name; ?></a>
                                                </h4>
                                                <a data-id="<?php echo $prd[0]; ?>"
                                                   data-tr="<?php echo "tr-pop-" . $i; ?>"
                                                   class="del-pro-link"
                                                   href="#"
                                                   title="">
                                                    <i class="far fa-trash-alt"></i><span
                                                            class="text-del">Bỏ sản phẩm</span>
                                                </a>
                                            </div>
                                            <div class="clear"></div>
                                        </td>
                                        <td class="td-price text-right" width='15%'>
                                        <?php if ($prd[2]==1){?>
                                            <p>
                                            <span class="price">
                                                <?php
                                                echo ($product->discount) ? format_money($price_new, 'đ') : format_money($price, 'đ');
                                                ?>
                                            </span>
                                            </p>
                                            <?php if ($product->discount) { ?>
                                                <p>
                                                    <span class="old_price "> <?php echo format_money($price, 'đ'); ?></span>
                                                </p>
                                            <?php } ?>
                                        <?php } else{ ?>
                                            <p>
                                                <span class="price"> <?php echo format_money($price_old, 'đ'); ?></span>
                                            </p>
                                        <?php } ?>
                                        </td>
                                        <td width='15%'>
                                            <div class=" select-box">
                                                <input readonly style="border: none" type="text"
                                                       name="quantity_<?php echo $prd[0] ?>"
                                                       id='quantity_<?php echo $prd[0] ?>'
                                                       value='<?php echo $prd[1]; ?>'/>
                                            </div>
                                        </td>

                                        <td width='15%' class="text-right">
                                        <span class="total">
                                            <?php if ($prd[2]==1){?>
                                                <?php
                                                if ($product->discount) {
                                                    echo format_money($price_new * $prd[1], 'đ');
                                                } else {
                                                    echo format_money($price_new * $prd[1], 'đ');
                                                }
                                                ?>
                                            <?php } else{ ?>
                                                <?php echo format_money($price_old * $prd[1], 'đ');?>
                                            <?php } ?>
                                        </span>
                                        </td>

                                    </tr>
                                    <?php
                                }
                                $i++;
                            }
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>
            <div class="ft-popup-cart">
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-7 col-md-5 col-lg-offset-7 col-sm-12 col-xs-12 text-right price-ajax">
                        <p class="txt-total-pop">Thành tiền: <span
                                    class="total-pop"><?php echo format_money($total, 'đ'); ?></span></p>
                        <p>Đã bao gồm VAT</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="sub-wrapper-popup col-lg-12 col-md-12 col-sm-12 col-xs-12">
<!--                        <a href="--><?php //echo URL_ROOT; ?><!--" class="fl-left bt-pop view-cart"><i-->
<!--                                    class="fas fa-angle-left"></i>Tiếp-->
<!--                            tục mua hàng</a>-->
                        <a href="javascript:void(0)" class="fl-right bt-pop continue-buy">Tiến hành thanh toán</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
