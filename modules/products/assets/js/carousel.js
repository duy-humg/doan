$(document).ready(function() {
  // window.prettyPrint && prettyPrint();
  $('#imageGallery').lightSlider({
      gallery:true,
      item:1,
      vThumbWidth:80,
      thumbItem:5,
      slideMargin:0,
      onSliderLoad: function(el) {
        el.lightGallery({
          selector: '#imageGallery.lslide'
        });
      }
    });  

  // $('#imageGallery').lightSlider({
  //   gallery: true,
  //   item: 1,
  //   vThumbWidth: 80,
  //   thumbItem: 5,
  //   thumbMargin: 12,
  //   slideMargin: 0,
  //   responsive: [{
  //   breakpoint: 480,
  //   settings: {
  //       thumbItem: 3,
  //       verticalHeight: 300,
  //     }
  //   }],

  //   onSliderLoad: function(el) {
  //     el.lightGallery({
  //       selector: '#imageGallery.lslide'
  //     });
  //   }
  // });

  $('#imageGallery').lightGallery({
    thumbnail: false,
  });
});
