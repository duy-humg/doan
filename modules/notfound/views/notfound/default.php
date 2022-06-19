<?php 
    global $tmpl,$config;
    $tmpl -> addStylesheet("default","modules/employer/assets/css");
    $tmpl -> addStylesheet("bootstrap.min","modules/employer/assets/css");
    $tmpl -> addStylesheet("resitersuccess","modules/employer/assets/css");
?>

<?php //echo $config['config_thanks_signup']; ?>
<div class="animated fadeInDown">
    <div class="container m-t-lg">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="ibox">
                    <div class="ibox-content fadeInRight animated">
                        <div class="row">
                            <div class="col-sm-12">
                                    <div class="row section-message">
                                        <div class="col-sm-12">
                                            <div class="text-center m-t-xs fadeInDown">
                                                	<?php echo $config['info_404']; ?>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>