<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/video/models/video.php';
	class VideoBControllersVideo
	{
		function __construct()
		{
		}
		function display($parameters,$title,$id)
		{
			$vid = $parameters->getParams('link');
//                        var_dump($link);die;
            
			$model = new VideoBModelsVideo();
			include 'blocks/video/views/video/default.php';
		}
               
	}
	
?>