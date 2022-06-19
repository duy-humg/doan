<?php
/**
 * Created by hoi.
 * Date: 11/16/2019
 * Time: 11:41
 */


?>
<?php global $tmpl, $config;
$tmpl->addScript('form1');
$tmpl->addStylesheet('default_book', 'blocks/discount/assets/css');
$tmpl->addScript('default_book', 'blocks/discount/assets/js');
$tmpl->addStylesheet('owl.carousel.min', 'libraries/owlcarousel/assets');
$tmpl->addStylesheet('owl.theme.default', 'libraries/owlcarousel/assets');
$tmpl->addScript('owl.carousel.min', 'libraries/owlcarousel');

$alert_info = array(
    0 => 'Bạn chưa nhập họ và tên',
    1 => '"Họ tên của bạn" phải 6 kí tự trở lên, vui lòng sửa lại!',
    2 => 'Bạn chưa nhập số điện thoại.',
    3 => 'Số điện thoại không đúng.',
    4 => 'Bạn chưa chọn Tỉnh - thành phố.',
    5 => 'Bạn chưa chọn Quận - huyện.',
    6 => 'Bạn chưa chọn sách mua',
    7 => 'Emal không đúng.',

);
//$id = FSInput::get('id');
//var_dump($id);die;
?>
<input type="hidden" id="alert_info" value='<?php echo json_encode($alert_info) ?>'/>
<div class="form_order" id="form_order">
    <div class="container">
        <p class="text_order"><?php echo FSText::_('Đặt hẹn'); ?></p>
        <form method="post" action="#" name="contact" class="form" enctype="multipart/form-data">
            <div class="row">
                <div class="bao_input col-md-4">
                    <input type="text" maxlength="255" name="contact_name" id="contact_name" placeholder="<?php echo FSText::_('Nhập họ tên của bạn'); ?>*" value="" class="form-control "/>
                </div>
                <div class="bao_input col-md-4">
                    <select name="gender" id="gender">
                        <option value="">--<?php echo FSText::_("Chọn Giới tính"); ?>--</option>
                        <option value="male"><?php echo FSText::_("Nam"); ?></option>
                        <option value="female"><?php echo FSText::_("Nữ"); ?></option>
                    </select>
                </div>
                <div class="bao_input div_birth_year col-md-4">
                    <select name="birth_year" id="birth_year">
                        <option value=""><?php echo FSText::_("Năm sinh"); ?></option>
                        <?php $current_year = date("Y");?>
                        <?php for($i = $current_year ; $i > 1900 ; $i -- ) {?>
                            <?php $check = ($i == $data->birth_year) ? "selected='selected'": ""; ?>
                            <option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="clearfix">

                </div>
                <div class="bao_input col-md-4">
                    <input type="tel" maxlength="255" name="job" id="job" placeholder="<?php echo FSText::_('Nghề nghiệp'); ?>" value="" class="form-control "/>
                </div>
                <div class="bao_input col-md-4">
                    <input type="text" maxlength="255" name="phone" id="phone" placeholder="<?php echo FSText::_('Số điện thoại'); ?>" value="" class="form-control "/>
                </div>
                <div class="bao_input div_email col-md-4">
                    <input type="text" maxlength="255" name="email" id="email" placeholder="<?php echo FSText::_('Email'); ?>" value="" class="form-control "/>
                </div>
                <div class="clearfix">

                </div>
                <div class="bao_input col-md-4">
                    <select name="city_id" id="city_id" class="tinh">
                        <option value=""><?php echo FSText::_('Tỉnh/Thành phố') ?></option>
                        <?php foreach($lis_city as $item){?>
                            <?php $checked =  (@$data->city_id == $item->id)? " selected = 'selected'": ""; ?>
                            <option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name ; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="bao_input col-md-4">
                    <select name="district_id" id="home_district"
                            class="quan">
                        <option value=""><?php echo FSText::_("Quận/Huyện"); ?></option>
                        <?php
                        if (
                            $data->district_id!=0) {
                            ?>
                            <?php foreach($lis_district as $item_district){?>
                                <?php $checked =  (@$data->district_id == $item_district->id)? " selected = 'selected'": ""; ?>
                                <option value="<?php echo $item_district->id; ?>" <?php echo $checked; ?> ><?php echo $item_district->name ; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-4 bao_input div_txtCaptcha">
                    <div class="row-item">
                        <div class="col-md-6 col-sm-6 text_txtCaptcha">
                            <input class="form-control txtCaptcha fl-left" placeholder="<?php echo FSText::_('Nhập mã bảo mật'); ?>" type="text"
                                   id="txtCaptcha" value="" name="txtCaptcha" size="5">
                        </div>
                        <a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code-view fl-left col-md-6 col-sm-6">
                            <img id="imgCaptcha" class="fl-left"
                                 src="<?php echo URL_ROOT ?>libraries/jquery/ajax_captcha/create_image.php"/>
                            <i class="fa fa-sync-alt"></i>
                        </a>
                        <div class="clearfix"></div>

                    </div>
                </div>
                <div class="div_submitbt">
                    <a class="button submitbt" href="javascript: void(0)"
                       id="submitbt"><?php echo FSText::_('ĐẶT HẸN'); ?></a>
                </div>
            </div>

            <!--        <input type="hidden" name='return' value='--><?php //echo $return; ?><!--'/>-->
            <input type="hidden" name="module" value="home"/>
            <input type="hidden" name="view" value="home"/>
            <input type="hidden" name="task" value="save"/>
            <input type="hidden" name="id_memmber" value="<?php echo $data_member->id; ?>"/>
            <input type="hidden" name="name_memmber" value="<?php echo $data_member->lname; ?>"/>
            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>"/>
        </form>
    </div>
</div>


        