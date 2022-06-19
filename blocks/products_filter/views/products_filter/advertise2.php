<?php
global $tmpl;
$tmpl->addScript('styles', 'blocks/banners/assets/js');
$tmpl->addStylesheet('advertise', 'blocks/banners/assets/css');
$lang = FSInput::get('lang');
$Itemid = FSInput::get('Itemid');
?>
<a class="book2">
    <p>Stephen King !</p>
    <img src="blocks/banners/assets/images/book/book1.jpg">
</a>