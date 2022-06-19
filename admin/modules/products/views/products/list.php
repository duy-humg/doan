<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css"/>
<?php
global $toolbar;
//$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
//$toolbar->addButton('import',FSText :: _('Import'),FSText :: _(''),'Excel-icon.png');

$toolbar->setTitle(FSText:: _('News'));
//$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
$toolbar->addButton('add', FSText:: _('Add'), '', 'add.png');
$toolbar->addButton('remove', FSText:: _('Remove'), FSText:: _('You must select at least one record'), 'remove.png');
$toolbar->addButton('published', FSText:: _('Published'), FSText:: _('You must select at least one record'), 'published.png');
$toolbar->addButton('unpublished', FSText:: _('Unpublished'), FSText:: _('You must select at least one record'), 'unpublished.png');

//	FILTER
$filter_config = array();
$fitler_config['search'] = 1;
$fitler_config['filter_count'] = 2;

$filter_categories = array();
$filter_categories['title'] = FSText::_('Categories');
$filter_categories['list'] = @$categories;
$filter_categories['field'] = 'treename';

$fitler_config['filter'][] = $filter_categories;


$filter_publish = array();
$filter_publish['title'] = FSText::_('Hoạt động');
$filter_publish['list'] = @$array_publish;
$fitler_config['filter'][] = $filter_publish;

//	CONFIG
$list_config = array();
$list_config[] = array('title' => 'Sản phẩm', 'field' => 'name', 'ordering' => 1, 'align' => 'left', 'type' => 'text_link', 'col_width' => '30%', 'link' => 'index.php?module=products&view=product&ccode=ccode&code=code&id=id&Itemid=4', 'arr_params' => array('size' => 30));

//$list_config[] = array('title'=>'Title','field'=>'','type'=>'text','align'=>'left','arr_params'=>array('function'=>'view_title'),'col_width' => '20%');
$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/small/','width'=>'90'));
//$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
//	$list_config[] = array('title'=>'Danh mục','field'=>'category_name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
$list_config[] = array('title' => 'Người đăng', 'field' => 'author', 'ordering' => 1, 'type' => 'text');
$list_config[] = array('title' => 'Ngày sửa', 'field' => 'updated_time', 'ordering' => 1, 'type' => 'datetime');
$list_config[] = array('title' => 'Bán chạy', 'field' => 'is_hot', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'is_hot'));
$list_config[] = array('title' => 'Check home', 'field' => 'show_in_homepage', 'ordering' => 1, 'type' => 'change_status');
$list_config[] = array('title' => 'Lượt xem', 'field' => 'hits', 'ordering' => 1, 'type' => 'text');
$list_config[] = array('title' => 'Hoạt động', 'field' => 'published', 'ordering' => 1, 'type' => 'published','arr_params'=>$array_publish);

$list_config[] = array('title' => 'Edit', 'type' => 'edit');
$list_config[] = array('title' => 'Id', 'field' => 'id', 'ordering' => 1, 'type' => 'text');

TemplateHelper::genarate_form_liting($this->module, $this->view, $list, $fitler_config, $list_config, $sort_field, $sort_direct, $pagination);
?>
