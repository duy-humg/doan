<?php 
	class PartnersBModelsPartners
	{
		function __construct()
		{
		      $this->table_name = 'fs_partners';
              $this->table_categories = 'fs_partners_categories';
              $this -> limit = 20;
		}
		
		function get_data($ordering){
			$where=" published = 1 ";
            
			$order = '';
				switch ($ordering){
    				case 'alphabet':
    					$order .= ' ORDER BY name ASC';
    					break;
    				case 'manual':
    					$order .= ' ORDER BY ordering';
    					break;
    				default:
    					$order .= ' ORDER BY ordering';
    					break;
				}
			$query = "  SELECT id,name,image,url
					FROM fs_partners
					WHERE ".$where."
					 ".$order."
					 ";
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
        /*
		 * select cat list is children of catid
		 */
		function getCats()
		{
			global $db;
			$query = ' SELECT *
					FROM '. $this->table_categories .' 
					WHERE published = 1 
					ORDER BY ordering ASC , created_time DESC
					';
                  
			$db->query($query);
			$list = $db->getObjectList();
			return $list;	
		}
        
        function getPartners($cat_id)
		{
		    $where = '';  

			global $db;
			if(!$cat_id)
				return false;
			
			$order = " ORDER BY ordering DESC, id DESC ";
			$query   = ' SELECT *
						FROM '. $this->table_name .' 
						WHERE category_id_wrapper like "%'.$cat_id.'%" AND published = 1 '.$where 
						.$order.' 
						LIMIT '.$this -> limit; 
            //print_r($query);             			
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
        
	}
	
?>