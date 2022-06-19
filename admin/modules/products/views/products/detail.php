<?php  if($type_save==1){ ?>
    <p><a  style="font-size: 24px;color: #333333;text-decoration: none" onclick="unset()" href="#">Chọn lại danh mục</a></p>
<?php } ?>

<script type="text/javascript">
    function unset() {


        $.ajax({
            url: "index.php?module=products&view=products&task=unset_dm&raw=1",
            type: 'GET',
            data: '',
            dataType: 'html',
            success: function ($html) {


            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
            }
        });
        location.reload()
    }
</script>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<!-- FOR TAB -->	
<script>
    $(document).ready(function () {
        $("#tabs").tabs();
    });
</script>
<?php
$title = @$data ? FSText :: _('Edit') : FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText :: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText :: _('Cancel'), '', 'cancel.png');
$this->dt_form_begin(0);
?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Tr&#432;&#7901;ng c&#417; b&#7843;n"); ?></span></a></li>
<!--        <li><a href="#fragment-2"><span>--><?php //echo FSText::_("Image"); ?><!--</span></a></li>-->
        <li><a href="#fragment-4"><span><?php echo FSText::_("Sản phẩm phụ"); ?></span></a></li>
<!--        <li><a href="#fragment-3"><span>--><?php //echo FSText::_("Xem trước"); ?><!--</span></a></li>-->
    </ul>

    <!--	BASE FIELDS    -->
    <div id="fragment-1" class="clearfix">
        <?php include_once 'detail_base.php'; ?>
    </div>
<!--    <div id="fragment-2">-->
<!--        --><?php //include_once 'detail_images.php';?>
<!--    </div>-->
    <div id="fragment-4">
        <?php include_once 'detail_product.php';?>
    </div>
<!--    <div id="fragment-3">-->
<!--        --><?php //include_once 'see_first.php'; ?>
<!--    </div>-->
</div>
<?php
$this -> dt_form_end(@$data,0,1);
//$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo');
//$this->dt_form_end(@$data, 1, 0, 2, 'Cấu hình seo', '', 1, 'col-sm-4');
?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator()
    {
        $('.alert-danger').show();

        if (!notEmpty('name', 'Bạn phải nhập tiêu đề'))
            return false;


        if (!notEmpty('category_id', 'Bạn phải chọn danh mục'))
            return false;

        $('.alert-danger').hide();
        return true;
    }


</script>
