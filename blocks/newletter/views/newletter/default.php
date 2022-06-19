<?php
global $config, $tmpl;
$tmpl->addStylesheet('newletter', 'blocks/newletter/assets/css');
?>
<!--<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
<!--    <div class='created_email clearfix'>-->
<!--        <h5 class="contact-us-ft">--><?php //echo FSText::_("Hình thức thanh toán"); ?><!--</h5>-->
        <!--            <form id="discount_form" method="post" name="newletter_form" action="-->
        <?php //echo FSRoute::_('index.php?module=discount&task=save'); ?><!--" onsubmit="javascript: return check_discount_form();" >-->
        <!--                <input type="text" name="email" id="dc_email" value="" class="txt-input" placeholder="-->
        <?php //echo FSText::_('Email của bạn...') ?><!--" />-->
        <!--                <button type="submit">Đăng ký</button>-->
        <!--                <input type="hidden" name='return' value="-->
        <?php //echo base64_encode($_SERVER['REQUEST_URI']);?><!--"  />-->
        <!--            </form>-->
<!--        <div class="clearfix"></div>-->
<!--        <div class="list-service-ft">-->
<!--            <img src="--><?php //echo URL_ROOT . 'images/visa.png' ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'images/master-card.png' ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'images/jcb.png' ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'images/cod.png' ?><!--">-->
<!--        </div>-->
<!--        <a href="--><?php //echo URL_ROOT . $config['link_registration'] ?><!--"-->
<!--           target="_blank" class="img-dk-ft">-->
<!--            <img-->
<!--                    src="--><?php //echo URL_ROOT . $config['registration'] ?><!--"-->
<!--                    class="img-responsive"></a>-->
<!--    </div>-->
<!--</div>-->