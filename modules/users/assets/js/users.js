$(document).ready(function () {
    $('#edit_pass').click(function() {
        if( $(this).is(':checked')) {
            $("#changepassword").show();
        } else {
            $("#changepassword").hide();
        }
    });

    $('.gpup').click(function () {
        $('#file2').click();
    });
    $('.lgup').click(function () {
        $('#file').click();
    });

});
function mualai(id){
    $("#mualai_"+id).submit();
}

function product_infor($id)

{
    // alert($id);
    // return false;
    $.ajax({
        type : 'get',
        url : '/index.php?module=users&view=order&task=ajax_load_infor&raw=1',
        dataType : 'html',
        data: {id:$id},
        success : function(data){
            // return false;
            $(".infor"+$id).html(data);
            $('.infor'+$id).removeAttr('disabled');
            $('.infor'+$id).removeClass('hidden');
            // $(this).click(function() {
            var h2 = $(".infor"+$id).position();
                $('html, body').animate({
                    scrollTop: h2.top
                }, 500);
                return false;

            // }); // left menu link2 click() scroll END

            return true;
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
    });
    return false;
    // } else {
    //     // Do nothing!
    // }

}
