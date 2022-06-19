<?php
//include('libraries/fsfactory.php');

class Comment{
	function save() {
		$name = mysql_real_escape_string(FSInput::get('user_name'));
		$text = mysql_real_escape_string(FSInput::get('text'));
        
		$record_id = FSInput::get('record_id',0,'int');
		$parent_id = FSInput::get('parent_id',0,'int');
		$user_id = FSInput::get('user_id');
		$email = FSInput::get('user_email');
		$rating= FSInput::get('rating');
		$module = FSInput::get('module');
		
		$time = date('Y-m-d H:i:s');
		$published =0;
		
        
        $fs_table = FSFactory::getClass('fstable');
        $this->table_name_comment = $fs_table -> getTable('fs_'.$module.'_comments');
        
		 $sql = " INSERT INTO $this->table_name
					(name,comment,record_id,parent_id,email,user_id,published,created_time,edited_time,rating,add_point)
					VALUES('$name','$text','$record_id','$parent_id','$email','$user_id','$published','$time','$time','$rating',0)
					";
		global $db;
		$db->query($sql);
		$id = $db->insert();
		// insert
        $this->table_name = $fs_table -> getTable('fs_'.$module);
		if(!$count){
			$sql = " UPDATE  $this->table_name
						SET comments_total = comments_total + 1,
						    comments_unread = comments_unread + 1,
						    comments_last_time = '".$time."'
						    WHERE id = ".$record_id."
						";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
		}	
		return $id;
	}

}
?>