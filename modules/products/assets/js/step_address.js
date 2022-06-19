$(document).ready(function () {

    $('#submitbt_pay').click(function(){
        // alert(1);
        if(checkFormsubmit_pay())
            document.form_pay_code.submit();
    });
    $('#submitbt_pay_m').click(function(){
        // alert(1);
        if(checkFormsubmit_pay())
            document.form_pay_code.submit();
    });
    
    if($('#add_address').is(":hidden") ){
        $('#add_address').find('input').attr('required', false);
        $('#add_address').find('select').attr('required', false);
    }
    
    if($('#has_expost').is(":hidden") ){
        $('#has_expost').find('input').attr('required', false);
        $('#has_expost').find('select').attr('required', false);
    }
    if ($('#same_address').is(":checked") == true){
        $('#add_same_address').hide();
        $('#add_same_address').find('input').attr('required', false);
        $('#add_same_address').find('select').attr('required', false);
    }
        
    $("input[name$='add_other']").click(function() {
        var test = $(this).val();
        if(test == 'add'){
            $("#add_address").show();
            $('#add_address').find('input').attr('required', true);
            $('#add_address').find('select').attr('required', true);
        }else{
            $("#add_address_click").removeClass('add_address_active');
            $("#add_address").hide();
            $("#add_address").hide();
            $('#add_address').find('input').attr('required', false);
            $('#add_address').find('select').attr('required', false);
            $('#add_address_input').val(0);
        }
    });
    $('#same_address').change(function () {
        if ($(this).is(":checked") == true){
            $('#add_same_address').hide();
            $('#add_same_address').find('input').attr('required', false);
            $('#add_same_address').find('select').attr('required', false);
        }else{
            $('#add_same_address').show();  
            $('#add_same_address').find('input').attr('required', true);
            $('#add_same_address').find('select').attr('required', true);
        }
    });
    
    $('#expost').change(function () {
        if ($(this).is(":checked") == true){
            $('#has_expost').show();
            $('#has_expost').find('input').attr('required', true);
        }else{
            $('#has_expost').hide();
            $('#has_expost').find('input').attr('required', false);
        }
    });
    $('.home2').change(function () {
        if ($(this).val() == 'nhận tại nhà'){
            $('#store_select').hide();
            $('#layhang').hide();
            $('#giaohang').show();
            $('input[name=hinhthuc]').prop('checked', false);
            $('#ghtktc').prop('checked', true);

            // $('#has_expost').find('input').attr('required', true);
        }else{
            $('input[name=hinhthuc]').prop('checked', false);
            $('#store_select').show();
            $('#layhang').show();
            $('#giaohang').hide();
            $('#vtpost').prop('checked', true);

            // $('#has_expost').find('input').attr('required', false);
        }
    });
    if ($("#add_other").is(":checked") == true){
        $("#add_address").show();
        $('#add_address').find('input').attr('required', true);
        $('#add_address').find('select').attr('required', true);
    }else{
        $('#add_address').hide();
        $('#add_address').find('input').attr('required', false);
        $('#add_address').find('select').attr('required', false);
    }
});
$("#add_address_click").click(function () {
    $("#add_address").show();
    $("#add_address_click").addClass('add_address_active');
    $('input[name=add_other]').prop('checked', false);
    $('#add_address_input').val(1);
});

function check_call() {
    if ($('#call_member').is(":checked") == true) {
        $('.form-call').show();
    }
    else $('.form-call').hide();
}

function yesnoCheck(cod) {
    if(cod == 1 || cod == 2 || cod == 4){
        $('#nganhang').removeClass('in');
        $('#nganhang').attr('aria-expanded','false')
    }

    if(cod == 1 || cod == 3 || cod == 4){
        $('#list_nganhang').removeClass('in');
        $('#list_nganhang').attr('aria-expanded','false')
    }
    $('#pay_book').val(cod);
    $('.a_pay').removeClass('active_payment');
    $('.a_pay_'+cod).addClass('active_payment');
}

$(".option_item_pay").click(function () {
    item_pay = $(this).attr("va");
    $('#pay_item').val(item_pay);
    $('.option_item_pay').removeClass('active_pay');
    $(this).addClass('active_pay');
});

$('[name="pay_book"]').click(function () {
    if ($(this).is(":checked") == true) {
        name = $(this).attr('data-name');
        $('.httt').html(name);
    }
    height = $('.httt').height();
    $('.l_httt').height(height);
    $('.change_payment').height(height);
});

function loadstoreinfor($store_id)
{
    // console.log($city_id);
    // alert($store_id);
    $.ajax({
            type : 'get',
            url : '/index.php?module=users&view=address&raw=1&task=ajax_load_storeinfor',
            dataType : 'html',
            data: {store_id:$store_id},
            success : function(data){
                $('#myModal').modal('hide');
// alert(data['store']);
                $("#store_infor").html(data);
                $('#store_selected').val($store_id);
                return true;
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {}
    });
    return false;
}

$("#city").change(function () {
    $.ajax({
        url: "index.php?module=products&view=cart&task=ajax_get_districs&raw=1",
        type: 'GET',
        data: {cities_id: $(this).val()},
        dataType: 'html',
        success: function ($html) {
            $("#district").html($html);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
});

$("#district").change(function () {
    $.ajax({
        url: "index.php?module=products&view=cart&task=ajax_get_ward&raw=1",
        type: 'GET',
        data: {district_id: $(this).val()},
        dataType: 'html',
        success: function ($html) {
            $("#ward").html($html);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
});

function checkFormsubmit_pay()
{
    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

    check_add = $('#add_address_input_new').val();
    check_add_2 = $('#add_address_input').val();
    if(check_add==1 || check_add_2 == 1){
        if(!notEmpty("name","Bạn chưa nhập họ và tên"))
        {
            return false;
        }

        if(!lengthMin("name",6,'"Họ tên đầy đủ của bạn" phải 6 kí tự trở lên, vui lòng sửa lại!'))
        {
            return false;
        }


        if(!notEmpty("telephone","Bạn chưa nhập số điện thoại")){
            return false;
        }
    
        // if(!emailValidator("email","Emal không đúng định dạng")){
        //     return false;
        // }

        if(!notEmpty("city","Bạn chưa chọn tỉnh/thành phố"))
        {
            return false;
        }

        if(!notEmpty("district","Bạn chưa chọn quận/huyện"))
        {
            return false;
        }
        if(!notEmpty("ward","Bạn chưa chọn phường/xã"))
        {
            return false;
        }
        if(!notEmpty("address","Vui lòng nhập địa chỉ chi tiết"))
        {
            return false;
        }
        
    }
    return true;
}
