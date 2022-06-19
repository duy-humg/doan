<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/config_service/models/config_service.php';
	class Config_serviceBControllersConfig_service
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$limit = $parameters->getParams('limit');
			$style = $parameters->getParams('style');
            $pos = $parameters->getParams('pos');
			//$timeout = $parameters->getParams('timeout');
			//$is_auto = $parameters->getParams('is_auto');
			$limit = $limit? $limit : '20';
            
			$style = $style ? $style : 'default';
			$ordering = $parameters->getParams('ordering'); 
			//$timeout = $timeout ? $timeout : '3';
			// call models
			$model = new Config_serviceBModelsConfig_service();
            
            $list = $model->get_list();
            if(!count($list))
                return false;
            //print_r($data);die;
   
			include 'blocks/config_service/views/config_service/'.$style.'.php';
		}
	}
	
?>