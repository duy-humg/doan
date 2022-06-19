<?php
//print_r($_REQUEST);
global $tmpl;
$tmpl->setTitle("Thành viên");
$tmpl->addStylesheet("user", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('users', 'modules/users/assets/js');
$Itemid = FSInput::get('Itemid', 1);

//var_dump($_SESSION);
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
            <div class="cat_title clearfix mt10">
                <div class="inner">
                    <h1><?php echo FSText::_("Thông tin tài khoản"); ?></h1>
                    <p class="p-inner">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                </div>

            </div>
            <div class="arrow-right">
                <form id="form-user-edit"
                      action="<?php echo FSRoute::_("index.php?module=users&view=users&task=edit_save"); ?>"
                      method="post" name="form-user-edit" enctype="multipart/form-data">
                    <div class="row row_form">
                        <div class="form-left col-lg-7 col-md-7 col-sm-7 col-xs-7">
                            <div class="row">
                                <div class="form-control-left form-control-user col-md-6">
                                    <div class="text-form">
                                        <label><?php echo FSText::_("Họ"); ?></label>
                                    </div>
                                    <div class="input-form">
                                        <input class="txt-input input-full-name"
                                               placeholder="<?php echo FSText::_("Họ"); ?>" type="text"
                                               name="ho" id="ho" value="<?php echo $data->surname ?>"
                                               required/>
                                    </div>
                                </div>
                                <div class="form-control-right form-control-user col-md-6">
                                    <div class="text-form">
                                        <label><?php echo FSText::_("Tên"); ?></label>
                                    </div>
                                    <div class="input-form">
                                        <input class="txt-input input-full-name"
                                               placeholder="<?php echo FSText::_("Tên"); ?>" type="text"
                                               name="name" id="name" value="<?php echo $data->name ?>"
                                               required/>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="form-control-user col-md-12">
                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                        <label><?php echo FSText::_("Email"); ?></label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <p class="p-form"><?php echo $data->email; ?> <a href="<?php echo FSRoute::_("index.php?module=users&view=users&task=email_1") ?>"><?php echo FSText::_("Thay đổi"); ?></a></p>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-control-user col-md-12">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <label><?php echo FSText::_("Số điện thoại"); ?></label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <p class="p-form"><?php echo $data->telephone; ?></p>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="form-control-user col-md-12">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <label><?php echo FSText::_("Giới tính"); ?></label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                                                <input type="radio" name="sex" id="sex_boy"
                                                       value="1" <?php echo ($data->sex == '1') ? 'checked' : ''; ?>
                                                       required> <label  class="sex_1"
                                                                         for="sex_boy"><?php echo FSText::_("Nam"); ?></label>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                                                <input type="radio" name="sex" id="sex_girl"
                                                       value="2" <?php echo ($data->sex == '2') ? 'checked' : ''; ?>
                                                       required> <label class="sex_1"
                                                                        for="sex_girl"><?php echo FSText::_("Nữ"); ?></label>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                                                <input type="radio" name="sex" id="sex_khac"
                                                       value="3" <?php echo ($data->sex == '3') ? 'checked' : ''; ?>
                                                       required> <label class="sex_1"
                                                                        for="sex_khac"><?php echo FSText::_("Khác"); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label><?php echo FSText::_("Ngày sinh"); ?></label>

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="form-control-day col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <select name="birth_day">
                                                <option>Ngày</option>
                                                <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                    <option value="<?php echo $i ?>" <?php echo (date("d", strtotime($data->birthday)) == $i) ? 'selected' : ''; ?>><?php echo $i ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-control-month col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <select name="birth_month">
                                                <option>Tháng</option>
                                                <?php for ($j = 1; $j <= 12; $j++) { ?>
                                                    <option value="<?php echo $j ?>" <?php echo (date("m", strtotime($data->birthday)) == $j) ? 'selected' : ''; ?>><?php echo $j ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-control-year  col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <select name="birth_year">
                                                <option>Năm</option>
                                                <?php for ($k = (date("Y") - 1); $k > (date("Y") - 70); $k--) { ?>
                                                    <option value="<?php echo $k ?>" <?php echo (date("Y", strtotime($data->birthday)) == $k) ? 'selected' : ''; ?>><?php echo $k ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="bot-but">
                                    <input class="button-submit-edit button" name="submit" type="submit"
                                           value="<?php echo FSText::_("Lưu lại"); ?>"/>
                                    <input type="hidden" name="module" value="users">
                                    <input type="hidden" name="view" value="users">
                                    <input type="hidden" name="task" value="edit_save">
                                    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <div class="form-right col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <div class="fix-avatar">
                                <?php
                                if ( @$_SESSION['avatar'])
                                    $avatar = URL_ROOT . str_replace('original', 'large', @$data->avatar); ?>
                                <div class="items-item image-area-single <?php if(!$_SESSION['avatar']){ ?>no-avt <?php } ?> image_preview" id="image_preview"
                                     style="">
                                     
                                     <?php if($data->avatar){ ?>
                                        <img id="previewing" class="img-responsive <?php if($_SESSION['avatar']){ ?>img-avt <?php } ?>  lgup rounded-circle"
                                         src="<?php echo @$avatar ? $avatar : URL_ROOT . 'images/user_a.svg' ?>"
                                         alt=""  style=""/>
                                    <?php }else{ ?>
                                        
                                        <img id="previewing" class="img-responsive <?php if($_SESSION['avatar']){ ?>img-avt <?php } ?>  lgup rounded-circle"
                                         src="<?php echo  URL_ROOT . 'images/user_a.svg' ?>"
                                         alt=""  style=""/>
                                    <?php } ?>
                                    
                                </div>
                                <div class="items-item image"
                                     style="overflow: hidden;text-align: center;">
                                    <a href="javascript:void(0)" class="lgup"><?php echo FSText::_("Chọn ảnh"); ?></a>
                                    <p class="supporting"><?php echo FSText::_("Dụng lượng file tối đa 1 MB Định dạng:.JPEG, .PNG"); ?></p>

                                    <script>
                                        var loadFile2 = function (event) {
                                            var reader = new FileReader();
                                            reader.onload = function () {
                                                var output = document.getElementById('previewing');
                                                output.src = reader.result;
                                                $('#ava_u').val('1');
                                            };
                                            reader.readAsDataURL(event.target.files[0]);
                                        };
                                    </script>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="check_logo" id="check_logo"
                               value="<?php echo !empty($_COOKIE['el_avatar']) || !empty($_SESSION['el_avatar']) ? 1 : 0 ?>"/>
                        <input class="hide" type="file" name="avatar" id="file"  onchange="loadFile2(event)"
                               style="color: green;"/>
                        <input type="hidden" name="ava_u" id="ava_u"
                               value="<?php if (@$avatar) echo '1' ?>">
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>