<!-- HEAD -->
	<?php
    if(@$data->id){
        $_SESSION['session_image'] = $data->id;
    }else{
        if(isset($_SESSION['session_image'])){
            $_SESSION['session_image'] = mt_rand();
        }else{
            $_SESSION['session_image'] = mt_rand();
        }
    }


	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
        $toolbar->addButton('save_add', FSText :: _('Save and new'), '', 'save_add.png');
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png',1); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png',1); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
     echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';
	//$this -> dt_form_begin();
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh mục'),'fa-edit',1,'col-md-12',1);
    
	TemplateHelper::dt_edit_text(FSText :: _('Tên Danh mục'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
//    TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt'),'summary',@$data -> summary);

	//	TemplateHelper::dt_checkbox(FSText::_('Không phải sách'),'not_book',@$data -> not_book,1);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_checkbox(FSText::_('Nổi bật'),'is_hot',@$data -> is_hot,0);
//	TemplateHelper::dt_checkbox(FSText::_('Theo độ tuổi'),'is_age',@$data -> is_age,0);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'image',URL_ROOT.str_replace('/original/','/small/',@$data->image));
//	TemplateHelper::dt_edit_image(FSText :: _('Banner'),'icon',URL_ROOT.str_replace('/original/','/lager/',@$data->icon));
?>
<input type="hidden" id="data_id" name="data_id" value="<?php echo @$data->id ?>"/>
<input type="hidden" id="total_data" name="total_data" value=""/>
<input type="hidden" id="total_data_up" name="total_data_up" value="<?php echo count(@$list_item) ?>"/>
<input type="hidden" value="<?php echo @$_SESSION['session_image'] ?>" name="session_data" id="session_data">
<div class="data_them">
    <div class="title-data">
        <p class="p-text-data"><?php echo FSText::_("Dữ liệu mở rộng"); ?></p>
    </div>
    <div class="list-data-dau">
        <div class="title-dau name">
            <p><?php echo FSText::_("Tên"); ?></p>
        </div>
        <div class="title-dau type">
            <p><?php echo FSText::_("Kiểu trường"); ?></p>
        </div>
        <div class="title-dau table-data">
            <p><?php echo FSText::_("Bảng mở rộng"); ?></p>
        </div>
        <div class="title-dau ordering">
            <p><?php echo FSText::_("Thứ tự"); ?></p>
        </div>
        <div class="title-dau save">
            <p><?php echo FSText::_("Lưu"); ?></p>
        </div>
        <div class="title-dau detele">
            <p><?php echo FSText::_("Xóa"); ?></p>
        </div>
    </div>
    <div class="item_add_service" id="item_add_service_edit">
        <div class="list-data" id="list-data">
        <?php if(@$list_item){ ?>
            <?php $i=1; foreach ($list_item as $item) { ?>
            <input type="hidden" name="id_data<?php echo $i ?>" id="id_data<?php echo $i ?>" value="<?php echo $item->id ?>">
            <div class="list-item-data list-item-data-<?php echo $i ?>">
                <div class="name-data text-list-data">
                    <input class="input-date" id="name_data2_<?php echo $i ?>" name="name_data2_<?php echo $i ?>" type="text" value="<?php echo $item->title ?>">
                </div>
                <div class="type-data text-list-data">
                    <select class="select target_type" key_type="<?php echo $i ?>" name="field_type2_<?php echo $i ?>" id="field_type2_<?php echo $i ?>" onclick="change_field_type_2(<?php echo $i ?>);">
                        <option value="">-- <?php echo FSText::_("Chọn"); ?> --</option>
                        <?php foreach ($type as $item2){ ?>
                            <?php $checked =  (@$item->field_type == $item2->id)? " selected = 'selected'": ""; ?>
                            <option value="<?php echo @$item2->id; ?>" <?php echo $checked; ?>><?php echo @$item2->title ; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php if($item->field_type == 33 or $item->field_type == 36){ ?>
                <div class="table-list-data text-list-data table-list-data<?php echo $i ?>">
                    <select disabled class="select select_dis" name="field_table2_<?php echo $i ?>" id="field_table2_<?php echo $i ?>">
                        <?php }else{ ?>
                        <div class="table-list-data text-list-data table-list-data<?php echo $i ?>">
                            <select class="select" name="field_table2_<?php echo $i ?>" id="field_table2_<?php echo $i ?>">
                                <?php } ?>

                                <option value="">-- <?php echo FSText::_("Chọn"); ?> --</option>
                                <?php foreach ($table as $item2){ ?>
                                    <?php $checked =  (@$item->field_table == $item2->id)? " selected = 'selected'": ""; ?>
                                    <option value="<?php echo @$item2->id; ?>" <?php echo $checked; ?>><?php echo @$item2->name ; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="ordering-data text-list-data">
                            <?php if($item->ordering == 1){ ?>
                                <input class="" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,'')}" id="ordering_data2_<?php echo $i ?>" name="ordering_data2_<?php echo $i ?>" type="text">
                            <?php }else{ ?>
                                <input class=""
                                       onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,'')}"
                                       id="ordering_data2_<?php echo $i ?>"
                                       name="ordering_data2_<?php echo $i ?>"
                                       value="<?php echo @$item->ordering ; ?>"
                                       type="text">
                            <?php } ?>

                        </div>
                        <div class="save-data text-list-data">
                            <a href="javascript: void(0)" onclick="update_data_item_2(<?php echo $item->id ?>,<?php echo $data->id ?>,<?php echo $i ?>)" class="a-add">
                                <img src="<?php echo URL_ROOT.'images/save.png' ?>" alt="png">
                            </a>
                        </div>
                        <div class="detele-data text-list-data">
                            <a href="javascript: void(0)" onclick="remove2(<?php echo $item->id ?>,<?php echo $data->id ?>)" class="detele">
                                <img src="<?php echo URL_ROOT.'images/remove.jpg' ?>" alt="png">
                            </a>
                        </div>
                </div>
                <?php $i++; } ?>
            <?php } ?>

        </div>
        <div class="list-item-data-add" id="list-item-data-add">

        </div>
    </div>
    <div class="add-data">
        <a class="a-add-data" href="javascript:void(0)"   onclick="addservice()"><?php echo FSText::_("Thêm mới"); ?></a>
    </div>
</div>
<?php

	$this -> dt_form_end(@$data,1,1);
//	$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',0,'col-sm-4');
	?>
<script type="text/javascript">

    ser = 1;
    function addservice(){
        // alert(1);
        $.ajax({
            url: "index.php?module=products&view=categories&task=adddata&raw=1",
            type: 'GET',
            data: {id: '1',a: ser},
            dataType: 'html',
            success: function ($html) {
                $("#list-item-data-add").append($html);
                $("#total_data").val(ser);
                $( ".target_type" ).change(function() {
                    // alert( "Handler for .change() called." );
                    a = $(this).val();
                    var key = $(this).attr("key_type");
                    // alert(key);
                    change_field_type(key);
                    // alert(a);
                });
                ser++;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
        // i++;
    }

    function change_field_type($extend_number){
        // alert(2);
        var $field_type = $('#field_type'+$extend_number).val();
        if($field_type=='34' || $field_type=='35'){
            // console.log(1);
            $('#field_table_'+$extend_number).prop("disabled", false);
            $('#field_table_'+$extend_number).removeClass('select_dis');
        }else{
            $('#field_table_'+$extend_number).val('');
            $('#field_table_'+$extend_number).addClass('select_dis');
            $('#field_table_'+$extend_number).prop("disabled", true);
        }
    }

    function remove($i) {
        $(".list-item-data"+$i).remove();
    }

    function add_data_item($i) {
        var data_id = $('#data_id').val();
        if (checker_data($i)){
            name_data =  $("#name_data"+$i).val();
            field_type =  $("#field_type"+$i).val();
            field_table =  $("#field_table_"+$i).val();
            // alert(field_table);
            ordering_data =  $("#ordering_data"+$i).val();
            session_service =  $("#session_data").val();
            record_id = '0';

            // alert($type);
            $.ajax({
                url: "index.php?module=products&view=categories&task=add_item_data&raw=1",
                type: 'GET',
                data: {name_data: name_data,field_type: field_type,field_table: field_table,ordering_data: ordering_data,session_service: session_service,record_id: record_id,data_id: data_id},
                dataType: 'html',
                success: function ($html) {

                    $("#list-data").html($html);

                    $(".list-item-data"+$i).remove();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
                }
            });
        }
    }

    function update_data_item(id,sessions) {

        name_data =  $("#name_data"+id).val();
        field_type =  $("#field_type"+id).val();
        field_table =  $("#field_table_"+id).val();
        // alert(field_table);
        ordering_data =  $("#ordering_data"+id).val();
        record_id = '0';
        $.ajax({
            url: "index.php?module=products&view=categories&task=update_data_item&raw=1",
            type: 'GET',
            data: {id: id,name_data: name_data,field_type: field_type,field_table: field_table,ordering_data: ordering_data,session_service: sessions,record_id: record_id},
            dataType: 'html',
            success: function ($html) {

                $("#list-data").html($html);
                // $(".item-service"+$i).remove();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
    }

    function remove2(id,sessions) {
        var data_id = $('#data_id').val();
        $.ajax({
            url: "index.php?module=products&view=categories&task=remove2&raw=1",
            type: 'GET',
            data: {id: id,sessions: sessions,data_id:data_id},
            dataType: 'html',
            success: function ($html) {
                $("#list-data").html($html);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
    }
    function update_data_item_2(id,record_id,i) {

        name_data =  $("#name_data2_"+i).val();
        field_type =  $("#field_type2_"+i).val();
        field_table =  $("#field_table2_"+i).val();
        // alert(field_table);
        ordering_data =  $("#ordering_data2_"+i).val();

        $.ajax({
            url: "index.php?module=products&view=categories&task=update_data_item_2&raw=1",
            type: 'GET',
            data: {id: id,name_data: name_data,field_type: field_type,field_table: field_table,ordering_data: ordering_data,record_id: record_id},
            dataType: 'html',
            success: function ($html) {

                $("#list-data").html($html);
                // $(".item-service"+$i).remove();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
    }


    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
	function formValidator()
	{
	    $('.alert-danger').show();	
        
		if(!notEmpty('name','Bạn phải nhập tên danh mục'))
			return false;
                
		$('.alert-danger').hide();
		return true;
	}

    function checker_data($i) {

        name_data =  $("#name_data"+$i).val();
        if (name_data='') {
            alert('Bạn chưa nhập tên')
            return false;
        }

        field_type =  $("#field_type"+$i).val();
        if (field_type='') {
            alert('Bạn chưa chọn kiểu trường')
            return false;
        }



        return true;
    }
   

</script>

<style>
    .data_them .title-data .p-text-data {
        margin-bottom: 0px;
        background: #567549;
        color: #fff;
        text-align: center;
        font-weight: bold;
        padding: 10px 0px; }
    .data_them .list-data-dau {
        display: flex;
        background: #eeeeee;
        border-bottom: 1px solid #dddddd; }
    .data_them .list-data-dau .title-dau {
        border-right: 1px solid #dddddd; }
    .data_them .list-data-dau .title-dau p {
        padding: 10px 0px;
        margin-bottom: 0px;
        font-weight: bold;
        text-align: center; }
    .data_them .list-data-dau .name {
        width: 25%; }
    .data_them .list-data-dau .name p {
        text-align: left;
        padding-left: 10px; }
    .data_them .list-data-dau .type {
        width: 15%; }
    .data_them .list-data-dau .table-data {
        width: 30%; }
    .data_them .list-data-dau .ordering {
        width: 15%; }
    .data_them .list-data-dau .save {
        font-weight: normal;
        width: 7.5%; }
    .data_them .list-data-dau .save p {
        font-weight: normal; }
    .data_them .list-data-dau .detele {
        font-weight: normal;
        width: 7.5%;
        border-right: 0px solid #dddddd; }
    .data_them .list-data-dau .detele p {
        font-weight: normal; }
    .data_them .item_add_service {
        border: 1px solid #dddddd;
        border-top: 0px solid #dddddd; }
    .data_them .item_add_service .list-item-data {
        border-bottom: 1px solid #dddddd;
        display: flex; }
    .data_them .item_add_service .list-item-data .text-list-data {
        border-right: 1px solid #dddddd;
        padding: 5px; }
    .data_them .item_add_service .list-item-data .text-list-data input {
        width: 100%;
        height: 35px;
        border: 1px solid #c0c2c9;
        padding-left: 10px;
        border-radius: 5px; }
    .data_them .item_add_service .list-item-data .text-list-data input:focus {
        outline: unset; }
    .data_them .item_add_service .list-item-data .text-list-data .label_error {
        margin-bottom: 5px !important; }
    .data_them .item_add_service .list-item-data .text-list-data select {
        width: 100%;
        height: 35px;
        border: 1px solid #c0c2c9;
        padding-left: 10px;
        border-radius: 5px; }
    .data_them .item_add_service .list-item-data .text-list-data select:focus {
        outline: unset; }
    .data_them .item_add_service .list-item-data .text-list-data .select_dis {
        background: #eeeeee; }
    .data_them .item_add_service .list-item-data .name-data {
        width: 25%; }
    .data_them .item_add_service .list-item-data .type-data {
        width: 15%; }
    .data_them .item_add_service .list-item-data .table-list-data {
        width: 30%; }
    .data_them .item_add_service .list-item-data .ordering-data {
        width: 15%; }
    .data_them .item_add_service .list-item-data .save-data {
        width: 7.5%;
        align-items: center;
        justify-content: center;
        display: grid; }
    .data_them .item_add_service .list-item-data .detele-data {
        width: 7.5%;
        border-right: 0px;
        align-items: center;
        justify-content: center;
        display: grid; }
    .data_them .item_add_service .list-item-data2 {
        background: #f8f8f8; }
    .data_them .add-data {
        margin-top: 30px;
        text-align: center; }
    .data_them .add-data .a-add-data {
        background: #567549;
        padding: 10px 25px;
        border-radius: 5px;
        color: #ffffff; }
</style>

