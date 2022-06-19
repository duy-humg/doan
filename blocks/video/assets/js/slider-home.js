$(document).ready(function() {
      //scroll_tab();  
      $('.video-gallery').lightGallery({
        loadYoutubeThumbnail: true,
        youtubeThumbSize: 'default',
        loadVimeoThumbnail: true,
        vimeoThumbSize: 'thumbnail_medium',
      }); 
      
      $(".click-show").click(function(){
        $(".show-video").toggleClass("hide");

        var element = $(this);
        if (element.hasClass('active')) {
            element.html('Xem thêm video khác').removeClass('active');
        }else{
            element.html('Ản video').addClass('active');
        }
    });
    
    //$(".column-add").sticky({ topSpacing: 30,bottomSpacing: 800 });
});
