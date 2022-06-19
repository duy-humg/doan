<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("address", "modules/users/assets/css");
$tmpl->addScript('address', 'modules/users/assets/js');
//var_dump($_SESSION);
$default = $model->get_record('member_id=' . $_SESSION['user_id'] . ' and defau=1', 'fs_members_address');
//var_dump($default);
?>
<div class="container">
    <div class="users row">

        <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?php include 'menu_user.php'; ?>
        </div>
        <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="body_add">
                <div class="cat_title clearfix mt10">
                    <div class="inner">
                        <span><?php echo FSText::_("Địa chỉ giao hàng"); ?></span>
                        <a class="add_address" href="<?php echo FSRoute::_('index.php?module=users&view=address&task=add_address'); ?>"
                           title="<?php echo FSText::_("Thêm địa chỉ mới"); ?>">
                            <i class="fal fa-plus"></i>
                            <?php echo FSText::_("Thêm địa chỉ mới"); ?>
                        </a>
                    </div>
                </div>
                <div class="arrow-right">
                    <?php if($list_address){ ?>

                        <?php foreach ($list_address as $item) {
                            $wards = $model->get_record_by_id($item->ward_id, 'fs_wards')->name;

                            $district = $model->get_record_by_id($item->district_id, 'fs_districts')->name;

                            $province = $model->get_record_by_id($item->province_id, 'fs_cities')->name;

                            ?>
                            <div class="item_address row">
                                <div class=" left-address col-md-8 col-sm-8 col-xs-8">

                                    <div class="address_item">
                                        <h4>
                                            <span><?php echo FSText::_("Họ và tên"); ?></span>
                                            <p class="p-username">
                                                <?php echo $item->username; ?>

                                            </p>
                                            <?php if ($item->defau == 1) { ?>
                                                <p class="default"><?php echo FSText::_("mặc định"); ?></p>
                                            <?php } ?>
                                        </h4>
                                        <p class="p-address">
                                            <span><?php echo FSText::_("Số Điện Thoại"); ?></span> 
                                            <?php echo $item->telephone; ?>
                                        </p>
                                        <p class="p-address">
                                            <span>
                                                <?php echo FSText::_("Địa chỉ"); ?>
                                            </span>
                                            <?php echo $item->content . ", " . $wards . ", " . $district . ", " . $province; ?>
                                        </p>

                                    </div>
                                </div>
                                <div class=" right-address col-md-4 col-sm-4 col-xs-4 text-right">
                                    <div class="thaotac">
                                        <p>
                                            <a class="edit_address"
                                               href="<?php echo FSRoute::_('index.php?module=users&view=address&task=edit_address&raw=1&id=' . $item->id); ?>"><?php echo FSText::_("Sửa"); ?></a>
                                        </p>
                                        <?php if ($item->defau != 1) { ?>
                                            <p class="p_clear_address"><a class="clear_address" href="#"
                                                  onclick="delete_address('<?php echo $item->id; ?>')"><?php echo FSText::_("Xóa"); ?></a>
                                            </p>
                                        <?php } ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="thietlap">
                                        <?php if ($item->defau != 1) { ?>
                                            <a  class="clear_address" href="#"
                                               onclick="delete_default('<?php echo $item->id; ?>','<?php echo $default->id; ?>')">
                                                <?php echo FSText::_("Thiết lập mặc định"); ?>
                                            </a>
                                        <?php } else { ?>
                                            <span><?php echo FSText::_("Thiết lập mặc định"); ?></span>
                                        <?php } ?>
                                    </div>


                                </div>
                            </div>
                        <?php } ?>

                    <?php }else{ ?>
                        <div class="null_address">
                            <img src="<?php echo URL_ROOT.'images/address.svg' ?>" alt="address">
                            <p class="p-null-address"><?php echo FSText::_("Bạn chưa có địa chỉ."); ?></p>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
    </div>
</div>