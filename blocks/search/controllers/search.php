<?php

/*
 * Huy write
 */
	// models 
//include 'blocks/search/models/search.php';
	
	class SearchBControllersSearch
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            
			require_once 'blocks/search/models/search.php';
			$model = new SearchBModelsSearch();
			//$field_work = $model->get_field_work();
			$list_quick = $model->get_list_quick();
			// call views
			include 'blocks/search/views/search/'.$style.'.php';
		}
  
	}
	
?>