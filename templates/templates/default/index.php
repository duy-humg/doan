<?php
global $config, $tmpl, $user;
$Itemid = FSInput::get('Itemid', 1, 'int');
$lang = FSInput::get('lang');
$logo = URL_ROOT . $config['logo'];
$tmpl->addStylesheet('fontawesome-all.min', 'libraries/font-awesome/css');
$tmpl->addScript('chebien', 'modules/home/assets/js');
$tmpl->addStylesheet('form_');
$tmpl->addStylesheet('cart');
$tmpl->addStylesheet('slick');
$tmpl->addStylesheet('slick-theme');
$tmpl->addScript('slick.min');
$tmpl->addScript('form1');
$total_cart = 0;
if (isset($_SESSION['cart'])) {
    $product_list = $_SESSION['cart'];
    foreach ($product_list as $prd) {
        $total_cart += $prd[1];
    }
}
//var_dump($_SESSION);
$arr_name = explode(' ', $_SESSION['user_name']);
//var_dump($arr_name);
$module = FSInput::get('module');
?>
<div class="menu_mobile_list">
    <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'default', 'group' => '1')); ?>
</div>

<div class="menu_mobile_footer">
    <?php echo $tmpl->load_direct_blocks('discount', array('style' => 'mobile', 'group' => '1')); ?>
</div>

<!--<img class="img_m" src="--><?php //echo URL_ROOT.'images/mobile.jpg' ?><!--" alt="">-->
<div class="box-shadow-ql">
    <header class="row-content" id="header">
        <div class="header-logo clearfix " id="head-aff-top">

            <div class=" top_benner <?php if($Itemid != 1){echo 'menu_orther';} ?>">
                <div class="container">
                    <div class="header_top">
                        <div class="tongdai">
                            <p>
                                <img src="<?php echo URL_ROOT.'images/phone.svg' ?>" alt="top">
                                <?php echo FSText::_("Tổng đài hỗ trợ"); ?>:

                                <span class="span_nd"><?php echo $config['tongdai'] ?></span>
                            </p>
                        </div>
                        <div class="ketnoi">
                            <span> <?php echo FSText::_("Kết nối"); ?></span>
                            <a href="<?php echo $config['facebook'] ?>">
                                <img src="<?php echo URL_ROOT.'images/Instagram.svg' ?>" alt="face">
                            </a>
                            <a href="<?php echo $config['instagram'] ?>">
                                <img src="<?php echo URL_ROOT.'images/Instagram.svg' ?>" alt="instagram">
                            </a>
                            <a href="<?php echo $config['twitter'] ?>">
                                <img src="<?php echo URL_ROOT.'images/Twitter.svg' ?>" alt="Twitter">
                            </a>

                            <a href="<?php echo $config['linkedin'] ?>">
                                <img src="<?php echo URL_ROOT.'images/Linkedin.svg' ?>" alt="Linkedin">
                            </a>
                        </div>
                        <div class="sp_love">
                            <p><i class="far fa-heart"></i> <a href=""> <?php echo FSText::_("Sản phẩm yêu thích"); ?></a></p>
                        </div>
                        <div class="tin_nhan">
                            <p>
<!--                                <i class="far fa-comment"></i>-->
                                <img src="<?php echo URL_ROOT.'images/message-square.svg' ?>" alt="">
                                <a href=""> <?php echo FSText::_("Tin nhắn"); ?></a></p>
                        </div>
                        <div class="user_header">
                            <p>
<!--                                <i class="fal fa-user"></i>-->
                                <img src="<?php echo URL_ROOT.'images/user.svg' ?>" alt="">
                                <?php if($_SESSION['user_id']){ ?>
                                    <a href="<?php echo FSRoute::_("index.php?module=users") ?>"><?php echo  $_SESSION['user_name'] ?></a>
                                <?php }else{ ?>
                                    <a href="<?php echo FSRoute::_("index.php?module=users&view=formregister") ?>"> <?php echo FSText::_("Tài khoản"); ?></a>
                                <?php } ?>

                            </p>
                        </div>
                    </div>
                    <div class="row row_mg">
                        <a class="logo-image visible_pc col-md-2 col-sm-12 col-xs-12" href="<?php echo URL_ROOT; ?>"
                           title="<?php echo $config['site_name'] ?>">
                            <img class="img-responsive logo-mobile-hide" src="<?php echo $logo; ?>"
                                 alt="<?php echo $config['site_name'] ?>"/>
                            <img class="img-responsive logo-pc-hide" src="<?php echo $config['logo_mobile']; ?>"
                                 alt="<?php echo $config['site_name'] ?>"/>
                        </a>
                        <div class="col-md-8 col_pd">

                                <div class="visible_pc">
                                    <div class="top-right">
                                        <?php echo $tmpl->load_direct_blocks('search', array('style' => 'default')); ?>
                                        <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'default', 'group' => '1')); ?>
                                    </div>
                                </div>



                        </div>
                        <div class="cart-top-head text-center col-md-2 col-sm-2 col-xs-2 visible_pc">
                            <a class="link-cat"
                               href="<?php echo FSRoute::_('index.php?module=products&view=cart'); ?>">

                                <img src="<?php echo URL_ROOT.'images/shopping-cart.svg' ?>" alt="">
<!--                                <i class="fas fa-shopping-cart"></i>-->
                                <p><?php echo FSText::_("Giỏ hàng"); ?></p>
                                <span><?php echo $total_cart ?></span>
                            </a>
                        </div>
                        <div class="menu_mobile">
                            <a onclick="bl_moblie()" href="javascript:void(0)">
                                <i class="fa fa-bars"></i>
                            </a>
                        </div>
<!--                        <div class=" col-md-2 col-sm-2 col-xs-2  visible-xs col_pd cart_mb">-->
<!--                            <a class="link-cat_mb"-->
<!--                               href="--><?php //echo FSRoute::_('index.php?module=products&view=cart'); ?><!--">-->
<!--                                <i class="fas fa-shopping-cart"></i>-->
<!--                                <span>--><?php //echo $total_cart ?><!--</span>-->
<!--                            </a>-->
<!--                        </div>-->
                    </div><!-- END: .header-logo -->
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: header -->
    <!--    <nav class="nav-item-menu" id="nav">-->
    <!--        --><?php //echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'megamenu', 'group' => '6')); ?>
    <!--    </nav>-->
    <!-- END: nav -->
    <div class="clearfix"></div>

    <?php if ($Itemid != 1) { ?>
<!--        <section id="main-breadcrumbs" class="main-breadcrumbs">-->
<!--            --><?php //echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
<!--        </section>-->
        <div class="clearfix"></div>
    <?php } ?>
    <!--    <div class="container">-->
    <div class="main row-content" id="main">
        <?php include 'main_wrapper.php' ?>
    </div>
    <!-- END: main -->
    <div class="clearfix"></div>
    <!--    </div>-->
    <footer class="row-conten clearfixt " id="footer">
        <div class="container">
            <div class="footer-top row">
                <div class="footer-ds-sp col-md-3 inline_footer inline_footer_1">
                    <h3>Danh mục sản phẩm</h3>
                    <?php echo $tmpl->load_direct_blocks('discount', array('style' => 'discount')); ?>
                </div>
                <div class="chamsoc col-md-3 inline_footer inline_footer_1">
                    <h3>Chăm sóc khách hàng</h3>
                    <?php echo $tmpl->load_direct_blocks('discount', array('style' => 'default')); ?>
                </div>
                <div class="menu_footer_pc col-md-3 inline_footer inline_footer_1">
                    <h3>Về vinashoe.vn</h3>
                    <?php echo $tmpl->load_direct_blocks('discount', array('style' => 'menu')); ?>
                </div>
                <div class="thanhtoan col-md-3 inline_footer inline_footer_2">
                    <h3>Thanh toán</h3>
                    <div class="footer-pay">
                        <div class="item-pay">
                            <img src="<?php echo URL_ROOT.'images/Visa.png' ?>" alt="Visa">
                        </div>
                        <div class="item-pay">
                            <img src="<?php echo URL_ROOT.'images/Group.png' ?>" alt="Group">
                        </div>
                        <div class="item-pay">
                            <img src="<?php echo URL_ROOT.'images/Jcb.png' ?>" alt="Jcb">
                        </div>
                        <div class="item-pay item-pay-last">
                            <img src="<?php echo URL_ROOT.'images/cod.png' ?>" alt="cod">
                        </div>
                    </div>
                    <h3>Vận chuyển</h3>
                    <div class="vc-pay vc-last">
                        <div class="item-vc">
                            <img src="<?php echo URL_ROOT.'images/1.png' ?>" alt="1">
                        </div>
                        <div class="item-vc">
                            <img src="<?php echo URL_ROOT.'images/2.png' ?>" alt="1">
                        </div>
                        <div class="item-vc">
                            <img src="<?php echo URL_ROOT.'images/3.png' ?>" alt="2">
                        </div>
                        <div class="item-vc item-vc-last">
                            <img src="<?php echo URL_ROOT.'images/4.png' ?>" alt="4">
                        </div>
                    </div>
                    <div class="vc-pay vc-pay-cuoi">
                        <div class="item-vc">
                            <img src="<?php echo URL_ROOT.'images/5.png' ?>" alt="1">
                        </div>
                        <div class="item-vc">
                            <img src="<?php echo URL_ROOT.'images/6.png' ?>" alt="1">
                        </div>
                        <div class="item-vc">
                            <img src="<?php echo URL_ROOT.'images/7.png' ?>" alt="2">
                        </div>
                        <div class="item-vc item-vc-last">
                            <img src="<?php echo URL_ROOT.'images/8.png' ?>" alt="4">
                        </div>
                    </div>
                    <h3>Theo dõi chúng tôi trên</h3>
                    <div class="mxh">
                        <a href="<?php echo $config['facebook'] ?>">
                            <img src="<?php echo URL_ROOT.'images/Facebook_f.svg' ?>" alt="face">
                        </a>

                        <a href="<?php echo $config['twitter'] ?>">
                            <img src="<?php echo URL_ROOT.'images/Twitter_f.svg' ?>" alt="face">
                        </a>
                        <a href="<?php echo $config['instagram'] ?>">
                            <img src="<?php echo URL_ROOT.'images/Instagram.png' ?>" alt="face">
                        </a>
                        <a class="a-last" href="<?php echo $config['linkedin'] ?>">
                            <img src="<?php echo URL_ROOT.'images/Linkedin_f.svg' ?>" alt="face">
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
    </footer>
    <div class="footer-bottom">
        <div class="container">
            <p class="text-c">© 2021 Vinashoe. Tất cả các quyền được bảo lưu.</p>
            <div class="thongbao">
                <div class="img1">
                    <img src="<?php echo $config['registration'] ?>" alt="ấn">
                </div>
                <div class="img2">
                    <img src="<?php echo $config['dmca'] ?>" alt="ấn">
                </div>
            </div>
        </div>
    </div>
    <!-- END: footer -->
</div>


<?php include 'notification.php'; // thong bao?>
<!--popup-->
<div class="content-pop">
    <div class="wrapper-popup" id="wrapper-popup"></div>
    <div class="wrapper-popup-2" id="wrapper-popup-2"></div>
    <div class="wrapper-popup-3" id="wrapper-popup-3"></div>
</div>
<div class="full"></div>
<div class="full2"></div>

<!-- Load Facebook SDK for JavaScript -->
<style>
    .fb-livechat, .fb-widget {
        display: none
    }

    .ctrlq.fb-button {
        position: absolute;
        /*right: 24px;*/
        cursor: pointer;
        left: 5px;
    }

    @media (max-width: 767px) {
        .ctrlq.fb-button {
            right: 5px;
            left: unset;
        }
    }

    .ctrlq.fb-close {
        position: fixed;
        /*right: 24px;*/
        cursor: pointer;
        left: 335px;
    }

    .ctrlq.fb-button {
        z-index: 999;
        background: url('../images/fbchat.png') center no-repeat;
        width: 110px;
        height: 110px;
        text-align: center;
        bottom: 275px;
        border: 0;
        outline: 0;
        border-radius: 60px;
        -webkit-border-radius: 60px;
        -moz-border-radius: 60px;
        -ms-border-radius: 60px;
        -o-border-radius: 60px;
        /*box-shadow: 0 1px 6px rgba(0, 0, 0, .06), 0 2px 32px rgba(0, 0, 0, .16);*/
        -webkit-transition: box-shadow .2s ease;
        background-size: 80%;
        transition: all .2s ease-in-out
    }

    .ctrlq.fb-button:focus, .ctrlq.fb-button:hover {
        transform: scale(1.1);
        /*box-shadow: 0 2px 8px rgba(0, 0, 0, .09), 0 4px 40px rgba(0, 0, 0, .24)*/
    }

    .fb-widget {
        background: #fff;
        z-index: 1000;
        position: fixed;
        width: 360px;
        height: 435px;
        overflow: hidden;
        opacity: 0;
        bottom: 0;
        right: 24px;
        /*left: 10px;*/
        border-radius: 6px;
        -o-border-radius: 6px;
        -webkit-border-radius: 6px;
        box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
        -webkit-box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
        -moz-box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
        -o-box-shadow: 0 5px 40px rgba(0, 0, 0, .16)
    }

    .fb-credit {
        text-align: center;
        margin-top: 8px
    }

    .fb-credit a {
        transition: none;
        color: #bec2c9;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 12px;
        text-decoration: none;
        border: 0;
        font-weight: 400
    }

    .ctrlq.fb-overlay {
        z-index: 0;
        position: fixed;
        height: 100vh;
        width: 100vw;
        -webkit-transition: opacity .4s, visibility .4s;
        transition: opacity .4s, visibility .4s;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, .05);
        display: none
    }

    .ctrlq.fb-close {
        z-index: 4;
        padding: 0 6px;
        background: #365899;
        font-weight: 700;
        font-size: 11px;
        color: #fff;
        margin: 8px;
        border-radius: 3px
    }

    .ctrlq.fb-close::after {
        content: "X";
        font-family: sans-serif
    }

    .bubble {
        width: 20px;
        height: 20px;
        background: #c00;
        color: #fff;
        position: absolute;
        z-index: 999999999;
        text-align: center;
        vertical-align: middle;
        top: -2px;
        left: -5px;
        border-radius: 50%;
    }

    .bubble-msg {
        width: 120px;
        left: -140px;
        top: 5px;
        position: relative;
        background: rgba(59, 89, 152, .8);
        color: #fff;
        padding: 5px 8px;
        border-radius: 8px;
        text-align: center;
        font-size: 13px;
    }</style>
<!--<div class="fb-livechat">-->
<!--    <div class="ctrlq fb-overlay"></div>-->
<!--    <div class="fb-widget">-->
<!--        <div class="ctrlq fb-close"></div>-->
<!--        <div class="fb-page" data-href="https://www.facebook.com/genivietnam/" data-tabs="messages" data-width="360"-->
<!--             data-height="400" data-small-header="true" data-hide-cover="true" data-show-facepile="false"></div>-->
<!--        <div class="fb-credit"><a href="https://finalstyle.com" target="_blank">Powered by FS</a></div>-->
<!--        <div id="fb-root"></div>-->
<!--    </div>-->
<!--    <a href="https://m.me/genivietnam" title="Gửi tin nhắn cho chúng tôi qua Facebook" class="ctrlq fb-button">-->
<!--        <!--        <div class="bubble">1</div>-->
<!--        <!--        <div class="bubble-msg">Bạn cần hỗ trợ?</div>-->
<!--    </a></div>-->
<!---->
<!--<script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<!--<script>$(document).ready(function () {-->
<!--        function detectmob() {-->
<!--            if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {-->
<!--                return true;-->
<!--            } else {-->
<!--                return false;-->
<!--            }-->
<!--        }-->
<!---->
<!--        var t = {delay: 125, overlay: $(".fb-overlay"), widget: $(".fb-widget"), button: $(".fb-button")};-->
<!--        setTimeout(function () {-->
<!--            $("div.fb-livechat").fadeIn()-->
<!--        }, 8 * t.delay);-->
<!--        if (!detectmob()) {-->
<!--            $(".ctrlq").on("click", function (e) {-->
<!--                e.preventDefault(), t.overlay.is(":visible") ? (t.overlay.fadeOut(t.delay), t.widget.stop().animate({-->
<!--                    bottom: 0,-->
<!--                    opacity: 0-->
<!--                }, 2 * t.delay, function () {-->
<!--                    $(this).hide("slow"), t.button.show()-->
<!--                })) : t.button.fadeOut("medium", function () {-->
<!--                    t.widget.stop().show().animate({bottom: "30px", opacity: 1}, 2 * t.delay), t.overlay.fadeIn(t.delay)-->
<!--                })-->
<!--            })-->
<!--        }-->
<!--    });</script>-->
<!-- Google Tag Manager (noscript) -->
<!--<noscript>-->
<!--    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WS77MJT"-->
<!--            height="0" width="0" style="display:none;visibility:hidden">-->
<!--    </iframe>-->
<!--</noscript>-->
<!-- End Google Tag Manager (noscript) -->
