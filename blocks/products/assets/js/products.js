$(document).ready(function () {
   $('.sider-slick-add').slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 6,
        arrows: true,
        dots: false,
        responsive: [
            {
                breakpoint: 350,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    // dots: true,
                }
            },
            {
                 breakpoint: 767,
                 settings: {
                      slidesToShow: 2,
                      slidesToScroll: 2,
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
