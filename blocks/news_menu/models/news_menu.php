<?php 
	class News_menuBModelsNews_menu
	{
		function __construct()
		{
            $fstable = FSFactory::getClass('fstable');
            $this->table_name = $fstable->_('fs_news');
            $this->table_categories = $fstable->_('fs_news_categories');
		}
        
        function getListCat($category_id){
            //$id = FSInput::get('id');
	        $where = '';
            if($category_id) 
                $where = ' AND  parent_id =  '. $category_id ;  
			$query = ' SELECT name,alias,id,level,parent_id as parent_id,alias, list_parents,icon 
						  FROM '. $this->table_categories .' AS a
						  WHERE published = 1 '. $where .'
						  ORDER BY ordering ASC, id ASC
						 ';            
			global $db;
			$db->query($query);
			$category_list = $db->getObjectList();
			
			if(!$category_list)
			  return;
			$tree_class  = FSFactory::getClass('tree','tree/');
			return $list = $tree_class -> indentRows2($category_list,3);
				
		}
        function getNews()
        {
            $id = FSInput::get2('id',0,'int');
            if($id){
                $where = " id = '$id' ";
            } else {
                $code = FSInput::get('code');
                if(!$code)
                    die('Not exist this url');
                $where = " alias = '$code' ";
            }
            $fs_table = FSFactory::getClass('fstable');
            $query = " SELECT id,title,content,category_id,category_alias, summary,hits, video, is_video,
                        alias, tags, created_time, updated_time,seo_title,image,optimal_seo,
                        seo_keyword,seo_description,news_related,author_id,products_related
						FROM ".$fs_table -> getTable('fs_news')." 
						WHERE
						".$where." ";
            //print_r($query) ;
            global $db;
            $sql = $db->query($query);
            $result = $db->getObject();
            return $result;
        }
		
	}
?>