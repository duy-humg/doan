<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/calenda/models/calenda.php';
	class CalendaBControllersCalenda
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$cat_id = $parameters->getParams('category_id'); 
			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:3; 
			// call models
			$model = new CalendaBModelscalenda();
            //$list = $model->get_list();
            
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
			
			// call views
			include 'blocks/calenda/views/calenda/'.$style.'.php';
		}
        function get_record($where = '', $table_name = '', $select = '*') {
    		if (! $where)
    			return;
    		if (! $table_name)
    			$table_name = $this->table_name;
    		$query = " SELECT " . $select . "
    					  FROM " . $table_name . "
    					  WHERE " . $where;
    		
    		global $db;
    		$db->query ( $query );
    		$result = $db->getObject ();
    		return $result;
    	}
        
        function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '') {
    		$sql_where = " ";
    		if ($where) {
    			$sql_where .= ' WHERE ' . $where;
    		}
    		if (! $table_name)
    			$table_name = $this->table_name;
    		$query = " SELECT " . $select . "
    					  FROM " . $table_name . $sql_where;
    		
    		if ($ordering)
    			$query .= ' ORDER BY ' . $ordering;
    		if ($limit)
    			$query .= ' LIMIT ' . $limit;
    		
    //		echo $query;
    		global $db;
    		$sql = $db->query ( $query );
    		if (! $field_key)
    			$result = $db->getObjectList ();
    		else
    			$result = $db->getObjectListByKey ( $field_key );
    		return $result;
    	}
	}
	
?>