<?php
    global $tmpl;
    $tmpl -> addStylesheet('config_service', 'blocks/config_service/assets/css');
?>

<div class="row">
<?php foreach ($list as $item) {
    ?>
    <div class="col-sm-6 col-xs-12">
        <div class="item-intro row-item">
			<h3>
        <a href="<?php echo $item->link_title; ?>"><?php echo $item->name; ?></a>
      </h3>
			<summary><?php echo $item->summary ?></summary>

            <div class="contents row-item">
                <?php echo str_replace('<br/>', '', html_entity_decode($item->content)); ?>
            </div><!--  END: col-sm-6 -->

			<div class="buy-ndt">
                <?php if ($item->name_link1) {
        ?>
				<a class="link1" href="<?php echo $item->link1 ?>"><?php echo $item->name_link1; ?></a>
                <?php
    } ?>

                <?php if ($item->name_link2) {
        ?>
				<a class="link2" href="<?php echo $item->link2 ?>"><?php echo $item->name_link2; ?></a>
                <?php
    } ?>
			</div><!--  END: buy-ndt -->

            <?php if ($item->sale) {
        ?>
            <div class="sales-intro posis-<?php echo $item->positions ?>">
				<?php echo html_entity_decode($item->sale); ?>
			</div>
            <?php
    } ?>
		</div><!--  END: item-intro -->
    </div><!--  END: col-sm-6 -->
<?php
} ?>
 </div>
