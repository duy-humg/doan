<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("address2", "modules/users/assets/css");
$tmpl->addScript('address2', 'modules/users/assets/js');
//var_dump($data_address);
?>
<div class="container">
    <div class="users row">
        <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php include 'menu_user.php'; ?>
        </div>
        <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="cat_title clearfix mt10">
                <div class="inner">
                    <span><?php echo FSText::_("Sửa địa chỉ"); ?></span>
                </div>
            </div>
            <div class="arrow-right">
                <form id="form-user-edit"
                      action="<?php echo FSRoute::_("index.php?module=users&view=address&task=editing_address"); ?>"
                      method="post" name="form-user-edit" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Họ và tên*"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <input class="txt-input input-full-name"
                                   placeholder="<?php echo FSText::_("Họ và tên"); ?>" type="text"
                                   name="full_name" id="full_name" value="<?php echo $data_address->username; ?>"
                                   required/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Số điện thoại*"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <input class="txt-input" type="tel"
                                   placeholder="<?php echo FSText::_("Số điện thoại"); ?>" name="telephone"
                                   id="telephone" value="<?php echo $data_address->telephone; ?>" required/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Email*"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <input class="txt-input" type="email"
                                   placeholder="<?php echo FSText::_("Email của bạn"); ?>" name="email"
                                   id="email" value="<?php echo $data_address->email; ?>" required/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Tỉnh/Thành phố*"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <select name="province" onchange="loaddistrict(this.value);" required>
                                <option value="">Chọn Tỉnh/Thành phố</option>
                                <?php foreach ($province as $item) { ?>
                                    <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $data_address->province_id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Quận/huyện*"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <select name="district" id="district" onchange="loadwards(this.value);" required>
                                <option value="">Chọn Quận/Huyện</option>
                                <?php foreach ($district as $item) { ?>
                                    <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $data_address->district_id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Phường/xã*"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <select name="wards" id="wards" required>
                                <option value="">Chọn Phường/Xã</option>
                                <?php foreach ($wards as $item) { ?>
                                    <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $data_address->ward_id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label><?php echo FSText::_("Địa chỉ"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                    <textarea rows="4" name="content"
                                              placeholder="<?php echo FSText::_("Số nhà, tên ngõ, tên đường,..."); ?>"
                                              required><?php echo $data_address->content; ?></textarea>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 mgt">
                            <input type="checkbox" name="address_default" id="address_default"
                                   value="1" <?php echo ($data_address->defau == 1) ? 'checked' : ''; ?> />
                            <label for="address_default"><span
                                        class="change-pass"><?php echo FSText::_("Sử dụng địa chỉ này làm địa chỉ nhận hàng mặc định"); ?></span></label>
                        </div>
                        <div class="clearfix"></div>
<!--                        <div class="change-pas-div"></div>-->

                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <input class="button-submit-edit button" name="submit" type="submit"
                                   value="<?php echo FSText::_("Cập nhật"); ?>"/>
                            <input type="hidden" name="module" value="users"/>
                            <input type="hidden" name="view" value="address"/>
                            <input type="hidden" name="task" value="editing_address"/>
                            <input type="hidden" name="member_id" value="<?php echo $data->id; ?>"/>
                            <input type="hidden" name="id" value="<?php echo $data_address->id; ?>"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>