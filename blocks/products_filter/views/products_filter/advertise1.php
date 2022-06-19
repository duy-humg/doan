<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/banners/assets/js');
$tmpl->addStylesheet('advertise', 'blocks/banners/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>
<a class="book1">
    <p>Hiện tượng thực phẩm mới!</p>
    <img src="blocks/banners/assets/images/book/book0.jpg">
</a>