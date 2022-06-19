<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("level", "modules/users/assets/css");
$Itemid = FSInput::get('Itemid', 1);
?>
<div class="users row">
    <div class="main-column-left col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <?php include 'menu_user.php'; ?>
    </div>
    <div class="main-column-content col-lg-10 col-md-10 col-sm-12 col-xs-12">
        <div class="cat_title clearfix mt10">
            <div class="inner">
                <span><?php echo FSText::_("Cấp tài khoản"); ?></span>
            </div>

        </div>
        <div class="arrow-right-top">
            <h3 class="title-in-box"><?php echo FSText::_("Thông tin cấp tài khoản của bạn"); ?></h3>
            <div class="table-responsive">
                <table width="100%" cellpadding="4" class="table-level table">
                    <thead>
                    <tr class="head-tr">
                        <th width="15%" class="fisrt-vl"><?php echo FSText::_("Cấp tài khoản"); ?></th>
                        <th width="23%"><?php echo FSText::_("Giá trị đơn hàng "); ?></th>
                        <th width="23%"><?php echo FSText::_("Quyền lợi của bạn"); ?></th>
                        <th width="23%"><?php echo FSText::_("Ngày tạo tại khoản"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="value-acount"><?php
                            if($data->member_level==1){
                                echo 'Thường';
                            }elseif($data->member_level==2){
                                echo 'Vip 1';
                            }elseif($data->member_level==3){
                                echo 'Vip 3';
                            }
                            ?></td>
                        <td><?php echo format_money($data->money); ?></td>
                        <td>Giảm giá <span>
                                <?php
                                if($data->member_level==1){
                                    echo '0%';
                                }elseif($data->member_level==2){
                                    echo '5%';
                                }elseif($data->member_level==3){
                                    echo '7%';
                                }
                                ?>
                            </span></td>
                        <td><?=$data->created_time?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="arrow-right-bottom">
            <div class="table-acount">
                <h3 class="title-in-box"> <?php echo FSText::_("Các mức của cấp tài khoản"); ?></h3>
                <div class="table-responsive">
                    <table width="100%" cellpadding="4" class="table-list-level table">
                        <thead>
                        <tr class="head-tr">
                            <th width="20%"><?php echo FSText::_("Cấp tài khoản"); ?></th>
                            <th width="34%"><?php echo FSText::_("Điều kiện"); ?></th>
                            <th width="46%"><?php echo FSText::_("Quyền lợi"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="value-acount">Thường</td>
                            <td>Giá trị đơn hàng <span><1 triệu/năm</span></td>
                            <td>Giảm giá <span>0%</span> giá trị đơn hàng</td>
                        </tr>
                        <tr>
                            <td class="value-acount">Vip 1</td>
                            <td>Giá trị đơn hàng từ <span>1 triệu đến <10 triệu/năm</span></td>
                            <td>
                                <p>Giảm giá <span>5%</span> giá trị đơn hàng</p>
                                <p>Không áp dụng đồng thời chương trình khuyến mãi giảm giá khác.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="value-acount">Vip 2</td>
                            <td>Giá trị đơn hàng từ <span>10 triệu/năm</span> trở lên</td>
                            <td>
                                <p>Giảm giá <span>7%</span> giá trị đơn hàng</p>
                                <p>Không áp dụng đồng thời chương trình khuyến mãi giảm giá khác.</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h3 class="title-in-box"> <?php echo FSText::_("Tìm hiểu thêm về cấp tài khoản"); ?></h3>
                <ul>
                    <li>
                        <a><i class="fas fa-circle"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>