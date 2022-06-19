<?php if ($tmpl->count_block('top')) { ?>
    <div class="row-content pos-top">
        <?php echo $tmpl->load_position('top'); ?>
    </div> <!-- END: .pos-top -->
    <div class="clearfix"></div>
<?php } ?>
<div class="main-content row-item ">
    <div class=" main_ct">
        <?php if ($tmpl->count_block('left')) { ?>
            <div class="container">
                <div class="row ctt">

                <div class="main-column-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <?php echo $tmpl->load_position('left'); ?>
            </div>
            <div class="main-column-content col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <?php if ($tmpl->count_block('pos_contents_top')) { ?>
                    <div class="row-content pos_contents_top">
                        <?php echo $tmpl->load_position('pos_contents_top'); ?>
                    </div> <!-- END: .pos_contents_top -->
                <?php } ?>

                <?php echo $main_content; ?>

                <?php if ($tmpl->count_block('pos_contents_bottom')) { ?>
                    <div class="row-content pos_contents_bottom">
                        <?php echo $tmpl->load_position('pos_contents_bottom'); ?>
                    </div> <!-- END: .pos_contents_bottom -->
                <?php } ?>
            </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="main-column col-xs-12">
                <?php if ($tmpl->count_block('pos_contents_top')) { ?>
                    <div class="row-content pos_contents_top">
                        <?php echo $tmpl->load_position('pos_contents_top'); ?>
                    </div> <!-- END: .pos_contents_top -->
                <?php } ?>

                <?php echo $main_content; ?>

                <?php if ($tmpl->count_block('pos_contents_bottom')) { ?>
                    <div class="row-content pos_contents_bottom">
                        <?php echo $tmpl->load_position('pos_contents_bottom'); ?>
                    </div> <!-- END: .pos_contents_bottom -->

                <?php } ?>
            </div><!-- END: .main-column -->
        <?php } ?>
<?php //if ($module == 'home'){?>
<!--        <div class=" visible-xs col-sm-12 col-xs-12">-->
<!--            --><?php //echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'leftmenu1_mb',  'group' => 1)); ?>
<!--            --><?php //echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'leftmenu2_mb',  'group' => 5)); ?>
<!--            --><?php //echo $tmpl->load_direct_blocks('favourite_author', array('style' => 'default_mb')); ?>
<!--        </div>-->
<?php //} ?>
    </div>
</div>
<div class="clearfix"></div>
<?php if ($tmpl->count_block('bottom')) { ?>
    <div class="pos-bottom row-content">
        <?php echo $tmpl->load_position('bottom'); ?>
    </div><!--END: .pos-bottom -->
    <div class="clearfix"></div>
<?php } ?>
