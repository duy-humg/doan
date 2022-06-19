<?php
    global $tmpl;
    $tmpl -> addStylesheet("search","blocks/search/assets/css");
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
    $tmpl -> addScript("search","blocks/search/assets/js");

    $text_default = FSText::_('Nhập từ khóa tìm kiếm');

    $keyword = $text_default;
    $module = FSInput::get('module');
    if($module == 'products'){
        $key = FSInput::get('keyword');
        if($key){
            $keyword = $key;
        }
    }
  
?>
<h1><?php // echo $tieude?></h1>
<div id="search" class="nav-search">
    <?php $link = FSRoute::_('index.php?module=products&view=search');?>
    <form class="search-form row-item" action="<?php echo $link; ?>" name="search_form" id="search_form" method="get" onsubmit="javascript: submit_form_search();return false;" >
<!--        <a href="#" class="btn btn-default">Danh mục<i class="fas fa-angle-down"></i></a>-->
    	<input type="text" value="" placeholder="<?php echo $keyword; ?>" name="keyword" class="form-control" id="autocomplete" />
<!--        <button type="submit"><i class="fal fa-search"></i></button>-->
        <input type='hidden'  name="module" value="news"/>
    	<input type='hidden'  name="module" id='link_search' value="<?php echo FSRoute::_('index.php?module=products&view=search'); ?>" />
    	<input type='hidden'  name="view" value="search"/>
    	<input type='hidden'  name="Itemid" value="20"/>
    </form>
</div>
