$(document).ready(function () {
    del_cart1();
    $('input.quantity-value').keypress(function () {
        if (window.event.keyCode === 46) {
            return false;
        }
    })

    $('.smt_m').click(function(){
    
        document.order_form.submit();
	})

    $("#all_checkbox").click(function() {
        $(".checkbox_all").prop("checked", this.checked);
        $(".all_checkbox_shop").prop("checked", this.checked);
        var array = [];
        $("input:checkbox[name=id_pub]:checked").each(function() {

            array.push($(this).val());
        });
        $.ajax({
            url: "index.php?module=products&view=product&task=check_cart_all&raw=1",
            type: 'GET',
            dataType: 'html',
            data: "array=" + array,
            success: function (html) {
                $('.span_cart_price_all').html(html);
                // location.reload()
            }
        });
    });
    $("#all_checkbox_2").click(function() {
        $(".checkbox_all").prop("checked", this.checked);
        $(".all_checkbox_shop").prop("checked", this.checked);
        var array = [];
        $("input:checkbox[name=id_pub]:checked").each(function() {

            array.push($(this).val());
        });
        $.ajax({
            url: "index.php?module=products&view=product&task=check_cart_all&raw=1",
            type: 'GET',
            dataType: 'html',
            data: "array=" + array,
            success: function (html) {
                $('.span_cart_price_all').html(html);
                // location.reload()
            }
        });
    });
    $("#all_checkbox_").click(function() {
        $(".checkbox_all").prop("checked", this.checked);
        $(".all_checkbox_shop").prop("checked", this.checked);
        var array = [];
        $("input:checkbox[name=id_pub]:checked").each(function() {

            array.push($(this).val());
        });
        $.ajax({
            url: "index.php?module=products&view=product&task=check_cart_all&raw=1",
            type: 'GET',
            dataType: 'html',
            data: "array=" + array,
            success: function (html) {
                $('.span_cart_price_all').html(html);
                // location.reload()
            }
        });
    });
    $(".all_checkbox_shop").click(function() {
        $a = $(this).attr("id_shop");
        $(".checkbox_shop_"+$a).prop("checked", this.checked);

        var array = [];
        $("input:checkbox[name=id_pub]:checked").each(function() {

            array.push($(this).val());
        });
        $.ajax({
            url: "index.php?module=products&view=product&task=check_cart_all&raw=1",
            type: 'GET',
            dataType: 'html',
            data: "array=" + array+"&id_shop=" + $a,
            success: function (html) {
                $('.span_cart_price_all').html(html);
                // location.reload()
            }
        });
    });

});
$(document).ready( function(){

    $('.content_upcoming').owlCarousel({
        loop:true,
        margin:67,
        dots:false,
        nav:true,
        autoplay:false,
        autoplayTimeout:6000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })
    $(".upcoming .content_upcoming .owl-nav .owl-prev").html("<img src=\"modules/products/assets/images/left.png\" alt=\"\">")

    $(".upcoming .content_upcoming .owl-nav .owl-next").html("<img src=\"modules/products/assets/images/next.png\" alt=\"\">")
});



$(".check_item").click(function () {
    $stt = $(this).attr("stt");
    $val = $(this).val();
    if ($(this).is(":checked") == true) {
        $.ajax({
            url: "index.php?module=products&view=product&task=check_cart&raw=1",
            type: 'GET',
            dataType: 'html',
            data: "id=" + $val,
            success: function (html) {
                $('.span_cart_price_all').html(html);
                $('.btn_mua').removeClass('btn_mua_active');
                $('.btn_mua').addClass('btn_mua_active');
                // location.reload()
            }
        });
    }
});
$(".check_item").click(function () {
    $stt = $(this).attr("stt");
    $id_shop_sp = $(this).attr("id_shop_sp");
    $val = $(this).val();
    if ($(this).is(":checked") == false) {
        $.ajax({
            url: "index.php?module=products&view=product&task=check_cart_false&raw=1",
            type: 'GET',
            dataType: 'html',
            data: "id=" + $val,
            success: function (html) {
                $('.span_cart_price_all').html(html);
                // location.reload()
            }
        });
    }
});


function del_cart() {

    $(".name-product .del-pro-link").click(function () {
        $a = $(this).attr("data-tr");
        $("." + $a).hide();

        var $id = $(this).attr("data-id");
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/index.php?module=products&view=product&task=edel',
            data: "id=" + $id,
            success: function () {
                location.reload()
            }
        });
    });
    $(".continue-buy").click(function () {
        document.order_form.submit();
    });
}

function validateUpdateCart() {
    $('input.quantity-value').each(function () {
        if (!Number.isInteger(parseFloat($(this).val()))) {
            alert('Số lượng không hợp lệ');
            $(this).focus();
            return false;
        }
    });
    var data = $('form#order_form').serialize();
    $.ajax({
        type: 'POST',
        url: 'index.php?module=products&view=product&raw=1&task=updateCart',
        dataType: 'json',
        data: data,
        success: function (data) {
            window.location.reload(true);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
    });
    return false;
}

function DowUpdateCart(id) {
    var val = parseInt($('#add_quantity_' + id).val());
    // if (val < 0) $('#add_quantity_'+id).val(val = 1);
    // $('#add_quantity_'+id).val(val + 1);
    if (val > 1) {
        $('#checkadd_quantity_' + id).html(val - 1);
        pro_id = id;
        up = 2;
        $('#add_quantity_' + id).val(val - 1);
        // var data = $('form#order_form').serialize();
        // alert(data);
        quan = $('#add_quantity_' + id).val();
        $.ajax({
            type: 'POST',
            url: 'index.php?module=products&view=product&raw=1&task=updateCart',
            dataType: 'json',
            data: {pro_id: pro_id, quan: quan, up: up},
            success: function (data) {

                window.location.reload(true);
            },
            // error: function (XMLHttpRequest, textStatus, errorThrown) {
            //     alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
            // }
        });
        return false;
    } else
        return false;
}

function UpUpdateCart(id) {

    // var valid = $(this).attr('data-id');
    // var inpt = $(this).parents(".custom-quantity-input").find('[id="' + valid + '"]');

    var val = parseInt($('#add_quantity_' + id).val());
// alert(val);
    if (val < 0) $('#add_quantity_' + id).val(val = 1);
    // $('#add_quantity_'+id).val(val + 1);
    // alert(val + 1);
    $('#checkadd_quantity_' + id).html(val + 1);
    pro_id = id;
    // alert(pro_id);
    up = 1;
    $('#add_quantity_' + id).val(val + 1);
    // var data = $('form#order_form').serialize();
    // alert(data);
    quan = $('#add_quantity_' + id).val();
    $.ajax({
        type: 'POST',
        url: 'index.php?module=products&view=product&raw=1&task=updateCart',
        dataType: 'json',
        data: {pro_id: pro_id, quan: quan, up: up},
        success: function (data) {

            window.location.reload(true);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
    });
    return false;
}

function del_cart1() {

    $(".del-pro-link").click(function () {
        // alert(1);
        $a = $(this).attr("data-tr");
        $("." + $a).hide();
        var $id = $(this).attr("data-id");
        // alert($id);
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/index.php?module=products&view=product&task=edel1',
            data: "id=" + $id,
            success: function () {
            }
        });
        location.reload();
    });
}

$('.replay').click(function () {
    $(".menuu").removeClass("in");
})

function change_adj($id_pro) {
    var $id = $id_pro;
    // alert($id_pro);

    // var $quan = $("#quantity").val();
    var $price = $("#price_input").val();
    var $color = $("#color_input").val();
    var $products_type = $("#products_type_input").val();
    var $quantity_sub = $("#quantity_sub ").val();
    var $id_sub = $("#id_sub").val();
    // alert($id_sub);
    // var $price = $('input[name="price"]:checked').val();
    // alert($price);
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: 'index.php?module=products&view=cart&raw=1&task=change',
        data: "id_change=" + $id + '&price=' + $price + '&color=' + $color + '&products_type=' + $products_type + '&quantity_sub=' + $quantity_sub + '&id_sub=' + $id_sub,
        success: function (data) {
            if (data == 1) {
                alert('Sản phẩm tạm thời hết hàng');
                $('html, body').animate({
                    scrollTop: $('.in').offset().top
                }, 500);
                // return false;
                location.reload();
            } else {
                window.location.reload(true);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }

    });
    return false;

}

$(".item_price").click(function () {
    var item = $(this).attr("data");
    var name = $(this).attr("name");
    var title = $(this).attr("name-item");
    $("." + item).removeClass("active2");
    $(this).addClass("active2");


    var color = $('.in .color .active2').attr("color_id");
// alert(color);
    var products_type = $('.in .products_type .active2').attr("products_type_id");
    // alert(products_type);

    if (!color) {
        color = 0;
    }
    if (!products_type) {
        products_type = 0;
    }

    $('#color_input').val(color);
    $('#products_type_input').val(products_type);
    // $('#memory_input').val(memory);

    product = $('.in .products_sub').val();
    // alert(product);
    // return false;
    product = eval(product);
    // alert(product);
    var price = 0;
    var price_old = 0;
    var discount = 0;
    var quan = 0;
    var id = 0;
    for (var i = 0; i < product.length; i++) {
        // alert(1);
        if ((color == product[i].color_id) && (products_type == product[i].product_type_id)) {
            // alert(1);
            id = product[i].id;
            price = product[i].price;
            price_old = product[i].price_old;
            discount = product[i].discount;
            quan = product[i].quantity;
            break;
        }
    }

    // alert(quan);
    // alert(price);
    // $('.quan_sub').html(quan);
    $('#quantity_sub').val(quan);
    $('#id_sub').val(id);
    // $('#quan_input').val(0);
    if (price == 0) {
        //     price = 'Liên hệ';
        $('#price_input').val(0);
        //     // $('#price_input_buynow').val(0);
    }
    else {
        $('#price_input').val(price);
        // $('#price_input_buynow').val(price);
        // alert(price);
        // var price = price.toString();
        // var format_money = "";
        // while (parseInt(price) > 999) {
        //     format_money = "." + price.slice(-3) + format_money;
        //     price = price.slice(0, -3);
        // }
        // price = price + format_money;
        // price = price + ' đ';
// alert(price);
    }

    // $('.infor-price').html(price);
    // $('.price_modal').html(price);

    // if (price_old > 0 && discount > 0) {
    //
    //     var price_old = price_old.toString();
    //     // alert(price_old);
    //     var format_money = "";
    //     while (parseInt(price_old) > 999) {
    //         format_money = "." + price_old.slice(-3) + format_money;
    //         price_old = price_old.slice(0, -3);
    //     }
    //     price_old = price_old + format_money;
    //     price_old = price_old + ' đ';
    //     // alert(price_old);
    //     $('.giatien .price_old').html(price_old);
    //     // alert(price_old);
    //
    //
    // } else {
    //     price_old = '';
    //     $('.giatien .price_old').html(price_old);
    //
    // }

    // $('.price_old').html(price_old1);
});

function cbyuy($id, $price, $quan) {
    var a = '#item_' + $id;
    var lpr = $('#list_product_add').val();
    // alert(lpr);
    var ttprice = $('#total_price').val();
    var ttquan = $('#total_quan').val();
    if ($(a).prop('checked')) {
        $('#list_product_add').val(lpr + $id + ',');
        // alert(ttt);
        tt = parseInt(ttprice) + parseInt($price);
        total_quan = parseInt(ttquan) + parseInt($quan);
        $('#total_quan').val(total_quan);
        $('#total_price').val(tt);
        $('.total-pop').html(fomatPrice(tt));
        $('.quantt').html(total_quan);

        // document.getElementById("tgb").innerHTML = fomatPrice(tt);
    } else {
        $('#list_product_add').val(lpr.replace(',' + $id, ''));
        tt = ttprice - $price;
        // alert(tt);
        total_quan = parseInt(ttquan) - parseInt($quan);
        $('#total_quan').val(total_quan);
        $('#total_price').val(tt);
        $('.total-pop').html(fomatPrice(tt));
        $('.quantt').html(total_quan);

        // document.getElementById("tgb").innerHTML = fomatPrice(tt);
    }
}

$(".check_").click(function () {
    if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".check_").each(function () {
            if (!this.checked)
                isAllChecked = 1;
        });

        if (isAllChecked == 0) {
            $("#checkAll").prop("checked", true);
        }
    }
    else {
        $("#checkAll").prop("checked", false);
    }
});

function submitFormb() {
    document.order_form.submit();
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

$("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
    $total_price = $('#total_price_check').val();
    $total_quan = $('#total_quan_check').val();
    $list_prd = $('#list_product_add_check').val();

    if ($('#checkAll').prop('checked')) {
        $('#total_price').val($total_price);
        $('#total_quan').val($total_quan);
        $('#list_product_add').val($list_prd);
        $('.total-pop').html(fomatPrice($total_price));
        $('.quantt').html($total_quan);
    } else {
        $('#total_price').val(0);
        $('#total_quan').val(0);
        $('.total-pop').html(fomatPrice(0));
        $('.quantt').html(0);
        $('#list_product_add').val(',');
    }
});

function change_quantity($id) {
    var $quan = $('#quantity_' + $id).val();
    var quan_sub = $('#quan_max_' + $id).val();
    $quan = parseInt($quan);

    var txt_max = 'Bạn đã đặt quá số lượng sản phẩm có sẵn.';

    if ($quan > quan_sub) {
        alert(txt_max);
        $('#quantity_' + $id).val(quan_sub);
        $('#quantity_' + $id).html(quan_sub);
    }
    var up = 3;
    quan = $('#quantity_' + $id).val();
    pro_id = $id;
    $.ajax({
        type: 'POST',
        url: 'index.php?module=products&view=product&raw=1&task=updateCart',
        dataType: 'json',
        data: {pro_id: pro_id, quan: quan, up: up,quan_sub: quan_sub},
        success: function (data) {

            window.location.reload(true);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
    });
    return false;
}


function up_quantity($id) {
    var $quan = $('#quantity_' + $id).val();
    var quan_sub = $('#quan_max_' + $id).val();
    $quan = parseInt($quan);
    var txt_max = 'Bạn đã đặt quá số lượng sản phẩm có sẵn.';
    $('#quantity_' + $id).val($quan + 1);
    if ($quan + 1 > quan_sub) {
        alert(txt_max);
        $('#quantity_' + $id).val(quan_sub);
        $('#quantity_' + $id).html(quan_sub);
    }
    var up = 1;
    quan = $('#quantity_' + $id).val();
    pro_id = $id;
    $.ajax({
        type: 'POST',
        url: 'index.php?module=products&view=product&raw=1&task=updateCart',
        dataType: 'json',
        data: {pro_id: pro_id, quan: quan, up: up,quan_sub: quan_sub},
        success: function (data) {

            window.location.reload(true);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
    });
    return false;
}


function down_quantity($id) {

    var $quan = $('#quantity_' + $id).val();
    var quan_sub = $('#quan_max_' + $id).val();

    $quan = parseInt($quan);
    var txt_max = $('#info_max').val();
    if ($quan < 1) {
        $('#quantity_' + $id).val($quan = 1);

    }
    if ($quan == 1) return;
    $('#quantity_' + $id).val($quan - 1);
    var up = 2;
    quan = $('#quantity_' + $id).val();
    pro_id = $id;

    // return false;
    $.ajax({
        type: 'POST',
        url: 'index.php?module=products&view=product&raw=1&task=updateCart',
        dataType: 'json',
        data: {pro_id: pro_id, quan: quan, up: up,quan_sub: quan_sub},
        success: function (data) {

            window.location.reload(true);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Có lỗi trong quá trình tải lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
    });
    return false;
}