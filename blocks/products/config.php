<?php

$params = array(
    'suffix' => array(
        'name' => 'Hậu tố',
        'type' => 'text',
        'default' => '_products'
    ),
    'limit' => array(
        'name' => 'Giới hạn',
        'type' => 'text',
        'default' => '6'
    ),
    'type' => array(
        'name' => 'Lấy theo',
        'type' => 'select',
        'value' => array(
            'new' => 'Mới nhất',
            'hot' => 'Bán chạy',
            'home' => 'Check home',
            'sale' => 'Khuyến mại hot',
            'coming' => 'Sắp ra mắt',
        ),
        'attr' => array('multiple' => 'multiple'),
    ),		
    'style' => array(
        'name' => 'Style',
        'type' => 'select',
        'value' => array(
            'default' => 'Full',
            'default_cat' => 'Danh mục',
        )
    ),
    'category_id' => array(
        'name' => 'Nhóm danh mục',
        'type' => 'select',
        'value' => get_category(),
	'attr' => array('multiple' => 'multiple'),
    ),
);

function get_category() {
    global $db;
    $query = " SELECT name, id 
						FROM fs_products_categories 
						";
    $sql = $db->query($query);
    $result = $db->getObjectList();
    if (!$result)
        return;
    $arr_group = array();
    foreach ($result as $item) {
        $arr_group[$item->id] = $item->name;
    }
    return $arr_group;
}

?>