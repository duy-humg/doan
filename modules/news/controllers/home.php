<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersHome extends FSControllers
	{
		function display()
		{			
			// call models
			$model = $this -> model;

			global $tags_group;
			
//			$categories = $model->get_records(' published = 1 ','fs_news_categories','id,name,alias');

			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
//			var_dump($list);
		
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);

            $list_dm = $model->list_dm();
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=> FSText::_('Tin tức'), 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
                
                function show_home(){
                    $id = FSInput::get('id');
                    $model = $this -> model;
                    $error_image =  URL_ROOT.'images/logo1lduoc.jpg';
                    $data = $model->getNews($id);
                    $link = FSRoute::_("index.php?module=news&view=news&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias);
                    $html = '<a class="new-item" href='.$link.' title="'.$data->title.'" >
                        <img src="'.URL_ROOT. str_replace('original', 'large_2', $data->image).'" class="img-responsive" onerror="this.onerror=null;this.src="'.$error_image.'";" >
                        <p>'.getWord(20, $data->title).'</p>
                    </a>';
                    
                    $result = array();
                    $result['result'] = true;
                     $result['html'] = $html;
                    echo json_encode($result);
                    return $result;
                }
		
	}
	
?>