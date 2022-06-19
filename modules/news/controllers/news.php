<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersNews extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			
			$data = $model->getNews();
			
			if(!$data)
				setRedirect(URL_ROOT,'Không tồn tại bài viết này','Error');
			$ccode = FSInput::get('ccode');
				
			$category_id = $data -> category_id;
			
			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','Error');
                
			$Itemid = 7;
			// relate
			$relate_news_list = $model->getRelateNewsList($category_id);

            $this->update_hits();
 
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2') );
			$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=news&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias));	
            //$breadcrumbs[] = array(0=>$category -> name, 1 => '');	
			//$breadcrumbs[] = array(0=>$data->title, 1 => '');	
			global $tmpl,$module_config;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

            $tmpl->assign('title', $data->title);
//        $tmpl->assign('tags', $data->tags);
            $tmpl->assign('og_image', URL_ROOT . str_replace('/original/', '/small/', $data->image));

            $tmpl->assign('og_des',  getWord(10,$data->summary));

            $tmpl->setTitle($data->title);
//			$tmpl -> assign('title', $data->title);
//			$tmpl -> assign('tags', $data->tags);
//            $tmpl->assign ( 'description', $data->content );
//			$tmpl->assign ( 'og_image', URL_ROOT.$data->image );
			
			// seo
			$tmpl -> set_data_seo($data);
			
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		// check captcha
		function check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			
			if ( $captcha == $_SESSION["security_code"]){
				return true;
			} else {
			}
			return false;
		}
		
		function rating(){
			$model = $this -> model;
			if(!$model -> save_rating()){
				echo '0';
				return;
			} else {
				echo '1';
				return;
			}
		}
		function count_views(){
			$model = $this -> model;
			if(!$model -> count_views()){
				echo 'hello';
				return;
			} else {
				echo '1';
				return;
			}
		}
		// update hits
		function update_hits(){
			$model = $this -> model;
			$news_id = FSInput::get('id');
			$model -> update_hits($news_id);
		}
		
	}
	
?>