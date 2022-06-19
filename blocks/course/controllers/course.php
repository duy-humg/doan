<?php
/*
 * Huy write
 */
// models 
include 'blocks/course/models/course.php';

class CourseBControllersCourse {
	function __construct() {
	}
	function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			// call models
			$model = new CourseBModelsCourse();
            $data_course = $model->getCourse();
			
			// call views
			include 'blocks/course/views/course/'.$style.'.php';
		}
	}
?>