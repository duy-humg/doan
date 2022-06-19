    function dropFunction(id) {
    var x = document.getElementById(id);
    
    
}
function filterFunction(id,input) {
    var input, filter, ul, li, a, i;
    input = document.getElementById(input);
    filter = input.value.toUpperCase();
    div = document.getElementById(id);
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
$(".w3-btn").mouseout(function() {
    $(".w3-dropdown-content").delay(500).removeClass("w3-show");
    $(this).removeClass("show-sub-filter")
});
$(".show-sub-filter").mouseover(function() {
    $(this).siblings(".w3-dropdown-content").addClass("w3-show");
});
$(".w3-dropdown-content").mouseover(function() {
    $(this).delay(500).addClass("w3-show");
    $(this).siblings(".w3-btn").addClass("show-sub-filter");
});
$(".w3-dropdown-content").mouseout(function() {
    $(".w3-dropdown-content").delay(500).removeClass("w3-show");
    $(".w3-btn").delay(1000).removeClass("show-sub-filter");
});
$(document).ready(function(){
     $(".view-more-ft").on("click",function(){
        $(this).siblings(".hidden-filter").toggleClass("show-sub-filter");
		$(this).siblings(".view-less-ft").toggleClass("show-sub-filter");
		$(this).toggle();
		$(this).siblings(".view-less-ft").show();
     });
	 $(".view-less-ft").on("click",function(){
        $(this).siblings(".hidden-filter").toggleClass("show-sub-filter");
		$(this).siblings(".view-more-ft").toggleClass("show-sub-filter");
		$(this).toggle();
		 $(this).siblings(".view-more-ft").show();
     });
//     $(window).on("load",function(){
//        $(".wrapper-filter").mCustomScrollbar({
//                theme:"minimal"
//        });
//    });
});

