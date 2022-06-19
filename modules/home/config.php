<?php 
//module_view_task
$config_module['home_home'] = array(
	'params' => array (	
				'column_left_name' => array(
							'name' => 'Tên cột bên trái',
							'type' => 'text',
							),
				'column_left_cat' => array(
							'name' => 'Danh mục',
							'type' => 'select',
							'value' => get_categories(),
							),
				'sepa1' => array(
							'type' => 'sepa',
							),			
				'column_center_name' => array(
							'name' => 'Tên cột bên giữa',
							'type' => 'text',
							),			
				'column_center_cat' => array(
							'name' => 'Danh mục',
							'type' => 'select',
							'value' => get_categories(),
							),
				'sepa2' => array(
							'type' => 'sepa',
							),			
				'column_right_name' => array(
							'name' => 'Tên cột bên phải',
							'type' => 'text',
							),
				'column_right_cat' => array(
							'name' => 'Danh mục',
							'type' => 'select',
							'value' => get_categories_content(),
							),			
					
	),

);
/*
 * Hàm liệt kê danh sách cách phương thức resize ảnh
 */
function get_style(){
	return array('default' => 'Mặc định',
				'highlight' => 'Nổi bật',	
		);
}
function get_categories(){
		global $db;
			$query = " SELECT name, id,parent_id
						FROM fs_news_categories
						";
			$db->query($query);
			$list = $db->getObjectList();
			$arr_group = array(''=>'Chọn danh mục');
			if(!$list)
			     return;
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($list);
			
            foreach($list as $item){
            	$arr_group[$item -> id] = $item -> treename;
            }
			return $arr_group;
	}
function get_categories_content(){
		global $db;
			$query = " SELECT name, id,parent_id
						FROM fs_contents_categories
						";
			$db->query($query);
			$list = $db->getObjectList();
			$arr_group = array(''=>'Chọn danh mục');
			if(!$list)
			     return;
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($list);
			
            foreach($list as $item){
            	$arr_group[$item -> id] = $item -> treename;
            }
			return $arr_group;
	}	
?>