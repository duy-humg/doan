function chebien(i){
    $( ".a-chebien-chung" ).removeClass( "active_chebien" );
    $( ".a-chebien-"+i ).addClass( "active_chebien" );
    $('#chebien').val(i);
}

function bl_moblie(){
    $(".menu_mobile_list").css("display", "block");
}
function no_moblie(){
    $(".menu_mobile_list").css("display", "none");
}

function submit_form_search_2() {


    url = '';
    var keyword = $( "#keyword_menu" ).val();
    var chebien = $( "#chebien" ).val();
    if(keyword){

    }else {
        alert('Bạn phải nhập tham số tìm kiếm');
        return false;
    }

    var link = link_search+'?'+keyword;

    window.location.href=link;
    return false;
}

$('.smt-seach-menu').click(function(){
    if(checkFormsubmit_menu())
        // alert(1);
        document.search_form_2.submit();
})
function checkFormsubmit_menu()
{
    $('label.label_error').prev().remove();
    $('label.label_error').remove();
    email_new = $('#email_new').val();

    if(!notEmpty("keyword_menu","Bạn chưa nhập từ khóa tìm kiếm"))
    {
        return false;
    }
    return true;
}