$(document).ready(function($){
//	$('#megamenu').dcMegaMenu({
//		rowItems: '3',
//		speed: '1'
//	});
	pos_right_megamenu = $('#megamenu').offset().left+$('#megamenu').width();
	padding = 20;
	$('#megamenu .level_0').mouseover(function(){
		$(this).addClass('hover');
		e_left =  $(this).offset().left;
		hightlight_child = $(this).find('.highlight');
		if(hightlight_child){
			e_width =  hightlight_child.width();
			if((e_left + e_width ) < pos_right_megamenu ){
				hightlight_child.css('left',-150);
			}else{
				chil_left =  0 - e_left -  e_width + pos_right_megamenu - padding;
				hightlight_child.css('left',chil_left);
			}
		}
		
		$(this).find('.highlight').show();
		
	}).mouseout(function(){
		$(this).removeClass('hover');
		$(this).find('.highlight').hide();
	});
});