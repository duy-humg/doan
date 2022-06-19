<?php
global $tmpl, $config;
$tmpl->addStylesheet('step_address', 'modules/products/assets/css');
$tmpl->addStylesheet('thanhtoan_thongtindathang-b1', 'modules/products/assets/css');
$tmpl->addScript("step_address", "modules/products/assets/js");
$url = $_SERVER['REQUEST_URI'];
$tmpl->addScript('form1');
$return = base64_encode($url);
$total_quan = 0;
$total_price = 0;
//var_dump($list_cart);
foreach ($list_cart as $prd) {
$total_quan += $prd[1];
    $total_price += $prd[1]*$prd[2];
}
?>
<div class="ql_m">
    <a href="<?php echo FSRoute::_('index.php?module=products&view=cart'); ?>">
    <svg viewBox="0 0 22 17" role="img" class="stardust-icon stardust-icon-back-arrow _1aiFrB"><g stroke="none" stroke-width="1" fill-rule="evenodd" transform="translate(-3, -6)"><path d="M5.78416545,15.2727801 L12.9866648,21.7122915 C13.286114,22.0067577 13.286114,22.4841029 12.9866648,22.7785691 C12.6864297,23.0738103 12.200709,23.0738103 11.9004739,22.7785691 L3.29347136,15.0837018 C3.27067864,15.0651039 3.23845445,15.072853 3.21723364,15.0519304 C3.06240034,14.899273 2.99480814,14.7001208 3.00030983,14.5001937 C2.99480814,14.3002667 3.06240034,14.1003396 3.21723364,13.9476821 C3.23845445,13.9275344 3.2714646,13.9345086 3.29425732,13.9166857 L11.9004739,6.22026848 C12.200709,5.92657717 12.6864297,5.92657717 12.9866648,6.22026848 C13.286114,6.51628453 13.286114,6.99362977 12.9866648,7.288096 L5.78416545,13.7276073 L24.2140442,13.7276073 C24.6478918,13.7276073 25,14.0739926 25,14.5001937 C25,14.9263948 24.6478918,15.2727801 24.2140442,15.2727801 L5.78416545,15.2727801 Z"></path></g></svg>
        Giỏ hàng
    </a>
</div>
<div class="total_price_m">
    <p class="p-3">Tổng thanh toán: <span class="price_end"><?php echo format_money($total_price); ?></span></p>
    <a  id="submitbt_pay_m" href="javascript:void(0)"><?php echo FSText::_("Đặt hàng"); ?></a>
    <p class="p-dk">Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý tuân theo <a href="#"> Điều khoản Vinashoe</a></p>
</div>
<div class="container">
    <div class="margin-top-cat">
        <form action="<?php echo FSRoute::_('index.php?module=products&view=pay&task=set_info&raw=1'); ?>"
              name="form_pay_code" class="form_pay_code" method="post">
            <div class="left-cart-pay">
                <div class="left-box-list">
                    <?php if($_SESSION['user_id']){ ?>
                        <div class="address_user">
                            <h3 class='title-cart-right'><?php echo FSText::_("ĐỊA CHỈ NHẬN HÀNG"); ?></h3>
                            <!--dia chi cu-->
                            <div class="list_address_all">
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
                                                    <span>(<?php echo $item->telephone; ?>)</span></p>
                                            </label>
                                            <p class="address_mb"><?php echo $item->content . ", " . $wards . ", " . $district . ", " . $province2; ?></p>
                                            <p class="default_ <?php echo ($item->defau == 1) ? 'default' : 'default1'; ?>"><?php echo ($item->defau == 1) ? 'Mặc định' : ''; ?></p>
                                            <!--                                            <a class="edit_adrr text-right"-->
                                            <!--                                               href="--><?php //echo FSRoute::_('index.php?module=users&view=address&task=edit_address&raw=1&id=' . $item->id); ?><!--">Thay đổi</a>-->
                                        </li>
                                    <?php } ?>
                                    <li class="list_address_orther">
                                        <a class="a_add" id="add_address_click" href="javascript:void(0)"><?php echo FSText::_("Thêm địa chỉ mới"); ?></a>
                                        <a class="a_thietlap" href="<?php echo FSRoute::_('index.php?module=users&view=address'); ?>"><?php echo FSText::_("Thiết lập địa chỉ"); ?></a>
                                        <?php if(count($address_user)>=1){ ?>
                                            <input type="hidden" id="add_address_input" name="add_address_input" value="">
                                        <?php }else{ ?>
                                            <input type="hidden" id="add_address_input" name="add_address_input" value="1">
                                        <?php } ?>
                                       
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                            <!--them dia chi-->
                            <div id="add_address" class="hide-add-address <?php if(count($address_user)>=1){ ?> <?php }else{ ?>add-address-block <?php } ?>"   >
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Họ và tên"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <input required="" class="input_add" type="text" name="name" id="name"
                                           placeholder="<?php echo FSText::_("Họ và tên"); ?>"
                                           value="<?php echo $member->username; ?>">
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Điện thoại"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="telephone" id="telephone"
                                                                                          placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                                                                          value="<?php echo $member->telephone; ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Email*"); ?></p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="email" id="email"
                                                                                          placeholder="<?php echo FSText::_("Email"); ?>"
                                                                                          value="<?php echo $member->email; ?>"
                                                                                          required>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Tỉnh/Thành phố"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="city" id="city">
                                        <option value=""><?php echo FSText::_("Chọn Tỉnh/Thành phố"); ?></option>
                                        <?php foreach ($city as $item){
                                            ?>
                                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Quận/Huyện"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="district" id="district">
                                        <option value=""><?php echo FSText::_("Chọn Quận/Huyện"); ?></option>
                                        <?php foreach ($districts as $item){

                                            ?>
                                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                        <?php } ?>


                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Phường/Xã"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                    <select name="ward" id="ward">
                                        <option value=""><?php echo FSText::_("Chọn Phường/Xã"); ?></option>
                                        <?php foreach ($wards as $item){
                                            ?>
                                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12"><p
                                            class="title-input"><?php echo FSText::_("Địa chỉ chi tiết"); ?>*</p></div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"><input type="text" name="address" id="address"
                                                                                          placeholder="<?php echo FSText::_("Vui lòng nhập địa chỉ chi tiết"); ?>"
                                                                                          required></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    <?php }else{ ?>
                        <input type="hidden" id="add_address_input_new" name="add_address_input_new" value="1">
                        <div class="address_datthang_1 address_datthang">
                            <h3><?php echo FSText::_("Địa chỉ nhận hàng"); ?></h3>
                            <div class="form-control-dt">
                                <input type="text" name="name" id="name"
                                       placeholder="<?php echo FSText::_("Họ và tên"); ?>"
                                       value=""
                                       required>
                            </div>
                            <div class="form-control-dt">
                                <input type="text" name="telephone" id="telephone"
                                       placeholder="<?php echo FSText::_("Số điện thoại"); ?>"
                                       value=""
                                       required>
                            </div>
                            <div class="row">
                                <div class="left-address col-md-6">
                                    <div class="form-control-dt">
                                        <select name="city" id="city">
                                            <option value="<?php echo $item->id ?>"><?php echo FSText::_("Chọn Tỉnh/Thành phố"); ?></option>
                                            <?php foreach ($city as $item){
                                                $class = '';
                                                if($item->id==$_SESSION['id_city']){
                                                    $class .= 'selected="selected"';
                                                }
                                                ?>
                                                <option <?php echo $class ?> value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                            <?php } ?>


                                        </select>
                                    </div>
                                </div>
                                <div class="right-address col-md-6">
                                    <div class="form-control-dt">
                                        <select name="district" id="district">
                                            <option value="<?php echo $item->id ?>"><?php echo FSText::_("Chọn Quận/Huyện"); ?></option>
                                            <?php foreach ($districts as $item){
                                                $class = '';
                                                if($item->id==$_SESSION['id_huyen']){
                                                    $class .= 'selected="selected"';
                                                }
                                                ?>
                                                <option <?php echo $class ?> value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                            <?php } ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-control-dt">
                                <select name="ward" id="ward">
                                    <option value="<?php echo $item->id ?>"><?php echo FSText::_("Chọn Phường/Xã"); ?></option>
                                    <?php foreach ($wards as $item){
                                        $class = '';
                                        if($item->id==$_SESSION['id_xa']){
                                            $class .= 'selected="selected"';
                                        }
                                        ?>
                                        <option <?php echo $class ?> value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-control-dt">
                                <input type="text" name="address" id="address"
                                       placeholder="<?php echo FSText::_("Số nhà, tên đường *"); ?>"
                                       value=""
                                       required>
                            </div>
                            <input type="hidden" value="add" id="add_other_s" name="add_other_s">
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="right-cart">
                <div class="list-products-cart">
                    <?php foreach ($list_shop as $item){
                    $model = $this->model;
                    $get_shop = $model->get_shop($item);
                    ?>
                        <div class="item-shop">
                            <div class="row header-item-shop">
                                <div class="text-sp item-header-shop col-md-7 col-sm-6 col-xs-6">
                                    <p>Sản phẩm</p>
                                </div>
                                <div class="dongia-sp item-header-shop col-md-2 col-sm-2 col-xs-2">
                                    <p>Đơn giá</p>
                                </div>
                                <div class="sl-sp item-header-shop col-md-1 col-sm-2 col-xs-2">
                                    <p>Số lượng</p>
                                </div>
                                <div class="thanhtien-sp item-header-shop col-md-2 col-sm-2 col-xs-2">
                                    <p>Thành tiền</p>
                                </div>
                            </div>
                            <div class="name-shop-chat">
                                <div class="name_shop">
                                    <a href="<?php echo  FSRoute::_('index.php?module=products&view=shop&cid=' . $get_shop->id . '&ccode=' . $get_shop->alias) ?>" target="_blank">
                                        <?php echo $get_shop->name ?>
                                    </a>
                                </div>
                                <div class="chat_shop">
                                    <a href="#">Chat ngay</a>
                                </div>
                            </div>
                            <div class="bao-sp-shop">
                                <?php $i = 0;$total = 0;$total_all=0; foreach  ($list_cart as $prd){
                                    $i++;
                                    ?>
                                    <?php if($item==$prd[6]){
                                        $product_img = $model->get_records('published = 1 and id=' . $prd[0], 'fs_products', '*');
                                        $image = URL_ROOT . str_replace('/original/', '/tiny/', $product_img[0]->image);
                                        if($prd[5]){
                                            $product_sub = $model->get_records('published = 1 and id=' . $prd[5], 'fs_products_sub', '*');
                                        }
                                        $total_sp = $prd[1] * $prd[2];
                                        $total_all += $total_sp;

                                        ?>
                                        <div class="item-sp row">
                                            <div class="cart-sp inline-header col-md-7 col-sm-6  col-xs-6">
                                                <div class="img-sp">
                                                    <img src="<?php echo $image ?>" alt="">
                                                </div>
                                                <div class="name-sp">
                                                    <p><?php echo $product_img[0]->name ?></p>
                                                </div>
                                                <?php if($prd[5]){ ?>
                                                    <div class="pl">
                                                        <p>Loại: <?php if($product_sub[0]->color_id){ ?><?php echo $product_sub[0]->color_name ?>, <?php } ?> <?php if($product_sub[0]->size_id){ ?><?php echo $product_sub[0]->size_name ?><?php } ?></p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="cart-price inline-header col-md-2 col-sm-2 col-xs-2">
                                                
                                                    <?php if($prd[5]){ ?>
                                                        <p class="price-sp">
                                                            <?php if($product_sub[0]->price){ ?>
                                                                <span class="price_old"><?php echo format_money($product_sub[0]->price)  ?>
                                                                </span>
                                                            <?php } ?>
                                                            <?php echo format_money($product_sub[0]->price_h ) ?></p>
                                                    <?php }else{ ?>
                                                        <p class="price-sp">
                                                            <?php if($product_img[0]->price_old){ ?>
                                                                <span class="price_old"><?php echo format_money($product_img[0]->price_old)  ?></span>
                                                            <?php } ?>
                                                            <?php echo format_money($product_img[0]->price)  ?></p>
                                                    <?php } ?>
                                                

                                            </div>
                                            <div class="cart-count inline-header col-md-1 col-sm-2 col-xs-2">
                                                 <span class="number-input">
                                                    <?php echo $prd[1] ?>
                                                 </span>
                                            </div>
                                            <div class="cart-total-price inline-header  col-md-2 col-sm-2 col-xs-2">
                                                <p><?php echo format_money($total_sp) ?></p>
                                            </div>
                                        </div>
                                        <div class="item-sp-m">
                                                <div class="img-sp">
                                                    <img src="<?php echo $image ?>" alt="">
                                                </div>
                                                <div class="name-sp">
                                                    <p><?php echo $product_img[0]->name ?></p>
                                                </div>
                                                <?php if($prd[5]){ ?>
                                                    <div class="pl">
                                                        <p>Loại: <?php if($product_sub[0]->color_id){ ?><?php echo $product_sub[0]->color_name ?>, <?php } ?> <?php if($product_sub[0]->size_id){ ?><?php echo $product_sub[0]->size_name ?><?php } ?></p>
                                                    </div>
                                                <?php } ?>
                                                <?php if($prd[5]){ ?>
                                                    <p class="price-sp">
                                                        <?php if($product_sub[0]->price){ ?>
                                                            <span class="price_old"><?php echo format_money($product_sub[0]->price)  ?>
                                                            </span>
                                                        <?php } ?>
                                                        <?php echo format_money($product_sub[0]->price_h ) ?></p>
                                                <?php }else{ ?>
                                                    <p class="price-sp">
                                                        <?php if($product_img[0]->price_old){ ?>
                                                            <span class="price_old"><?php echo format_money($product_img[0]->price_old)  ?></span>
                                                        <?php } ?>
                                                        <?php echo format_money($product_img[0]->price)  ?></p>
                                                <?php } ?>
                                            <div class="cart-count inline-header ">
                                                 <span class="number-input">
                                                     Số lượng: 
                                                    <?php echo $prd[1] ?>
                                                 </span>
                                            </div>
                                            <div class="cart-total-price inline-header">
                                                
                                                <p>Tổng số tiền: <span><?php echo format_money($total_sp) ?></span></p>
                                            </div>

                                        </div>

                                    <?php } ?>

                                <?php } ?>
                            </div>
                            <div class="loinhan-total-price-shop">
                                <div class="left_ln">
                                    <p class="p-text-loinhan">Lời nhắn</p>
                                    <div class="input-loinhan">
                                        <input name="note_send_<?php echo $get_shop->id ?>" type="text" value="" placeholder="Lưu ý cho Người bán...">
                                    </div>
                                    <p class="p-free">Miễn phí vận chuyển</p>
                                </div>
                                <div class="right_ln">
                                    <p>Tổng số tiền: <span><?php echo format_money($total_all) ?></span></p>
                                    <input type="hidden" id="total_price_shop_<?php echo $get_shop->id ?>" name="total_price_shop_<?php echo $get_shop->id ?>" value="<?php echo $total_all ?>">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class=clearfix></div>
                    <div class="price-total">
                        <div class="payments ">

                            <div class="pdbt bdbt payment_mb">
                                <p class="l_httt">Phương thức thanh toán</p>
                                <ul>
                                    <li>
                                        <a class="a_pay a_pay_1 active_payment" onclick="yesnoCheck(1)" href="javascript:void(0)" cod="1" cod_name="<?php echo FSText::_("Thanh toán khi nhận hàng"); ?>">
                                            <?php echo FSText::_("Thanh toán khi nhận hàng"); ?>
                                            <img src="<?php echo URL_ROOT.'modules/products/assets/images/check.svg' ?>" alt="check">
                                        </a>
                                    </li>
                                    <li>
                                        <a class="a_pay a_pay_2  btn btn-info" type="button"  data-toggle="collapse" data-target="#list_nganhang"  href="javascript:void(0)" onclick="yesnoCheck(2)" cod="2" cod_name="<?php echo FSText::_("Thẻ ATM/Internet banking"); ?>">
                                            <?php echo FSText::_("Thẻ ATM/Internet banking"); ?>
                                            <img src="<?php echo URL_ROOT.'modules/products/assets/images/check.svg' ?>" alt="check">
                                        </a>
                                    </li>
                                    <li>
                                        <a class="a_pay a_pay_3 btn btn-info" type="button"  data-toggle="collapse" data-target="#nganhang" href="javascript:void(0)" onclick="yesnoCheck(3)" cod="3" cod_name="<?php echo FSText::_("Chuyển khoản qua ngân hàng"); ?>">
                                            <?php echo FSText::_("Chuyển khoản qua ngân hàng"); ?>
                                            <img src="<?php echo URL_ROOT.'modules/products/assets/images/check.svg' ?>" alt="check">
                                        </a>
                                    </li>
                                    <li>
                                        <a class="a_pay a_pay_4" href="javascript:void(0)" onclick="yesnoCheck(4)" cod="4" cod_name="<?php echo FSText::_("Thẻ Tín dụng/Ghi nợ"); ?>">
                                            <?php echo FSText::_("Thẻ Tín dụng/Ghi nợ"); ?>
                                            <img src="<?php echo URL_ROOT.'modules/products/assets/images/check.svg' ?>" alt="check">
                                        </a>
                                    </li>

                                    <div id="nganhang" class="collapse taikhoan_nganhang">
                                        <?php echo $config['banks_send'] ?>
                                    </div>

                                    <div id="list_nganhang" class="collapse taikhoan_nganhang">
                                        <ul class="ul_list_pay"> 
                                            <li class="active_pay option_item_pay" value="NCB"> 
                                                Ngân hàng NCB
                                            </li>
                                            <li class="option_item_pay" va="AGRIBANK"> Ngân hàng Agribank</li>
                                            <li class="option_item_pay" va="SCB"> Ngân hàng SCB</li>
                                            <li class="option_item_pay" va="SACOMBANK">Ngân hàng SacomBank</li>
                                            <li class="option_item_pay" va="EXIMBANK"> Ngân hàng EximBank</li>
                                            <li class="option_item_pay" va="MSBANK"> Ngân hàng MSBANK</li>
                                            <li class="option_item_pay" va="NAMABANK"> Ngân hàng NamABank</li>
                                            <li class="option_item_pay" va="VNMART"> Vi dien tu VnMart</li>
                                            <li class="option_item_pay" va="VIETINBANK">Ngân hàng Vietinbank</li>
                                            <li class="option_item_pay" va="VIETCOMBANK"> Ngân hàng VCB</li>
                                            <li class="option_item_pay" va="HDBANK">Ngân hàng HDBank</li>
                                            <li class="option_item_pay" va="DONGABANK"> Ngân hàng Dong A</li>
                                            <li class="option_item_pay" va="TPBANK"> Ngân hàng TPBank</li>
                                            <li class="option_item_pay" va="OJB"> Ngân hàng OceanBank</li>
                                            <li class="option_item_pay" va="BIDV"> Ngân hàng BIDV</li>
                                            <li class="option_item_pay" va="TECHCOMBANK"> Ngân hàng Techcombank</li>
                                            <li class="option_item_pay" va="VPBANK"> Ngân hàng VPBank</li>
                                            <li class="option_item_pay" va="MBBANK"> Ngân hàng MBBank</li>
                                            <li class="option_item_pay" va="ACB"> Ngân hàng ACB</li>
                                            <li class="option_item_pay" va="OCB"> Ngân hàng OCB</li>
                                            <li class="option_item_pay" va="IVB"> Ngân hàng IVB</li>
                                            <li class="option_item_pay" va="VISA"> Thanh toán qua VISA/MASTER</li>
                                        </ul>
                                        <input type="hidden" value="NCB" name="pay_item" id="pay_item">
                                    </div>



                                    <input type="hidden" id="pay_book" name="pay_book" value=1"
                                           data-name="Thanh toán khi nhận hàng">
                                </ul>

                            </div>

                            <div class="clearfix"></div>

                            <div class="pdbt pdt mgbt">
                                <p class="p-1">Tổng tiền hàng <span><?php echo format_money($total_price); ?></span></p>
                                <p class="p-2">Phí vận chuyển <span>Miễn phí</span></p>
                                <p class="p-3">Tổng thanh toán <span
                                            class="price_end"><?php echo format_money($total_price); ?></span></p>

                            </div>
                            <div class="text-right buy_">
                                <p>Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý tuân theo  <a href="<?php echo URL_ROOT.'dieu-khoan-amp;-dieu-kien-c27.html' ?>" target="_blank">  Điều khoản Vinashoe</a></p>
                                <div class="sumit_buy">

                                    <a  id="submitbt_pay" href="javascript:void(0)"><?php echo FSText::_("Đặt hàng"); ?></a>
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

