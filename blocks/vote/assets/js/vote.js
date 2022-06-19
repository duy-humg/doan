$(document).ready(function () {
    
    $("#close-cart").click(function () {
        $(".wrapper-popup-2").hide();
        $(".full").hide();
    });

    $(".full").click(function () {
        $(".wrapper-popup-2").hide();
        $(".full").hide();
    });
 
});
function get_vote(){
    $.ajax({
            type : 'GET',
            dataType: 'html',
            url : '/index.php?module=contact&view=contact&raw=1&task=view_vote',
            success : function(data){
                $("#wrapper-popup-2").html(data);
                ajax_pop_cart();
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert('There is an error in the process of bringing up the server. Would you please check the connection.');
            }
    });
    $(".wrapper-popup-2").show();
    $(".full").show();			
}

function ajax_pop_cart(){
	  $("#close-cart").click(function(){
		$(".wrapper-popup-2").hide();
		$(".full").hide();
	});
}