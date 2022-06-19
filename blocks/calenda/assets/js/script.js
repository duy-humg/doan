function CustomAlert(){
    this.render = function(dialog){
        var winW = window.innerWidth;
        var winH = window.innerHeight;
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = "block";
        dialogoverlay.style.height = winH+"px";
        dialogbox.style.left = (winW/2) - (320 * .5)+"px";
        dialogbox.style.top = "100px";
        dialogbox.style.display = "block";
        document.getElementById('dialogboxhead').innerHTML = "Thông báo:";
        document.getElementById('dialogboxbody').innerHTML = dialog;
        document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Alert.ok()">OK</button>';
    }
	this.ok = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
var Alert = new CustomAlert();

function getCalendar(year,month){
	$.ajax({
		type:'POST',
		url: '/index.php?module=home&view=home&task=ajax_getCalendar&raw=1',
		data:{year:year,month:month},
        dataType: 'json',
		success : function(data){
            if(data.error == false){
                $('#month').html(data.month);
                $('#days').html(data.days);
            } else {
                Alert.render('Lỗi lấy dữ liệu.');
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            Alert.render('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        }
	});
}
//		
//function getEvents(date){
//	$.ajax({
//		type:'POST',
//		url:'functions.php',
//		data:'func=getEvents&date='+date,
//		success:function(html){
//			$('#event_list').html(html);
//			$('#event_add').slideUp('slow');
//			$('#event_list').slideDown('slow');
//		}
//	});
//}
//
//function addEvent(date){
//	$('#eventDate').val(date);
//	$('#eventDateView').html(date);
//	$('#event_list').slideUp('slow');
//	$('#event_add').slideDown('slow');
//}
//        
//$(document).ready(function(){
//	$('#addEventBtn').on('click',function(){
//		var date = $('#eventDate').val();
//		var title = $('#eventTitle').val();
//		$.ajax({
//			type:'POST',
//			url:'functions.php',
//			data:'func=addEvent&date='+date+'&title='+title,
//			success:function(msg){
//				if(msg == 'ok'){
//					var dateSplit = date.split("-");
//					$('#eventTitle').val('');
//					alert('Event Created Successfully.');
//					getCalendar('calendar_div',dateSplit[0],dateSplit[1]);
//				}else{
//					alert('Some problem occurred, please try again.');
//				}
//			}
//		});
//	});
//});
//        
//$(document).ready(function(){
//	$('.date_cell').mouseenter(function(){
//		date = $(this).attr('date');
//		$(".date_popup_wrap").fadeOut();
//		$("#date_popup_"+date).fadeIn();	
//	});
//	$('.date_cell').mouseleave(function(){
//		$(".date_popup_wrap").fadeOut();		
//	});
//	$('.month_dropdown').on('change',function(){
//		getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
//	});
//	$('.year_dropdown').on('change',function(){
//		getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
//	});
//	$(document).click(function(){
//		$('#event_list').slideUp('slow');
//	});
//});