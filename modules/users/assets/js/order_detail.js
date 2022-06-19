  $(document).ready(function() {
    var maxHeight = 0;			
    $(".col-2").each(function(){
      if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
    });			
    $(".col-2").height(maxHeight);
  });
  function re_order($id_pro) {
      $('html,body').animate({scrollTop: '0px'}, 500);
      // alert(1);
      var $id = $id_pro;
      var $quan = '1';
      $.ajax({
          type: 'GET',
          dataType: 'html',
          url: '/index.php?module=products&view=product&raw=1&task=re_buy',
          data: "quantity=" + $quan + "&id=" + $id,
          success: function (data) {
              $("#wrapper-popup").html(data);
              ajax_pop_cart();
              del_cart();
          }
      });
      $(".wrapper-popup").show();
      $(".full").show();

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

function mualai(id){
    $("#mualai_"+id).submit();
}
