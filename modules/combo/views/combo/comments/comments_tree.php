<?php 
	$url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
	$max_level = 1;
?>
<?php 
function display_comment_item($item,$childdren,$level,$max_level = 2,$return){
	$sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
	$html = '<div class="comment-item comment-item-'.$item -> id.' '. ($item -> parent_id? "comment-child":""). ' comment_level_'.$level.' comment_sub_'.$sub.'"   >';
	
    $html .= '<div class="row-item item-comment">';			
	$html .= '<p class="name row-item"><img class="fl-left" alt="" height="25" src="'.URL_ROOT.'images/noavata.jpg">'.$item -> name.'</p> ';
    $html .= '</div>';
    
	$html .= '<div class="comment_content "> ';
    $html .= '<p class="content">'.$item -> comment.'</p>';
    $html .= '<div class="row-item _control">';	
    $html .= '<a class="button_reply" href="javascript: void(0)" >Trả lời</a>';
    $html .= '<span class="date">'. time_elapsed_string(strtotime($item -> created_time)) .'</span> ';
    $html .= '</div>';	
	$html .= '	<div class="reply_area hide row-item">';
	$html .= '	<form action="#" method="post" name="comment_reply_form_'.$item -> id.'"  id="comment_reply_form_'.$item -> id.'"  class="form_comment">';
	$html .= '<textarea class="col-xs-12 pal message" name="text" rows="8" placeholder="'.FSText::_('Nội dung').'" required ></textarea>';
    $html .= '<div class="row">
                <div class="label  col-xs-12 col-sm-3 ">
                    <label>Tên</label>
            		<input title="Nhập họ tên của bạn ít nhất 6 ký tự" pattern=".{6,}" class="pas txt_input" type="text" name="name" placeholder="'.FSText::_('Tên của bạn').'" required />
            	</div>
                <div class="label col-xs-12 col-sm-3">
                    <label>Email</label>
            		<input title="Nhập đúng định dạng Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,10}$" class="pas txt_input" type="text" name="email" placeholder="'.FSText::_('Email của bạn').'" required />
            	</div>
                <div class="button_area col-xs-12 col-sm-6 ">
                    <label>&nbsp;</label>
                    <a class="button_reply_close button" href="javascript: void(0)" ><span>Đóng lại</span></a>
                    <input class="button fl-right submitbt" type="submit" value="'.FSText::_('Gửi').'" />
            	</div>
        	</div>';
//    $html .= '<p class="name_email row">';
//	$html .= 	'<label class=" col-lg-6">';
//	$html .= '		<input type="text" class="txt_input" id="name_'.$item -> id.'" value="Họ tên" name="name" placeholder="'.FSText::_('Tên của bạn').'" size="40" />';
//	$html .= 	'</label>';
//	$html .= 	'<label class=" col-lg-6">';
//	$html .= '		<input type="text" class="txt_input" id="email_'.$item -> id.'" value="Email" name="email" size="40" placeholder="'.FSText::_('Email của bạn').'" />';
//	$html .= 	'</label>';
//	$html .= '	</p>';
//	$html .= '		<p class="text_area_ct">';
//	$html .= '			<textarea class="txt_input" id="text_'.$item -> id.'" cols="64" rows="4" name="text" onfocus="if(this.value==\'Nội dung\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Nội dung\'">Nội dung</textarea>';
//	$html .= '		</p>';
//			 
//	$html .= '		<p class="reply_button_area ">';
//	$html .= '			<a class="button_reply_close button" href="javascript: void(0)" >';
//	$html .= '				<span>Đóng lại</span>';
//	$html .= '			</a>';
//	$html .= '			<a class="button" href="javascript: void(0);" onclick="javascript: submit_reply('.$item -> id.'); ">';
//	$html .= '				<span>Gửi</span>';
//	$html .= '			</a>';
//	$html .= '			<div class="clear"></div>';
//	$html .= '		</p>';
	
	$html .= '<input type="hidden" value="1" name="raw" />';
	$html .= '<input type="hidden" value="news" name="module" />';
	$html .= '<input type="hidden" value="news" name="view" />';
	$html .= '	<input type="hidden" value="save_reply" name="task" />';
	$html .= '	<input type="hidden" value="'.$item->id.'" name="parent_id"  />';
	$html .= '	<input type="hidden" value="'.$item->record_id.'" name="record_id"  />';
	$html .= '	<input type="hidden" value="'.$return.'" name="return"  />';
	$html .= '	</form>';
	$html .= '	</div>';
	$html .= '</div>';
	if($level >= $max_level){
		$html .= '</div>';
	}
	if(isset($childdren[$item -> id]) && count($childdren[$item -> id])){
		foreach($childdren[$item -> id] as $c ){
			$html .= display_comment_item($c,$childdren,$level + 1,$max_level = 2,$return );
		}
	}
	if($level < $max_level){
		$html .= '</div>';
	}
	return $html;
}
?>
<div class='comments'>
				
		<?php 
		$num_child = array();
		$wrap_close = 0;
		if($comments){
		?>
			<div class='comments_contents'>
			<?php foreach ($list_parent as $item){ ?>
				<?php echo  display_comment_item($item,$list_children,0,3,$return);?>
			<?php }?>
			</div>
		<?php }?>
	
	
	<!-- FORM COMMENT	-->
	<div class='comment_form_title row-item' >Gửi bình luận</div>
    
	<form action="#" method="post" name="comment_add_form" id='comment_add_form' class='form_comment row-item'>
        <textarea  class="col-xs-12 pal message" name="text" rows="8" placeholder="<?php echo FSText::_('Nội dung'); ?>" required ></textarea>
        <div class="row">
            <div class="label  col-xs-12 col-sm-3 ">
                <label>Tên</label>
        		<input id="name" title="Nhập họ tên của bạn ít nhất 6 ký tự" pattern=".{6,}" class="pas txt_input" type="text" name="name" placeholder="<?php echo FSText::_('Tên của bạn'); ?>" required />
        	</div>
            <div class="label col-xs-12 col-sm-3">
                <label>Email</label>
        		<input id="email" title="Nhập đúng định dạng Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,10}$" class="pas txt_input" type="text" name="email" placeholder="<?php echo FSText::_('Email của bạn'); ?>" required />
        	</div>
            <div class="button_area col-xs-12 col-sm-6 ">
                <label>Mã bảo mật</label> 
        		<input type="text" id="txtCaptcha" value="" name="txtCaptcha" class="pas" placeholder="<?php echo FSText::_('Mã bảo mật'); ?>" required />	
        		<a href="javascript:changeCaptcha();" title="Click here to change the captcha" class="code__view">
        			<img id="imgCaptcha" src="http://eswap.vn/libraries/jquery/ajax_captcha/create_image.php" style="display: none;" />
                    <span class="view-change"><?php echo FSText::_('Click lấy mã xác minh'); ?></span>
        		</a>
                <input class="button fl-right submitbt" type="submit" value="<?php echo FSText::_('Gửi'); ?>" />
        	</div>
    	</div>
        
		<input type="hidden" value="1" name='raw' />
		<input type="hidden" value="news" name='module' />
		<input type="hidden" value="news" name='view' />
		<input type="hidden" value="save_comment" name='task' />
		<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
		<input type="hidden" value="<?php echo $return;?>" name='return'  />
	</form>
	<!-- end FORM COMMENT	-->
</div>

