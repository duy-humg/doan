<?php global $tmpl;
	$tmpl -> addStylesheet('parents_scroll','blocks/services_menu/assets/css');
//	$tmpl -> addScript('parents_scroll','blocks/services_menu/assets/js');
?>
        <ul class='services_menu  services_menu-<?php echo $style; ?> hiden ' >
	 	<?php 
    	$Itemid  = 5;
    	$root_parrent = 0;
    	foreach ($list as $item){
    		 	$link = FSRoute::_('index.php?module=services&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
    		if($item -> level == 0){
    			echo "<li class='item  ' id='pr_".$item -> id."' >";
    	        echo "<a href='".$link."' ><span> ".$item -> name."</span></a>  ";
    		}
    	}
    	?>
	 </ul> 	
	 <ul class="services_menu_2" >
    	<?php  
    		foreach ( $list as $item ){
    			if($item->alias ==  $ccode){
    				if($item -> level > 0 ){
    					$root_parrent = 	$item -> parent_id;
    				}else{
    					$root_parrent = 	$item -> id;
    				}
    				break;
    			}
    		}
    		
    		foreach ( $list as $item ){ 
    		    $image = URL_ROOT.'blocks/services_menu/assets/images/services_01.png';
    			$link = FSRoute::_('index.php?module=services&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
    			if($item->id == $root_parrent){
    				echo "<li id='pr_".$item->id."' class='item level_".$item->level."'><img src='".$image."' alt='".$item->name."'/><h2><a href='".$link."'>".$item->name."</a></h2></li>";
    			}
    			if($item->parent_id ==  $root_parrent){
    				echo "<li id='pr_".$item->id."' class='item level_".$item->level."'><h3><a href='".$link."'>".$item->name."</a></h3></li>";
    			}
    		}
		?>
	</ul>
        
 