function th(id) {
    // alert(1);
    $('#th_'+id).click();
}
function nd(id) {
    $('#nd_'+id).click();
}
$(document).ready( function(){
    var loc = $("#loc_sp").val();
    if(loc==1){
        scrollTop('.carousel-indicators');
    }
    
});
function scrollTop(name) {
    if (!name)
        return false;
    $(name).focus();
    //var top_ = $(name).position().top;
    var offset = $(name).offset();
    $('html, body').animate({
        scrollTop: offset.top
    }, 'slow');
}