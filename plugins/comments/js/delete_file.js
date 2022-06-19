function removeElement(divNum,data,table) {
  if (confirm('Bạn chắc chắn muốn xóa file này?')){
	  var d = document.getElementById('sortable');
	  var olddiv = document.getElementById(divNum);
	  $.ajax({
			url: "../index.php?module=members&view=seekers&raw=1&task=deleteOtherImage",
			type: "get",
			data: "data="+data+"&table="+table,
			error: function(){
				alert("Lỗi xóa dữ liệu");
			},
            success: function(){
                d.removeChild(olddiv);
            }
 		});
  }else{
  	return false;
  }
}