<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersCode extends FSControllers
	{
		function display()
		{
			// call models
			$model = $this -> model;

			$rs= $model->checkCode();
			if($rs){
			    $json=array(
			        'name'=> "$rs->title",
                    'code'=> $rs->name,
                    'type'=> $rs->type,
                    'value'=> $rs->val,

                );
                echo json_encode($json);
            }
            else{
                $json = array('error' => 'Error');
                echo json_encode($json);
            }

		}
		
	}
	
?>