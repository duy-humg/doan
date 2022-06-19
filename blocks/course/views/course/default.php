<?php
    global $tmpl;
    $tmpl -> addStylesheet("default","blocks/course/assets/css");
    $view = FSInput::get('view');
    $id = FSInput::get('id', 0,'int');
?>
<div id="block-course"> 
		<ul>
	        <li class="<?php echo($view=='content')?'active':'' ?>">
	            <a title="Giới thiệu" href="<?php echo FSRoute::_('index.php?module=course&view=content&id='.$id);?>"><span class="icon-title">Giới thiệu tổng quan</span><br/><span><?php echo $data_course->coursename;?></span></a>
	        </li>
	        <li class="course-list <?php echo($view=='cat' || $view=='course')?'active':'' ?>">
	            <a title="Tài liệu học" href="<?php echo FSRoute::_('index.php?module=course&view=cat&id='.$id);?>"><span class="icon-title">Tài liệu học</span><br/><span>Danh sách tài liệu học</span></a>
	        </li>
	        <li class="course-question <?php echo($view=='contest')?'active':'' ?>">
	            <a title="Trắc nghiệm" href="<?php echo FSRoute::_('index.php?module=course&view=contest&id='.$id);?>"><span class="icon-title">Trắc nghiệm</span><br/><span>Bài học trắc nghiệm</span></a>
	        </li>
	        <li class="course-video <?php echo($view=='video')?'active':'' ?>">
	            <a title="Video" href="<?php echo FSRoute::_('index.php?module=course&view=video&id='.$id);?>"><span class="icon-title">Bài học video</span><br/><span>Video các bài học về sản phẩm</span></a>
	        </li>
	        <div class="clear"></div>       
	    </ul>
</div>
