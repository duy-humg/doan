$(document).ready(function () {
   $('.sider-slick-cat').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        responsive: [
            {
                 breakpoint: 767,
                 settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1,
                      // dots: true,
                 }
            },
            {
                 breakpoint: 900,
                 settings: {
                      slidesToShow: 2,
                      slidesToScroll: 2,
                      // dots: true,
                 }
            }
       ]
    });
});
