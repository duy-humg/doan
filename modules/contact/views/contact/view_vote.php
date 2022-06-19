<div class="popup-show-info">
    <a href="javascript:void(0)" id="close-cart">
        <img src="<?php echo URL_ROOT . 'modules/procedure/assets/images/close-cart.png'; ?>" alt="close cart">
    </a>
    <div class="head_popup">
        <?php echo FSText::_("Kết quả biểu quyết");?>
    </div>
    
    <div class="content-poup">
        <ul>
            <?php 
            $total_2 = ($data->full + $data->notfull + $data->normal)
            ?>
            <li>Rất đầy đủ: <?php echo round(($data->full/$total_2)*100); ?>%</li>
            <li>Chưa đầy đủ: <?php echo round(($data->notfull/$total_2)*100); ?>%</li>
            <li>Bình thường: <?php echo round(($data->normal/$total_2)*100); ?>%</li>
        </ul>
    </div>
</div>
