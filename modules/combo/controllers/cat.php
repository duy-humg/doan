<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersCat extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$cat  = $model->getCategory();
			if(!$cat)
			{
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','error');
			}
			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($cat->id);
			$list = $model->getNewsList($query_body);
//			var_dump(count($list));
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
            $breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
            if($cat->parent_id){
                $list_cat_parent = $model->get_record_by_id($cat->parent_id,'fs_news_categories','id,alias,name');
                $breadcrumbs[] = array(0=>$list_cat_parent->name, 1 => FSRoute::_('index.php?module=news&view=cat&ccode='.$list_cat_parent->alias.'&id='.$list_cat_parent->id.'&Itemid=3'));
            }
			$breadcrumbs[] = array(0=>$cat->name);
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_data_seo($cat);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

        function loadmore()
        {
            // call models
            $model = $this->model;


            $pagecurrent = FSInput::get('pagecurrent');
            $limit = FSInput::get('limit');
            $cat_id = FSInput::get('cat_id');


            $total_old = $pagecurrent * $limit;
            $gt = $total_old . ',' . $limit;

            $fs_table = FSFactory::getClass('fstable');



            $query_body = $model->set_query_body($cat_id);
            $list = $model->getNewsList($query_body);


            if (!$list)
                return;

            include 'modules/' . $this->module . '/views/' . $this->view . '/load_more.php';
        }
        
        function ajax_session(){
            $type = FSInput::get('type');
            if($type){
                $_SESSION['type'] = $type;
                echo 1;
            }else{
                echo 0;
            }
        }
	}
	
?>