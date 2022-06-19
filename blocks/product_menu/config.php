<?php

$params = array(
    'suffix' => array(
        'name' => 'Hậu tố',
        'type' => 'text',
        'default' => '_productmenu'
    ),
    'style' => array(
        'name' => 'Style',
        'type' => 'select',
        'value' => array('default' => 'Mặc định', 'segment' => 'Phân  khúc')
    ),
    'catid' => array(
        'name' => 'Danh mục',
        'type' => 'select',
        'value' => get_categories(),
    ),
);

function get_categories() {
    global $db;
    $query = " SELECT name, id,parent_id
						FROM fs_products_categories
						";
    $db->query($query);
    $list = $db->getObjectList();
    $arr_group = array('' => 'Chọn danh mục');
    if (!$list)
        return;
    $tree = FSFactory::getClass('tree', 'tree/');
    $list = $tree->indentRows2($list);

    foreach ($list as $item) {
        $arr_group[$item->id] = $item->treename;
    }
    return $arr_group;
}

?>