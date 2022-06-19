
<?php 
	class CalendaBModelscalenda
	{
		function __construct()
		{
		  $fstable = FSFactory::getClass('fstable');
		  $this->table_name  = $fstable->_('fs_calenda_event');
		}
        
        function get_list()
		{
			global $db;
			$query = ' SELECT *
    					FROM '. $this->table_name .' 
    					WHERE published = 1 
    					ORDER BY ordering DESC , created_time DESC '
                    ;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;	
		}
	
	}
	
?>