<?php 
    global $config,$tmpl;
    $i = 1;
?>

<?php 
    foreach($list as $item){
?>
    <tr>
        <td><?php echo $i; ?></td>
        <td class="mailbox-name">
            <?php echo $item->name; ?>
        </td>
        <td class="mailbox-star">
            <?php echo $item->category_name ?>
        </td>
        <td>
            <?php echo $item->full_name ?>
        </td>
        <td class="mailbox-date">
            <?php echo date('H:i:s d/m/Y',strtotime($item->created_time)) ?>
        </td>
        <td>
            <a class="fa fa-edit bt_popup" data-id="<?php echo $item->id; ?>" role="button" href="#industry_popup" data-toggle="modal"></a>
        </td>
    </tr>
    <?php $i++; } ?>
