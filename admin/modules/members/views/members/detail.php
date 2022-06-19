<!--﻿<link type="text/css" rel="stylesheet" media="all" href="../modules/members/assets/css/chosen.css" />
<script type="text/javascript" src="../modules/members/assets/js/select_multiple.js"></script>
<script type="text/javascript" src="../modules/members/assets/js/chosen.jquery.js"></script>-->
<!--﻿<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>-->
<!--<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />-->
<!-- HEAD -->
<?php
$task = FSInput::get('task');
$module_ = FSInput::get('module');
$view = FSInput::get('víew');
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
//    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png', 1);
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png', 1);
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            </div>';


$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Thành viên'));

if (@$data->avatar) {
    $avatar = strpos(@$data->avatar, 'http') === false ? URL_ROOT . str_replace('/original/', '/original/', @$data->avatar) : @$data->avatar;
} else {
    $avatar = URL_ROOT . 'images/1473944223_unknown2.png';
}
?>

<input type="hidden" id="type_user" value="<?php echo @$data->type ?>">
<input type="hidden" id="id_user" value="<?php echo @$data->id ?>">
<?php if (!isset($data)) { ?>
<?php } ?>
<?php if ($task == 'add') { ?>
<?php } ?>

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Tên đăng nhập") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" type="text" name="username" id="username" value="<?php echo @$data->username ?>" maxlength="255" <?php if ($task == 'edit') echo 'readonly="true"' ?>/>
        <p id="username_error" style="color:#ff0000"></p>
    </div>
</div>
<?php
//TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập'), 'username', @$data->username);
?>
<!--<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Mật khẩu") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" type="password" name="password" id="password" value="<?php echo @$data->password ?>" />
    </div>
</div>-->


<?php
TemplateHelper::dt_edit_text(FSText :: _('Email'), 'email', @$data->email);
?>
<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"></label>
    <div class="col-sm-9 col-xs-12">
        <p id="email_error" style="color:#ff0000"></p>
    </div>
</div>


<div class="form-group cmt  <?php if (@$data->type != 3) echo 'block_field' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("CMT") ?></label>
    <div class="col-sm-9 col-xs-12">
        <input class="form-control" name="cmt" id="cmt" value="<?php echo @$data->cmt ?>" maxlength="12">
        <p id="cmt_error" style="color:#ff0000"></p>
    </div>
</div>
<?php if (@$data->type == 3 && $task == 'edit') { ?>
    <div class="form-group sex">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Giới tính") ?></label>
        <div class="col-sm-2 col-xs-2">
            <select name="sex" id="sex" class="form-control">
                <option value="">-- <?php echo FSText::_('Giới tính') ?> --</option>
                <option value="1"  <?php if (@$data->sex == 1) echo 'selected'; ?> >Nam</option>
                <option value="2"  <?php if (@$data->sex == 2) echo 'selected'; ?> >Nữ</option>
            </select>
        </div>
    </div>
    <div class="form-group telephone">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Số điện thoại") ?></label>
        <div class="col-sm-2 col-xs-2">
            <input class="form-control" name="telephone" id="telephone" value="<?php echo @$data->telephone ?>" maxlength="12">
        </div>
    </div>
<?php } ?>


<?php
?>
<div class="status_" style="<?php if ($task == 'edit' && @$data->type == 1) echo 'display:none;' ?>">
    <?php TemplateHelper::dt_checkbox(FSText::_('Hiện đang làm việc'), 'published', @$data->published, 1); ?>
</div>



<?php
TemplateHelper::dt_checkbox(FSText::_('Password'), 'edit_pass', isset($data) ? 0 : 1, 0);
?>
<input type="hidden" name="" id="task_" value="<?php echo $task ?>">
<div class="form-group password_area " style="display: <?php echo @$data->id ? "none" : "block" ?>;">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Mật khẩu") ?></label>
    <div class="col-sm-6 col-xs-12">
        <input class="form-control" type="password" name="password" id="password1" />
    </div>
</div>
<div class="form-group password_area" style="display: <?php echo @$data->id ? "none" : "block" ?>;">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Xác nhận mật khẩu") ?></label>
    <div class="col-sm-6 col-xs-12">
        <input class="form-control" type="password" name="re-password" id="re-password" />
    </div>
</div>
<?php
$this->dt_form_end(@$data, 1, 0);
?>
<script  type="text/javascript" language="javascript">

    $(function () {

        var $task_ = $('#task_').val();

        check_exist_user();

        check_exist_email();
        check_exist_dcs();
        check_exist_cmt();
        $("select#type_member").change(function () {
            var $vl_type = $(this).val();
            if ($vl_type == 1) {
                $('.headid').hide();
                $('.position').hide();
                $('.city').hide();
                $('.dsc_code').hide();
                $('.cmt').hide();

                $('.workstart').hide();
                $('.status_').hide();
                $('.department').show();
            } else if ($vl_type == 2) {
                $('.headid').hide();
                $('.position').hide();
                $('.dsc_code').hide();
                $('.cmt').hide();
                $('.department').hide();
                $('.workstart').hide();
                $('.city').show();
                $('.status_').show();


            } else if ($vl_type == 3) {
                $('.headid').show();
                $('.position').show();
                $('.dsc_code').show();
                $('.cmt').show();
                $('.department').hide();
                $('.workstart').show();
                $('.city').hide();

                $("select#headid").change(function () {
                    var $user_head = $("#headid option:selected").text();
                    var $id_head = $("#headid option:selected").val();
                    var $total_user = $("#headid option:selected").attr('data-total');
                    $("#username").val($user_head + '_0' + ($total_user + 1));
                    $("#id_head").val($id_head);
                    $("#username").prop('readonly', true);
                });

            }
        });
    })

    $('#edit_pass_0').click(function () {
        $('.password_area').hide();
    });
    $('#edit_pass_1').click(function () {
        $('.password_area').show();
    });

    /* CHECK EXIST  EMAIL */
    function check_exist_email() {
        $user_id = $('#id_user').val();

        $('#email').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_email&raw=1",
                    data: {email: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#email_error').text('Email này đã tồn tại. Bạn hãy sử dụng email khác!');
                            $('#email').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#email_error').text('');
                            $('#email_succes').text('Email này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    /* CHECK EXIST  EMAIL */
    function check_exist_user() {
        $user_id = $('#id_user').val();
        $('#username').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_username&raw=1",
                    data: {username: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#username_error').text('Tên đăng nhập này đã tồn tại. Vui lòng sử dụng tên đăng nhập khác');
                            $('#username').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#username_error').text('');
                            $('#email_succes').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    /* CHECK EXIST  DCS */
    function check_exist_dcs() {
        $user_id = $('#id_user').val();
        $('#code').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_dcs&raw=1",
                    data: {code_dcs: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#code_error').text('DCS code bị trùng. Bạn vui lòng nhập DCS code khác!');
                            $('#code').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#code_error').text('');
//                            $('#code_error').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    /* CHECK EXIST  CMT */
    function check_exist_cmt() {
        $user_id = $('#id_user').val();
        $('#cmt').blur(function () {
            if ($(this).val() != '') {
                $.ajax({url: "/index.php?module=users&task=ajax_check_exist_cmt&raw=1",
                    data: {cmt: $(this).val(), id: $user_id},
                    dataType: "text",
                    success: function (result) {
                        $('label.username_check').prev().remove();
                        $('label.username_check').remove();
                        if (result == 0) {
                            $('#email_succes').text('');
                            $('#cmt_error').text('Số CMT bị trùng. Bạn vui lòng nhập lại!');
                            $('#cmt').focus();
                            //    invalid('email', 'Email này đã tồn tại. Bạn hãy sử dụng email khác');

                        } else {
                            $('#cmt_error').text('');
//                            $('#code_error').text('Tên đăng nhập này được chấp nhận!!');
//                        valid('email');
//                        $('<br/><div id=\'email_error\' class=\'label_success username_check\'>' + 'Tên truy nhập này được chấp nhận' + '</div>').insertAfter($('#email').parent().children(':last'));
                        }
                    }
                });
            }
        });
    }
    $('#username').keyup(function (e) {
        var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
        var str = $(this).val();
        if (!characterReg.test(str)) {
            str = removeDiacritics(str);
            $(this).val(str);
        }
        if (e.which === 32) {
            //alert('No space are allowed in usernames'); 
            str = str.replace(/\s/g, '');
            $(this).val(str);
        }
        var characterReg2 = /^([a-zA-Z0-9]{6,100})$/;
        if (!characterReg2.test(str)) {

            str = removeDiacritics(str);
            str = str.replace(/\s/g, '');
            $(this).val(str);
        }

    }).blur(function () {
        var str = $(this).val();
        str = removeDiacritics(str);
        str = str.replace(/\s/g, '');
        $(this).val(str);
    });
    function removeDiacritics(input)
    {
        var output = "";
        var normalized = input.normalize("NFD");
        var i = 0;
        var j = 0;
        while (i < input.length)
        {
            output += normalized[j];
            j += (input[i] == normalized[j]) ? 1 : 2;
            i++;
        }
        return output;
    }
</script>
<style>
    .block_field{
        display: none;
    }
</style>

<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });
    function formValidator()
    {
//        $('.alert-danger').show();
        var $task_ = $('#task_').val();
        //nhập user
        if (($('#username').val()).length == '') {
            alert('Bạn chưa nhập tên đăng nhập');
            $('#username').focus();
            return false;
        }
        //không quá 255 kí tự
        if (($('#username').val()).length > 255) {
            alert('Tên Đăng Nhập không được quá 255 ký tự');
            return false;
        }
        //không chứa ký tự đặc biệt
        if (isChart_db("username", 'Tên Đăng Nhập không chứa kí tự đặc biệt!')) {
            return false;
        }

        if ($('#type_member').val() == 3 || $('#type_user').val() == 3) {
            //check kí tư đặc biệt code
            re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
            if (re.test($("#code").val())) {
                alert('DSC Code không chứa ký tự đặc biệt.');
                $('#code').focus();
                return false;
            }
            // if ($('#cmt').val() == 0) {
            //     alert('Vui lòng nhập sô CMT');
            //     $('#cmt').focus();
            //     return false;
            // }
            // re = /^[0-9 .]+$/;
            // if (!re.test($("#cmt").val())) {
            //     alert('Số CMT không đúng định dạng.');
            //     $('#cmt').focus();
            //     return false;
            // }
            // //Lớn hơn 9 kí tự
            // if (($('#cmt').val()).length < 9) {
            //     alert('Số CMT lớn hơn 9 ký tự.');
            //     $('#cmt').focus();
            //     return false;
            // }
            // //không quá 12 kí tự
            // if (($('#cmt').val()).length > 255) {
            //     alert('Sô CMT không được quá 12 ký tự');
            //     $('#cmt').focus();
            //     return false;
            // }

            //nhập email
            if (($('#email').val()).length == '') {
                alert('Vui lòng nhập Email!');
                $('#email').focus();
                alert('Vui lòng nhập Email!');
                return false;
            }

            //check email
            if (!isEmail('email', 'Email không đúng định dạng!'))
                return false;

            //nhập họ tên
            // if (($('#name').val()).length == '') {
            //     alert('Vui lòng nhập Họ và Tên');
            //     $('#name').focus();
            //     return false;
            // }

            // if ($('#position').val() == '') {
            //     alert('Bạn chưa chọn chức vụ');
            //     $('#position').focus();
            //     return false;
            // }
            // if ($('#word_start').val() == '') {
            //     alert('Bạn chưa nhập thời gian làm việc');
            //     $('#word_start').focus();
            //     return false;
            // }
        }

        //nhập email
        if (($('#email').val()).length == '') {
            alert('Vui lòng nhập Email');
            $('#email').focus();
            alert('Vui lòng nhập Email!');
            return false;
        }

        //check email
        if (!isEmail('email', 'Email không đúng định dạng!'))
            return false;



//            if ($('#type_member').val() != 2) {
//                //nhập thời gian làm việc
//                if ($('#workstart').val().length == '') {
//                    alert('Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc');
//                    $('#word_start').focus();
//                    return false;
//                }
//                         if ($('#workstart').val().length == '') {
//                $('#word_start').focus();
//                alert('Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc');
//                return false;
//            }
////                if (!notEmpty('word_start', 'Bạn vui lòng nhập Thời Gian Bắt Đầu Làm Việc!'))
////                    return false;
//
//                var txtVal = $('#workstart').val();
//                if (isDate(txtVal) == 'false') {
//                    alert('Bạn nhập sai đinh dạng thời gian dd/mm/yyyy');
//                    $('#msg_error').parent().show();
//                    $('#workstart').focus();
//                    alert('Bạn nhập sai đinh dạng thời gian dd/mm/yyyy')
//                    return false;
//                }
//            }

        if ($("input[name='edit_pass']:checked").val() == 1) {
            if ($('#password1').val() == '') {
                $('#password1').focus();
                alert('Bạn vui lòng nhập mật khẩu');
                return false;
            }

            if ($('#password1').length > 0) {
                if ($("#password1").val().length < 8) {
                    $('#password1').focus();
                    alert('Mật khẩu mới phải > 8 ký tự')
                    return false;
                }

                re = /[0-9]/;
                if (!re.test($("#password1").val())) {
                    $('#password').focus();
                    alert('Mật khẩu phải chứa ít nhất một chữ số (0-9)!');
                    return false;
                }

                re = /[A-Z]/;
                if (!re.test($("#password1").val())) {
                    $('#password').focus();
                    alert('Mật khẩu phải chứa ít nhất một chữ cái In Hoa (A-Z)');
                    return false;
                }
                // re = /[~`!#$%\^&*+=[\]\\';,/{}|\\":<>\?]/;
                // if (!re.test($("#password1").val())) {
                //     $('#password').focus();
                //     alert('Mật khẩu phải có ít nhất một ký tự đặc biệt(*&...)');
                //     return false;
                // }
            }

            if ($('#re-password').val() == '') {
                $('#re-password').focus();
                alert('Bạn vui lòng nhập xác nhận mật khẩu');
                return false;
            }
            if ($('#password1').val() != $('#re-password').val()) {
                $('#re-password').focus();
                alert('Mật khẩu không trùng nhau, vui lòng nhập lại!');
                return false;
            }
        }
        return true;
    }


    /*************** CHECK FORM ***************/
//If the length of the element's string is 0 then display helper message
    function notEmpty(elemid, helperMsg) {
        elem = document.getElementById(elemid);
        if (elem.value.length == 0) {
            document.getElementById('msg_error').innerHTML = helperMsg;
            $('#msg_error').parent().show();
//		alert(helperMsg);
            elem.focus(); // set the focus to this input
            return false;
        }
        return true;
    }

    function isDate(txtDate)
    {

        var currVal = txtDate;
        if (currVal == '')
            return false;
        //DeclareRegex  
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
        var dtArray = currVal.match(rxDatePattern); // is format OK?
        if (dtArray == null)
            return false;
        //Checks for mm/dd/yyyy format.

        dtMonth = dtArray[1];
        dtDay = dtArray[3];
        dtYear = dtArray[5];
        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay > 31)
            return false;
        else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
            return false;
        else if (dtMonth == 2)
        {
            var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
            if (dtDay > 29 || (dtDay == 29 && !isleap))
                return false;
        }
        return true;
    }

</script>