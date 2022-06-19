<?php
global $tmpl, $config;
$tmpl->addStylesheet('step_address', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_thongtindathang-b1', 'modules/products/assets/css');
$tmpl->addScript("step_address", "modules/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
$total_quan = 0;
//var_dump($list_cart);
foreach ($list_cart as $prd) {
    $total_quan += $prd[1];
}
?>
<div class="container">
    <div class="margin-top-cat">
        <!--        <div class="row">-->
        <form action="<?php echo FSRoute::_('index.php?module=products&view=pay&task=set_info&raw=1'); ?>"
              name="form_pay_code" class="form_pay_code" method="post">
            <div class="left-cart-pay">

                <div class="left-box-list">
                    <h3 class='title-cart-right'><?php echo FSText::_("ĐỊA CHỈ NHẬN HÀNG"); ?></h3>

                    <div class="row">
                        <!--dia chi cu-->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list_address_all">
                            <ul>
                                <?php foreach ($address_user as $k => $item) {
                                    $wards = $model->get_record_by_id($item->ward_id, 'fs_wards')->name;

                                    $district = $model->get_record_by_id($item->district_id, 'fs_districts')->name;

                                    $province2 = $model->get_record_by_id($item->province_id, 'fs_cities')->name;
                                    ?>
                                    <li class="list_address">
                                        <input type="radio" name="add_other" value="<?php echo $item->id; ?>"
                                               class="address_dk"
                                               id="address_dk_<?php echo $k; ?>" <?php echo ($item->defau == 1) ? 'checked' : ''; ?>>
                                        <label for="address_dk_<?php echo $k; ?>">
                                            <p><?php echo $item->username; ?>
                                                <span><?php echo $item->telephone; ?></span></p>
                                        </label>
                                        <p class="address_mb"><?php echo $item->content . ", " . $wards . ", " . $district . ", " . $province2; ?></p>
                                        <p class="default_ <?php echo ($item->defau == 1) ? 'default' : 'default1'; ?>"><?php echo ($item->defau == 1) ? 'Mặc định' : 'Đặt mặc định'; ?></p>
                                        <a class="edit_adrr text-right"
                                           href="<?php echo FSRoute::_('index.php?module=users&view=address&task=edit_address&raw=1&id=' . $item->id); ?>">Thay
                                            đổi</a>
                                    </li>
                                <?php } ?>
                                <li class="list_address_orther">
                                    <input type="radio" name="add_other" id="add_other"
                                           value="add" <?php echo (!$address_user) ? 'checked' : ''; ?> >
                                    <label for="add_other"><?php echo FSText::_("Thêm địa chỉ khác"); ?></label>
                                </li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <!--them dia chi-->
                        <div id="add_address" class="hide-add-address">
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Họ và tên"); ?>*</p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="name"
                                                                                      placeholder="<?php echo FSText::_("Họ và tên"); ?>"
                                                                                      value="<?php echo $member->username; ?>"
                                                                                      required></div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Điện thoại"); ?>*</p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="telephone"
                                                                                      placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                                                                      value="<?php echo $member->telephone; ?>"
                                                                                      required></div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Email*"); ?></p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="email"
                                                                                      placeholder="<?php echo FSText::_("Email"); ?>"
                                                                                      value="<?php echo $member->email; ?>"
                                                                                      required>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Tỉnh/Thành phố"); ?>*</p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <select name="province" onchange="loaddistrict(this.value);" required>
                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                    <?php foreach ($province as $item) { ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Quận/Huyện"); ?>*</p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <select name="district" disabled id="district" onchange="loadwards(this.value);"
                                        required>
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Phường/Xã"); ?>*</p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <select name="wards" disabled id="wards">
                                    <option value="">Chọn Phường/Xã</option>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                        class="title-input"><?php echo FSText::_("Địa chỉ chi tiết"); ?>*</p></div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="address"
                                                                                      placeholder="<?php echo FSText::_("Vui lòng nhập địa chỉ chi tiết"); ?>"
                                                                                      required></div>
                            <div class="clearfix"></div>
                        </div>
                        <!--                                                    <div class="row">-->
                        <!--                                                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">--><?php //echo FSText::_("Lời nhắn"); ?>
                        <!--                                                            <p class="kbb">(Không bắt buộc)</p></div>-->
                        <!--                                                        <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">-->
                        <!--                                                            <textarea row="4" name="note_send"-->
                        <!--                                                                      placeholder="-->
                        <!--                        -->
                        <?php //echo FSText::_("Ví dụ: Giao hàng trong giờ hành chính"); ?><!--"></textarea>-->
                        <!--                                                        </div>-->
                        <!--                                                        <div class="clearfix"></div>-->
                        <!--                                                    </div>-->
                    </div>
                </div>
            </div>
            <div class="right-cart">
                <div class="list-products-cart">
                    <div class="thanh-toan-2">
                        <table class="table visible_pc">
                            <thead>
                            <tr>
                                <td width="50%">Sản phẩm</td>
                                <td width="20%"></td>
                                <td width="10%"><span>Đơn giá</span></td>
                                <td width="10%"><span>Số lượng</span></td>
                                <td width="10%"><span>Thành tiền</span></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_price = 0;
                            //                            var_dump($list_cart);
                            foreach ($list_cart as $prd) {
                                if ($prd[4]) {
                                    $product = $data[$prd[4]];
//                                var_dump($product);
                                    $price = $product->price_sub;
                                } else {
                                    $product = $data[$prd[0]];
                                    $price = $product->price;
                                }
//                            var_dump($product);
                                $total_price += $price * $prd[1];
                                $link_view = FSRoute::_('index.php?module=products&view=product&code=' . $product->alias . '&id=' . $product->id . '&ccode=' . $product->category_alias);
                                if (!$prd[4]) {
                                    $image = URL_ROOT . str_replace('/original/', '/small/', $product->image);
                                } else {
                                    $image = URL_ROOT . str_replace('/original/', '/small/', $product->image_sub);
                                }
                                ?>
                                <tr>
                                    <td>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 imb">
                                            <!--                                                            <input type="checkbox" id="item_-->
                                            <?php //echo $product->id_sub ?><!--" value="" checked="checked" required>-->
                                            <!--                                                            <label for="item_-->
                                            <?php //echo $product->id_sub ?><!--"></label>-->
                                            <a class="pull-left" href="<?php echo $link_view; ?>">
                                                <img class="img-responsive" src="<?php echo $image; ?>"
                                                     alt="<?php echo htmlspecialchars($product->name); ?>">
                                            </a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 nmb">
                                            <h4 class="media-heading">
                                                <a href="<?php echo $link_view ?>"><?php echo $product->name; ?></a>
                                            </h4>

                                        </div>
                                        <div class="clear"></div>
                                    </td>

                                    <td>
                                        <div class="border">
                                            <?php if ($prd[4]) { ?>
                                                <p class="type_prd">Loại:
<!--                                                    --><?php //if ($product->name_sub) { ?>
                                                        <span><?php echo $product->name_sub ?></span>
<!--                                                    --><?php //} ?>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border">
                                            <p><?php echo format_money($price); ?></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="border">
                                            <p><?php echo $prd[1]; ?></p>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="border">
                                            <p><?php echo format_money($price * $prd[1]); ?></p>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="list_cat_mb visible-xs">

                            <?php
                            $total_price = 0;
                            //                            var_dump($list_cart);
                            foreach ($list_cart as $prd) {
                                if ($prd[4]) {
                                    $product = $data[$prd[4]];
                                    //                                var_dump($product);
                                    $price = $product->price_sub;
                                } else {
                                    $product = $data[$prd[0]];
                                    $price = $product->price;
                                }
                                //                            var_dump($product);
                                $total_price += $price * $prd[1];
                                $link_view = FSRoute::_('index.php?module=products&view=product&code=' . $product->alias . '&id=' . $product->id . '&ccode=' . $product->category_alias);
                                $image = URL_ROOT . str_replace('/original/', '/small/', $product->image);
                                ?>
                                <div class="row pd_col">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 mg_col">
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 mg_col">
                                            <a href="<?php echo $link_view ?>">
                                                <img src="<?php echo $image ?>" alt="<?php echo $product->name ?>"
                                                     class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 mg_col">
                                            <a href="<?php echo $link_view ?>">
                                                <p class="name_mb"><?php echo $product->name ?></p>
                                                <?php if ($prd[4]) { ?>
                                                    <p class="type_prd">Loại:
<!--                                                        --><?php //if ($product->name_sub) { ?>
                                                            <span><?php echo $product->name_sub ?></span>
<!--                                                        --><?php //} ?>
                                                    </p>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mg_col mg_col_r">
                                        <p><?php echo format_money($price); ?></p>
                                        <p><?php echo 'x' . $prd[1]; ?></p>
                                        <p class="price_item_mb"><?php echo format_money($price * $prd[1]); ?></p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            <?php } ?>

                        </div>
                        <div class="chot_sale">
                            <div class="row">
                                <div class="col-md-5 col-xs-12 left_bot">
                                    <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12 note_"><?php echo FSText::_("Lời nhắn:"); ?>
                                    </div>
                                    <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12">
                                        <input class="form-control" name="note_send"
                                               placeholder="Lưu ý cho người bán..." type="text">
                                    </div>

                                </div>
                                <div class="col-md-7 col-xs-12 right_bot">
                                    <div class="vanchuyen">
                                        <p class="unit_ship">Đơn vị vân chuyển:</p>
                                        <div>
                                            <p class="hinh_thuc">Vận chuyển nhanh</p>
                                            <p>Giao hàng tiết kiệm</p>
                                        </div>
                                        <div class="text-right visible_pc">
                                            <?php echo format_money($total_price); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total_price_">
                            <p>Tổng tiền hàng (<?php echo $total_quan ?> sản phẩm):
                                <span><?php echo format_money($total_price); ?></span></p>
                        </div>
                    </div>
                    <div class=clearfix></div>
                    <div class="price-total">
                        <div class="payments ">
                            <div class="row">
                                <div class="col-md-7 col-xs-12 pdbt bdbt payment_mb">
                                    <p class="l_httt">Hình thức thanh toán</p>
                                </div>
                                <div class="col-md-3 col-xs-9 pdbt bdbt payment_mb1">
                                    <p class="httt">Thanh toán khi nhận hàng</p>
                                </div>
                                <div class="col-md-2 col-xs-3  pdbt bdbt">
                                    <div class="text-right">
                                        <a class="change_payment" href="#" data-toggle="modal" data-target="#pay">thay
                                            đổi</a>
                                    </div>
                                    <div class="modal fade pop-up-pay" id="pay" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Chọn hình thức thanh
                                                        toán</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="list-thanh-toan">
                                                        <ul>
                                                            <li class="clearfix">
                                                                <input type="radio" name="pay_book" id="cod" value="2"
                                                                       data-name="Thanh toán khi nhận hàng"
                                                                       onclick="yesnoCheck()"
                                                                       checked>
                                                                <label for="cod"
                                                                       class="tien-mat"><?php echo FSText::_("Thanh toán khi nhận hàng"); ?>
                                                                    <span><?php echo FSText::_("Quý khách sẽ thanh toán bằng tiền mặt hoặc thẻ khi chúng tôi giao hàng cho quý khách."); ?></span></label>
                                                            </li>
                                                            <li class="clearfix">
                                                                <input type="radio" name="pay_book" id="put_bank"
                                                                       data-name="Thanh toán bằng chuyển khoản qua ngân hàng"
                                                                       value="1" onclick="yesnoCheck()">
                                                                <label for="put_bank"
                                                                       class="chuyen-khoan"><?php echo FSText::_("Thanh toán bằng chuyển khoản qua ngân hàng"); ?>
                                                                    <span><?php echo FSText::_("Quý khách sẽ thanh toán bằng hình thức chuyển khoản qua tài khoản ngân hàng của chúng tôi."); ?></span></label>
                                                                <div class="info-banks-send clearfix">
                                                                    <?php echo $config['banks_send']; ?>
                                                                </div>
                                                            </li>
                                                            <!--                                                            <li class="clearfix">-->
                                                            <!--                                                                <input type="radio" name="pay_book" id="port_pay"-->
                                                            <!--                                                                       value="3"-->
                                                            <!--                                                                       onclick="yesnoCheck()">-->
                                                            <!--                                                                <label for="port_pay"-->
                                                            <!--                                                                       class="cong-thanh-toan">--><?php //echo FSText::_("Thanh toán online qua cổng thanh toán"); ?>
                                                            <!--                                                                    <span>-->
                                                            <?php //echo FSText::_("Quý khách sẽ được chuyển đến “Tên cổng thanh toán” để thanh toán."); ?><!--</span></label>-->
                                                            <!--                                                            </li>-->
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-secondary nut"
                                                            data-dismiss="modal">Trở lại
                                                    </button>
                                                    <button type="button" class=" btn-primary nut" data-dismiss="modal">
                                                        Hoàn thành
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-7 col-xs-12">
                                </div>
                                <div class="col-md-5 col-xs-12 pdbt pdt mgbt">
                                    <p>Tổng tiền hàng <span><?php echo format_money($total_price); ?></span></p>
                                    <p>Phí vận chuyển <span><?php if ($total_price >= $config['feeAdc']) {
                                                echo '0đ';
                                            } else {
                                                echo 'Đang tính';
                                            } ?></span></p>
                                    <p>Tổng thanh toán <span
                                                class="price_end"><?php echo format_money($total_price); ?></span></p>
                                </div>
                                <div class="col-md-12 col-xs-12 text-right buy_">
                                    <input type="submit" value="<?php echo FSText::_("Đặt hàng"); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="conditional-terms">-->
            <!--<p><input type="checkbox" class="success_us" id="success_us" required> <label for="success_us">Tôi đồng ý với <a href="#">điều khoản & điều kiện</a> giao dịch của AdcBook</label></p>-->
            <input type="hidden" name="module" value="products">
            <input type="hidden" name="view" value="pay">
            <input type="hidden" name="task" value="set_info">
            <input type="hidden" name="raw" value="1">
            <input type="hidden" name='return' value='<?php echo $return; ?>'/>
            <!--            </div>-->
            <div class="clearfix"></div>
        </form>
        <!--        </div>-->
    </div>
</div>