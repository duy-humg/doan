<?php 
	class CourseBModelsCourse
	{
		function __construct()
		{
		}
		/*
		 * get Category current
		 * By Id or By code
		 */
		function getCourse()
		{
			$fs_table = FSFactory::getClass('fstable');
			$id = FSInput::get('id',0,'int');
			if(!$id)
				die('Not exist this url');
			$where = " AND id = '$id' ";
			$query = " SELECT id, coursename
						FROM ".$fs_table -> getTable('fs_course')." 
						WHERE published = 1 ".$where;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
	}
?>