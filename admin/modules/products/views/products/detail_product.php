<!-- BODY-->
<div class="form_body">

        <!--	FIELD	-->
        <fieldset>
            <legend>Danh Sách sản phẩm phụ</legend>
            <div id="tabs">
                <p class="notice blue"></p>
                <table cellpadding="5" class="field_tbl" width="100%" border="1" bordercolor="red">
                    <tr>

                        <td width="20%"> Chọn Size </td>
                        <td width="20%"> Màu sắc </td>

                        <td width="12%"> Giá ban đầu</td>

                        <td width="12%"> Giá bán</td>

                        <td width="7%"> Show </td>
                        <td width="3%"> X&#243;a</td>
                    </tr>
                    <?php $i = 0;?>
                    <?php if(isset($products) && count($products)) {
                        $array_default = array('id','productid','categoryid','manufactory','models');
                        foreach ($products as $field) {
                                ?>
                                <input type="hidden" name="id_exist_<?php echo $i;?>" value="<?php echo $field->id; ?>">
                                <tr id="extend_field_exist_<?php echo $i; ?>">

                                    <td valign="center"  class="left_col">
                                        <?php $products_type_compare = isset($field->size_id)?$field->size_id:0; ?>
                                        <select name="products_type_id_exist_<?php echo $i;?>"  id="products_type_id" >
                                            <option value="0" >Chọn size</option>
                                            <?php
                                            foreach ($list_size as $item)
                                            {
                                                $checked = "";
                                                if($products_type_compare == $item->id )
                                                    $checked = "selected=\"selected\"";
                                                ?>
                                                <option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
                                                <?php
                                            }?>
                                        </select>

                                        <input type="hidden" name='products_type_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->size_id; ?>" />
                                    </td>

                                    <td valign="center"  class="left_col">
                                        <?php $colors_compare = isset($field->color_id)?$field->color_id:0; ?>
   
                                        <?php 
                                            TemplateHelper::dt_edit_selectbox('', 'color_id_exist_'.$i, @$field->color_id, 0, @$color, 'id', 'name', $size = 1, 1, 1);
                                        ?>
                                        <style>
                                            .left_col .control-label{
                                                width: 0px;
                                                display: none;
                                            }
                                            .left_col .col-md-9{
                                                width: 100%;
                                                display: block;
                                            }
                                        </style>

                                        <!-- <select name="color_id_exist_<?php echo $i;?>"  id="color_id" >
                                            <option value="0" >Chọn màu sắc</option>
                                            <?php
                                            foreach ($color as $item)
                                            {
                                                $checked = "";
                                                if($colors_compare == $item->id )
                                                    $checked = "selected=\"selected\"";
                                                ?>
                                                <option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
                                                <?php
                                            }?>
                                        </select> -->

                                        <input type="hidden" name='color_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->color_id; ?>" />
                                    </td>



                                    <td valign="center" class="left_col">
                                        <input type="text" name='price_exist_<?php echo $i;?>' value="<?php echo $field->price; ?>"/>
                                        <input type="hidden" name='price_exist_<?php echo $i;?>_begin' value="<?php echo $field->price; ?>" />
                                    </td>

                                    <td valign="center" class="left_col">
                                        <input type="text" name='price_h_exist_<?php echo $i;?>' value="<?php echo $field->price_h; ?>"/>
                                        <input type="hidden" name='price_h_exist_<?php echo $i;?>_begin' value="<?php echo $field->price_h; ?>" />
                                    </td>


                                    <td valign="center" class="left_col">
                                        <select name="is_published_exist_<?php echo $i;?>"   id='is_published_exist_<?php echo $i;?>' class='is_config_exist' >
                                            <option value="1" <?php if(@$field->published) echo "selected='selected'" ;?>  > Có</option>
                                            <option value="0" <?php if(!@$field->published) echo "selected='selected'" ;?>  >Không</option>
                                        </select>
                                        <input type="hidden" name='is_published_exist_<?php echo $i;?>_begin' value="<?php echo @$field->is_config; ?>" />
                                    </td>

                                    <td>
                                        <a href="javascript: void(0)" onclick="javascript: remove_extend_field(<?php echo $i?>,'<?php echo $field->id; ?>')" ><?php echo  FSText :: _("Remove")?></a>
                                    </td>
                                </tr>



                            <?php $i ++ ;?>
                        <?php }?>
                    <?php } ?>

                    <?php for( $i = 0 ; $i< 100; $i ++ ) {?>
                        <tr id="tr<?php echo $i; ?>" ></tr>
                    <?php }?>

                </table>
                <a style="color: #73c5fa;" href="javascript:void(0);" onclick="addField()" > <?php echo FSText :: _("Thêm sản phẩm"); ?> </a>
            </div>
        </fieldset>

        <!--	end FIELD	-->
        <input type="hidden" value="" name="field_remove" id="field_remove" />
    <?php if($type_save==2){ ?>
        <input type="hidden" value="<?php echo count($products) ?>" name="field_extend_exist_total" id="field_extend_exist_total" />
    <?php }else{ ?>
        <input type="hidden" value="0" name="field_extend_exist_total" id="field_extend_exist_total" />
    <?php } ?>

        <input type="hidden" value="" name="new_field_total" id="new_field_total" />

        <input type="hidden" value="0" name="boxchecked" />
<!--    --><?php //var_dump($list_size); ?>
<!--    <option value="0" >Chọn màu sắc </option>-->
<!--        <input type="hidden" value="--><?php //echo $max_ordering?><!--" name="max_ordering" id = "max_ordering" />-->
</div>
<!-- END BODY-->

<script>
    var i = 0;
    function   addField()
    {
        area_id = "#tr"+i;
        htmlString = "<td>";
        htmlString += "<select name='new_size_id_"+i+"'>";
        htmlString += "<option value='0'>Chọn size</option>";
        <?php foreach ($list_size as $item) { ?>
        htmlString += "<option value='<?php echo $item->id; ?>' ><?php echo $item->name;  ?></option>";
        <?php } ?>
        htmlString += "</select>";
        htmlString += "</td>";

        // htmlString = "<td>";
        // htmlString +=  "<input type=\"text\" name='new_products_type_id_"+i+"' id='new_products_type_id_"+i+"'  />";
        // htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<select  data-placeholder='Màu sắc' class='form-control chosen-select chosen-select-deselect-no-results' multiple='multiple' style='display: block;' id='new_color_id_"+i+"[]' name='new_color_id_"+i+"[]'>";
        // htmlString += "<option value='0' >Chọn màu sắc </option>";
            <?php foreach ($color as $item) { ?>
            htmlString += "<option value='<?php echo $item->id; ?>' ><?php echo $item->name;  ?></option>";
            <?php } ?>
        htmlString += "</select>";
        htmlString += "<p style='margin-top:5px'>Giữ Ctr để chọn nhiều</p>";
        htmlString += "</td>";
        //
        // htmlString += "<td>" ;
        // htmlString +=  "<input type=\"text\" name='new_quan_"+i+"' id='new_quan_"+i+"'  />";
        // htmlString += "</td>";

        htmlString += "<td>" ;
        htmlString +=  "<input type=\"text\" name='new_price_"+i+"' id='new_price_"+i+"'  />";
        htmlString += "</td>";
        
        // htmlString += "<td>" ;
        // htmlString +=  "<input type=\"text\" name='new_discount_"+i+"' id='new_discount_"+i+"'  />";
        // htmlString += "</td>";

        htmlString += "<td>" ;
        htmlString +=  "<input type=\"text\" name='new_price_h_"+i+"' id='new_price_h_"+i+"'  />";
        htmlString += "</td>";


        // htmlString += "<td class='text-center'>" ;
        // htmlString += "<img alt=\"image\" src=\"\" onerror=\"this.src='/images/not_picture1.png'\"/>" ;
        // htmlString +=  "<input style='margin: auto;padding-top: 15px' type='file' name='new_other_image_"+i+"'/>";
        // htmlString += "</td>";



        //htmlString += "<td>";
        //htmlString += "<select name='new_memory_id_"+i+"'>";
        //htmlString += "<option value=\"0\" >Chọn bộ nhớ </option>";
        <?php //foreach ($memory as $item) {?>
        //htmlString += "<option value=\"<?php //echo $item->id; ?>//\" ><?php //echo $item->name;  ?>//</option>";
        <?php //}?>
        //htmlString += "</select>";
        //htmlString += "</td>";

        //htmlString += "<td>";
        //htmlString += "<select name='new_origin_id_"+i+"'>";
        //htmlString += "<option value=\"0\" >Chọn tình trạng </option>";
        <?php //foreach ($origin as $item) {?>
        //htmlString += "<option value=\"<?php //echo $item->id; ?>//\" ><?php //echo $item->name;  ?>//</option>";
        <?php //}?>
        //htmlString += "</select>";
        //htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<select name='new_published_"+i+"' id='new_published_"+i+"' class='new_published'>";
        htmlString += "<option value=\"1\" selected='selected' >Có</option>";
        htmlString += "<option value=\"0\"  >Không</option>";
        htmlString += "</select>";
        htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field("+ i +")\" >" + " X&#243;a" + "</a>";
        htmlString += "</td>";

        $(area_id).html(htmlString);
        i++;
        $("#new_field_total").val(i);
    }

    //remove extend field exits
    function remove_extend_field(area,fieldid)
    {
        if(confirm("You certain want remove this fiels"))
        {
            remove_field = "";
            remove_field = $('#field_remove').val();
            remove_field += ","+fieldid;
            $('#field_remove').val(remove_field);
            $('#extend_field_exist_'+area).html("");
        }
        return false;
    }
    //remove new extend field
    function remove_new_field(area)
    {
        if(confirm("You certain want remove this fiels"))
        {
            area_id = "#tr"+area;
            $(area_id).html("");
        }
        return false;
    }

    function change_ftype(element){
        type_id = $(element).attr('id');
        foreign_id = type_id.replace("ftype","foreign_id");
        val = $(element).val();
        if(val == 'foreign_one' || val == 'foreign_multi'){
            $('#'+foreign_id).show();
        }else{
            $('#'+foreign_id).hide();
        }
    }

</script>
<style>
    .field_tbl select{
        width: 60px;
    }
    .field_tbl select.ftype_exist,.field_tbl select.new_ftype{
        width: 90px;
    }
    .field_tbl select.is_main_exist, .field_tbl select.new_is_main,
    .field_tbl select.is_filter_exist, .field_tbl select.new_is_filter,
    .field_tbl select.is_config_exist, .field_tbl select.new_is_config {
        width: 60px;
    }
</style>