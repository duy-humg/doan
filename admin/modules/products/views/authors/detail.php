<?php
$title = @$data ? FSText:: _('Edit') : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');

$this->dt_form_begin();

TemplateHelper::dt_edit_text(FSText:: _('Tên tác giả'), 'name', @$data->name);
TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
TemplateHelper::dt_edit_image(FSText:: _('Image'), 'image', URL_ROOT . str_replace('/original/', '/resized/', @$data->image));
TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
TemplateHelper::dt_checkbox(FSText::_('Tác giả yêu thích'), 'like_author_translate', @$data->like_author_translate, 0);

TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
TemplateHelper::dt_edit_text(FSText:: _('Mô tả'), 'content', @$data->content, '', 650, 450, 1);

$this->dt_form_end(@$data, 1, 0);

?>
