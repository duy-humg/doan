// $(document).ready(function () {
    // var $width = $(window).width();
    // var i = 0;
    // $width1 = $width + 2;
    // alert($width1);
    // $(".dropdown-menu").css('width', $width1);

var i = 0;
$('#btn-menu').click(function () {
        var $width = $(window).width();
        $width1 = $width + 2;
        // alert($width1);
        $(".dropdown-menu").css('width', $width1);

        i++;
        if (i % 2 != 0) {
            $('#btn-menu .close_bar').show();
            $('#btn-menu .open_bar').hide();
            // alert(1);
            $('.dropdown-menu').addClass('show-abcd');
            // $("#bg-opacity").addClass('bg-opacity');
            // $("#bg-opacity").addClass('bg-none');
            // $("#bg-opacity").css('display', 'none');
            // $('head').append('<style>.bg-opacity:after{height: ' + $height + 'px;}</style>');
            // $('#id-show-cart').hide();
            // $('.full').show();
            // $('#dots-show').hide();
            $('#show-menu').slideDown('300');
            // $('#btn-dots').attr('src', root + 'templates/mobile/images/icon_cham_top.png');
            // $(this).attr('src', root + 'templates/mobile/images/icon_show_menu_black.png');
        } else {
            $('#btn-menu .close_bar').hide();
            $('#btn-menu .open_bar').show();
            $('.dropdown-menu').removeClass('show-abcd');
            // $("#bg-opacity").removeClass('bg-opacity');
            // $("#bg-opacity").removeClass('bg-none');
            // $("#bg-opacity").css('display', 'block');
            $('#show-menu').slideUp('300');
            // $('.full').hide();

            // $(this).attr('src', root + 'templates/mobile/images/icon_show_menu.png');
        }
    });
// });
