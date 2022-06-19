$(document).ready(function(){
	click_menu();
});	

function click_menu(){
	$('.h2_0').click(function(){
		var wrapper_child = $(this).next('ul');
		if(wrapper_child.hasClass('hiden')){
			wrapper_child.removeClass('hiden');
		}else{
			wrapper_child.addClass('hiden');
		}
//		if($(this).hasClass('close')){
//			$(this).removeClass("close");
//			$(this).addClass("open");
//			$(this).next("ul").stop(true,true).show(200);
//		}else{
//			$(this).addClass("close");
//			$(this).removeClass("open");
//			$(this).next("ul").hide(200);
//		}
	});
}
