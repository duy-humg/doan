<?php
global $tmpl;
$tmpl->addStylesheet('dropzone', 'plugins/comments/css');
$tmpl->addScript('dropzone', 'plugins/comments/js');
$tmpl->addScript('delete_file', 'plugins/comments/js');

$Itemid_detail = 31;
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);
//if (isset($data->id) && $data->id) {
//    $uploadConfig = base64_encode('edit|' . $data->id);
//} else {
$uploadConfig = base64_encode('add|' . session_id());
//}

?>
<script>
    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
        init: function () {
            this.on("addedfile", function (file) {
                var id = $('#id_mage').val();
                // Create the remove button
                var removeButton = Dropzone.createElement("<a class='dz-remove'>x</a>");


                // Capture the Dropzone instance as closure.
                var _this = this;

                // Listen to the click event
                removeButton.addEventListener("click", function (e) {
                    // Make sure the button click doesn't submit the form:
                    e.preventDefault();
                    e.stopPropagation();

                    // Remove the file preview.
                    _this.removeFile(file);
                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                    $.ajax({
                        type: "POST",
                        url: "/index.php?module=contact&view=contact&raw=1&task=deleteFile",
                        data: {'name': file.name, 'id': id}
                    });
                });
                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);
            });
        }
    };

</script>

<div class="ratingg">
    <form id="my-dropzone"
          action="<?php echo URL_ROOT ?>index.php?module=products&view=product&raw=1&task=data_upload_file&data=<?php echo $uploadConfig; ?>"
          class="dropzone form_dropzone clearfix" enctype="multipart/form-data" style="margin:0 0px 10px;">


        <p class="tiltle_up">
            <?php echo FSText::_('Thêm hình sản phẩm nếu có( tối đa 5 hình):'); ?>
        </p>
        <input type="hidden" value="<?php echo $uploadConfig; ?>" id="uploadConfig"/>
        <input type="hidden" value="<?php echo @$data->id; ?>" id="id_mage"/>
        <input type="hidden" value="<?php echo FSText::_('Tải lên'); ?>" id="not_dinhkem"/>
    </form>


</div>


