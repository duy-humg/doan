<?php
global $tmpl;
$url = $_SERVER['REQUEST_URI'];
$tmpl->addStylesheet("menu", "modules/users/assets/css");
$view = FSInput::get('view');
//var_dump($url);
?>
<div class="list-menu-user">
    <div class="user-name-show clearfix">
        <div class="avt">
            <?php if($data->avatar){ ?>
                <img src="<?php echo URL_ROOT . str_replace('original', 'large', @$data->avatar); ?>" alt="avt">
            <?php }else{ ?>
                <img src="<?php echo URL_ROOT.'images/avt.svg' ?>" alt="avt">
            <?php } ?>
        </div>
        <div class="info">
            <?php if($_SESSION['name']){ ?> 
                <p><?php echo $_SESSION['name'] ?></p>
            <?php }else{ ?>
                <p><?php echo $_SESSION['telephone'] ?></p>
            <?php } ?>
            <a href="<?php echo FSRoute::_('index.php?module=users'); ?>"><img src="<?php echo URL_ROOT.'images/edit-3.svg' ?>" alt="edit"> Sửa hồ sơ</a>
        </div>
    </div>
    <ul>
        <li>
            <a href="javascript:void(0)"  class="btn btn-info" data-toggle="collapse" data-target="#demo_tk">
                <img src="<?php echo URL_ROOT.'images/user_2.svg' ?>" alt="user">
                <?php echo FSText::_("Tài khoản của tôi");?>
            </a>
            <ul id="demo_tk" class="collapse ul-c2 <?php if($url=='/thong-tin-ca-nhan.html' or $url=='/doi-hop-thu-b1.html' or $url=='/doi-hop-thu-b2.html' or $url=='/doi-mat-khau.html'){ ?> in <?php } ?>">
                <li class="li-c2">
                    <a class="<?php if($url=='/thong-tin-ca-nhan.html' or $url=='/doi-hop-thu-b1.html' or $url=='/doi-hop-thu-b2.html'){ ?> active<?php } ?>" href="<?php echo FSRoute::_('index.php?module=users'); ?>">
                        <?php echo FSText::_("Hồ sơ");?>
                    </a>
                </li>
                <li class="li-c2">
                    <a class="" href="<?php echo FSRoute::_('index.php?module=users&view=address'); ?>">
                        <?php echo FSText::_("Địa chỉ");?>
                    </a>
                </li>
                <li class="li-c2">
                    <a class="<?php if($url=='/doi-mat-khau.html'){ ?> active<?php } ?>" href="<?php echo FSRoute::_('index.php?module=users&view=users&task=changepass'); ?>">
                        <?php echo FSText::_("Đổi mật khẩu");?>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo FSRoute::_('index.php?module=users&view=order'); ?>">
                <img src="<?php echo URL_ROOT.'images/clipboard.svg' ?>" alt="Quản lý đơn hàng">
                <?php echo FSText::_("Quản lý đơn hàng");?>
            </a>
        </li>

        <li>
            <a href="<?php echo FSRoute::_('index.php?module=users&view=favourite'); ?>">
                <img src="<?php echo URL_ROOT.'images/heart.svg' ?>" alt="Sản phẩm yêu thích">
                <?php echo FSText::_("Sản phẩm yêu thích");?>
            </a>
        </li>
<!--        <li><a href="--><?php //echo FSRoute::_('index.php?module=users&view=level'); ?><!--"><i class="fas fa-user-graduate"></i>--><?php //echo FSText::_("Cấp tài khoản");?><!--</a></li>-->
<!--        <li><a href="--><?php ////echo FSRoute::_('index.php?module=users&view=address'); ?><!--"><i class="fas fa-id-card"></i>--><?php //echo FSText::_("Thẻ thanh toán");?><!--</a></li>-->
<!--        <li><a href="--><?php ////echo FSRoute::_('index.php?module=users&view=address'); ?><!--"><i class="fas fa-handshake"></i>--><?php //echo FSText::_("Cộng tác viên");?><!--</a></li>-->
        <li>
            <a href="<?php echo FSRoute::_("index.php?module=users&view=users&task=logout"); ?>">
                <img src="<?php echo URL_ROOT.'images/log-out.svg' ?>" alt="Đăng xuất">
                <?php echo FSText::_("Đăng xuất");?>
            </a>
        </li>
    </ul>
</div>