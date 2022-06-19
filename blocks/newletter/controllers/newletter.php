<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/newletter/models/newletter.php';
	class NewletterBControllersNewletter
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$id = $parameters->getParams('link');
//                        var_dump($link);die;
            
			$model = new NewletterBModelsNewletter();
			include 'blocks/newletter/views/newletter/default.php';
		}
                
               
	}
	
?>