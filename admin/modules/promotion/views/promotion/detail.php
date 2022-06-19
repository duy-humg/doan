<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
//	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
//	TemplateHelper::dt_edit_text(FSText :: _('Url'),'link',@$data -> link,'',80,1,0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        $this->dt_form_begin(1, 2, FSText::_('Sản phẩm'), 'fa-info', 1, 'col-md-12');
        include 'detail_package.php';
        $this->dt_form_end_col(); // END: col-4
//	TemplateHelper::dt_checkbox(FSText::_('Bôi đậm'),'is_bold',@$data -> is_bold,1);
//	TemplateHelper::dt_checkbox(FSText::_('Mở tab mới'),'target',@$data -> target,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	$this -> dt_form_end(@$data);

?>
		
