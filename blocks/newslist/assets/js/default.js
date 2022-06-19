$(document).ready(function(){
     $('#home ul li').hover(function(){
         var id = $(this).attr('id_data');
         $.ajax({
            type : 'GET',
            dataType: 'json',
            url : '/index.php?module=news&view=home&raw=1&task=show_home',
            data: "id="+id,
            success : function(result){
                $("#new-show").css("display", "none");
                $("#new-show").html(result.html);
                $("#new-show").fadeIn(200);
            },
            timeout: 3000 
        });
     });
});
