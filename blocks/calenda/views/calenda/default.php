<?php 
    global $config,$tmpl;
    $lang = FSInput::get('lang');
    $tmpl -> addStylesheet('default','blocks/calenda/assets/css');
    $tmpl -> addScript('script','blocks/calenda/assets/js');
    
    $dateYear = date("Y");
	$dateMonth = date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
    if($dateMonth == '1'){
        $Year_next = $dateYear;
        $Year_pre = $dateYear - 1;
        $month_next = $dateMonth + 1;
        $month_pre = 12;
    }elseif($dateMonth == '12'){
        $Year_next = $dateYear + 1;
        $Year_pre = $dateYear;
        $month_next = 1;
        $month_pre = $dateMonth - 1;
    }
    
    $fstable = FSFactory::getClass('fstable');
	$this->table_name  = $fstable->_('fs_calenda_event');
    
?>

<div id="calenda-event">
    <div class="month row-item" id="month">      
          <ul>
                <li class="prev" onclick="getCalendar(<?php echo $Year_pre.','.$month_pre ?>)">❮</li>
                <li class="next" onclick="getCalendar(<?php echo $Year_next.','.$month_next ?>)">❯</li>
                <li style="text-align:center">
                  <span><?php echo FSText::_('Lịch sự kiện tháng').' '.date('m/Y') ?> </span>
                </li>
          </ul>
    </div><!-- END: month -->
    
    <div class="content row-item">
        <ul class="weekdays row-item">
              <li><?php echo FSText::_('Su'); ?></li>  
              <li><?php echo FSText::_('Mo'); ?></li>
              <li><?php echo FSText::_('Tu'); ?></li>
              <li><?php echo FSText::_('We'); ?></li>
              <li><?php echo FSText::_('Th'); ?></li>
              <li><?php echo FSText::_('Fr'); ?></li>
              <li><?php echo FSText::_('Sa'); ?></li>
              
        </ul><!-- END: weekdays -->
        
        <ul class="days row-item" id="days">
           <?php $dayCount = 1; 
                $tooltip = '';
                $class = '';
				for($cb=1;$cb<=$boxDisplay;$cb++){
					if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
						$currentDate = date('Y-m-d',strtotime($dateYear.'-'.$dateMonth.'-'.$dayCount));
						$eventNum = 0;
				        $event = $this->get_records(' published = 1 AND created_time = "'.$currentDate.'"',$this->table_name,'name');
                        if(count($event)){
                            $class = 'tooltips';
                            foreach($event as $item){
                                $tooltip .= '<span>'.$item->name.'</span>';
                            }
                        }
						if($currentDate == date("Y-m-d")){
							echo '<li date="'.$currentDate.'" class="grey date_cell '.$class.'">
                                        <time>'.$dayCount.'</time>
                                        <div class="tooltiptext">'.$tooltip.'</div>
                                 ';
						}else if($currentDate < date("Y-m-d")){
							echo '<li date="'.$currentDate.'" class="light_sky date_cell '.$class.'">
                                    <time>'.$dayCount.'</time>
                                    <div class="tooltiptext">'.$tooltip.'</div>
                                ';
						}else{
							echo '<li date="'.$currentDate.'" class="light_to date_cell '.$class.'">
                                    <time>'.$dayCount.'</time>
                                    <div class="tooltiptext">'.$tooltip.'</div>
                                ';
						}
						echo '</li>';
                        $tooltip = '';
                        $class = '';
						$dayCount++;
			?>
			<?php }else{ ?>
				<li>&nbsp;</li>
			<?php } } ?>  
        </ul><!-- END: days -->
    </div><!-- END: content -->
</div>
<!--<li><span class="active">10</span></li>-->