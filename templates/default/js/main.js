//<![CDATA[
$(window).on('load', function() { // makes sure the whole site is loaded
   // will first fade out the loading animation
  $('.preloader').delay(30).fadeOut('slow'); // will fade out the white DIV that covers the website.
  $('body').delay(30).css({
    'overflow': 'visible'
  });
})
//]]>

var is_rewrite = 1;
var root = '/';
(function() {
  if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
      document.createTextNode(
        "@-ms-viewport{width:auto!important}"
      )
    );
    document.getElementsByTagName("head")[0].
    appendChild(msViewportStyle);
  }
})();

function changeCaptcha() {
  var date = new Date();
  var captcha_time = date.getTime();
  $("#imgCaptcha").attr({
    src: '/libraries/jquery/ajax_captcha/create_image.php?' + captcha_time
  });
}

function openNav() {
  document.getElementById("mySidenav").style.width = "280px";
  //document.getElementById("page").style.marginRight = "280px";
  //ocument.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  //document.getElementById("page").style.marginRight= "0";
  //document.body.style.backgroundColor = "white";
}

function myTimer() {
  //$('.alert').remove();
  location.reload();
}

function close(name_lable = '', type = '') {
  $('.alert').remove();
  if (!name_lable)
    return false;
  $('<div class="alert ' + type + '"><span class="closebtn">×</span><strong>' + name_lable + '</strong></div>').insertAfter('#alert-error').animate({
    top: 130
  });

  var close = document.getElementsByClassName("closebtn");
  var i;

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.opacity = "0";
      setTimeout(function() {
        div.style.display = "none";
      }, 600);
    }
  }

  $('.alert').delay(4000).fadeOut('slow');
}

function close_moda(name_lable = '', content = '') {
  $('.alert_moda').remove();
  if (!name_lable)
    return false;
  var html = '';
  html += '<div class="modal fade alert_moda" id="' + name_lable + '" role="dialog">';
  html += '	<div class="modal-dialog">';
  html += '		<div class="modal-content">';
  html += '			<div class="modal-body">';
  html += '				<h4 class="modal-title">Thông báo</h4>';
  html += '				<button type="button" class="close23" data-dismiss="modal"><i class="fa fa-times"></i></button>';
  html += '       <div class="row-item content-info">' + content + '</div>';
  html += '				<div class="row-item bt-content" >';
  html += '						<a class="bt-modal bt-cancel" data-toggle="modal" data-target="#' + name_lable + '" href="#">Cancel</a>';
  html += '						<a class="bt-modal bt-ok" data-toggle="modal" data-target="#' + name_lable + '" href="#" >OK</a>';
  html += '				</div>';
  html += '			</div>';
  html += '		</div>';
  html += '	</div>';
  html += '</div>';

  $(html).insertAfter('.scrollToTop');
  $('#' + name_lable).modal('show');
  //$('#'+name_lable).delay(10000).fadeOut('slow');
  //setInterval(remove_moda, 30000);
}

function alert_moda(name_lable = '', content = '') {
  $('.alert_moda').remove();
  if (!name_lable)
    return false;
  var html = '';
  html += '<div class="modal fade alert_moda" id="' + name_lable + '" role="dialog">';
  html += '	<div class="modal-dialog">';
  html += '		<div class="modal-content" style="background:#ffffff !important" >';
  html += '			<div class="modal-body" style="text-align: center;">';
  html += '				<div class="loader"></div>';
  html += '       <div class="row-item content-info">' + content + '</div>';
  html += '			</div>';
  html += '		</div>';
  html += '	</div>';
  html += '</div>';

  $(html).insertAfter('.scrollToTop');
  $('#' + name_lable).modal('show');
}

function info_moda(name_lable = '', content = '', error = 1) {
  $('.alert_moda').remove();
  if (!name_lable)
    return false;
  var html = '';
  html += '<div class="modal fade alert_moda" id="' + name_lable + '" role="dialog">';
  html += '	<div class="modal-dialog">';
  html += '		<div class="modal-content" style="background:#ffffff !important" >';
  html += '			<div class="modal-body" style="text-align: center;">';
  if (error == 1) {
    html += '				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/></svg>';
  } else {
    html += '       <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2"><circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/><line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/></svg>';
  }
  html += '       <div class="row-item content-info">' + content + '</div>';
  html += '				<div class="row-item bt-content" >';
  html += '						<a class="bt-modal bt-ok" data-toggle="modal" data-target="#' + name_lable + '" href="#" >OK</a>';
  html += '				</div>';
  html += '			</div>';
  html += '		</div>';
  html += '	</div>';
  html += '</div>';

  $(html).insertAfter('.scrollToTop');
  $('#' + name_lable).modal('show');
}

function remove_moda() {
  $('.alert_moda').remove();
}

$(document).ready(function() {
    if (screen.width<=575.98) {
        // $('#head-aff-top').data('spy','affix');
        $('#head-aff-top').attr('data-spy','affix');
        $('#head-aff-top').attr('data-offset-top','200');
        $('#head-aff-top').css("top",0);
        $(window).scroll(function() {
            if ($(this).scrollTop() >= 200) { // this refers to window

                $('#head-aff-top').css("width","100%");
                $('#head-aff-top').css("box-shadow","0px 0px 2px 0px");
                $('.logo-mobile-hide').hide();
            }else {
                // $('#head-aff-top').css("top",0);
                $('.logo-mobile-hide').show();
                $('#head-aff-top').css("box-shadow","none");
            }
        });
    }
    else {
//do something else
    }

    $("#close-cart").click(function () {
        $(".wrapper-popup").hide();
        $(".wrapper-popup-2").hide();
        $(".full").hide();
    });
    $(".show-info-member").click(function () {
        $(".title-login-club ul").toggle("slow");
    });

    $(".full").click(function () {
        $(".wrapper-popup").hide();
        $(".wrapper-popup-2").hide();
        $("#wrapper-video").hide();
        $(".full").hide();
        $("#basic-setup-example").hide();
    });

  $('#mm-blocker').on('click', function() {
    var menu = $('#menu');
    menu.addClass('hide').hide();
  });
  // menu- responsive
  $('#search-mobile').on('click', function() {
    var menu = $(this);
    if (menu.hasClass('open')) {
      menu.removeClass('open');
      $('#search_form').removeClass('open').slideUp(200);
    } else {
      menu.addClass('open');
      $('#search_form').addClass('open').slideDown(200);
    }
  });

  $(window).scroll(function() {
    if (window.innerWidth < 767) {
      $(".group-modal").css("display", "none").fadeIn("10000");
    }
    if ($(this).scrollTop() > 300) {
      $('.scrollToTop').fadeIn().addClass('active');
      //$('.group-modal').fadeIn().addClass('active');
    } else {
      $('.scrollToTop').fadeOut().removeClass('active');
      //$('.group-modal').fadeOut().removeClass('active');
    }
  });

  //Click event to scroll to top
  $('.scrollToTop').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;
  });

  $('#nav_tab a').click(function() {
    var id = $(this).data('id');
    $('#groupModal .tab-pane').hide();
    $('#tab-pane-' + id).show();
  });



});

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
    
    

function OpenPrint() {
  u = location.href;
  window.open(u + "?print=1");
  return false;
}

$(function(){
    $('#sl-link').on('change', function() {  
      var url = this.value;              // or whatever
        window.open(url, '_blank');  
    });
});

Number.prototype.formatMoney = function(c, d, t) {
  var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


//dang ky dang nhap

function registration(){
    // alert(1);
            $.ajax({
                    type : 'GET',
                    dataType: 'html',
                    url : '/index.php?module=users&view=users&raw=1&task=registration',
                    success : function(data){
                        $("#wrapper-popup-2").html(data);
                        close();
                        check_exist_username();
                        check_re_pass();
                    }
            });
            $(".wrapper-popup-2").show();
            $(".full").show();
			
}
function login(){
            $.ajax({
                    type : 'GET',
                    dataType: 'html',
                    url : '/index.php?module=users&view=users&raw=1&task=registration ',
                    success : function(data){
                        $("#wrapper-popup-2").html(data);
                        close();
                    }
            });
            $(".wrapper-popup-2").show();
            $(".full").show();
			
}
function forget(){
            $.ajax({
                    type : 'GET',
                    dataType: 'html',
                    url : '/index.php?module=users&view=users&raw=1&task=forget_popup',
                    success : function(data){
                        $("#wrapper-popup-3").html(data);
                        close();
                    }
            });
            $(".wrapper-popup-3").show();
            $(".full").show();
			
}

function close(){
    $("#close-cart").click(function () {
        $(".wrapper-popup").hide();
        $(".wrapper-popup-2").hide();
        $(".wrapper-popup-3").hide();
        $(".full").hide();
    });
}

function check_exist_username(){
    // alert(1);
    $('#dk_email1').blur(function(){
            if($(this).val() != ''){
                    if(!emailValidator("dk_email1","Email không đúng định dạng ")){
                        return false;
                    }
                    $.ajax({
                    type: "POST",	
                    data: {email_register: $('#dk_email1').val()},
                    url: root+"index.php?module=users&task=ajax_check_exist_email&raw=1",
                    success: function(result) {
                            if(result == 0){
                                    // invalid('dk_email');
                                    $('.label_error').remove();
                                    $('.label_success').remove();
                                    $('<div class=\'label_error\'>'+'Tên truy nhập này đã tồn tại hoặc không đúng. Bạn hãy sử dụng tên truy cập khác'+'</div>').insertAfter($('#dk_email1').parent().children(':last'));
                            } else {
                                    // valid('dk_email');
                                    $('.label_error').remove();
                                    $('.label_success').remove();
                                    $('<div class=\'label_success\'>'+'Tên truy nhập này được chấp nhận'+'</div>').insertAfter($('#dk_email1').parent().children(':last'));
                            }
                    }
            });
            }
    });
}

function check_re_pass(){
    $('#re_password').blur(function(){
        if($(this).val() != $('#dk_password1').val()){
            invalid('re_password');
            $('.label_error').remove();
            $('.label_success').remove();
            $('<div class=\'label_error\'>'+'Mật khẩu không khớp. vui lòng nhập lại'+'</div>').insertAfter($('#re_password').parent().children(':last'));

        }else {
            valid('re_password');
            $('.label_error').remove();
            $('.label_success').remove();
            $('<div class=\'label_success\'>'+'Khớp mật khẩu'+'</div>').insertAfter($('#re_password').parent().children(':last'));
        }
    });
}

function check_discount_form(){

	if(jQuery.trim($('#dc_email').val()) == '' || jQuery.trim($('#dc_email').val()) == 'Enter your email'){

		alert('Hãy nhập email của bạn');

		$('#dc_email').focus();

		return false;

	}


	var filterEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(!$('#dc_email').val().match(filterEmail)){

		alert('Email chưa đúng định dạng');

		$('#dc_email').focus();

		return false;

	}

	return true;

}
function order($id_pro) {
    $('html,body').animate({scrollTop: '0px'}, 500);
    // alert(1);
    var $id = $id_pro;
    var $quan = $("#quantity").val();
    $.ajax({
        type: 'GET',
        dataType: 'html',
        url: '/index.php?module=products&view=product&raw=1&task=buy',
        data: "quantity=" + $quan + "&id=" + $id,
        success: function (data) {
            if (data == 1) {
                alert('Sản phẩm tạm thời hết hàng');
                // Alert.render('Sản phẩm tạm thời hết hàng');
                return false;
            } else {
                $("#wrapper-popup").html(data);
                ajax_pop_cart();
                del_cart();
                $(".wrapper-popup").show();
                $(".full").show();
            }
        }
    });


}

function ajax_pop_cart() {
    $("#close-cart").click(function () {
        $(".wrapper-popup-2").hide();
        $(".wrapper-popup").hide();
        $(".full").hide();
    });
}

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

            }
        });
    });
    $(".continue-buy").click(function () {
        document.order_form.submit();
    });
}
// $(window).scroll(function () {
//     // alert($(this).scrollTop());
//     if ($(this).scrollTop() >= 250 && $(this).scrollTop() < 2339) {
//         $('.menu_footer').fadeIn();
//     }
//
//     if ($(this).scrollTop() > 2400) {
//         $('.menu_footer').fadeOut();
//     }
//     if ($(this).scrollTop() < 250) {
//         $('.menu_footer').fadeOut();
//     }
//     // else {
//     //     $('.download').fadeOut();
//     // }
// });