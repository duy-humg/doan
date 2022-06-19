$(document).ready(function () {
    checkcode();
    $('#add_code_price').click(function () {

        var $val = $('#code_down').val();
        var $ship = $('#ship').val();
        // alert($ship);
        var $total = $("#after_discount_member").val();
        if($('#code_down').val().trim() !=="") {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/index.php?module=products&view=code&raw=1',
                data: {
                    val: $val,
                    total: $total,
                    ship: $ship,
                },
                success: function ($result) {
                    $total1=parseInt($total);
                    $ship1=parseInt($ship);
                    // console.log($result);
                    // item = jQuery.parseJSON($result);
                    if (!$result.error) {
                        valid('code_down');
                        $('#inputcode').val(1);
                        $('<div class=\'label_success \'>' + array_info[1] + '</div>').insertAfter($('#code_down').parent().children(':last'));

                        if ($result.type === "1") {
                            // var $tt=$("#after_discount_member").val();
                            // console.log()
                            $('#code_dis').html(fomatPrice($total * ($result.value / 100)));
                            var $money=$total-$total * ($result.value / 100);
                            if($money>0){
                                // alert($ship);
                                // $end =$total-$total * ($result.value / 100)+$ship;

                                // $end =;
                                // alert($end);
                                $('#total_money').html(fomatPrice($total1-$total1 * ($result.value / 100)+$ship1));
                                $('#after_discount').val($total1-$total1 * ($result.value / 100));
                            }else {
                                $('#total_money').html(fomatPrice(0));
                                $('#after_discount').val(0);
                            }

                        } else {
                            // alert($result.value);
                            // console.log($result.value);
                            $('#code_dis').html(fomatPrice($result.value));
                            var $money=$total-$result.value;
                            if($money>0){
                                $('#total_money').html(fomatPrice($total1-$result.value+$ship1));
                                $('#after_discount').val($total1-$result.value);
                            }else {
                                $('#total_money').html(fomatPrice(0+$ship1));
                                $('#after_discount').val(0);
                            }

                        }

                    } else {
                        invalid('code_down', array_info[0]);
                        $('#inputcode').val(0);
                        $('#code_dis').html("0đ");
                        $('#total_money').html(fomatPrice($total1+$ship1));
                        $('#after_discount').val($total);
                    }
                }
            });
        }
        else {
            $('#inputcode').val(0);
            $('.label_success').remove();
            $('#code_dis').html("0đ");
            $('#total_money').html(fomatPrice($total1));
            $('.label_error').remove();

        }
    })
    // $('#show_add_code').click(function () {
    //     if($(this).prop('checked')){
    //
    //     }else {
    //         $("#code_down").val("");
    //         checkcode();
    //     }
    // });
    var info_code = $('#paycode').val();
    array_info = info_code ? JSON.parse(info_code) : [];
});

function checkcode() {
    $("#code_down").blur(function () {

        var $val = $(this).val();
        var $total = $("#after_discount_member").val();
        if($(this).val().trim() !=="") {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/index.php?module=products&view=code&raw=1',
                data: {
                    val: $val,
                    total: $total,
                },
                success: function ($result) {
                    // console.log($result);
                    // item = jQuery.parseJSON($result);
                    if (!$result.error) {
                        valid('code_down');
                        $('<div class=\'label_success \'>' + array_info[1] + '</div>').insertAfter($('#code_down').parent().children(':last'));
                        // if ($result.type === "1") {
                        //     // var $tt=$("#after_discount_member").val();
                        //     // console.log()
                        //     $('#code_dis').html(fomatPrice($total * ($result.value / 100)));
                        //     var $money=$total-$total * ($result.value / 100);
                        //     if($money>0){
                        //         $('#total_money').html(fomatPrice($total-$total * ($result.value / 100)));
                        //         $('#after_discount').val($total-$total * ($result.value / 100));
                        //     }else {
                        //         $('#total_money').html(fomatPrice(0));
                        //         $('#after_discount').val(0);
                        //     }
                        //
                        // } else {
                        //     // alert($result.value);
                        //     // console.log($result.value);
                        //     $('#code_dis').html(fomatPrice($result.value));
                        //     var $money=$total-$result.value;
                        //     if($money>0){
                        //         $('#total_money').html(fomatPrice($total-$result.value));
                        //         $('#after_discount').val($total-$result.value);
                        //     }else {
                        //         $('#total_money').html(fomatPrice(0));
                        //         $('#after_discount').val(0);
                        //     }
                        //
                        // }

                    } else {
                        invalid('code_down', array_info[0]);
                        $('#inputcode').val(0);
                        $('#code_dis').html("0đ");
                        $('#total_money').html(fomatPrice($total));
                        $('#after_discount').val($total);
                    }
                }
            });
        }
        else {
            $('#inputcode').val(0);
            $('.label_success').remove();
            $('#code_dis').html("0đ");
            $('#total_money').html(fomatPrice($total));
            $('.label_error').remove();

        }
    })

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
    moth_format = moth_format+' đ';

    return moth_format;
    // $('#price_moth').html(moth_format);
}