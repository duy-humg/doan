var proLightSlider;
$(document).ready(function () {

    // $('.a-mua').click(function(){
	
    //     document.buy_now.submit();
	// })

    nd_height = $( ".nd_height" ).height();
    if(nd_height<500){
        // alert(1);
        $( ".content-nd" ).removeClass('boxdesc');
        $( ".more-thugon" ).css('display','none');
        $( ".content-nd" ).css('height','auto');
        $( ".content-nd" ).attr('id','');
    }


    $('#imageGallery').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        nav:true,
        thumbItem:5,
        slideMargin:50,
        enableDrag: false,
        currentPagerPosition:'left',
        
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        },
        // responsive:{
        //     0:{
                
        //     },
        //     600:{
        //         gallery:true,
        //     },
        //     1000:{
        //         gallery:true,
        //     }
        // }
    });

    $('.content_upcoming').owlCarousel({
        loop:true,
        margin:67,
        dots:false,
        nav:true,
        autoplay:true,
        autoplayTimeout:6000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:3
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    })

    $(".upcoming .content_upcoming .owl-nav .owl-prev").html("<img src=\"modules/products/assets/images/left.png\" alt=\"\">")

    $(".upcoming .content_upcoming .owl-nav .owl-next").html("<img src=\"modules/products/assets/images/next.png\" alt=\"\">")

    // click_color();
    // click_type();
    yesnoCheck();
    $(".quantity-input-up").click(function () {
        var quan_sub = $('#quantity_sub').val();
        var valid = $(this).attr('data-id');
        var inpt = $(this).parents(".custom-quantity-input").find('[id="' + valid + '"]');
        var val = parseInt(inpt.val());
        if (val < 0) inpt.val(val = 1);
        inpt.val(val + 1);
        if ((val + 1) > quan_sub) {
            alert('Vượt quá số lượng sản phẩm có sẵn')
            return false;
        }
        $('.check' + valid).html(val + 1);
        $('input[name="quantity"]').val(val + 1);

    });

    $('.color_vina_click').on('click', function() {
        // alert(1);
        $('.color_vina_click.active').removeClass('active');
        var name_color = $(this).attr("name-item");
        var id_color = $(this).attr("color_id");
        // alert(2);
        $(this).addClass('active');


        $("#color_id_vinashoes").val(id_color);
        // alert(1);

    });

    $('.a-option_size').on('click', function() {
        // alert(1);
        $('.a-option_size.active').removeClass('active');
        var name_size = $(this).attr("name-item-size");
        var id_size = $(this).attr("size_id");

        $(this).addClass('active');
        // $('#info_size b').html(name_size);
        $("#size_id_vinashoes").val(id_size);

    });

    $(".quantity-input-down").click(function () {

        var valid = $(this).attr('data-id');
        var inpt = $(this).parents(".custom-quantity-input").find('[id="' + valid + '"]');
        var val = parseInt(inpt.val());
        if (val < 1) inpt.val(val = 1);
        if (val == 1) return;
        inpt.val(val - 1);
        $('.check' + valid).html(val - 1);


        $('input[name="quantity"]').val(val - 1);

    });
    $(".clickmore").click(function () {

        var id = $(this).attr("data-id");

        var less = $(this).attr("data-class");
// alert(id);

        if (less == 1) {

            $("#" + id).height("auto");

            $(this).html("Thu gọn <i class='fa fa-angle-up'></i>");

            $(this).removeAttr("data-class");

        } else {

            var height = $("#" + id).attr("data-height");

            $("#" + id).height(height);

            $(this).html("Xem thêm");

            $(this).attr("data-class", "1");
        }
    });

});



$(".clickmore").click(function () {
    var id = $(this).attr("data-id");
    var less = $(this).attr("data-class");
    if (less == 1) {
        $("#" + id).height("auto");
        $(this).html("Thu gọn");
        $(this).removeAttr("data-class");
    }
    else {
        var height = $("#" + id).attr("data-height");
        $("#" + id).height(height);
        $(this).html("Xem thêm");
        $(this).attr("data-class", "1");
    }

});
function list_color(id,id_sp) {

    price =  $(".option_size_price"+id).attr("size_price");
    price_old =  $(".option_size_price"+id).attr("size_price_old");
    dis =  $(".option_size_price"+id).attr("size_dis");
    if(price_old){
        $(".infor-price_ .price_old").html(price_old);
    }
    if(dis){
        $(".infor-price_ .p-giamgia").html(dis);
    }
    if(price){
        $(".infor-price_ .infor-price").html(price);
    }

    color_id =  $("#color_id_vinashoes").val();
   
    // console.log(price

    // alert(1);
    $.ajax({
        url: "index.php?module=products&view=product&task=ajax_list_color&raw=1",
        type: 'GET',
        data: {size_id: id,id_sp: id_sp,color_id:color_id},
        dataType: 'html',
        success: function ($html) {
            $("#lis_clor").html($html);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.');
        }
    });
}

function check($id) {
    var a = '#check_' + $id;
    total_money =  $('#total_money_muacung').val();
    id_muacung =  $('#id_muacung').val();



    if ($(a).prop('checked')) {
        $(".bao-item-sp-"+ $id).css("opacity", "1");
        arr_id = id_muacung + $id+',',
            $('#id_muacung').val(arr_id);
        money =  $('#money-muacung-'+$id).val();
        cong = parseInt(total_money)+parseInt(money);

        moth_format = cong;
        var moth_format = moth_format.toString();
        var format_money = "";
        while (parseInt(moth_format) > 999) {
            format_money = "," + moth_format.slice(-3) + format_money;
            moth_format = moth_format.slice(0, -3);
        }
        moth_format = moth_format + format_money;
        moth_format = moth_format + ' đ';
        // alert(cong);
        $('#total_money_muacung').val(cong);
        $('.p-total-money span').html('<span>'+moth_format+'</span>');
    } else {

        $(".bao-item-sp-"+ $id).css("opacity", "0.5");
        money =  $('#money-muacung-'+$id).val();
        id_re = $id+',';

        let result = id_muacung.replace(id_re, "");

        $('#id_muacung').val(result);


        tru = parseInt(total_money)-parseInt(money);

        moth_format = tru;
        var moth_format = moth_format.toString();
        var format_money = "";
        while (parseInt(moth_format) > 999) {
            format_money = "," + moth_format.slice(-3) + format_money;
            moth_format = moth_format.slice(0, -3);
        }
        moth_format = moth_format + format_money;
        moth_format = moth_format + ' đ';
        // alert(tru);
        $('#total_money_muacung').val(tru);
        $('.p-total-money span').html('<span>'+moth_format+'</span>');
    }
}

$(".item_price_2_color").click(function () {


    var size   = $('#size_id_vinashoes').val();
    var color = $(this).attr("color_id");
    id_color   = $('#color_id_vinashoes').val(color);
    // alert(color)
    // console.log(color_2);
    var id_shop    = $('#product_id').val();
    $.ajax({

        type: 'GET',
        url: '/index.php?module=products&view=product&raw=1&task=get_price_shop&id='+ id_shop + '&color=' + color + '&size=' + size,
        dataType : 'html',
        success : function(data){

            $("#price_vinashoes").html(data);
            // $('#district').removeAttr('disabled');
            return true;
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
    });
});

// $(".a-option_size").click(function () {

//     var color   = $('#color_id_vinashoes').val();
//     alert(color);
//     var size   = $(this).attr("size_id");
//     // var color_2 = $(this).attr("color_id");
//     // console.log(color_2);
//     var id_shop    = $('#product_id').val();
//     $.ajax({

//         type: 'GET',
//         url: '/index.php?module=products&view=product&raw=1&task=get_price_shop&id='+ id_shop + '&color=' + color + '&size=' + size,
//         dataType : 'html',
//         success : function(data){

//             $("#price_vinashoes").html(data);
//             // $('#district').removeAttr('disabled');
//             return true;
//         },
//         error : function(XMLHttpRequest, textStatus, errorThrown) {}
//     });
// });

$(".item_price").click(function () {
    // alert(1);
    // click_color();
    // click_szie();
    var id_main = $("#product_id").val();
    $('#quantity_' + id_main).html(1);
    $('#quantity_' + id_main).val(1);
    var item = $(this).attr("data");
    var name = $(this).attr("name");
    var title = $(this).attr("name-item");
    $("." + item).removeClass("active2");
    $(this).addClass("active2");


    // var color = $('.color .active2').attr("color_id");

    var products_type = $('.products_type .active2').attr("products_type_id");
    // alert(products_type);

    // if (!color) {
    //     color = 0;
    // }
    if (!products_type) {
        products_type = 0;
    }

    // $('#color_input').val(color);
    $('#products_type_input').val(products_type);
    // $('#color_input_buynow').val(color);
    $('#products_type_input_buynow').val(products_type);
    // $('#memory_input').val(memory);

    product = $('#products_sub').val();
// alert(product);
    product = eval(product);
    // alert(product);
    var price = 0;
    var price_old = 0;
    var discount = 0;
    var quan = 0;
    var id = 0;
    for (var i = 0; i < product.length; i++) {
        if (products_type == product[i].id) {
            id = product[i].id;
            price = product[i].price;
            price_old = product[i].price_old;
            discount = product[i].discount;
            quan = product[i].quantity;
            break;
        }
    }

    // alert(quan);
    // alert(price_old);
    $('.quan_sub').html(quan);
    $('#quantity_sub').val(quan);
    $('#id_sub').val(id);
    // $('#quan_input').val(0);
    if (quan > 0) {
        $('.quantt').html('<p class="quant">Còn hàng</p>');
    } else if (quan == 0) {
        $('.quantt').html('<p class="out_of_stock">Hết hàng</p>');
    }

    if (price == 0) {
        price = 'Liên hệ';
        $('#price_input').val(0);
        $('#price_input_buynow').val(0);
    }
    else {
        $('#price_input').val(price);
        $('#price_input_buynow').val(price);
        // giamgia=0;
        // if (price_old > 0 && discount > 0){
        //     giamgia = 100 - price/price_old*100;
        //     $('.giatien .p-giamgia').html(price_old);
        // }

        // alert(price);
        var price = price.toString();
        var format_money = "";
        while (parseInt(price) > 999) {
            format_money = "." + price.slice(-3) + format_money;
            price = price.slice(0, -3);
        }
        price = price + format_money;
        price = price + ' đ';
// alert(price);
    }

    $('.infor-price').html(price);
    // $('.price_modal').html(price);

    if (price_old > 0 && discount > 0) {

        var price_old = price_old.toString();
        // alert(price_old);
        var format_money = "";
        while (parseInt(price_old) > 999) {
            format_money = "." + price_old.slice(-3) + format_money;
            price_old = price_old.slice(0, -3);
        }
        price_old = price_old + format_money;
        price_old = price_old + ' đ';
        // alert(price_old);
        $('.giatien .price_old').html(price_old);
        // alert(price_old);
        $('.giatien .p-giamgia').hidden();
        $('.giatien .p-giamgia').css("display", "none");

    } else {
        price_old = '';
        $('.giatien .price_old').html(price_old);


    }
    var color_id = $('.color .active2').attr("color_id");

    var type_id = $('.products_type .active2').attr("products_type_id");
    // alert(type_id);
    // $('.price_old').html(price_old1);
    // var type_id = $(this).attr("products_type_id");
    // alert(type_id);

    // var color_id = $(this).attr("color_id");
    // alert(color_id);

    // if (color_id && !type_id) {
    //     color_id = "color-" + color_id;
    //     $('.lSGallery .' + color_id).click();
    // } else if(!color_id && type_id) {
    type_id = "type-" + type_id;
    $('.lSGallery .' + type_id).click();
    // }else if(color_id && type_id) {
    //     type_id = "type-" + type_id;
    //     color_id = "color-" + color_id;
    //     $('.lSGallery .' + color_id + '.' + type_id).click();
    // }

    proLightSlider.goToSlide($('#imageGallery .active').index());
});
// click_color();
// click_type();
// function click_color() {
//     $('.color_click').click(function () {
//         var color_id = $(this).attr("color_id");
//         color_id = "color-" + color_id;
// // alert(color_id);
//         // $('.color_rm').hide();
//         $('.' + color_id).show();
//         $('.color_rm').removeClass('active');
//         // $('.undefined').removeClass('active');
//         $('.' + color_id).addClass('active');
//
//         proLightSlider.goToSlide($('.active').index());
//     })
// }
// function click_type() {
//     $('.products_type_click').click(function () {
//         alert(2);
//         var type_id = $(this).attr("products_type_id");
//         type_id = "type-" + type_id;
// // alert(type_id);
//         // $('.color_rm').hide();
//         $('.' + type_id).show();
//         $('.color_rm').removeClass('active');
//         // $('.undefined').removeClass('active');
//         $('.' + type_id).addClass('active');
//
//         proLightSlider.goToSlide($('.active').index());
//     })
// }
$(window).bind("pageshow", function () {

    $("input[name='checkbuy']").prop("checked", true);
});
$(document).ready(function () {

    setTimeout(function () {
        var product_id = $('#product_id').val();
        $.get("/index.php?module=products&view=product&task=update_hits&raw=1", {id: product_id}, function (status) {
        });
    }, 3000);

    var maxHeight = 0;
    if ($('.all_info_product').height() > maxHeight) {
        maxHeight = $('.all_info_product').height();
    }
    $(".price_product_pc").height(maxHeight);
});

$(document).scroll(function () {
    // if ($(this).scrollTop() > 225) {
    //     if ($('.fix_scroll').offset().top + $('.fix_scroll').height() >= $('.list_products').offset().top - 10)
    //         $('.fix_scroll').css({'position': 'absolute', 'width': '533px', 'bottom': 0, 'top': 'auto'});
    //
    //     if ($(document).scrollTop() + $('.fix_scroll').height() < $('.list_products').offset().top)
    //         $('.fix_scroll').css({'position': 'fixed', 'width': '533px', 'top': 0, 'bottom': 'auto'});
    // } else {
    //     $('.fix_scroll').css({'position': 'relative', 'top': 'auto', 'bottom': 'auto'});
    // }
});

$('.p37').click(function () {
    user = $('#user_id').val();
    if (!user) {
        alert('Bạn phải đăng nhập để sử dụng tính năng này');
        return false;
    }
})

function scroll_info() {
    $('html, body').animate({
        scrollTop: $('#thong-tin-chi-tiet').offset().top
    }, 1500);
}
function muacung() {
    id_muacung = $('#id_muacung').val();
    if (id_muacung) {

    }else {
        alert('Chưa có sản phẩm nào được chọn');
        return false;
    }

    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=products&view=product&raw=1&task=buy_muacung',
        data: "id_muacung=" + id_muacung,
        success: function (data) {

            if (data.length == 702) {
                $("#wrapper-popup-2").html(data);
                ajax_pop_cart();
                // del_cart();
                $(".wrapper-popup-2").show();
                $(".full").show();
                return false;
            } else {
                $("#wrapper-popup").html(data);
                ajax_pop_cart();
                // del_cart();
                $(".wrapper-popup").show();
                $(".buy_mobile_popup").hide();
                $(".full").show();
            }
            $('#quantity_' + $id_pro).html(1);
            $('#quantity_' + $id_pro).val(1);
        }
    });
}


function order($id_pro) {

    check_conhang = $('#check_conhang').val();
    if (check_conhang == 0) {
                alert('Sản phẩm đã hết hàng');
                // scrollTop('.products_type_item ');
                return false;
    }
    // if (products_type_count && products_type_count != 0) {
    //     products_type = $('#products_type_input').val();
    //     if (!products_type) {
    //         alert('Bạn phải chọn phân loại hàng');
    //         scrollTop('.products_type_item ');
    //         return false;
    //     }
    // }
    $('html,body').animate({scrollTop: '0px'}, 500);
    var $id = $id_pro;
    var $quan = $("#quantity_" + $id_pro).val();
    var $price = $("#price_input").val();
    var $id_shop = $("#id_shop").val();
    var $color = $("#color_id_vinashoes").val();
    var $products_type = $("#size_id_vinashoes").val();
    var $quantity_sub = $("#quantity_sub ").val();
    // if ($quantity_sub == 0 || !$quantity_sub) {
    //     alert('Sản phẩm tạm thời hết hàng')
    //     return false;
    // }
    var $quantity_main = $("#quantity_main ").val();
    var $id_sub = $("#id_sub").val();
    // alert($quantity_main);
    // alert($id_sub);
    // var $price = $('input[name="price"]:checked').val();
    // alert($price);
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=products&view=product&raw=1&task=buy',
        data: "quantity=" + $quan + "&id=" + $id + '&price=' + $price + '&products_size=' + $products_type + '&products_color=' + $color + '&quantity_sub=' + $quantity_sub + '&id_sub=' + $id_sub + '&quantity_main=' + $quantity_main + '&id_shop=' + $id_shop,
        success: function (data) {

            if (data.length == 702) {
                $("#wrapper-popup-2").html(data);
                ajax_pop_cart();
                // del_cart();
                $(".wrapper-popup-2").show();
                $(".full").show();
                return false;
            } else {
                $("#wrapper-popup").html(data);
                ajax_pop_cart();
                // del_cart();
                $(".wrapper-popup").show();
                $(".buy_mobile_popup").hide();
                $(".full").show();
            }
            $('#quantity_' + $id_pro).html(1);
            $('#quantity_' + $id_pro).val(1);
        }
    });
}
function submit_buy_now(id_pro) {

    check_conhang = $('#check_conhang').val();
    if (check_conhang == 0) {
                alert('Sản phẩm đã hết hàng');
                return false;
    }
    var link_search = document.getElementById('link_buy_now').value;
    
    var id = id_pro;
    var quantity_now = $("#quantity_" + id_pro).val();
    var price = $("#price_input").val();
    var id_shop = $("#id_shop").val();
    var color = $("#color_id_vinashoes").val();
    var products_type = $("#size_id_vinashoes").val();
    var quantity_sub = $("#quantity_sub ").val();
  
    var quantity_main = $("#quantity_main ").val();
    var id_sub = $("#id_sub").val();

    var link = link_search+'&quantity_now='+quantity_now+'&price='+price+'&color_id='+color+'&size_id='+products_type+'&quantity_sub='+quantity_sub+'&id_shop='+id_shop+'&id_sub='+id_sub;

    window.location.href=link;
    return false;
}

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

function ajax_pop_cart() {
    $("#close-cart").click(function () {
        $(".wrapper-popup-2").hide();
        $(".wrapper-popup").hide();
        $(".full").hide();
    });
}

function del_cart() {

    $(".del_prd .del-pro-link").click(function () {
        $a = $(this).attr("data-tr");
        $("." + $a).hide();

        var $id_sub = $(this).attr("data-id");
        // var $color_id = $(this).attr("data-color");
        // var $prd_type = $(this).attr("data-prd_type");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/index.php?module=products&view=product&task=edel',
            data: "id_sub=" + $id_sub,
            success: function () {
            }
        });
    });
    $(".continue-buy").click(function () {
        document.order_form.submit();
    });
}

function cbyuy($id, $price) {
    var a = '#item_' + $id;
    var lpr = $('#list_product_add').val();
    // alert(lpr);
    var ttprice = $('#total_price').val();
    if ($(a).prop('checked')) {
        $('#list_product_add').val(lpr + $id + ',');
        // alert(ttt);
        tt = parseInt(ttprice) + parseInt($price);
        $('#total_price').val(tt);
        document.getElementById("tgb").innerHTML = fomatPrice(tt);
    } else {
        $('#list_product_add').val(lpr.replace(',' + $id, ''));
        tt = ttprice - $price;
        $('#total_price').val(tt);
        document.getElementById("tgb").innerHTML = fomatPrice(tt);
    }


}


function fomatPrice(moth) {
    moth_format = moth.toString();
    var moth_format = moth_format.toString();
    var format_money = "";
    while (parseInt(moth_format) > 999) {
        format_money = "." + moth_format.slice(-3) + format_money;
        moth_format = moth_format.slice(0, -3);
    }
    moth_format = moth_format + format_money;
    moth_format = moth_format + ' đ';
    return moth_format;
    // $('#price_moth').html(moth_format);
}

function submitForm() {
    document.formbuy.submit();
}

function submitFormb() {
    products_type_count = $('#products_type_count').val();
    if (products_type_count && products_type_count != 0) {
        products_type = $('#products_type_input').val();
        if (!products_type) {
            alert('Bạn phải chọn phân loại hàng');
            scrollTop('.products_type_item ');
            return false;
        }
    }
    // color_count = $('#color_count').val();
    //
    // if (color_count && color_count != 0) {
    //     color = $('#color_input').val();
    //     // alert(color);
    //     if (!color || color == 0) {
    //         alert('Bạn phải chọn màu sắc');
    //         scrollTop('.color_item');
    //
    //         return false;
    //     }
    // }
    var $quantity_sub = $("#quantity_sub ").val();
    // if ($quantity_sub == 0 || !$quantity_sub) {
    //     alert('Sản phẩm tạm thời hết hàng')
    //     return false;
    // }
    document.formbuyb.submit();
}

// $(document).ready(function () {
//     $('.checkbox1').click(function() {
//         if( $(this).is(':checked')) {
//             $("#changepassword").show();
//         } else {
//             $("#changepassword").hide();
//         }
//     });
// });
// function favourite($id)
//
// {
// alert($id_default);
// return false;
// console.log($id);
// if (confirm('Bạn có thật sự muốn xóa địa chỉ này?')) {
// $.ajax({
//     type : 'get',
//     url : '/index.php?module=users&view=favourite&task=add_favourite&raw=1',
//     dataType : 'html',
//     data: 'id='+$id,
//     alert(data)
//     success : function(data){
//         // return false;
//         window.location.reload();
//         return true;
//     }
// });
// return false;
// } else {
//     // Do nothing!
// }

// }
function favourite($id) {
    // console.log($city_id);
    $.ajax({
        type: 'get',
        url: '/index.php?module=users&view=favourite&task=add_favourite&raw=1',
        dataType: 'html',
        data: {id: $id},
        success: function (data) {


            return true;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
    return false;
}

function like() {
    var id = $('#product_id').val();
    var user_id = $('#user_id').val();
    if (!user_id) {
        alert('Bạn phải đăng nhập để sử dụng tính năng này')
        return false;
    }
    $.ajax({
        type: 'get',
        url: '/index.php?module=users&view=favourite&task=add_favourite_&raw=1',
        dataType: 'html',
        data: {id: id},
        success: function (data) {
            $(".favorite_prd").html(data);
            return true;
            un_like();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
    return false;
}



function un_like() {
    var id = $('#product_id').val();
    var user_id = $('#user_id').val();
    if (!user_id) {
        alert('Bạn phải đăng nhập để sử dụng tính năng này')
        return false;
    }
    $.ajax({
        type: 'get',
        url: '/index.php?module=users&view=favourite&task=un_favourite_&raw=1',
        dataType: 'html',
        data: {id: id},
        success: function (data) {
            $(".favorite_prd").html(data);
            return true;
            like();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
        }
    });
    return false;
}

function yesnoCheck() {
    if ($('#price_new').is(":checked") == true) {
        $('#new').show();
        $('#old').hide();
        $('#price_type').val(1);
    }
    else {
        $('#new').hide();
        $('#old').show();
        $('#price_type').val(2);

    }

}

// $(function(){
//     var hDiv = $('.left_tuoitredanggia_2').height();
//     alert(hDiv);
//     if (hDiv < 180){
//         $('.show').hide();
//     }
// });
var i = 0;
$('.open_menu_prd').click(function () {
    i++;
    if (i % 2 != 0) {
        $('.menu_drop').slideDown('300');
        // $('.full').show();

    } else {
        $('.menu_drop').slideUp('300');
        // $('.full').hide();
    }
});
$('.open_share').click(function () {
    i++;
    if (i % 2 != 0) {
        $('.share_mb').show();
    } else {
        $('.share_mb').hide();
    }
});
$('.popup_buy .open_popup').click(function () {
    $('.buy_mobile_popup').show();
    // $('.full').show();
    $('.bottom-add-cart').show();
    $(".bottom-add-cart").removeClass('show_buy');
    $('.bottom-buy-now').show();
    $(".bottom-buy-now").removeClass('show_buy');
    $('html,body').animate({scrollTop: '0px'}, 500);
});
$('.right_menu_buy').click(function () {
    $('.buy_mobile_popup').show();
    // $('.full').show();
    $('.bottom-add-cart').hide();
    $(".bottom-buy-now").show();
    $(".bottom-buy-now").addClass('show_buy');
    $('html,body').animate({scrollTop: '0px'}, 500);

});
$('.cart_mb').click(function () {
    $('.buy_mobile_popup').show();
    // $('.full').show();
    $('.bottom-buy-now').hide();
    $(".bottom-add-cart").show();
    $(".bottom-add-cart").addClass('show_buy');
    $('html,body').animate({scrollTop: '0px'}, 500);

});
$('.close_popup').click(function () {
    $('.buy_mobile_popup').hide();
    $('.full').hide();
});

function change_quantity($id) {
    var $quan = $('#quantity_' + $id).val();
    var quan_sub1 = $('#quantity_sub').val();
    var $quantity_main = $("#quantity_main ").val();
    var countype = $('#products_type_count').val();

    if(countype != 0){
        quan_sub = quan_sub1;
    }else {
        quan_sub = $quantity_main;
    }
    if (countype != 0 && !quan_sub) {
        alert("Bạn phải chọn phân loại sản phẩm.")
        return false;
    }
    $quan = parseInt($quan);

    var txt_max = 'Bạn đã đặt quá số lượng sản phẩm có sẵn.';

    if ($quan > quan_sub) {
        alert(txt_max);
        $('#quantity_' + $id).val(quan_sub);
        $('#quantity_' + $id).html(quan_sub);
    }
    $('#quantity_now').val($quan);

    // this.parentNode.querySelector('input#quantity_<?php echo $item[0]; ?>').stepUp()

    // alert($quan);
    // $('#quantity_' + $id).value = $('#quantity_' + $id).value(replace(/[^0-9\,\.]/,''));

    // delay_function(function () {

    // if ($quan > 99999) {
    //     alert(txt_max);
    // } else {
    //     $.ajax({
    //         type: 'GET',
    //         dataType: 'json',
    //         url: '/index.php?module=products&view=product&raw=1&task=change_quantity',
    //         data: "id=" + $id + "&quantity=" + $quan,
    //         success: function ($json) {
    //             if ($json.txt_min_quantity != '') {
    //                 alert($json.txt_min_quantity);
    //             } else {
    //                 // $(".tempo_price").html($json.total_money);
    //                 // $(".total_price").html($json.total_money);
    //                 $(".total_cart").html($json.total_cart);
    //                 $(".total_head").html($json.total_cart);
    //
    //                 // money_change = $(val).find('money_change').text();
    //
    //                 if ($quan > 0) {
    //                     $('#quantity_' + $id).val();
    //
    //                 } else {
    //                     $('#quantity_' + $id).val(1);
    //                 }
    //             }
    //
    //         }
    //     });
    // }
    // }, 500);
}


function up_quantity($id) {
    var $quan = $('#quantity_' + $id).val();
    var quan_sub1 = $('#quantity_sub').val();
    var $quantity_main = $("#quantity_main ").val();
    var countype = $('#products_type_count').val();
    if(countype != 0){
        quan_sub=quan_sub1;
    }else {
        quan_sub = $quantity_main;
    }
    // console.log(quan_sub);
    // console.log(countype);
    if (countype != 0 && !quan_sub) {
        alert("Bạn phải chọn phân loại sản phẩm.")
        return false;
    }
    // var $quan_min = $('#oder_min').val();
    $quan = parseInt($quan);

    var txt_max = 'Bạn đã đặt quá số lượng sản phẩm có sẵn.';

    // $('#quantity_' + $id ).html($quan + 1);
    $('#quantity_' + $id).val($quan + 1);
    $('#quantity_now').val($quan + 1);

    // var txt_min = $('#info_min').val();
    if ($quan + 1 > quan_sub) {
        alert(txt_max);
        $('#quantity_' + $id).val(quan_sub);
        $('#quantity_' + $id).html(quan_sub);
        $('#quantity_now').val(quan_sub);
    }
    //     $('#quantity_' + $id ).html(quan_sub);
    //     $('#quantity_' + $id ).val(quan_sub);
    // }else if($quan < $quan_min){
    //     alert(txt_min);
    // }

    // else {
    //
    //     $.ajax({
    //         type: 'GET',
    //         dataType: 'json',
    //         url: '/index.php?module=products&view=product&raw=1&task=change_quantity',
    //         data: "id=" + $id + "&quantity=" + $quan,
    //         success: function ($json) {
    //             if ($json.txt_min_quantity != '') {
    //                 alert($json.txt_min_quantity);
    //             } else {
    //
    //                 // $(".tempo_price").html($json.total_money);
    //                 // $(".total_price").html($json.total_money);
    //                 $(".total_cart").html($json.total_cart);
    //                 $(".total_head").html($json.total_cart);
    //
    //                 if ($quan > 0) {
    //                     $('#quantity_' + $id).val($quan);
    //
    //                 } else {
    //                     $('#quantity_' + $id).val(1);
    //                 }
    //             }
    //
    //         }
    //     });
    //
    // }
}


function down_quantity($id) {

    var $quan = $('#quantity_' + $id).val();
    var quan_sub = $('#quantity_sub').val();
    var countype = $('#products_type_count').val();

    if (countype != 0 && !quan_sub) {
        alert("Bạn phải chọn phân loại sản phẩm.")
        return false;
    }
    $quan = parseInt($quan);
    var txt_max = $('#info_max').val();
    if ($quan < 1) {
        $('#quantity_' + $id).val($quan = 1);
        $('#quantity_now').val($quan = 1);

    }
    if ($quan == 1) return;
    $('#quantity_' + $id).html($quan - 1);
    $('#quantity_' + $id).val($quan - 1);
    $('#quantity_now').val($quan - 1);

    // if ($quan > 99999) {
    //     alert(txt_max);
    // } else {
    //     $.ajax({
    //         type: 'GET',
    //         dataType: 'json',
    //         url: '/index.php?module=products&view=product&raw=1&task=change_quantity',
    //         data: "id=" + $id + "&quantity=" + $quan,
    //         success: function ($json) {
    //             if ($json.txt_min_quantity != '') {
    //                 alert($json.txt_min_quantity);
    //             } else {
    //                 // $(".tempo_price").html($json.total_money);
    //                 // $(".total_price").html($json.total_money);
    //                 $(".total_cart").html($json.total_cart);
    //                 $(".total_head").html($json.total_cart);
    //
    //                 if ($quan > 0) {
    //                     $('#quantity_' + $id).val($quan);
    //
    //                 } else {
    //                     $('#quantity_' + $id).val(1);
    //                 }
    //
    //             }
    //         }
    //     });
    // }
}