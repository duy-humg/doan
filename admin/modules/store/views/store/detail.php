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
	TemplateHelper::dt_edit_selectbox(FSText::_('Thành phố'), 'city', @$data -> city, 0, $city, $field_value = 'id', $field_label = 'name', $size = 1, 0,1);
//	TemplateHelper::dt_edit_selectbox(FSText::_('Quận huyện'), 'district', @$data -> district, 0, $district, $field_value = 'id', $field_label = 'name', $size = 1, 0);
?>
<div class="form-group">
	<label class="col-md-3 col-xs-12 control-label">Quận huyện</label>
	<div class="col-md-9 col-xs-12">
		<select class="form-control" name="district" id="district">
			<option value="0">Quận/huyện</option>
			<?php
			foreach ($district as $item){
			$selected='';
			if(@$data -> district==$item->id){
				$selected.= 'selected';
			}
			?>
			<option  <?php echo $selected; ?>  value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
			<?php } ?>
		</select>

	</div>
</div>
<script>
	$(document).ready(function(){
		$("#city").change(function(){
			city=$('#city').val();
			$.ajax({
				url: "index.php?module=store&view=store&task=district&raw=1&city="+city,
				dataType:"html",
				success: function(result){
					$("#district").html(result);
				}
			});
		});
	});
</script>
<?php
//	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
//	TemplateHelper::dt_edit_text(FSText :: _('Url'),'link',@$data -> link,'',80,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ cửa hàng'),'address',@$data -> address);

	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//	TemplateHelper::dt_checkbox(FSText::_('Bôi đậm'),'is_bold',@$data -> is_bold,1);
//	TemplateHelper::dt_checkbox(FSText::_('Mở tab mới'),'target',@$data -> target,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	$this -> dt_form_end(@$data);

?>
		
