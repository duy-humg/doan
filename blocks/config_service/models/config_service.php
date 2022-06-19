<?php 
	class Config_serviceBModelsConfig_service
	{
		function __construct()
		{
		    $this->table_name = 'fs_config_employer';
		}
		
		function get_list(){
		  
			$where = " published = 1 ";
			
			$query = ' SELECT *
					   FROM '.$this->table_name.'
					   WHERE '.$where .' ORDER BY ordering ASC,id DESC '
                     ;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
        
	}
	
?>