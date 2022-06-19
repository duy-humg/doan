<?php

/*
 * Huy write
 */

// controller

class ProductsControllersCat extends FSControllers
{

    var $module;
    var $view;

    function display()
    {

        // call models
        $model = $this->model;
        $cat = $model->getCategory();

//        var_dump($cat->id);

        if($cat->level >= 0){

            $list_cat = $model->get_cat($cat->parent_id);
            $get_name_cat = $model->get_name_cat($cat->parent_id);
            $list_type = $model->type($cat->id);
//            var_dump($list_type);
        }

        $banner = $model->banners();
        $list_dm = $model->dm($cat->id);
        $dm_0 = $model->dm_0();
        $list_price_ = $model->list_price();

        $category_url = FSInput::get('category');
        if($category_url){
            $category_url_2 = explode(':',$category_url);
            $list_bl = $model->list_bl($category_url_2[0]);
        }else{
            $list_bl = $model->list_bl($cat->id);
        }
       
   


        $list_cat_child = $model->get_cat($cat->id);
       
        $bread = explode(',', $cat->list_parents);
        $bread = array_reverse($bread);
        if (!$bread) {
            setRedirect(URL_ROOT, 'Không tồn tại danh mục này', 'Error');
        }
        $category = array();
        $j = 0;
        $breadcrumbs = array();
//        $breadcrumbs[] = array(0 => $cat->name);
        foreach ($bread as $item) {
            if ($item) {
                $category[$j] = $model->get_category_by_id($item);
                if (!$category[$j])
                    setRedirect(URL_ROOT, 'Không tồn tại danh mục này', 'Error');
                $breadcrumbs[] = array(0 => $category[$j]->name, 1 => FSRoute::_('index.php?module=products&view=cat&ccode=' . $category[$j]->alias . '&cid=' . $item . '&Itemid=3'));
            }
            $j++;
        }
        // var_dump($cat->id);/

   

        global $tags_group;
//            $tags_group = $cat -> tags_group;
        $total_pr = $model->count_total($cat->id);

        $query_body = $model->set_query_body1($cat->id, '');
   
        $list = $model->getProductsList1($query_body);

        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);
        // $total = $model->getTotal($query_body);
        // $pagination_2 = $model->getPagination_2($total_pr);

        // var_dump(count($list));

        $arr_hang = array();;
        foreach ($list as $item){
            $arr_hang[] = $item->hang_id ;
        }

        $arr_hang =array_unique($arr_hang);
//        var_dump($arr_hang);
        $query_body_hang = $model->set_query_body_hang();
        $list_hang = $model->get_list_hang($query_body_hang);

        $list_hang_2 = array();
        foreach ($list_hang as $item_){
            foreach ($arr_hang as $item_city){
//                echo $item_city;
//                echo '<br>';
//                echo $item_->id;
//                echo '<br>';
//                echo '<br>';
                if($item_city == $item_->id){
                    $list_hang_2[]= $item_;
                }
            }
        }
//        var_dump(count($list_hang_2));


//        var_dump();
//        echo count($list);die;
        
       
        // var_dump($pagination_2);
        $list_company = $model->getListCompany();
        $list_author = $model->getListauthor();

        $list_tags = $model->getListTags();
        $list_price = $model->getListPrice();
        $list_object = $model->getListObject();
        $list_color = $model->getListColor();
        $list_origin = $model->getListOrigin();
        $list_producer = $model->getListProducer();
        $list_prdcer = array();
//        var_dump($list);
        foreach ($list as $item) {
            if (isset($item->producer_id) && !empty($item->producer_id)) {
                if (in_array($item->producer_id, $list_prdcer)) {
                } else {
                    $list_prdcer[] = $item->producer_id;
                }
            }
        }
        $list_prdcer_ = array();
        foreach ($list_producer as $item) {
            foreach ($list_prdcer as $key) {
                if ($key == $item->id) {
                    $list_prdcer_[] = $item;
                }
            }
        }

//        $banner1 = $model->get_records('published = 1 and category_id = 14', 'fs_banners');
//        $banner2 = $model->get_records('published = 1 and category_id = 15', 'fs_banners');
//        $banner3 = $model->get_records('published = 1 and category_id = 17', 'fs_banners');
//        $banner4 = $model->get_records('published = 1 and category_id = 16', 'fs_banners');

        $prices = FSInput::get('prices');
        if ($prices) {
            $pr = explode(':', $prices);
            $pri = $model->getPrice($pr[0]);
        }

        $get_hang = FSInput::get('hang');
        if ($get_hang) {
            $a_hang = explode(':', $get_hang);
            $name_hang = $model->gethang($a_hang[0]);
        }

        $get_type = FSInput::get('type');
        if ($get_type) {
            $a_type = explode(':', $get_type);
//            var_dump($a_type[0]);
            $name_type = $model->gettype($a_type[0]);
//            var_dump($name_type);
        }



        $origin = FSInput::get('origin');
        if ($origin) {
            $or = explode(':', $origin);
            $ori = $model->getOrigin($or[0]);
        }

        $object = FSInput::get('object');
        if ($object) {
            $ob = explode(':', $object);
            $obj = $model->getObject($ob[0]);
        }

        $color = FSInput::get('color');
        if ($color) {
            $co = explode(':', $color);
            $cor = $model->getColor($co[0]);
        }

        $producer = FSInput::get('producer');
        if ($producer) {
            $pr = explode(':', $producer);
            $pro = $model->getProducer($pr[0]);
        }

        $company = FSInput::get('company');
        if ($company) {
            $com = explode(':', $company);
            $coma = $model->getCompany($com[0]);
        }

        global $tmpl;

//        $tmpl->assign('title', $cat->name);
        $tmpl->setMeta('og:image', URL_ROOT . $cat->image);
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->assign('canonical', FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias . '&cid=' . $cat->id . '&Itemid=3'));
        // seo
        $tmpl->set_data_seo($cat);


//        var_dump($cat);die;
//        if ($cat->level == 0){
        // call views
        $query_body_hot = $model->set_query_body($cat->id, 'is_hot');
//            var_dump($query_body_hot);
        $list_hot = $model->getProductsList($query_body_hot);

        $query_body_sale = $model->set_query_body($cat->id, 'is_sale');
        $list_sale = $model->getProductsList($query_body_sale);

        $query_body_new = $model->set_query_body($cat->id, 'is_news');
        $list_new = $model->getProductsList($query_body_new);

        $query_body_coming = $model->set_query_body($cat->id, 'coming_soon');
        $list_coming = $model->getProductsList($query_body_coming);

//            var_dump($list_coming);
//
//        if ($cat->level == 0){
//            include 'modules/' . $this->module . '/views/' . $this->view . '/default_cat.php';
//        }else{
        // call views

            include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';

    }

    function loadmore_hang()
    {
        // call models
        $model = $this->model;


        $pagecurrent = FSInput::get('pagecurrent');
        $limit = FSInput::get('limit');
        $type_id = FSInput::get('type_id');
        $type_alias = FSInput::get('type_alias');
        $htp_host = FSInput::get('htp_host');
        $uri = FSInput::get('uri');

        $total_old = $pagecurrent * $limit;
        $gt = $total_old . ',' . $limit;

        $fs_table = FSFactory::getClass('fstable');



        // phan trang
//        $query_body = $model->set_query_body();
//        $list_ = $model->get_list($query_body);



        $query_body_hang = $model->set_query_body_hang();
        $list_ = $model->get_list_hang($query_body_hang);
//        var_dump($list_);

//        if (count($list) < $limit)
//            echo '<script>$(".c-view-more .load_more").hide();</script>';

        if (!$list_)
            return;

        include 'modules/' . $this->module . '/views/' . $this->view . '/load_hang.php';
    }

    function loadmore()
    {
        // call models
        $model = $this->model;


        $pagecurrent = FSInput::get('pagecurrent');
        $limit = FSInput::get('limit');
        $type_id = FSInput::get('type_id');


        $type_alias = FSInput::get('type_alias');

        $total_old = $pagecurrent * $limit;
        $gt = $total_old . ',' . $limit;

        $fs_table = FSFactory::getClass('fstable');

        // phan trang
//        $query_body = $model->set_query_body();
//        $list_ = $model->get_list($query_body);


        $id_cat = FSInput::get('id_cat');
        $query_body = $model->set_query_body1($id_cat, '');
        $list_ = $model->getProductsList1($query_body);

//        var_dump($list_);

//        if (count($list) < $limit)
//            echo '<script>$(".c-view-more .load_more").hide();</script>';

        if (!$list_)
            return;

        include 'modules/' . $this->module . '/views/' . $this->view . '/load_sp.php';
    }

    function search_sp()
    {
        $model = $this->model;

        $id_cat = FSInput::get('id_cat');
        $query_body = $model->set_query_body1($id_cat, '');
        $list_ = $model->getProductsList1($query_body);
        include 'modules/'.$this->module.'/views/'.$this->view.'/seach_sp.php';
        return;

    }


}

?>