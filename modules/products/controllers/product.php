<?php

/*
 * Huy write
 */

// controller

class ProductsControllersProduct extends FSControllers
{

    var $module;
    var $view;

    function display()
    {
        // call models
        $model = $this->model;

        $id = FSInput::get2('id', 0, 'int');


//        var_dump($id);
        $data = $model->getProduct($id);
        $get_dm = $model->get_records('published = 1 and id=' . $data->category_id, 'fs_products_categories', '*');
        $dm = $model->get_records('published = 1 and id=' . $get_dm[0]->parent_id, 'fs_products_categories', '*');
        if(!$dm){
            $dm = $model->get_records('published = 1 and id=' . $get_dm[0]->id, 'fs_products_categories', '*');
        }
//        var_dump($dm[0]);
        $product_images = $model->getImageProducts($id);
        $list_tienich = $model->list_tienich();
        $nhomhang = $model->nhomhang();
        $list_sp = $model->list_sp();
        $list_news = $model->list_news();
        if($data->id_shop){
            $list_shop = $model->list_shop($data->id_shop);
            $list_shop_m = $model->list_shop_m($data->id_shop);
            $listsp_shop = $model->listsp_shop($data->id_shop);
            $get_shop =  $model->get_shop($data->id_shop);
        }


        $list_sp_banchay = $model->list_sp_banchay();
        if($_SESSION['user_id']){
            $love = $model->love($data->id,$_SESSION['user_id']);
        }
        

//        $get_shop =  $model->get_shop($data->id_shop);
//        var_dump(count($get_shop));
//        var_dump($list_shop);

        $prv = explode(",",$data->muacung);
//            var_dump($prv);die;
        $list_muacung = array();
        foreach ($list_sp as $item_){
            foreach ($prv as $item_city){
                if($item_city == $item_->id){
                    $list_muacung[]= $item_;
                }
            }
        }
//        var_dump($list_muacung);

//        var_dump(count($product_images));
//        var_dump($data);
        $cmt = $model->get_comments($id);
     
        $total_cmt = count($cmt);
        // var_dump($total_cmt);
        $rate1 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 1 ', 'fs_products_comments', 'rating'));
        $rate2 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 2 ', 'fs_products_comments', 'rating'));
        $rate3 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 3 ', 'fs_products_comments', 'rating'));
        $rate4 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 4 ', 'fs_products_comments', 'rating'));
        $rate5 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 5 ', 'fs_products_comments', 'rating'));
        $sum_rate = ($rate1 + $rate2 * 2 + $rate3 * 3 + $rate4 * 4 + $rate5 * 5) / ($total_cmt);
//var_dump($sum_rate);
        if (!$data)
            setRedirect(URL_ROOT, 'Không tồn tại sản phảm này', 'Error');
        $ccode = FSInput::get('ccode');

        $list_id = $data->package_related;
        $list_package = $model->list_products_add($list_id);
//        echo $data->name;
//        var_dump($data->author_book_id);
        if ($data->author_book_id && $data->author_book_id != ',,') {
            $author = $model->getAuthor($data->author_book_id);
        }
//        var_dump($author);die;
//        if(!$author){
//            setRedirect(URL_ROOT, 'Không có tác giả này', 'error');
//        }
        $city = $model->get_records('published = 1 order by name ASC', 'fs_cities', '*');
        if ($data->color_id && !($data->color_id)) {
            $color_id = trim($data->color_id, ',');
            $arr_color_id = explode(',', $color_id);
        }
//        var_dump($arr_color_id);die;
        $lis_cat_parent = $model->get_list_parent($data->category_id_wrapper);


        //sản phẩm phụ
        $product = $model->get_records('published = 1 and product_id=' . $data->id, 'fs_products_sub', '*');
//        var_dump($product);

        @$list_size = array();

      

        foreach ($product as $item) {
            if ($item->size_id) {
                if (in_array($item->size_id, $list_size)) {
                } else {
                    $list_size[] = $item->size_id;
                }
            }
            // if ($item->color_id) {
            //     if (in_array($item->color_id, $list_color)) {

            //     } else {
            //         $list_color[] = $item->color_id;
            //     }
            // }
        }

       

       
        sort($list_size);
        // var_dump($list_size);
        if($list_size){
            @$list_color = array();
            $product_2 = $model->get_records('published = 1 and product_id=' . $data->id . ' and size_id = '.$list_size[0], 'fs_products_sub', '*');
            foreach ($product_2 as $item) {
                // if ($item->size_id) {
                //     if (in_array($item->size_id, $list_size)) {
                //     } else {
                //         $list_size[] = $item->size_id;
                //     }
                // }
                if ($item->color_id) {
                    if (in_array($item->color_id, $list_color)) {
    
                    } else {
                        $list_color[] = $item->color_id;
                    }
                }
            }
            sort($list_color);
        }
        


//        foreach( $list_size as $n) {
//            echo "$n <br>";
//        }



//        var_dump($product);
        if ($product) {
            $json = '['; // start the json array element
            $json_names = array();
            foreach ($product as $item) {
                $price_sub = $item->price_h;
                $price_sub_old = $item->price;
                $json_names[] = "{price_old : $price_sub_old, quantity: $item->quantity, discount: $item->discount, price: $price_sub , id: $item->id}";
            }
            $json .= implode(',', $json_names);
            $json .= ']'; // end the json array element
        }

//        var_dump($json);
        $breadcrumbs = array();
        for ($i = 0; $i < count($lis_cat_parent); $i++) {
            $item = $lis_cat_parent [$i];
            $breadcrumbs [] = array(0 => $item->name, 1 => FSRoute::_('index.php?module=products&view=cat&ccode=' . $item->alias . '&cid=' . $item->id . '&Itemid=17'));
        }
        $breadcrumbs[] = array(0 => $data->name);

        $category_id = $data->category_id;
        $bread = explode(',', $data->category_id_wrapper);
        $bread = array_reverse($bread);
        $category = array();
        $j = 0;

        $relate_products_list = $model->getRelateProductsList($category_id);

//        var_dump($category_id);
        $product_images = $model->getImageProducts($data->id);
        $list_see = array();
        if (empty($_SESSION['see_product'])) {
            $product_list_see = array();
            $product_list_see[] = array($id);
            $list_see = array();
        } else {
            $product_list_see = $_SESSION['see_product'];
            $exist_prd = 0;
            $id_products = '';
            for ($j = 0; $j < count($product_list_see); $j++) {
                $prd = $product_list_see[$j];
                $id_products .= ',' . $prd[0];
                if ($prd[0] == $id) {
                    $exist_prd++;
                    break;
                }
            }
            $id_products .= ',';
            $list_see = $model->list_products_see($id_products);
            // if not exist product
            if (!$exist_prd) {
                $product_list_see[count($product_list_see)] = array($id);
            }
        }
        $_SESSION['see_product'] = $product_list_see;


        global $tmpl, $module_config;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
//        $tmpl->assign('title', $data->name);
//        $tmpl->assign('tags', $data->tags);
//        $tmpl->assign('description', $data->content);
        $tmpl->assign('og_image', URL_ROOT . str_replace('/original/', '/tiny/', $data->image));

        // seo
        $tmpl->set_data_seo($data);

        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function get_price_shop()
    {
        $model = $this->model;
        $id = FSInput::get('id');
        $color = FSInput::get('color');
        $size = FSInput::get('size');
        if($color){

        }else{
            $color = 0;
        }
        if($size){

        }else{
            $size = 0;
        }


        $get = $model->get_price_ajax($id,$color,$size);
//        $get_product = $model->get_price_ajax_product($id);
//        $lang = FSInput::get('lang');
        include 'modules/' . $this->module . '/views/' . $this->view . '/price.php';
//        if($get){
//            $html = '';
//            if($get->price) {
//                $html .= '<p class="price">'. format_money($get->price_h) .' <span class="old-price">'. format_money($get->price) .'</span></p>';
//                $html .= '<input type="hidden" id="price_moddi" value="'. $get->price_h .'">';
//            }else{
//                $html .= '<p class="price">'. format_money($get->price) .' </p>';
//                $html .= '<input type="hidden" id="price_moddi" value="'. $get->price .'">';
//            }
//        }else{
//            $html = '';
//            if($get->price) {
//                $html .= '<p class="price">'. format_money($get_product->price) .' <span class="old-price">'. format_money($get_product->price_old) .'</span></p>';
//                $html .= '<input type="hidden" id="price_moddi" value="'. $get_product->price .'">';
//            }else{
//                $html .= '<p class="price">'. format_money($get_product->price_old) .'</p>';
//                $html .= '<input type="hidden" id="price_moddi" value="'. $get_product->price_old .'">';
//            }
//        }
//        echo $html;
    }

    function buy_muacung()
    {
//        $i = 0;
        $model = $this->model;
        FSFactory::include_class('errors');
//        $record_id = FSInput::get('id', 0, 'int'); // product_id
        $id_muacung = FSInput::get('id_muacung'); // product_id
        $muacung =  rtrim($id_muacung, ',');
        $arr_muacung = explode(',',$muacung);
//        var_dump($arr_muacung);
//        var_dump(count($arr_muacung));
//        for ($i=1;$i<=count($arr_muacung);$i++){
//        }
//        foreach ($arr_muacung as $item_buy){
//            echo $item_buy;
//        }
//        die;
        for ($i=0;$i<count($arr_muacung);$i++){
//        foreach ($arr_muacung as $item_buy){
//            if($i==2){
//                echo 1;die;
//            }
//            echo $arr_muacung[$i];

            $data = $model->getProduct($arr_muacung[$i]);
//            var_dump($data->price);
//            echo '<br>';
            $quantity_sub =1;
            $quantity_main = 300;


            $quality = 1; // quality

            $price = $data->price; // quality
//        $color = FSInput::get('color', 1, 'int'); // quality
            $products_type = ''; // quality
            $id_sub = '';

            $link = FSRoute::_('index.php?module=products&view=cart&task=eshopcart2');
            if ($id_sub && !$quantity_sub || !$id_sub && !$quantity_main) {
//            echo 1;die;
//            $url = URL_ROOT;
//            $msg = 'Sản phẩm tạm hết hàng';
//            setRedirect($url, $msg, 'error');
                include 'modules/' . $this->module . '/views/' . $this->view . '/out_of_stock.php';

//            echo 1;
                return;
            } else {
                if (empty($_SESSION['cart'])) {
                    $product_list = array();
                    if (!$data) {
                        Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
                        setRedirect($link);
                        return;
                    }
                    $product_list[] = array($arr_muacung[$i], $quality, $price, $products_type, $id_sub); // prdid,quality
                } else {
                    $product_list = $_SESSION['cart'];
                    $exist_prd = 0;
                    for ($j = 0; $j < count($product_list); $j++) {
                        $prd = $product_list[$j];
//                    $i++;
//                    $prd[6] = $prd[0] . '_' . $i;
                        if ($id_sub) {
                            if ($prd[4] == $id_sub) {
                                if ($quality <= 1) {
                                    $product_list[$j][1] += $quality;
                                } else {
                                    $product_list[$j][1] += $quality;
                                }
                                $exist_prd++;

                                break;
                            }
                        } else {
                            if ($prd[0] == $arr_muacung[$i]) {
                                if ($quality <= 1) {
                                    $product_list[$j][1] += $quality;
                                } else {
                                    $product_list[$j][1] += $quality;
                                }
                                $exist_prd++;
                                break;
                            }
                        }
                    }
                    // if not exist product
                    if (!$exist_prd) {
                        $product_list[count($product_list)] = array($arr_muacung[$i], $quality, $price, $products_type, $id_sub);
                    }
                }
                $_SESSION['cart'] = $product_list;
            }

        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-cart.php';
        return;
    }
    

    function mualai()
    {

        $sl_sp = FSInput::get('sl_sp'); 
        $id_order = FSInput::get('id_order'); 
    

        for($i=1;$i <= $sl_sp;$i++){
            $record_id = FSInput::get('id_'.$id_order.'_'.$i); 

            $quality = FSInput::get('quantity_'.$id_order.'_'.$i, 1, 'int');
            $quantity_sub = 1000; 
            $price = FSInput::get('price_'.$id_order.'_'.$i); 
            $size_id = FSInput::get('size_'.$id_order.'_'.$i);
            $color_id = FSInput::get('color_'.$id_order.'_'.$i);
            $quantity_main = 1000;
            $id_sub = FSInput::get('id_sub_'.$id_order.'_'.$i);
            $id_shop = FSInput::get('id_shop_'.$id_order.'_'.$i);
            $pub = 0;
            FSFactory::include_class('errors');
            $model = $this->model;

            $link = FSRoute::_('index.php?module=products&view=home');

            $data = $model->getProduct($record_id);
            $url = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $record_id);
            
            if (empty($_SESSION['cart'])) {
                $product_list = array();
                if (!$data) {
                    Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
                    setRedirect($link);
                    return;
                }
                $product_list[] = array($record_id, $quality, $price, $color_id,$size_id, $id_sub,$id_shop,$pub); // prdid,quality
            } else {
                $product_list = $_SESSION['cart'];
                $exist_prd = 0;
                for ($j = 0; $j < count($product_list); $j++) {
                    $prd = $product_list[$j];
                    if ($id_sub) {
                        if ($prd[5] == $id_sub) {
                            if ($quality <= 1) {
                                $product_list[$j][1] += $quality;
                            } else {
                                $product_list[$j][1] += $quality;
                            }
                            $exist_prd++;

                            break;
                        }
                    } else {
                        if ($prd[0] == $record_id) {
                            if ($quality <= 1) {
                                $product_list[$j][1] += $quality;
                            } else {
                                $product_list[$j][1] += $quality;
                            }
                            $exist_prd++;
                            break;
                        }
                    }
                }
                // if not exist product
                if (!$exist_prd) {
                    $product_list[count($product_list)] = array($record_id, $quality, $price, $color_id,$size_id, $id_sub,$id_shop,$pub);
                }
            }
            $_SESSION['cart'] = $product_list;
            
        }
        $link_now = FSRoute::_('index.php?module=products&view=cart&task=cart');
        setRedirect($link_now);
       


       
        

      

        
        
    }

    function buy()
    {
//        $i = 0;
        $model = $this->model;
        FSFactory::include_class('errors');
        $record_id = FSInput::get('id', 0, 'int'); // product_id
        $data = $model->getProduct($record_id);
        $quantity_sub = FSInput::get('quantity_sub');
        $quantity_main = FSInput::get('quantity_main');

        $quality = FSInput::get('quantity', 1, 'int'); // quality
        $price = FSInput::get('price', 1, 'int'); // quality

        $products_size = FSInput::get('products_size', 1, 'int'); // quality
        $products_color = FSInput::get('products_color', 1, 'int'); // quality
        $id_sub = FSInput::get('id_sub');
        $id_shop = FSInput::get('id_shop');
        $published = 0;

        $link = FSRoute::_('index.php?module=products&view=cart&task=eshopcart2');

            if (empty($_SESSION['cart'])) {
                $product_list = array();
                if (!$data) {
                    Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
                    setRedirect($link);
                    return;
                }
                $product_list[] = array($record_id, $quality, $price, $products_size,$products_color, $id_sub,$id_shop,$published); // prdid,quality
            } else {
                $product_list = $_SESSION['cart'];
                $exist_prd = 0;
                for ($j = 0; $j < count($product_list); $j++) {
                    $prd = $product_list[$j];
                    if ($id_sub) {
                        if ($prd[5] == $id_sub) {
                            if ($quality <= 1) {
                                $product_list[$j][1] += $quality;
                            } else {
                                $product_list[$j][1] += $quality;
                            }
                            $exist_prd++;

                            break;
                        }
                    } else {
                        if ($prd[0] == $record_id) {
                            if ($quality <= 1) {
                                $product_list[$j][1] += $quality;
                            } else {
                                $product_list[$j][1] += $quality;
                            }
                            $exist_prd++;
                            break;
                        }
                    }
                }
                if (!$exist_prd) {
                    $product_list[count($product_list)] = array($record_id, $quality, $price, $products_size,$products_color, $id_sub,$id_shop,$published);
                }
            }
            $_SESSION['cart'] = $product_list;
            include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-cart.php';
            return;

    }


    function re_buy()
    {
        $record_id = FSInput::get('id', 0); // product_id
//        var_dump($record_id);
        $tr_record_id = explode(' ', $record_id);
    //    var_dump($tr_record_id);die;
        $quality = FSInput::get('quantity', 1, 'int'); // quality
        FSFactory::include_class('errors');
        $model = $this->model;
        $link = FSRoute::_('index.php?module=products&view=cart&task=eshopcart2');
        foreach ($tr_record_id as $item) {
            $data = $model->getProduct($item);
//var_dump($data->name);
            if (empty($_SESSION['cart'])) {
                $product_list = array();
                if (!$data) {
                    Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
                    setRedirect($link);
                    return;
                }
                $product_list[] = array($item, $quality); // prdid,quality
            } else {
                $product_list = $_SESSION['cart'];

                $exist_prd = 0;
                for ($j = 0; $j < count($product_list); $j++) {
                    $prd = $product_list[$j];

                    if ($prd[0] == $item) {
                        if ($quality <= 1) {
                            $product_list[$j][1] += $quality;
                        } else {
                            $product_list[$j][1] += $quality;
                        }

                        $exist_prd++;
                        break;
                    }
                }

                // if not exist product
                if (!$exist_prd) {

                    $product_list[count($product_list)] = array($item, $quality);
                }
            }
            $_SESSION['cart'] = $product_list;
        }


        include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-cart.php';
        return;
    }

    function buynow()
    {
        $record_id = FSInput::get('id', 0, 'int');
        // var_dump($record_id);die;
        $quality = FSInput::get('quantity_now', 1, 'int');
        $quantity_sub = FSInput::get('quantity_sub'); 
        $price = FSInput::get('price'); 
        $products_type = FSInput::get('products_type_input_buynow'); // quality
        $quantity_main = FSInput::get('quantity_main');
        $id_shop = FSInput::get('id_shop');
        $id_sub = FSInput::get('id_sub');
        // var_dump($id_sub);die;
        $color_id = FSInput::get('color_id');
        $size_id = FSInput::get('size_id');
        $pub = 0;
        FSFactory::include_class('errors');
        $model = $this->model;
        $link = FSRoute::_('index.php?module=products&view=home');

        $data = $model->getProduct($record_id);
        $url = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $record_id);
            if (empty($_SESSION['cart'])) {
                $product_list = array();
                if (!$data) {
                    Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
                    setRedirect($link);
                    return;
                }
                $product_list[] = array($record_id, $quality, $price, $color_id,$size_id, $id_sub,$id_shop,$pub); // prdid,quality
            } else {
                $product_list = $_SESSION['cart'];
                $exist_prd = 0;
                for ($j = 0; $j < count($product_list); $j++) {
                    $prd = $product_list[$j];
                    if ($id_sub) {
                        if ($prd[5] == $id_sub) {
                            if ($quality <= 1) {
                                $product_list[$j][1] += $quality;
                            } else {
                                $product_list[$j][1] += $quality;
                            }
                            $exist_prd++;

                            break;
                        }
                    } else {
                        if ($prd[0] == $record_id) {
                            if ($quality <= 1) {
                                $product_list[$j][1] += $quality;
                            } else {
                                $product_list[$j][1] += $quality;
                            }
                            $exist_prd++;
                            break;
                        }
                    }
                }
                // if not exist product
                if (!$exist_prd) {
                    $product_list[count($product_list)] = array($record_id, $quality, $price, $color_id,$size_id, $id_sub,$id_shop,$pub);
                }
            }

            $_SESSION['cart'] = $product_list;

            
            $link_now = FSRoute::_('index.php?module=products&view=cart&task=cart');
            setRedirect($link_now);


            
    }
    function check_cart_all()
    {
        $array = FSInput::get2('array', array(), 'array');
        $id_shop = FSInput::get('id_shop', 0, 'int');
//        var_dump($id_shop);

        $array_2 = explode(',',$array[0]);
    //    var_dump($array_2);
    //    echo '<br>';
        $product_list_2 = array();
        if($array_2[0] != ''){
//            echo 1;
            $listProducts = $_SESSION['cart'];
            // var_dump($listProducts);
            foreach ($listProducts as $key => $val) {
                foreach ($array_2 as $key_1){
                   
                    if ($listProducts[$key][5]) {
                        
                        if (str_replace(' ','',$listProducts[$key][5]) == str_replace(' ','',$key_1)) {
                            $listProducts[$key][7] = 1;
                        }
                    } else {
                        
            
                        if (str_replace(' ','',$listProducts[$key][0])  ==  str_replace(' ','',$key_1)) {
                            $listProducts[$key][7] = 1;
                        }
                    }
                }
                if($listProducts[$key][7] == 1){
                    $product_list_2[] = array($listProducts[$key][0], $listProducts[$key][1], $listProducts[$key][2],$listProducts[$key][3], $listProducts[$key][4],$listProducts[$key][5],$listProducts[$key][6],$listProducts[$key][7]);
                }

            }
//            var_dump();
            $_SESSION['cart_2'] = $product_list_2;
            $_SESSION['check'] = 1;
            $_SESSION['id_shop'] = $id_shop;
            $_SESSION['id_shop'] = 1;
            $_SESSION['btn_mua'] = 1;

            $_SESSION['cart'] = $listProducts;
        }else{
//            echo 2;
            $listProducts = $_SESSION['cart'];
            foreach ($listProducts as $key => $val) {
                $listProducts[$key][7] = 0;
                if($listProducts[$key][7] == 1){
                    $product_list_2[] = array($listProducts[$key][0], $listProducts[$key][1], $listProducts[$key][2],$listProducts[$key][3], $listProducts[$key][4],$listProducts[$key][5],$listProducts[$key][6],$listProducts[$key][7]);
                }
            }
            $_SESSION['check'] = 0;
            $_SESSION['cart'] = $listProducts;
            $_SESSION['cart_2'] = $product_list_2;
            $_SESSION['id_shop'] = 0;
            $_SESSION['btn_mua'] = 0;
        }
        $total_quan = 0;
        foreach ($listProducts as $prd) {
            if($prd[7]==1){
                $total_quan += $prd[1]*$prd[2];
            }
        }
//        return;

        include 'modules/' . $this->module . '/views/' . $this->view . '/load_price.php';

    }

    function check_cart()
    {
        $id_sub = FSInput::get('id', 0, 'int');
//        var_dump($id_sub);
        if ($id_sub) {
            $listProducts = $_SESSION['cart'];
            $product_list_2 = array();
            foreach ($listProducts as $key => $val) {
                if ($listProducts[$key][5]) {
                    if ($listProducts[$key][5] == $id_sub) {
                        $listProducts[$key][7] = 1;
                    }
                } else {
                    if ($listProducts[$key][0] == $id_sub) {
                        $listProducts[$key][7] = 1;
                    }
                }
                if($listProducts[$key][7] == 1){
                    $product_list_2[] = array($listProducts[$key][0], $listProducts[$key][1], $listProducts[$key][2],$listProducts[$key][3], $listProducts[$key][4],$listProducts[$key][5],$listProducts[$key][6],$listProducts[$key][7]);
                }

            }
            $_SESSION['cart_2'] = $product_list_2;
//            var_dump(count($product_list_2));
            if(count($product_list_2)>=1){
                $_SESSION['btn_mua'] = 1;
            }else{
                $_SESSION['btn_mua'] = 0;
            }


            $_SESSION['cart'] = $listProducts;
        }
//        var_dump($listProducts);die;
        $total_quan = 0;
        foreach ($listProducts as $prd) {
            if($prd[7]==1){
                $total_quan += $prd[1]*$prd[2];
            }
        }

//        var_dump('modules/' . $this->module . '/views/' . $this->view . '/load_price.php');die;
        include 'modules/' . $this->module . '/views/' . $this->view . '/load_price.php';
//        return;
    }

    function check_cart_false()
    {
//        echo 1;
        $id_sub = FSInput::get('id', 0, 'int');
//        var_dump($id_sub);
        if ($id_sub) {
            $listProducts = $_SESSION['cart'];
            $product_list_2 = array();
            foreach ($listProducts as $key => $val) {
                if ($listProducts[$key][5]) {
                    if ($listProducts[$key][5] == $id_sub) {
                        $listProducts[$key][7] = 0;
                    }
                } else {
                    if ($listProducts[$key][0] == $id_sub) {
                        $listProducts[$key][7] = 0;
                    }
                }
                if($listProducts[$key][7] == 1){
                    $product_list_2[] = array($listProducts[$key][0], $listProducts[$key][1], $listProducts[$key][2],$listProducts[$key][3], $listProducts[$key][4],$listProducts[$key][5],$listProducts[$key][6],$listProducts[$key][7]);
                }
            }
//            var_dump(count($product_list_2));
            $_SESSION['cart_2'] = $product_list_2;
            $_SESSION['cart'] = $listProducts;
            $_SESSION['id_shop'] = 0;
            if(count($product_list_2)>=1){
                $_SESSION['btn_mua'] = 1;
            }else{
                $_SESSION['btn_mua'] = 0;
            }
        }
        $_SESSION['check'] = 0;
        $total_quan = 0;
        foreach ($listProducts as $prd) {
            if($prd[7]==1){
                $total_quan += $prd[1]*$prd[2];
            }
        }
//        return;
        include 'modules/' . $this->module . '/views/' . $this->view . '/load_price.php';
    }
    function unset_ss()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart_2']);
        unset($_SESSION['btn_mua']);
        unset($_SESSION['id_shop']);
        $link = URL_ROOT;
        $msg = FSText::_('Xóa giỏ hàng thành công');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
        setRedirect($link, $msg);
        return;
    }

    function edel()
    {
        $id_sub = FSInput::get('id_sub', 0, 'int');
        if ($id_sub) {
            if (isset($_SESSION['cart'])) {
                $product_list = $_SESSION['cart'];
//                var_dump($product_list);die;
                // Repeat estores
                $products_new = array();
                // Repeat products
                for ($i = 0; $i < count($product_list); $i++) {
                    $prd = $product_list[$i];
                    if ($prd[4]) {
                        if ($prd[4] != $id_sub) {
                            $products_new[] = $prd;
                        }
                    } else {
                        if ($prd[0] != $id_sub) {
                            $products_new[] = $prd;
                        }
                    }
                }
                $_SESSION['cart'] = $products_new;
            }
        }
        $link = FSRoute::_('index.php?module=products&view=cart');
        setRedirect($link);
    }

    function get_product_by_id($product_id)
    {
        $model = $this->model;
        return $model->getProduct($product_id);
    }

    function update_hits()
    {
        $model = $this->model;
        $news_id = FSInput::get('id');
        $model->update_hits($news_id);
    }

    function updateCart_()
    {
        $data = array('error' => true, 'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        $arrQuantity = FSInput::get('quantity', array(), 'array');
//        var_dump($arrQuantity);die;
        if (isset($_SESSION['cart'])) {
            $listProducts = $_SESSION['cart'];
            $total = count($listProducts);
            foreach ($listProducts as $key => $val) {
                if (isset($arrQuantity[$listProducts[$key][0]]) && $arrQuantity[$listProducts[$key][0]]) {
                    $info = $listProducts[$key][2];
                    $listProducts[$key][2] = $info;
                    $listProducts[$key][1] = $arrQuantity[$listProducts[$key][0]];
                }
            }
            $_SESSION['cart'] = $listProducts;
        }
        $data['error'] = false;
        $data['message'] = 'Cập nhật giỏ hàng thành công!';
        echo json_encode($data);
    }

    function updateCart()
    {
        $data = array('error' => true, 'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
//        $arrQuantity = FSInput::get('quantity', array(), 'array');
        $pro_id = FSInput::get('pro_id');
        $quan = FSInput::get('quan','1','int');
        $quan_sub = FSInput::get('quan_sub','1','int');
        $up = FSInput::get('up');
//        var_dump($quan_sub);
//        var_dump($up);
//		var_dump($_SESSION['cart']);die;
        if (isset($_SESSION['cart'])) {
            $listProducts = $_SESSION['cart'];

            $total = count($listProducts);
            foreach ($listProducts as $key => $val) {
                if ($listProducts[$key][5]) {
                    if ($listProducts[$key][5] == $pro_id) {
                        if ($up == 1) {
                            if ($quan + 1 > $quan_sub) {
                                $listProducts[$key][1] = $quan_sub;
                            }else{
                                $listProducts[$key][1]++;
                            }
                        } elseif ($up == 2) {
                            $listProducts[$key][1]--;
                        } elseif ($up == 3) {
                            $listProducts[$key][1] = $quan;
                        }
                    }
                } else {
                    if ($listProducts[$key][0] == $pro_id) {
                        if ($up == 1) {
                            if ($quan + 1 > $quan_sub) {
                                $listProducts[$key][1] = $quan_sub;
                            }else{
                                $listProducts[$key][1]++;
                            }
                        } elseif ($up == 2) {
                            $listProducts[$key][1]--;
                        } elseif ($up == 3) {
                            $listProducts[$key][1] = $quan;
                        }
                    }
                }
            }

            $_SESSION['cart'] = $listProducts;
//            var_dump($_SESSION['cart']);
//            die;
        }
        $data['error'] = false;
        $data['message'] = 'Cập nhật giỏ hàng thành công!';
//        var_dump($data);die;
        echo json_encode($data);
    }


    function edel1()
    {
//        $data = array('error' => true, 'message' => 'Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
        $pid = FSInput::get('id');
        if ($pid) {
            if (isset($_SESSION['cart'])) {
                $product_list = $_SESSION['cart'];
                // Repeat estores
                $products_new = array();
                // Repeat products
                for ($i = 0; $i < count($product_list); $i++) {
                    $prd = $product_list[$i];
                    if ($prd[5]) {
                        if ($prd[5] != $pid) {
                            $products_new[] = $prd;
                        }
                    } else {
                        if ($prd[0] != $pid) {
                            $products_new[] = $prd;
                        }
                    }
                }
                $_SESSION['cart'] = $products_new;
            }
        }
//        $url =
//        $data['error'] = false;
//        $data['message'] = 'Cập nhật giỏ hàng thành công!';
//        echo json_encode($data);
//            $link = FSRoute::_('index.php?module=products&view=cart');
//            setRedirect($link);
    }

    /**
     * upload file
     */
    function data_upload_file()
    {
        $this->model->upload_data();
    }


    /**
     * Xóa file
     */
    function deleteFile()
    {
        $model = $this->model;
        $model->deleteFile();
    }

//    function loadcontent_book()
//    {
//        $html = '';
//        $model = $this->model;
//        $store_infor = FSInput::get('store_id');
////        echo $districtid;
//        $store_infor1 = $model->get_record('published =1 and id= ' . $store_infor ,'fs_store');
//
////        $wards = $model->getWard($districtid);
//        $html .= '<p>'.$store_infor1->name.'</p>
//                    <p>'.$store_infor1->address.'</p>';
//        echo $html;
//    }
    function save_comment()
    {
//        $fssecurity = FSFactory::getClass('fssecurity');
//        $fssecurity->checkLogin();
    //    echo 1; die;
        $return = FSInput::get('return');
        $link = base64_decode($return);

        $model = $this->model;
        $id = FSInput::get('id');
        $cmt = $model->get_comments($id);
        // var_dump($cmt);die;
        $total_cmt = count($cmt);
        $total_cmmt = $cmt->comments_total;
        // var_dump($total_cmt);
        $rate1 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 1 ', 'fs_products_comments', 'rating'));
        $rate2 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 2 ', 'fs_products_comments', 'rating'));
        $rate3 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 3 ', 'fs_products_comments', 'rating'));
        $rate4 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 4 ', 'fs_products_comments', 'rating'));
        $rate5 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 5 ', 'fs_products_comments', 'rating'));
        $sum_rate = ($rate1 + $rate2 * 2 + $rate3 * 3 + $rate4 * 4 + $rate5 * 5) / ($total_cmt);
        $row = array();
        $row['rating_count'] = $sum_rate;
        $row['comments_total'] = $total_cmmt+1;
        // var_dump($row['rating_count']);die;
        $save_rate = $model->_update($row, 'fs_products', 'id =' . $id);
//        var_dump($save_rate);die;
        $cmt_id = $model->save_comment();
//        $rate = $model->save_rating();
//        var_dump($rate);
        if ($cmt_id) {
            setRedirect($link);
        }
    }

    function save_reply()
    {
//        echo 1; die;
        $return = FSInput::get('return');
        $link = base64_decode($return);
//        echo 1; die;
//        $fssecurity = FSFactory::getClass('fssecurity');
//        $fssecurity->checkLogin();
//        echo 1; die;
        $model = $this->model;
        $reply_id = $model->save_reply();
//        var_dump($reply_id); die;
        if ($reply_id) {
            setRedirect($link);
        }
    }

    function update_useful()
    {
//echo 1; die;
        $model = $this->model;
        $id = FSInput::get('id');
//        var_dump($id);die;
//        $where = ' id = ' . $id;
//        $table = 'fs_products_comments';
//        $row=array();
//        $row['useful']=1;
//        var_dump($row);die;
        $model->update_useful($id);

    }

    function update_report()
    {
//echo 1; die;
        $model = $this->model;
        $id = FSInput::get('id');
//        var_dump($id);die;
        $where = ' id = ' . $id;
        $table = 'fs_products_comments';
        $row = array();
        $row['report'] = 1;
//        var_dump($row);die;
        $ddd = $model->_update($row, $table, $where);
        echo $ddd;
    }

    function change_quantity()
    {

        $record_id = FSInput::get('id', 0, 'int'); // product_id
        $quality = FSInput::get('quantity', 1, 'int'); // quality
        FSFactory::include_class('errors');
        $model = $this->model;
        $link = URL_ROOT;

        $data = $model->get_product();

        if (empty($_SESSION['cart'])) {
            $product_list = array();
            if (!$data) {
                $msg = FSText::_('Không có sản phẩm nào trong giỏ hàng');
                setRedirect($link, $msg, 'error');
                return;
            }
            $product_list[] = array($record_id, $quality); // prdid,quality,price
        } else {
            $product_list = $_SESSION['cart'];

            $exist_prd = 0;
            for ($j = 0; $j < count($product_list); $j++) {
                $prd = $product_list[$j];
                $product[$prd[0]] = $model->getProduct($prd[0]);

                if ($prd[0] == $record_id) {

                    if ($quality == 0) {
                        $product_list[$j][1] = 1;
                    } else {
                        if ($quality < $product[$prd[0]]->minimum) {
                            $product_list[$j][1] = $product[$prd[0]]->minimum;

                        } else {
//                        if ($quality > 0)
                            $product_list[$j][1] = $quality;
//                        else
//                            $product_list[$j][1] = 1;
                        }
                    }
                    $exist_prd++;
                    break;
                }
            }
            // if not exist product
            if (!$exist_prd) {
//                $prices = $model->getPrice();
                $product_list[count($product_list)] = array($record_id, $quality);// prdid,quality,price
            }
        }


        $_SESSION['cart'] = $product_list;

        $data = array();
        $total_cart = 0;
        $total_money = 0;
        $money_change = 0;
        $min_quan = '';
        foreach ($product_list as $item) {
            $data[$item[0]] = $model->getProduct($item[0]);
            $price[$item[0]] = $model->getPriceByPrd($item[0], $item[1]);

            if ($item[0] == $record_id) {
                if ($item[1] == $quality) {
                    $new_price = $price[$item[0]][0]->price;
                    $money_change = $item[1] * $new_price;
                }
                if ($quality < $product[$prd[0]]->minimum) {

                    $min_quan = FSText::_('Số lượng mua không được nhỏ hơn Số lượng tối thiểu của Sản phẩm');
                } else {
                    $min_quan = '';
                }
            }
            $total_cart += $item[1];
//            $total_money += ($item[1] * $item[2]);

        }
//var_dump($price);
        $json = array(
            'total_cart' => '',
//            'total_money' => '',
            'money_change' => '',
            'price_change' => '',
            'txt_min_quantity' => '',

        );

        $json['total_cart'] = $total_cart;
//        $json['total_money'] = format_money($total_money) ;
        $json['money_change'] = format_money($money_change);
        $json['price_change'] = format_money($new_price);
        if ($min_quan) {
            $json['txt_min_quantity'] = $min_quan;

        }

        echo json_encode($json);

    }

    function ajax_list_color()
        {
            // call models
            $model = $this->model;


            $size_id = FSInput::get('size_id');
            $id_sp = FSInput::get('id_sp');
            $get_id_color = FSInput::get('color_id');
            // var_dump($size_id );

            @$list_color = array();
            $product_2 = $model->get_records('published = 1 and product_id=' . $id_sp . ' and size_id = '.$size_id, 'fs_products_sub', '*');
            
            // var_dump(count($product_2));
            foreach ($product_2 as $item) {
               
                if ($item->color_id) {
                    if (in_array($item->color_id, $list_color)) {
    
                    } else {
                        $list_color[] = $item->color_id;
                    }
                }
            }


            sort($list_color);

            if($list_color){
                $color_item_dau = $model->get_record('id=' . $list_color[0], 'fs_products_color', '*');
            }
            
            if($get_id_color){
                $product_3 = $model->get_records('published = 1 and product_id=' . $id_sp . ' and size_id = '.$size_id . ' and color_id = '.$get_id_color, 'fs_products_sub', '*');
                // var_dump($product_3[0]->color_id);
            }
            
           
            

            

            // if (!$list_color)
                // return;

            include 'modules/' . $this->module . '/views/' . $this->view . '/list_color.php';
        }
}

?>