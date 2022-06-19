<?php
global $config, $tmpl;
$url = $_SERVER['REQUEST_URI'];
$return = base64_encode($url);

?>
<div id="block_id_<?php echo $id; ?>" class="clearfix">
    <?php echo 'OK'; ?>
</div>
