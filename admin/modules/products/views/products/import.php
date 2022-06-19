<?php
$title = 'Import excel';
global $toolbar, $arrProductLine;
$toolbar->setTitle($title);
$toolbar->addButton('do_import',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');
$this -> dt_form_begin(0);
//echo 1;
?>
    <table cellspacing="1" class="admintable" style="width: 100%;" >
        <tr>
            <td class="label key">Chọn file cần import</td>
            <td class="value">
                <input type="file" name="import" id="import" />
            </td>
        </tr>
    </table>
<?php
$this -> dt_form_end(@$data,0);
?>