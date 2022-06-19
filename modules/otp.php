<?php
global $tmpl;
$tmpl->addStyleSheet('login', 'modules/members/assets/css');
$tmpl->addScript('members1', 'modules/members/assets/js');
$tmpl->addTitle(FSText::_('Register Account'));

$alert_info = array(
    0 => FSText::_('Please enter the otp code'),
);
?>
<style>
    .label_error{
        width: 100%;
    }
    #otp{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }
    #otp input{
        width: 40px;
        padding: 5px;
        margin-right: 20px;
        text-align: center;
    }
    #otp input:last-child{
        margin-right: 0;
    }
</style>

<script>
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                if (event.which === 8) {
                    inputs[i].value = '';
                    if (i !== 0)
                        inputs[i - 1].focus();
                }
            })
        }
    }
    $(document).ready(function () {
        OTPInput();
        $(".otp_input").keyup(function () {
            if (this.value.length === this.maxLength) {
                $(this).next('.otp_input').focus();
            }
        });

    })
</script>

<script src="https://www.google.com/recaptcha/api.js"></script>

<input type="hidden" id="alert_info" value='<?php echo json_encode($alert_info) ?>' />
<div id="main">
    <div class="container">
        <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
        <div class="box-member">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-12 col">
                    <div class="form-box">
                        <div class="bf-heading">
                            <h1 class="h1_title"><?php echo FSText::_('Register Account') ?></h1>
                            <p><strong><?php echo FSText::_('Please enter verification code') ?><span style="color: #ef7598">*</span></strong></p>
                            <p><?php echo FSText::_('Your verification code will be sent by text message and email') ?></p>
                            <p><strong><?php echo $data->telephone ?></strong> - <strong><?php echo $data->email ?></strong></p>
                        </div>
                        <form id="frmOtp" name="frmOtp" action="" method="post">
                            <div class="input-box">
<!--                                <label class="title" for="reg_name">--><?php //echo FSText::_('Otp code') ?><!-- <span>*</span></label>-->
                                <div id="otp">
                                    <input maxlength="1" id="otp_code1" type="text" class="form-control otp_input" name="otp_code1" placeholder="<?php echo FSText::_('') ?>">
                                    <input maxlength="1" id="otp_code2" type="text" class="form-control otp_input" name="otp_code2" placeholder="<?php echo FSText::_('') ?>">
                                    <input maxlength="1" id="otp_code3" type="text" class="form-control otp_input" name="otp_code3" placeholder="<?php echo FSText::_('') ?>">
                                    <input maxlength="1" id="otp_code4" type="text" class="form-control otp_input" name="otp_code4" placeholder="<?php echo FSText::_('') ?>">
<!--                                    <input maxlength="1" id="otp_code5" type="text" class="form-control" name="otp_code5" placeholder="--><?php //echo FSText::_('') ?><!--">-->
<!--                                    <input maxlength="1" id="otp_code6" type="text" class="form-control" name="otp_code6" placeholder="--><?php //echo FSText::_('') ?><!--">-->
                                </div>
                            </div>
                            <div class="input-box">
                                <p><?php echo FSText::_('Didn\'t receive the code?') ?> <a id="resend_code" class="resend_code" href="javascript:void(0)" style="color:#ef7598;"><?php echo FSText::_('Resend code') ?></a></p>
                            </div>
                            <a class="btn-member btn-login" onclick="validateOtp();" href="javascript:void(0);">
                                <?php echo FSText::_('Submit') ?>
                            </a>
                            <input type="hidden" name="active1" id="active1" value="<?php echo FSInput::get('mail_active') ?>">
                            <input type="hidden" name="active2" id="active2" value="<?php echo FSInput::get('tel_active') ?>">

                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-12 col">
                    <div class="bf-heading">
                        <h1 class="h1_title"><?php echo FSText::_('Do you already have an account') ?></h1>
                        <p><strong><?php echo FSText::_('Login Account') ?></strong></p>
                        <p><?php echo FSText::_('By creating an account you will be able to shop faster, be up to date on an order\'s status, and keep track of the orders you have previously made.') ?></p>
                        <a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=login') ?>"><?php echo FSText::_('Continue') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal msgmodal fade" id="reg_modal" tabindex="-1" role="dialog" aria-labelledby="reg_modalLabel">
    <div class="modal-dialog" role="document">
        <div class="msgmodal-content">
            <div class="msgmodal-body">
                <div class="reg_message" id="reg_message">

                </div>
            </div>
        </div>
    </div>
</div>