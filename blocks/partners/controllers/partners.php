<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/partners/models/partners.php';
	class PartnersBControllersPartners
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
			$model = new PartnersBModelsPartners();
            
            if($style == 'default'){
                $list_cats = $model -> getCats();
    			$array_cats = array();
    			$array_partners = array();
    			$i = 0;
    			foreach (@$list_cats as $items)
    			{
    				$partners_in_cat = $model -> getPartners($items->id );
    				if(count($partners_in_cat)){
    					$array_cats[] = $items;
    					$array_partners[$items->id] = $partners_in_cat;	
    					
    				}
                    $i ++;
    			}
            }else{
                $data = $model -> get_data($ordering);
                if(!count($data))
				    return;
            }
            //print_r($data);die;
   
			include 'blocks/partners/views/partners/'.$style.'.php';
		}
	}
	
?>