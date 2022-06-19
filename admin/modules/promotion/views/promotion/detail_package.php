<div class="package_related">
    <div class="row">
        <div class="col-xs-12">
            <div class='package_related_search row'>
                <div class="row-item col-xs-6">
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Tìm kiếm tên sách hoặc tên tác giả" name='package_related_keyword' class="form-control" value='' id='package_related_keyword' />
                        <span class="input-group-btn">
                            <a id='package_related_search' class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-xs-12 col-md-6">
            <div class='title-related'><?php echo FSText::_('Danh sách sách'); ?></div>            
            <div id='package_related_l' >                
                <div id='package_related_search_list'>
                    <input type="hidden" value="<?php echo @$data->package_related ?>" id="str_related" name="str_related" />
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id='package_related_r'>
                <!--	LIST RELATE			-->
                <div class='title-related'><?php echo FSText::_('Sách'); ?></div>
                <ul id='package_sortable_related'>	
                    <?php
                    $i = 0;
                    if (isset($package_related))
                        foreach ($package_related as $item) {
                            ?>
                            <li id='package_record_related_<?php echo $item->id ?>'><?php echo $item->name; ?> 
                                <a class='package_remove_relate_bt'  onclick="javascript: remove_package_related(<?php echo $item->id ?>)" href="javascript: void(0)" title='Xóa'>
                                    <img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
                                </a> 
                                <!--<br />-->
                                <!--<img  width="80" src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>">-->
                                <input type="hidden" name='package_record_related[]' value="<?php echo $item->id; ?>" />
                            </li>
                        <?php } ?>
                </ul>
                <!--	end LIST RELATE			-->
                <div id='package_record_related_continue'></div>
            </div>
        </div>

        <!--<div class='package_close_related col-xs-12' style="display:none">
                    <a href="javascript:package_close_related()"><strong class='red'>Đóng</strong></a>
            </div>
            <div class='package_add_related col-xs-12'>
                    <a href="javascript:package_add_related()"><strong class='red'>Thêm sản phẩm liên quan</strong></a>
            </div> -->
    </div>
</div>
<script type="text/javascript" >
    search_package_related();
    $("#package_sortable_related").sortable();
    function package_add_related() {
        $('#package_related_l').show();
        $('#package_related_l').attr('width', '50%');
        $('#package_related_r').attr('width', '50%');
        $('.package_close_related').show();
        $('.package_add_related').hide();
    }
    function package_close_related() {
        $('#package_related_l').hide();
        $('#package_related_l').attr('width', '0%');
        $('#package_related_r').attr('width', '100%');
        $('.package_add_related').show();
        $('.package_close_related').hide();
    }
    $(document).ready(function () {
        var str_related = $('#str_related').val();
    var keyword_tag = $('#tags').val();
    if(keyword_tag){
      $("#package_related_search_list" ).load( "index2.php?module=promotion&view=promotion&task=ajax_get_package_related&raw=1",{"str_related":str_related,"keyword_tag":keyword_tag},function(){}); //load initial records  
    }
    
    $('textarea#tags').on('change',function(){
        //alert(123);
        var keyword_tag = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'index2.php?module=promotion&view=promotion&task=ajax_get_package_related&raw=1',
            data: {keyword_tag: keyword_tag,str_related:str_related},
            dataType: 'html',
            success: function(data) {
                $('#package_related_search_list').html(data);
            },
            error: function() {
                // code here
            }
        });
    
    });
    });
    function search_package_related() {
        $('#package_related_search').click(function () {
            var keyword = $('#package_related_keyword').val();
            var category_id = $('#package_related_category_id').val();
            var new_id = <?php echo @$data->id ? $data->id : 0 ?>;
            var str_exist = '';
            $("#package_sortable_related li input").each(function (index) {
                if (str_exist != '')
                    str_exist += ',';
                str_exist += $(this).val();
            });
            $.get("index2.php?module=promotion&view=promotion&task=ajax_get_package_related&raw=1", {new_id: new_id, category_id: category_id, keyword: keyword, str_exist: str_exist}, function (html) {
                $('#package_related_search_list').html(html);
            });
        });
    }
    function set_package_related(id) {
//        var max_related = 10;
//        var length_children = $("#package_sortable_related li").length;
//        if (length_children >= max_related) {
//            alert('Tối đa chỉ có ' + max_related + ' tin liên quan');
//            return;
//        }
        var title = $('.package_related_item_' + id).html();
        var html = '<li id="package_record_related_' + id + '">' + title + '<input type="hidden" name="package_record_related[]" value="' + id + '" />';
        html += '<a class="package_remove_relate_bt"  onclick="javascript: remove_package_related(' + id + ')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
        html += '</li>';
        $('#package_sortable_related').append(html);
        $('.package_related_item_' + id).hide();
    }
    function remove_package_related(id) {
        var str_related = $('#str_related').val();
        var keyword_tag = $('#tags').val();
        $('#package_record_related_' + id).remove();
        $('.package_related_item_' + id).show().addClass('red');
        $.ajax({
            type: 'POST',
            url: 'index2.php?module=promotion&view=promotion&task=ajax_get_package_related&raw=1',
            data: {id: id, str_related: str_related, keyword_tag: keyword_tag},
            dataType: 'html',
            success: function (data) {
                $('#package_related_search_list').html(data);
            },
            error: function () {
                // code here
            }
        });
    }
</script>
<style>
    .title-related{
        background: none repeat scroll 0 0 #F0F1F5;
        font-weight: bold;
        margin-bottom: 4px;
        padding: 2px 0 4px;
        text-align: center;
        width: 100%;
    }
    #package_related_search_list{
        height: 400px;
        overflow: scroll;
    }
    .package_related_item{
        border-bottom: 1px solid #EEEEEE;
        cursor: pointer;
        margin: 2px 10px;
        padding: 5px;
    }
    #package_sortable_related li{
        cursor: move;
        list-style: decimal outside none;
        margin-bottom: 8px;
    }
    .package_remove_relate_bt{
        padding-left: 10px;
    }
    .package_related table{
        margin-bottom: 5px;
    }
</style>