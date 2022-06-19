<?php
/*
 * Huy write
 */
// models
include 'blocks/services_menu/models/services_menu.php';

class Services_menuBControllersServices_menu
{
    function __construct()
    {
    }

    function display($parameters, $title)
    {
        $style = $parameters->getParams('style');
        $style = $style ? $style : 'default';

        $cid = FSInput::get('cid');
        // call models
        $model = new Services_menuBModelsServices_menu();
        $paren = $model->getCat($cid);
//        var_dump($paren);


        if ($paren->level != 0) {
//            $ppid = $model->getParentId($paren->id);
//            var_dump($ppid);
//
//            $pparent = $model->getCat($ppid);
////                var_dump($pparent);
            $list_parents = $paren->list_parents;
            $list_parents = str_replace(',' . $cid, '', $list_parents);
//            var_dump($list_parents);
            $str_list_parents = trim($list_parents, ',');
            $arr_list_parents = explode(',', $str_list_parents);
        }

        $list = $model->getListCat($cid, $paren->level);
//			if(!$list){
//                $list = $model->getListCat($cid,$paren->level-1);
//            }

        // need_chek
        $module = FSInput::get('module');
        $need_check = 0;
        $root_parrent_activated = 0;
        $group_has_parent_activated = array();

        if ($module == 'services') {
            $ccode = FSInput::get('ccode');
            foreach ($list as $item) {
                if ($item->alias == $ccode) {
                    if ($item->level > 0) {
                        $root_parrent_activated = $item->parent_id;
                        $group_has_parent_activated[] = $item->id;
                        $group_has_parent_activated[] = $item->parent_id;
                        $level_current = $item->level;

                        // Lấy tree có độ sâu > 2
                        while ($level_current > 1) {
                            foreach ($list as $item_child) {
                                if ($item_child->id == $root_parrent_activated) {
                                    $group_has_parent_activated[] = $item_child->id;
                                    $group_has_parent_activated[] = $item_child->parent_id;
                                    break;
                                }
                            }
                            $level_current--;
                        }
                    } else {
                        $root_parrent_activated = $item->id;
                        $group_has_parent_activated[] = $item->id;
                    }
                    break;
                }
            }
        }
        // call views
        include 'blocks/services_menu/views/services_menu/' . $style . '.php';
    }
}

?>