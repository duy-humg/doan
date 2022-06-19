<?php 
	class AddressModelsAddress extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'address';
			$this -> table_name = 'fs_address';
                        
                        $this -> arr_img_paths = array(array('resized',150,150,'cut_image'),array('large',880,487,'cut_image'));
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/address/'.$cyear.'/'.$cmonth.'/'.$cday;
                        
                        
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save($row = array(),$use_mysql_real_escape_string = 0){
			$name = FSInput::get('name');
			if(!$name)
				return false;
			
				
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			$row['latitude'] = FSInput::get('latitude');
			$row['longitude'] = FSInput::get('longitude');
                        
                        
                        $row['more_info'] = htmlspecialchars_decode(FSInput::get('more_info'));
			$id = FSInput::get('id',0,'int');
			// remove other_image
			if(!$this -> remove_other_images($id))
				return false;
			// upload other_imge
			
//			if(!$this->upload_other_images($id))
//			{
//				Errors::setError('Can not upload other_image');
//			}
                         if (! $this->remove_days ( $id )) {		
                        }
                        if (! $this->save_exist_days ( $id)) {
                        }
                        if (! $this->save_new_days ( $id )) {
                        }
			return parent::save($row);
                        
                        
                       
		}
		function remove(){
			$img_paths = array();
			$path_original =  PATH_IMG_ADDRESS.'original'.DS;
			$path_resize =  PATH_IMG_ADDRESS.'resized'.DS; //142x100
			$path_large =  PATH_IMG_ADDRESS.'large'.DS; //309x219
			$img_paths[] = $path_original;
			$img_paths[] = $path_resize;
			$img_paths[] = $path_large;
			return parent::remove('image',$img_paths);
		}
		
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
		}
		
		function get_showroom_images($address_id){
			if(!$address_id)
				return;
			$query   = " SELECT image,id 
						FROM fs_showroom_images
						WHERE address_id = $address_id";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function remove_other_images($add_id)
		{
			if(!$add_id)
				return true;
			$other_images_remove = FSInput::get('other_image',array(),'array');
			$str_other_images = implode(',',$other_images_remove);
			if($str_other_images)
			{
				global $db;
				
				// remove images in folder contain these images
				$query   = " SELECT image 
						FROM fs_showroom_images
						WHERE address_id = $add_id
						AND id IN ($str_other_images)
						";
				$sql = $db->query($query);
				$images_need_remove = $db->getObjectList();
				
				$fsFile = FSFactory::getClass('FsFiles','');
				foreach ($images_need_remove as $item) {
					if($item->image)
					{
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'original'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'resized'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'large'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'medium'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'small'.DS);
						
					}
				}
				
				// remove in database
				$sql = " DELETE FROM fs_showroom_images
						WHERE address_id = $add_id
							AND id IN ($str_other_images)" ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return true;
		}
                function getListDistricts($city_id = 0){
			global $db;
			$sqlWhere = '';
			if($city_id)
				$sqlWhere = ' AND provinceid = "'.$city_id.'"';
			$query = '  SELECT id, name,alias
						FROM district 
						WHERE published = 1 '.$sqlWhere.'
						ORDER BY alias ASC';
//                        echo $query;die;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
                function get_categories_tree2()
		{
			global $db;
			$query = " SELECT *
						  FROM 
						  	province AS a where 1=1 order by a.alias asc
						  	 ";
			//	echo $query;			
			$sql = $db->query($query);
			$result = $db->getObjectList();
//			$tree  = FSFactory::getClass('tree','tree/');
//			$list = $tree -> indentRows2($result);
			return $result;
		}
                function get_city(){
                    global $db;
                    $query = " SELECT a.*
                                              FROM province
                                               AS a
                                                    ORDER BY alias asc ";
                    $sql = $db->query($query);
                    $list = $db->getObjectList();
                    return $list;
                }
                function get_categories_tree()
		{
			global $db;
			$query = " SELECT name,id,province_name,provinceid
						  FROM 
						  	district AS a where 1=1 order by a.alias asc
						  	 ";
			//	echo $query;			
			$sql = $db->query($query);
			$result = $db->getObjectList();
//			$tree  = FSFactory::getClass('tree','tree/');
//			$list = $tree -> indentRows2($result);
			return $result;
		}
                
                 function remove_days($record_id) {
    			if (! $record_id)
    				return true;
    			$other_days_remove = FSInput::get('other_days',array(),'array');
    			$str_other_days = implode(',',$other_days_remove);
    			if ($str_other_days) {
    				global $db;
    				
    				// remove in database
    				$sql = " DELETE FROM fs_address_other
    							WHERE record_id = $record_id AND id IN ($str_other_days)";
    				$db->query ( $sql );
    				$rows = $db->affected_rows ();
    				return $rows;
    			}
    			return true;
    		}
    	function save_exist_days($id) {
    		global $db;
    		// EXIST FIELD
    		$days_exist_total = FSInput::get ( 'days_exist_total' );
    		
    		$sql_alter = "";
    		$arr_sql_alter = array ();
    		$rs = 0;
    		for ($i = 0; $i < $days_exist_total; $i++) {
                    $id_days_exist = FSInput::get('id_days_exist_' . $i);
                    $days_name = mysql_real_escape_string(FSInput::get('days_name_exist_' . $i));
                    $row = array();
                    $row ['source'] = $days_name;
//                    if($i==1){
//                        echo $id_days_exist;die;
//                    }
                    $u = $this->_update($row, 'fs_address_other', ' id=' . $id_days_exist);
                    if ($u)
                        $rs ++;
                }
                return $rs;
    	}
	    
        function save_new_days($record_id) {
        //    die;
    		global $db;
    		for($i = 0; $i < 20; $i ++) {
    			$row = array ();
                $row ['source'] = mysql_real_escape_string(FSInput::get ( 'new_days_name_' . $i ));
    			
                if (! $row ['source']) {
    				continue;
    			}
                
    			$row ['record_id'] = $record_id;
    			$rs = $this->_add ( $row, 'fs_address_other', 1 );
    		}
    		return true;
    	}
                function get_days($tours_id){
                        return $this -> get_records('record_id = '.$tours_id,'fs_address_other');
                }
	}
	
?>