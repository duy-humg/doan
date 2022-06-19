<?php
global $tmpl;
$url = $_SERVER['REQUEST_URI'];
$tmpl->addStylesheet("menu", "modules/users/assets/css");
?>
<div class="list-menu-user">
    <div class="user-name-show clearfix">
        <img src="<?php echo URL_ROOT.'images/detail_02.png'; ?>" class="img-responsive"/>
        <p><?php echo FSText::_("Tài khoản của");?></p>
        <p class="session_user"><?php echo $_SESSION['user_name']; ?></p>
    </div>
    <ul>
        <li><a href="<?php echo FSRoute::_('index.php?module=users'); ?>"><i class="fas fa-user"></i><?php echo FSText::_("Thông tin tài khoản");?></a></li>
        <li><a href="<?php echo FSRoute::_('index.php?module=users&view=order'); ?>" ><i class="fas fa-clipboard-list"></i><?php echo FSText::_("Quản lý đơn hàng");?></a></li>
        <li><a href="<?php echo FSRoute::_('index.php?module=users&view=level'); ?>" class="active"><i class="fas fa-user-graduate"></i><?php echo FSText::_("Cấp tài khoản");?></a></li>
        <li><a href="<?php echo FSRoute::_('index.php?module=users&view=address'); ?>" ><i class="fas fa-map-marker-alt"></i><?php echo FSText::_("Sổ địa chỉ");?></a></li>
        <li><a href="<?php echo FSRoute::_("index.php?module=users&view=users&task=logout"); ?>"><i class="fas fa-sign-out-alt"></i><?php echo FSText::_("Thoát tài khoản");?></a></li>
    </ul>
</div>