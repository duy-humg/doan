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
        $product_images = $model->getImageProducts($id);
        $list_tienich = $model->list_tienich();
        $nhomhang = $model->nhomhang();
        $list_sp = $model->list_sp();
        $list_news = $model->list_news();

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
        $products_type = array();
//        $color = array();
        foreach ($product as $item) {
            if ($item->products_type) {
                if (in_array($item->products_type, $products_type)) {
                } else {
                    $products_type[] = $item->products_type;
                }
            }
//            if ($item->color_id) {
//                if (in_array($item->color_id, $color)) {
//
//                } else {
//                    $color[] = $item->color_id;
//                }
//            }
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
//        foreach ($bread as $item) {
//            if ($item) {
//                $category[$j] = $model->get_category_by_id($item);
//                if (!$category[$j])
//                    setRedirect(URL_ROOT, 'Không tồn tại danh mục này', 'Error');
//                $breadcrumbs[] = array(0 => $category[$j]->name, 1 => FSRoute::_('index.php?module=products&view=cat&cid=' . $category[$j]->id . '&ccode=' . $category[$j]->alias));
//            }
//            $j++;
//        }

        // relate
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

    function buy()
    {
//        $i = 0;
        $model = $this->model;
        FSFactory::include_class('errors');
        $record_id = FSInput::get('id', 0, 'int'); // product_id
        $data = $model->getProduct($record_id);
        $quantity_sub = FSInput::get('quantity_sub');
        $quantity_main = FSInput::get('quantity_main');
//var_dump($quantity_main);die;
//        var_dump($quantity_sub);die;
//        if (!$_SESSION['user_id']) {
//            $link_now = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $record_id);
//            $msg = 'Bạn phải đăng nhập để mua hàng';
//            setRedirect($link_now, $msg, 'error');
//        }
        $quality = FSInput::get('quantity', 1, 'int'); // quality
//        var_dump($quality);die;
        $price = FSInput::get('price', 1, 'int'); // quality
//        $color = FSInput::get('color', 1, 'int'); // quality
        $products_type = FSInput::get('products_type', 1, 'int'); // quality
        $id_sub = FSInput::get('id_sub');
//        $ordering_prd = $record_id . '_' . $id_sub;

//        var_dump($price);die;
//        FSFactory::include_class('errors');

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
                $product_list[] = array($record_id, $quality, $price, $products_type, $id_sub); // prdid,quality
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
                    $product_list[count($product_list)] = array($record_id, $quality, $price, $products_type, $id_sub);
                }
            }
            $_SESSION['cart'] = $product_list;
//            var_dump($_SESSION['cart']);
//            session_unset($_SESSION['cart']);
//            if (!$_SESSION['user_id']) {
//                $link_now = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $record_id);
//                echo 2;
//                setRedirect($link_now, $msg, 'error');
//                include 'modules/' . $this->module . '/views/' . $this->view . '/error.php';
//                return;
//            } else {
            include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-cart.php';
            return;
//            }
        }
    }


    function re_buy()
    {
        $record_id = FSInput::get('id', 0); // product_id
//        var_dump($record_id);
        $tr_record_id = explode(' ', $record_id);
//        var_dump($tr_record_id);
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
        $record_id = FSInput::get('id', 0, 'int'); // product_id
        $quality = FSInput::get('quantity_now', 1, 'int');
        $quantity_sub = FSInput::get('quantity_sub'); // quality
        $price = FSInput::get('price_input_buynow'); // quality
//        $color = FSInput::get('color_input_buynow'); // quality
        $products_type = FSInput::get('products_type_input_buynow'); // quality
        $quantity_main = FSInput::get('quantity_main');

        $id_sub = FSInput::get('id_sub');
//        $ordering_prd = $record_id . '_' . $id_sub;

//var_dump($price);die;
        FSFactory::include_class('errors');
        $model = $this->model;
        $link = FSRoute::_('index.php?module=products&view=home');

        $data = $model->getProduct($record_id);
        $url = FSRoute::_('index.php?module=products&view=product&ccode=' . $data->category_alias . '&code=' . $data->alias . '&id=' . $record_id);

        if ($id_sub && !$quantity_sub || !$id_sub && !$quantity_main) {
            $msg = 'Sản phẩm tạm hết hàng';
            setRedirect($url, $msg, 'error');
        } else {
            if (empty($_SESSION['cart'])) {
                $product_list = array();
                if (!$data) {
                    Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
                    setRedirect($link);
                    return;
                }
                $product_list[] = array($record_id, $quality, $price, $products_type, $id_sub); // prdid,quality
            } else {
                $product_list = $_SESSION['cart'];
                $exist_prd = 0;
                for ($j = 0; $j < count($product_list); $j++) {
                    $prd = $product_list[$j];
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
                    $product_list[count($product_list)] = array($record_id, $quality, $price, $products_type, $id_sub);
                }
            }

            $_SESSION['cart'] = $product_list;
//            var_dump( $_SESSION['cart']);die;
//            if ($_SESSION['user_id']) {
//                $link_now = FSRoute::_('index.php?module=products&view=pay&task=step_address');
//            } else {
//            if ($_SESSION['user_id']) {
            $link_now = FSRoute::_('index.php?module=products&view=cart&task=cart');
            setRedirect($link_now);

//            } else {
//                $msg1 = 'Bạn phải đăng nhập để mua hàng';
//                setRedirect($url, $msg1, 'error');
//            }
        }
    }

    function edel()
    {
        $id_sub = FSInput::get('id_sub', 0, 'int');
//        $color_id = FSInput::get('color_id', 0, 'int');
//        $products_type= FSInput::get('products_type', 0, 'int');
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
//            var_dump($_SESSION['cart']);die;
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
                if ($listProducts[$key][4]) {
                    if ($listProducts[$key][4] == $pro_id) {
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

    function unset_ss()
    {
        unset($_SESSION['cart']);
        $link = URL_ROOT;
        $msg = FSText::_('Xóa giỏ hàng thành công');
//            Errors::_("S&#7843;n ph&#7849;m n&#224;y kh&#244;ng t&#7891;n t&#7841;i", 'error');
        setRedirect($link, $msg);
        return;
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
                    if ($prd[4]) {
                        if ($prd[4] != $pid) {
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
////        echo 1; die;
        $return = FSInput::get('return');
        $link = base64_decode($return);
//        var_dump($link);die;
//        $model = $this->model;
//        $news_id = FSInput::get('id');
//        $title = FSInput::get('title');
//        $content= FSInput::get('content');
//        $rating= FSInput::get('score');
//        $user_id= FSInput::get('user_id');
//        $user_name = $_SESSION['user_name'];
//        $time = date('Y-m-d H:i:s');
//        $published = 1;
//        $row = array();
//        $row['title']=$title;
//        $row['record_id']=$news_id;
//        $row['comment']=$content;
//        $row['rating']=$rating;
//        $row['user_id']=$user_id;
//        $row['name']=$user_name;
//        $row['published'] = $published;
//        $row['edited_time'] = $time;
//        $row['created_time'] = $time;
////        var_dump($row);die;
//       $comment= $model->_add($row, 'fs_products_comments');
//       if ($comment){
//           setRedirect($link);
//
//       }
        $model = $this->model;
        $id = FSInput::get('id');
        $cmt = $model->get_comments($id);
        $total_cmt = count($cmt);
        $rate1 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 1 ', 'fs_products_comments', 'rating'));
        $rate2 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 2 ', 'fs_products_comments', 'rating'));
        $rate3 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 3 ', 'fs_products_comments', 'rating'));
        $rate4 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 4 ', 'fs_products_comments', 'rating'));
        $rate5 = count($model->get_records('published=1 AND record_id=' . $id . ' AND rating = 5 ', 'fs_products_comments', 'rating'));
        $sum_rate = ($rate1 + $rate2 * 2 + $rate3 * 3 + $rate4 * 4 + $rate5 * 5) / ($total_cmt);
        $row = array();
        $row['rating_count'] = $sum_rate;
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
}

?>