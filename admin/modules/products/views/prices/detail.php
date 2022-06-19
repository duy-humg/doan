<?php ?>
<!-- HEAD -->
<?php
$title = @$data ? FSText :: _('S&#7917;a th&#244;ng tin v&#7873; H&#227;ng s&#7843;n xu&#7845;t') : FSText :: _('Th&#234;m m&#7899;i h&#227;ng s&#7843;n xu&#7845;t');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText :: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

$this->dt_form_begin();
TemplateHelper::dt_edit_text(FSText :: _('Tên'), 'name', @$data->name);
TemplateHelper::dt_edit_text(FSText :: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
TemplateHelper::dt_edit_text(FSText :: _('Giá trị đầu'), 'start', @$data->start);
TemplateHelper::dt_edit_text(FSText :: _('Giá trị cuối'), 'end', @$data->end);
//	TemplateHelper::dt_edit_text(FSText :: _('Toán tử'),'operator',@$data -> operator);
//	
?>
<div class="form-group">

    <label class="col-md-3 col-xs-12 control-label">Toán tử</label>
    <div class="col-md-9 col-xs-12">
        <select name='operator' >
            <?php foreach ($calculators as $item) { ?>
                <?php if ($item[0] == $data->operator) { ?>
                    <option value="<?php echo $item[0]; ?>" selected="selected" ><?php echo $item[1]; ?></option>

                <?php } else { ?>
                    <option value="<?php echo $item[0]; ?>"  ><?php echo $item[1]; ?></option>
                <?php } ?>

            <?php } ?>
        </select>
        <!--<input type="hidden" name='operator' value="<?php echo $field->operator; ?>" />-->
    </div>
</div>
<?php
//	TemplateHelper::dt_edit_selectbox(FSText::_('Sử dụng cho các bảng'),'tablenames',@$data -> tablenames,0,$tables,'table_name','table_name',$size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item');
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_text(FSText :: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');

$this->dt_form_end(@$data);
?>
<!-- END HEAD-->
