$(document).ready(function() {            
      scroll_tab(); 
      //moveScroller(); 
});

function scroll_tab(){
    var offser = $('.video-default').offset();
    var offser_of_partner = $('.bottom-block').offset();
	$(window).scroll(function () {
	    //var offser_of_ = $('#hidden_tabs').offset();
		var scrolltop = $(window).scrollTop();
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop() + 400;       
        
        //&& (offser_of_partner.top - 150) >= scrolltop
		if (offser.top <= scrolltop  && window.innerWidth > 768 && offser_of_partner.top <= scrollBottom ) {
            $('.video-default').css({
                position: 'fixed',
                top: '0px',
                width: '270px',
            });
            
            $('.staff-default').css({
                position: 'fixed',
                top: '235px',
                width: '270px',
            });
            
        }else{
            $('.video-default,.staff-default').attr("style", "position: relative;");
        }

	});
}
