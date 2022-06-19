<!--<p>--><?php //echo $_SESSION['category'] 
            ?>
<!--</p>-->
<!--<a href="">Chọn lại danh mục</a>-->
<?php
if (@$_SESSION['category']) {
    @$data->category_id = @$_SESSION['category'];
}
//unset($_SESSION['category']);
$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Products'), 'fa-edit', 1, 'col-md-8');
TemplateHelper::dt_edit_text(FSText::_('Sản phẩm'), 'name', @$data->name);
TemplateHelper::dt_edit_text(FSText::_('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
TemplateHelper::dt_edit_image(FSText::_('Hình ảnh'), 'image', str_replace('/original/', '/small/', URL_ROOT . @$data->image));
TemplateHelper::dt_edit_selectbox(FSText::_('Categories'), 'category_id', @$data->category_id, 0, $categories, $field_value = 'id', $field_label = 'treename', $size = 10, 0, 1);
TemplateHelper::dt_edit_selectbox(FSText::_('Shop'), 'id_shop', @$data->id_shop, 0, $list_shop, $field_value = 'id', $field_label = 'name', $size = 10, 0, 1);
TemplateHelper::dt_edit_text(FSText::_('Đã bán'), 'daban', @$data->daban);
TemplateHelper::dt_edit_text(FSText::_('Chất liệu'), 'chatlieu', @$data->chatlieu);
TemplateHelper::dt_edit_text(FSText::_('Kho hàng'), 'khohang', @$data->khohang);
TemplateHelper::dt_edit_text(FSText::_('Gửi từ'), 'guitu', @$data->guitu);
//TemplateHelper::dt_edit_text(FSText:: _('Ngôn ngữ'), 'language', @$data->language);
//TemplateHelper::dt_edit_selectbox('Tác giả/ Dịch giả', 'author_book_id', @$data->author_book_id, 0, $author_book, 'id', 'name', $size = 1, 1, 1);


//TemplateHelper::dt_edit_text(FSText :: _('Trọng lượng'), 'weight', @$data->weight);
?>
<!--    <div class="form-group">-->
<!--        <label class="col-md-3 col-xs-12 control-label">Trọng lượng(g)</label>-->
<!---->

<!--        </div>-->
<!--    </div>-->
<?php
//TemplateHelper::dt_edit_selectbox('Công ty phát hành', 'company_ex_id', @$data->company_ex_id, 0, $company_ex, 'id', 'name', 1, 0, 1);
//TemplateHelper::dt_edit_selectbox('Nhà xuất bản', 'home_ex_id', @$data->home_ex_id, 0, $xuatban, 'id', 'name', 1, 0, 1);
//TemplateHelper::dt_edit_selectbox('Loại bìa', 'loai_bia_id', @$data->loai_bia_id, 0, $loaibia, 'id', 'name', 1, 0, 1);
//TemplateHelper::dt_edit_text(FSText:: _('Ngày xuất bản'), 'released_time', @$data->released_time, 0);
TemplateHelper::dt_edit_text(FSText::_('Giá ban đầu'), 'price_old', @$data->price_old, 0);
TemplateHelper::dt_edit_text(FSText::_('Giá bán'), 'price', @$data->price, 0);
//TemplateHelper::dt_edit_selectbox('Loại giảm giá', 'discount_unit', @$data->discount_unit, 1, array('percent' => 'Phần trăm'), $field_value = '', $field_label = '');
//TemplateHelper::dt_edit_text(FSText:: _('Giá bán '), 'discount', @$data->discount, 0);

//TemplateHelper::dt_edit_text(FSText:: _('Số lượng'), 'quantity', @$data->quantity, 0);
//TemplateHelper::dt_edit_text(FSText :: _('Đơn vị'),'unit',@$data -> unit);

//TemplateHelper::dt_edit_text(FSText:: _('Số lượng sách mới còn lại'), 'quantity', @$data->quantity, 0);
//TemplateHelper::dt_edit_text(FSText:: _('Giá bán sách cũ'), 'price_old1', @$data->price_old1, 0);
//TemplateHelper::dt_edit_text(FSText:: _('Số lượng sách cũ'), 'quantity_old', @$data->quantity_old, 0);

//
?>
<!--    <div class="form-group">-->
<!--        <label class="col-sm-3 col-xs-12 control-label">--><?php //echo FSText:: _('Đối tượng sử dụng'); 
                                                                ?>
<!--</label>-->
<!--        <div class="col-sm-9 col-xs-12">-->
<!--            --><?php
                    //            $checked = 0;
                    //            $checked_all = 0;
                    //
                    //            if((!@$data->list_object)){
                    //                $checked = 0;
                    //            }  else {
                    //                $checked = 1;
                    //                $checked_all = 0;
                    //                $arr_menu_item = explode(',',@$data->list_object);
                    //            }
                    //            
                    ?>
<!--            <select data-placeholder="--><?php //echo FSText::_('Đối tượng sử dụng') 
                                                ?>
<!--" name="menu_object[]" size="8"-->
<!--                    multiple="multiple"-->
<!--                    class='form-control chosen-select-no-results listItem' >-->
<!--                --><?php
                        //
                        //                foreach ($list_object as $item) {
                        //
                        //                    $html_check = "";
                        //                    if ($checked_all) {
                        //                        $html_check = "' selected='selected' ";
                        //                    } else {
                        //                        if ($checked) {
                        //                            if (in_array($item->id, $arr_menu_item)) {
                        //                                $html_check = "' selected='selected' ";
                        //                            }
                        //                        }
                        //                    }
                        //                    
                        ?>
<!--                    <option value="--><?php //echo $item->id 
                                            ?>
<!--" --><?php //echo $html_check; 
            ?>
<!--><?php //echo $item->name; 
        ?><!--</option>-->
<!--                --><?php //} 
                        ?>
<!--            </select>-->
<!--        </div>-->
<!--    </div>-->
<?php
$this->dt_form_end_col(); // END: col-1

$this->dt_form_begin(1, 2, FSText::_('Quản trị'), 'fa-user', 1, 'col-md-4 fl-right');
TemplateHelper::dt_text(FSText::_('Người tạo'), @$data->author);
//TemplateHelper::dt_text(FSText :: _('Thời gian tạo'),date('H:i:s d/m/Y',strtotime(@$data -> start_time)));
TemplateHelper::dt_text(FSText::_('Người sửa cuối'), @$data->author_last);
//TemplateHelper::dt_text(FSText :: _('Thời gian sửa'),date('H:i:s d/m/Y',strtotime(@$data -> end_time)));
$this->dt_form_end_col(); // END: col-4

$this->dt_form_begin(1, 2, FSText::_('Kích hoạt'), 'fa-unlock', 1, 'col-md-4 fl-right');
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-sm-4', 'col-sm-8');
TemplateHelper::dt_checkbox(FSText::_('Is Hot'), 'is_hot', @$data->is_hot, 0, '', '', '', 'col-sm-4', 'col-sm-8');
TemplateHelper::dt_checkbox(FSText::_('Is New'), 'is_news', @$data->is_news, 1, '', '', '', 'col-sm-4', 'col-sm-8');
TemplateHelper::dt_checkbox(FSText::_('Khuyến mại hot'), 'is_sale', @$data->is_sale, 0, '', '', '', 'col-sm-4', 'col-sm-8');
//TemplateHelper::dt_checkbox(FSText::_('Sắp ra mắt'), 'coming_soon', @$data->coming_soon, 0, '', '', '', 'col-sm-4', 'col-sm-8');
//TemplateHelper::dt_checkbox(FSText::_('Is Hot'), 'is_hot', @$data->is_hot, 0, '', '', '', 'col-sm-4', 'col-sm-8');
//TemplateHelper::dt_checkbox(FSText::_('Bán chạy'), 'show_in_homepage', @$data->show_in_homepage, 0, '', '', '', 'col-sm-4', 'col-sm-8');

TemplateHelper::dt_edit_text(FSText::_('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '', '', 0, '', '', 'col-sm-4', 'col-sm-8');
$this->dt_form_end_col(); // END: col-2

//$this->dt_form_begin(1, 2, FSText::_('Tags'), 'fa-tag', 1, 'col-md-4 fl-right');
//TemplateHelper::dt_edit_selectbox(FSText::_('Tags'), 'tag_id', @$data->tag_id, 0, $tag, $field_value = 'alias', $field_label = 'name', $size = 30, 1);
//
//$this->dt_form_end_col(); // END: col-2
?>
<input type="hidden" id="count_thuoctinh" name="count_thuoctinh" value="<?php echo count($thuoctinh) ?>">
<!-- <input type="hidden" id="type_save" name="type_save" value="<?php echo $type_save ?>">
<select data-placeholder="Thương hiệu" class="form-control chosen-select chosen-select-deselect-no-results" name="thuoctinh4[]" id="thuoctinh4" multiple="multiple" style="display: none;">
    <option value="56">Nổi tiếng</option>
    <option value="57">Hàng XK</option>
    <option value="58">SP nội địa</option>
</select> -->


<?php

$this->dt_form_begin(1, 4, 'Thuộc thính', 'fa-edit', 1, 'col-md-8');
$i = 1;
foreach ($thuoctinh as $item) {
    $model = $this->model;
    $list_thuoctinh = $model->list_thuoctinh($item->field_table);
    if ($type_save == 2) {
        $list_nd = $model->list_thuoctinh_nd($item->field_table, $data->id);
        //        var_dump($list_nd);
    }
    if ($item->field_type == 34) {
?>
        <input type="hidden" id="field_type<?php echo $i ?>" name="field_type<?php echo $i ?>" value="<?php echo $item->field_type ?>">
        <input type="hidden" id="name_type<?php echo $i ?>" name="name_type<?php echo $i ?>" value="<?php echo $item->name_type ?>">
        <input type="hidden" id="field_table<?php echo $i ?>" name="field_table<?php echo $i ?>" value="<?php echo $item->field_table ?>">
        <input type="hidden" id="name_table<?php echo $i ?>" name="name_table<?php echo $i ?>" value="<?php echo $item->name_table ?>">
        <input type="hidden" id="record_id<?php echo $i ?>" name="record_id<?php echo $i ?>" value="<?php echo $item->id ?>">
        <input type="hidden" id="title<?php echo $i ?>" name="title<?php echo $i ?>" value="<?php echo $item->title ?>">

        <?php
        if ($type_save == 2) {
        ?>
            <input type="hidden" id="id_thuoctinh<?php echo $i ?>" name="id_thuoctinh<?php echo $i ?>" value="<?php echo @$list_nd->id ?>">
        <?php

            TemplateHelper::dt_edit_selectbox($item->title, 'thuoctinh' . $i, @$list_nd->noidung, 0, @$list_thuoctinh, 'id', 'name', 1, 0, 1);
        } else {

            TemplateHelper::dt_edit_selectbox($item->title, 'thuoctinh' . $i, '', 0, @$list_thuoctinh, 'id', 'name', 1, 0, 1);
        }
    } elseif ($item->field_type == 35) {
        ?>
        <input type="hidden" id="field_type<?php echo $i ?>" name="field_type<?php echo $i ?>" value="<?php echo $item->field_type ?>">
        <input type="hidden" id="name_type<?php echo $i ?>" name="name_type<?php echo $i ?>" value="<?php echo $item->name_type ?>">
        <input type="hidden" id="field_table<?php echo $i ?>" name="field_table<?php echo $i ?>" value="<?php echo $item->field_table ?>">
        <input type="hidden" id="name_table<?php echo $i ?>" name="name_table<?php echo $i ?>" value="<?php echo $item->name_table ?>">
        <input type="hidden" id="record_id<?php echo $i ?>" name="record_id<?php echo $i ?>" value="<?php echo $item->id ?>">
        <input type="hidden" id="title<?php echo $i ?>" name="title<?php echo $i ?>" value="<?php echo $item->title ?>">
        <?php
        if ($type_save == 2) {
        ?>
            <input type="hidden" id="id_thuoctinh<?php echo $i ?>" name="id_thuoctinh<?php echo $i ?>" value="<?php echo @$list_nd->id ?>">
<?php
            TemplateHelper::dt_edit_selectbox($item->title, 'thuoctinh' . $i, @$list_nd->noidung, 0, @$list_thuoctinh, 'id', 'name', $size = 1, 1, 1);
        } else {
            TemplateHelper::dt_edit_selectbox($item->title, 'thuoctinh' . $i, '', 0, @$list_thuoctinh, 'id', 'name', $size = 1, 1, 1);
        }
    }
    $i++;
}
//TemplateHelper::dt_edit_selectbox('Màu sắc', 'color_id', @$data->color_id, 0, @$color, 'id', 'name', 1, 1, 1);
//TemplateHelper::dt_edit_selectbox('Xuất xứ', 'origin_id', @$data->origin_id, 0, @$origin, 'id', 'name', 1, 0, 1);
//TemplateHelper::dt_edit_selectbox('Thương hiệu/ nhà sản xuất', 'producer_id', @$data->producer_id, 0, @$list_producer, 'id', 'name', 1, 0, 1);
//TemplateHelper::dt_edit_selectbox('Chất liệu', 'chatlieu_id', @$data->chatlieu_id, 0, @$list_chatlieu, 'id', 'name', 1, 0, 1);

$this->dt_form_end_col(); // END: col-1

$this->dt_form_begin(1, 2, FSText::_('Ảnh'), 'fa-image', 1, 'col-md-8');
TemplateHelper::dt_edit_image2(FSText::_('Image'), 'image', str_replace('/original/', '/resized/', URL_ROOT . @$data->image), '', '', '', 1);
$this->dt_form_end_col();

//$this->dt_form_begin(1, 4, FSText::_('Sản phẩm top'), 'fa-info', 1, 'col-md-8');
//TemplateHelper::dt_edit_text(FSText:: _(''), 'bestseller', @$data->bestseller, '', 650, 450, 1, '', '', 'col-sm-2', 'col-sm-12');
//$this->dt_form_end_col(); // END: col-4

$this->dt_form_begin(1, 4, FSText::_('Content'), 'fa-info', 1, 'col-md-8');
TemplateHelper::dt_edit_text(FSText::_(''), 'content', @$data->content, '', 650, 450, 1, '', '', 'col-sm-2', 'col-sm-12');
$this->dt_form_end_col(); // END: col-4

//$this->dt_form_begin(1, 2, FSText::_('Summary'), 'fa-info', 1, 'col-md-4');
//TemplateHelper::dt_edit_text(FSText:: _(''), 'summary', @$data->summary, '', 100, 5, 0, '', '', 'col-sm-2', 'col-sm-12');
//$this->dt_form_end_col(); // END: col-4

//$this->dt_form_begin(1, 2, FSText::_('Sản phẩm mua kèm'), 'fa-info', 1, 'col-md-12');
//include 'detail_package.php';
//$this->dt_form_end_col(); // END: col-4
?>