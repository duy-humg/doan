<?php
global $tmpl, $config;
$tmpl->addStylesheet('step_address', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_thongtindathang-b1', 'modules/products/assets/css');
$tmpl->addScript("step_address", "modules/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
//var_dump($_SESSION['info_guest']);

?>
<div class="menu-list-cart">
    <div class="container clearfix">
        <div class="col-md-12 cart_pc">
            <div class="_progress-bar">
                <span><i class="fa fa-shopping-cart"></i></span>
            </div>
        </div>

        <div class="col-md-12">
            <div id="nav-content">
                <ul class="clearfix">
                    <li class="choice"><a id="last-checked" href="">ĐĂNG NHẬP</a></li>
                    <li class="choice1"><a id="checked" href="">THÔNG TIN ĐẶT HÀNG</a></li>
                    <li><a href="">HÌNH THỨC THANH TOÁN</a></li>
                    <li><a href="">ĐẶT MUA</a></li>
                    <li><a href="">ĐẶT HÀNG THÀNH CÔNG</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="margin-top-cat">
        <div class="row">
            <form action="<?php echo FSRoute::_('index.php?module=products&view=pay&task=set_info&raw=1'); ?>"
                  name="form_pay_code" class="form_pay_code" method="post">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 left-cart-pay">

                    <h3 class='title-cart-right'><?php echo FSText::_("HÌNH THỨC NHẬN HÀNG"); ?></h3>
                    <div class="left-box-list mg1" id="check_box">
                        <div class="hinh-thuc-van-chuyen1">
                            <ul>
                                <li class="clearfix"><input type="radio" name="vanchuyen" value="nhận tại nhà"
                                                            id="home3" class="home2"
                                                            checked><label for="home3" class="home"> NHẬN ĐỒ TẠI
                                        NHÀ </label></li>
                                <li class="clearfix"><input type="radio" name="vanchuyen"
                                                            value="nhận tại cửa hàng"
                                                            id="store1" class="home2"><label for="store1"
                                                                                             class="store1">NHẬN ĐỒ TẠI
                                        CỬA
                                        HÀNG </label></li>
                            </ul>
                        </div>
                    </div>
                    <div class="left-box-list">
                        <div class="row">
                            <div id="store_select">

                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <p
                                            class="title-input title1"><?php echo FSText::_("BẠN MUỐN NHẬN ĐỒ TẠI:"); ?></p>
                                    <div class="add" id="store_infor">
                                        <p><?php echo $store_infor->name ?></p>
                                        <p><?php echo $store_infor->address ?></p>
                                    </div>
                                    <input type="hidden" name="store" id="store_selected"
                                           value="<?php echo $store_infor->id ?>">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right right_mb">
                                    <a href="" class="selet_store"
                                       data-toggle="modal" data-target="#myModal">Thay đổi cửa
                                        hàng</a>
                                    <div id="myModal" class="modal fade text-left" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h3 class="modal-title ">DANH SÁCH CỬA HÀNG</h3>
                                                </div>
                                                <div class="modal-body clearfix">
                                                    <select class="option1" name="province1"
                                                            onchange="loaddistrictstore(this.value);"
                                                    >
                                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                                        <?php foreach ($province as $item) { ?>
                                                            <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <select name="district1" disabled id="districtstore"
                                                            onchange="loadstore(this.value);"
                                                    >
                                                        <option value="">Chọn Quận/Huyện</option>
                                                    </select>
                                                    <div id="store">
                                                        <?php
                                                        $i = 1;
                                                        foreach ($store as $key) {
                                                            ?>
                                                            <div class="radio-cuahang<?php echo $key->id ?>">
                                                                <input type="radio" name="cuahang<?php echo $key->id ?>"
                                                                       id="cuahang<?php echo $key->id ?>" value=""
                                                                       onclick="loadstoreinfor(<?php echo $key->id; ?>)">
                                                                <label for="cuahang<?php echo $key->id; ?>">
                                                                    <span></span>&nbsp;<?php echo $key->name ?>
                                                                    <small><?php echo $key->address ?>
                                                                    </small>
                                                                </label>
                                                            </div>
                                                            <?php
                                                            $i++;
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <!--them dia chi-->
                            <div class="address-notmember">
                                <div class="col-sm-12 clearfix">
                                    <p style="float: left;"
                                       class=" title1 title2"><?php echo FSText::_("THÔNG TIN CỦA BẠN:"); ?></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Họ và tên"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="name"
                                                                                          placeholder="<?php echo FSText::_("Họ và tên"); ?>"
                                                                                          value="" required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Điện thoại"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="telephone"
                                                                                          placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                                                                          value="" required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Email"); ?></p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="email"
                                                                                          placeholder="<?php echo FSText::_("Email"); ?>"
                                                                                          value="<?php echo $_SESSION['not_user_2']; ?>">
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
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
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Quận/Huyện"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="district" disabled id="district" onchange="loadwards(this.value);"
                                            required>
                                        <option value="">Chọn Quận/Huyện</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Phường/Xã"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="wards" disabled id="wards" required>
                                        <option value="">Chọn Phường/Xã</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Địa chỉ chi tiết"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="address"
                                                                                          placeholder="<?php echo FSText::_("Vui lòng nhập địa chỉ chi tiết"); ?>"
                                    ></div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Lời nhắn"); ?></p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="note_send"
                                    ></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <h3 class='title-cart-right'><?php echo FSText::_("Thông tin người mua hàng"); ?></h3>
                    <div class="left-box-list">
                        <div class="check-show-hide">
                            <input checked="checked" type="checkbox" name="same_address" id="same_address"><label
                                    for="same_address"><?php echo FSText::_("Thông tin người mua hàng giống như trên"); ?></label>
                        </div>
                        <div class="add_same_address" id="add_same_address">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Họ và tên"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="re_name"
                                                                                          placeholder="<?php echo FSText::_("Họ và tên"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Điện thoại"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text"
                                                                                          name="re_telephone"
                                                                                          placeholder="<?php echo FSText::_("Điện thoại"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Email"); ?></p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="re_email"
                                                                                          placeholder="<?php echo FSText::_("Email"); ?>">
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Tỉnh/Thành phố"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="re_province" onchange="reloaddistrict(this.value);" required>
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
                                    <select name="re_district" disabled id="redistrict"
                                            onchange="reloadwards(this.value);" required>
                                        <option value="">Chọn Quận/Huyện</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Phường/Xã"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="re_wards" disabled id="rewards" required>
                                        <option value="">Chọn Phường/Xã</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Địa chỉ chi tiết"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="re_address"
                                                                                          placeholder="<?php echo FSText::_("Vui lòng nhập địa chỉ chi tiết"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div id="layhang">
                        <h3 class='title-cart-right'><?php echo FSText::_("Hình thức lấy hàng"); ?></h3>
                        <div class="left-box-list">
                            <div class="hinh-thuc-van-chuyen">
                                <ul>
                                    <li class="clearfix"><input type="radio" name="hinhthuc" value="lấy hàng trong ngày"
                                                                id="vtpost"
                                                                required><label for="vtpost" class="viettel_post">LẤY
                                            HÀNG
                                            TRONG NGÀY
                                        </label><span
                                                class="price-post"><?php echo format_money($config['pickup_day']); ?></span>
                                    </li>
                                    <li class="clearfix"><input type="radio" name="hinhthuc"
                                                                value="lấy hàng trong 1 giờ"
                                                                id="vnpost" required><label for="vnpost"
                                                                                            class="vietnam_post">LẤY
                                            HÀNG 1 GIỜ
                                        </label><span
                                                class="price-post"><?php echo format_money($config['pickup_hours']); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="giaohang">
                        <h3 class='title-cart-right'><?php echo FSText::_("Hình thức giao hàng"); ?></h3>

                        <div class="left-box-list">
                            <div class="hinh-thuc-van-chuyen">
                                <ul>
                                    <li class="clearfix"><input type="radio" name="hinhthuc"
                                                                value="giao hàng tiêu chuẩn"
                                                                id="ghtktc"
                                                                checked required><label for="ghtktc"
                                                                                        class="viettel_post">GIAO
                                            HÀNG TIÊU CHUẨN
                                        </label><span
                                                class="price-post"><?php echo format_money($config['standardd']); ?></span></li>
                                    <li class="clearfix"><input type="radio" name="hinhthuc" value="giao hàng nhanh"
                                                                id="ghtkn" required><label for="ghtkn"
                                                                                           class="vietnam_post">GIAO
                                            HÀNG NHANH
                                        </label><span
                                                class="price-post"><?php echo format_money($config['fast_ship']); ?></span></li>
                                    <li class="clearfix"><input type="radio" name="hinhthuc" value="giao hàng siêu tốc"
                                                                id="ghtkst" required><label for="ghtkst"
                                                                                            class="vietnam_post">GIAO
                                            HÀNG SIÊU TỐC
                                        </label><span
                                                class="price-post"><?php echo format_money($config['Super_speed']); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="left-box-list">
                        <div class="check-show-hide">
                            <input type="checkbox" name="expost" id="expost"><label
                                    for="expost"><?php echo FSText::_("Xuất hóa đơn GTGT cho đơn hàng"); ?></label>
                        </div>
                        <div class="has_expost" id="has_expost">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Mã số thuế"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="code_tax"
                                                                                          placeholder="<?php echo FSText::_("Vui lòng nhập Mã số thuế"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Tên công ty"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text"
                                                                                          name="name_company"
                                                                                          placeholder="<?php echo FSText::_("Vui lòng nhập Tên công ty"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Địa chỉ công ty"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text"
                                                                                          name="address_company"
                                                                                          placeholder="<?php echo FSText::_("Vui lòng nhập Địa chỉ công ty"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="checkbox"
                                                                                          name="save_company"
                                                                                          id="save_company"><label
                                            for="save_company"><?php echo FSText::_("Lưu thông tin này cho lần đặt hàng sau"); ?></label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 right-cart">
                    <h3 class='title-cart-right'><?php echo FSText::_("ĐƠN HÀNG CỦA BẠN"); ?> <span
                                class="soluong"> (<?php echo count($list_cart); ?> sản phẩm)</span></h3>
                    <div class="list-products-cart">
                        <div class="list-products">
                            <ul>
                                <?php
                                $total_price = 0;
                                foreach ($list_cart as $item) {
                                    if ($item[2] == 1) {
                                        $price = $data[$item[0]]->price;
                                    } else {
                                        $price = $data[$item[0]]->price_old1;
                                    }

                                    $total_price += $price * $item[1];
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                <a class="clearfix"
                                                   href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $data[$item[0]]->category_alias . '&code=' . $data[$item[0]]->alias . '&id=' . $data[$item[0]]->id); ?>">
                                                    <img src="<?php echo URL_ROOT . str_replace('original', 'small', $data[$item[0]]->image); ?>" onerror="this.src='/images/not_picture.png'"  class="img-responsive">
                                                    <?php echo $data[$item[0]]->name; ?>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <p><?php echo format_money($price); ?></p>
                                                <p>x<?php echo $item[1]; ?></p>
                                                <p><b><?php echo format_money($price * $item[1]); ?></b></p>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="price-total">
                            <ul>
                                <li><?php echo FSText::_("Tổng tiền sản phẩm"); ?><span
                                            class="red-price"><?php echo format_money($total_price); ?></span></li>
                                <li><?php echo FSText::_("Tổng chi phí vận chuyển"); ?><span
                                            class="blue-price">Liên hệ</span></li>
                                <!--                                    <li>-->
                                <?php //echo FSText::_("Cấp thành viên"); ?><!--<span>0đ</span></li>-->
                                <!--                                    <li>-->
                                <?php //echo FSText::_("Mã giảm giá"); ?><!--<span>0đ</span></li>-->
                            </ul>
                            <p class="clearfix"><?php echo FSText::_("Số tiền cần phải trả"); ?><span
                                        class="fred red-price"><?php echo format_money($total_price); ?></span></p>
                        </div>
                    </div>
                    <div class="conditional-terms">
                        <input type="submit" value="<?php echo FSText::_("vận chuyển và thanh toán"); ?>">
                        <input type="hidden" name="module" value="products">
                        <input type="hidden" name="view" value="pay_not">
                        <input type="hidden" name="task" value="set_info">
                        <input type="hidden" name="raw" value="1">
                        <input type="hidden" name='return' value='<?php echo $return; ?>'/>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>