<?php 
    $active = 0;   
    $active_content = 0; 
?>
<div class="row">
    <div class="col-sm-3 col-xs-12">
        <div class="box  box-info">
            <div class="box-header with-border" >
                <h3 class="box-title text-light-blue">
                    <i class="fa fa-edit"></i> <?php echo FSText::_('Thông tin cơ bản'); ?>
                </h3>
            </div>
            <!-- END: box-header -->
            
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <i class="fa fa-heart"></i> 
                        <b><?php echo FSText::_('Tên:'); ?></b>
                        <h5><?php echo $fun->name; ?></h5>
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-star"></i> 
                        <b><?php echo FSText::_('Module:'); ?></b>
                        <h5><?php echo $fun->category_name; ?></h5>
                    </li>
                    
                    <li class="list-group-item">
                        <i class="fa fa-user"></i> 
                        <b><?php echo FSText::_('Tác giả:'); ?></b>
                        <h5><?php echo @$use->full_name; ?></h5>
                    </li>
                    
                    <li class="list-group-item">
                        <i class="fa fa-clock-o"></i> 
                        <b><?php echo FSText::_('Thời gian:'); ?></b>
                        <time><?php echo date('H:i:s d/m/Y',strtotime($fun->created_time)) ?></time>
                    </li>
                    
                    <li class="list-group-item">
                        <summary class="summary mbc">
                            <i class="fa fa-commenting"></i>
                            <b><?php echo FSText::_('Mô tả:'); ?></b>
                            <?php echo $fun->summary; ?>
                        </summary>
                    </li>
                  </ul>
            </div><!-- END: body -->
        </div><!-- END: box -->
    </div><!-- END: col-sm-3 col-xs-12 -->
    
    <div class="col-sm-9 col-xs-12">
        <?php //include 'box_content.php' ?>
        <div class="box  box-primary">
            <div class="box-header with-border" >
                <h3 class="box-title text-light-blue">
                    <i class="fa fa-edit"></i> <?php echo FSText::_('Thông tin chi tiết'); ?>
                </h3>
            </div>
            <!-- END: box-header -->
        
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <?php if($fun->contronler){ ?>  
                      <li class="<?php echo !$active? 'active':''; ?>">
                        <a href="#contronler-chart" data-toggle="tab" ><?php echo FSText::_('contronler'); ?></a>
                      </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->model){ ?> 
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#model-chart" data-toggle="tab" ><?php echo FSText::_('model'); ?></a>
                        </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->views){ ?> 
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#views-chart" data-toggle="tab" ><?php echo FSText::_('views'); ?></a>
                        </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->css){ ?> 
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#css-chart" data-toggle="tab" ><?php echo FSText::_('css'); ?></a>
                        </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->js){ ?>   
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#js-chart" data-toggle="tab" ><?php echo FSText::_('js'); ?></a>
                        </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->fsrouter){ ?> 
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#fsrouter-chart" data-toggle="tab" ><?php echo FSText::_('fsrouter'); ?></a>
                        </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->htaccess){ ?> 
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#htaccess-chart" data-toggle="tab" ><?php echo FSText::_('htaccess'); ?></a>
                        </li>
                      <?php $active  = 1; } ?>
                      
                      <?php if($fun->sql){ ?> 
                        <li class="<?php echo !$active? 'active':''; ?>">
                            <a href="#sql-chart" data-toggle="tab" ><?php echo FSText::_('sql'); ?></a>
                        </li>
                      <?php } ?>
                    </ul><!-- END: nav -->
                    
                    <div class="tab-content box-body">
                            <?php if($fun->contronler){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="contronler-chart">
                                <?php echo html_entity_decode($fun->contronler); ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->model){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="model-chart">
                                <?php echo html_entity_decode($fun->model); ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->views){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="views-chart">
                                <?php echo html_entity_decode($fun->views); ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->css){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="css-chart">
                                <?php echo html_entity_decode($fun->css); ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->js){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="js-chart">
                                <?php echo $fun->js; ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->fsrouter){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="fsrouter-chart">
                                <?php echo html_entity_decode($fun->fsrouter); ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->htaccess){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="htaccess-chart">
                                <?php echo html_entity_decode($fun->htaccess); ?>
                            </div>
                            <?php $active_content  = 1; } ?>
                            
                            <?php if($fun->sql){ ?>
                            <div class="chart tab-pane <?php echo !$active_content? 'active':''; ?>" id="sql-chart">
                                <?php echo html_entity_decode($fun->sql); ?>
                            </div>
                            <?php  } ?>
                            
                    </div><!-- END: tab-content -->
                </div>
            </div>
            <!-- END: body -->
            
        </div><!-- END: box -->
    </div>
    <!-- END: col-sm-9 col-xs-12 -->
</div>
                    