<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/dropzone/dist/min/dropzone.min.css"/>
<link type="text/css" rel="stylesheet" media="all" href="../libraries/dropzone/fs/dropzone.css"/>


<script type="text/javascript" src="../libraries/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript" src="../libraries/uploadify/jquery.uploadify.js"></script>

<?php
if (!empty($id)) {
//    var_dump($prd_cl);
    $Itemid_detail = 31;
    $url = $_SERVER['REQUEST_URI'];
    $return = base64_encode($url);
    if (isset($data->id) && $data->id) {
        $uploadConfig = base64_encode('edit|' . $data->id);
    } else {
        $uploadConfig = base64_encode('add|' . session_id());
    }

    $arr_sku_map = array();
    $i = 0;
    foreach ($images as $item) {
        $arr_sku_map['Data'][$i]['AttachmentID'] = $item->id;
//				$arr_sku_map['Data'][$i]['size_id']=$item->size_id;
//				$arr_sku_map['Data'][$i]['FileName']=$item->name;
        $arr_sku_map['Data'][$i]['Path'] = URL_ROOT . str_replace('/original/', '/original/', $item->image);
        $arr_sku_map['Data'][$i]['ColorId'] = $item->color_id;
        $arr_sku_map['Data'][$i]['TypeId'] = $item->prd_type_id;
        $i++;
    }
    $skuConfig = json_encode($arr_sku_map);
    ?>
    <script>

        $(function () {
            $("#previews").sortable({
                update: function () {
                    serial = $("#previews").sortable("serialize");
                    $.ajax({
                        url: "index2.php?module=products&view=products&raw=1&task=sort_other_images",
                        type: "post",
                        data: serial,
                        error: function () {
                            alert("Lỗi load dữ liệu");
                        }
                    });

                }
            });

        });
        $(document).ready(function () {
            Dropzone.autoDiscover = false;
            var data = '<?php echo $skuConfig; ?>';
            var previewNode = document.querySelector("#template");
            var uploadConfig = $("#uploadConfig").val();
            previewNode.id = "";
            var previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);

            var myDropzone = new Dropzone(document.body, {// Make the whole body a dropzone
                //					autoProcessQueue: false,
                //					  uploadMultiple: true,
                //					  parallelUploads: 100,
                //					  maxFiles: 100,
                url: "index2.php?module=products&view=products&raw=1&task=upload_other_images&data=" + uploadConfig,
                thumbnailWidth: 100,
                thumbnailHeight: 100,
                parallelUploads: 20,
                previewTemplate: previewTemplate,
                autoQueue: true,
                previewsContainer: "#previews",
                clickable: ".fileinput-button",
                removedfile: function (file) {

                    var record_id = $("#id_mage").val();
                    $.ajax({
                        type: "POST",
                        url: "index2.php?module=products&view=products&raw=1&task=delete_other_image",
                        data: {"name": file.name, "record_id": record_id, "id": file.size}
                    });
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },

                //				  addedfile: function(file) {
                //					  console.log('vvv');
                //					    file.previewElement = Dropzone.createElement(this.options.previewTemplate);
                //					    // Now attach this new element some where in your page
                //					  },
                init: function () {
                    data = JSON.parse(data);
                    var thisDropzone = this;
                    if (data.Data != null) {
                        $.each(data.Data, function (index, item) {
                            var mockFile = {
                                name: item.FileName,
                                size: item.AttachmentID,
                                ColorId: item.ColorId,
                                size_id: item.size_id,
                            };
                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.emit("thumbnail", mockFile, item.Path);
                            thisDropzone.emit("complete", mockFile);

                            //	                                 console.log(mockFile);
                            // On the created element added the id property
                            $(mockFile.previewElement).prop("id", "sort_" + item.AttachmentID);
                            // $(mockFile.previewTemplate).find('.sizes').val(item.size_id);


                            $(mockFile.previewTemplate).find('#save').attr("data-id", item.AttachmentID);
                            if (item.ColorId) {
                                $(mockFile.previewTemplate).find('.dz-color').val(item.ColorId);
                                // alert(item.AttachmentID);
                                select_index = $('#sort_' + item.AttachmentID + ' .dz-color option:selected').index();
                            }
                            if (item.TypeId) {
                                $(mockFile.previewTemplate).find('.dz-prd_type').val(item.TypeId);
                                select_index = $('#sort_' + item.AttachmentID + ' .dz-prd_type option:selected').index();
                            }
                            //  color_code = $('#sort_'+item.AttachmentID+' .dz-color')[0].options[select_index].style.backgroundColor;
                            //	                       			 $(mockFile.previewTemplate).find('.dz-color').style.backgroundColor = color_code;
                            //    console.log($('#sort_'+item.AttachmentID+' .dz-color'));
                            // $('#sort_'+item.AttachmentID+' .dz-color').css('background-color', color_code);
                            //	                       			$('#sort_'+item.AttachmentID+' .dz-color').[0].style.backgroundColor = color_code;
                            //         							$(mockFile.previewTemplate).find('.dz-color').style.backgroundColor=$(mockFile.previewTemplate).find('.dz-color').options[select_index].style.backgroundColor;
                            //         							$(mockFile.previewTemplate).find('.dz-color').style.backgroundColor=$('#sort_'+item.AttachmentID+' .dz-color').options[select_index].style.backgroundColor;
                        });
                    }
                    this.on("success", function (file, response) {
                        response = JSON.parse(response);
                        file.previewElement.id = "sort_" + response.id;
                    });
                }
            });


        });

        function change_color(element) {
            value = $(element).val();
            parent_id = $(element).parent().attr('id');
            id = parent_id.replace("sort_", "");
            var uploadConfig = $("#uploadConfig").val();
            // alert(uploadConfig);
            $.ajax({
                type: "GET",
                url: "index2.php?module=products&view=products&raw=1&task=change_attr_image",
                data: {"field": "color", "data": uploadConfig, "id": id, "value_color": value}
            });
            element.style.backgroundColor = element.options[element.selectedIndex].style.backgroundColor;
        }

        function change_prd_type(element) {
            value = $(element).val();
            parent_id = $(element).parent().attr('id');
            id = parent_id.replace("sort_", "");
            var uploadConfig = $("#uploadConfig").val();
            // alert(uploadConfig);
            $.ajax({
                type: "GET",
                url: "index2.php?module=products&view=products&raw=1&task=change_attr_image",
                data: {"field": "prd_type", "data": uploadConfig, "id": id, "value_type": value}
            });
            element.style.backgroundColor = element.options[element.selectedIndex].style.backgroundColor;
        }

        function get_id_images(element) {
            parent_id = $(element).parent().attr('id');
            id = parent_id.replace("sort_", "");
            $(element).children("#save").attr("data-id", id);
        }


        function save_release(obj) {
            $(obj).children('img').attr('src', 'templates/default/images/toolbar/process.gif');
            $.ajax({
                url: 'index.php?module=products&view=products&task=save_release&raw=1',
                dataType: "json",
                data: {
                    id: $(obj).attr('data-id'),
                    size: $(obj).parent().children("#sizes").val(),
                },
                success: function (data) {
                    if (data.error == false)
                        $(obj).children('img').attr('src', 'templates/default/images/toolbar/save.png');
                }
            });
        }

        var a = "";

        function select_size(obj) {
            $(obj).attr("selected", "selected");
            a += "," + $(obj).attr("value");
            $(obj).parent().next().children().attr("size", a);
            $(obj).parent().next().next().children().attr("size", a);
        }
    </script>

    <input type="hidden" name="session_id" id="session_id" value="<?php
    $data2 = base64_decode($uploadConfig);
    $data2 = explode('|', $data2);
    echo $data2[1];
    ?>"/>
    <div class="dropzone files cf" id="previews">
        <div id="template" class="dz-preview dz-image-preview">
            <div class="dz-details" style="background-color: unset;">
                <img style="right: 0;margin: auto" data-dz-thumbnail/>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
            <a class="dz-remove" data-dz-remove id="">Remove</a>
            <!--             --><?php
            //                var_dump($prd_cl); ?>
<!--            <select class="dz-color" style="display: block; margin-top: 10px;padding: 3px; height: auto"-->
<!--                    onchange="javascript: change_color(this);">-->
<!--                <option value="0" style="">Chọn màu</option>-->
<!--                --><?php
//                if (@$color) {
//                    foreach ($color as $item) {
//                        ?>
<!--                        <option value="--><?//= $item->id ?><!--">--><?//= $item->name ?><!--</option>-->
<!--                    --><?php //} ?>
<!--                --><?php //} ?>
<!--            </select>-->
            <select class="dz-prd_type" style="display: block; margin-top: 10px;padding: 3px; height: auto"
                    onchange="javascript: change_prd_type(this);">
                <option value="0" style="">Chọn loại sản phẩm</option>
                <?php
                if (@$products_type) {
                    foreach ($products_type as $item) {
                        ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
    </div>
    <input type="hidden" value="<?php echo $uploadConfig; ?>" id="uploadConfig"/>
    <input type="hidden" value="<?php echo $id; ?>" id="id_mage"/>
    <span class="post_images fileinput-button">Thêm ảnh/video</span>

<?php } else { ?>
    <h3 style="color: #ff0000;"><?php echo FSText::_('Sau khi apply có thể nhập thêm ảnh'); ?></h3>
<?php } ?>