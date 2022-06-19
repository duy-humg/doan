<?php

class FSRoute
{

    var $url;

    function __construct($url)
    {

    }

    static function _($url)
    {
        return FSRoute::enURL($url);
    }

    /*
     * Trả lại tên mã hóa trên URL
     */

    static function get_name_encode($name, $lang)
    {
        $lang_url = array();

        if ($lang == 'vi')
            return $name;
        else
            return $lang_url[$name];
    }

    static function addParameters($params, $value, $module = '', $view = '')
    {
        // only filter
        if (!$module) {
            $module = FSInput::get('module');
            //$view = FSInput::get('view');
            if (!$view) {
                //$module = FSInput::get('module');
                $view = FSInput::get('view');
            }
        }

        return FSRoute:: _($_SERVER['REQUEST_URI']);
    }

    function removeParameters($params)
    {
        // only filter
        $module = FSInput::get('module');
        $view = FSInput::get('view');
        $ccode = FSInput::get('ccode');
        $filter = FSInput::get('filter');
        $manu = FSInput::get('manu');
        $Itemid = FSInput::get('Itemid');

        $url = 'index.php?module=' . $module . '&view=' . $view;
        if ($ccode) {
            $url .= '&ccode=' . $ccode;
        }
        if ($filter) {
            $url .= '&filter=' . $filter;
        }
        $url .= '&Itemid=' . $Itemid;
        $url = trim(preg_replace('/&' . $params . '=[0-9a-zA-Z_-]+/i', '', $url));
    }

    /*
     * rewrite
     */

    static function enURL($url)
    {
        if (!$url)
            $url = $_SERVER['REQUEST_URI'];

        if (!IS_REWRITE)
            return URL_ROOT . $url;
        if (strpos($url, 'http://') !== false || strpos($url, 'https://') !== false)
            return $url;

        $url_reduced = substr($url, 10); // width : index.php
        $array_buffer = explode('&', $url_reduced, 10);
        $array_params = array();
        for ($i = 0; $i < count($array_buffer); $i++) {
            $item = $array_buffer[$i];
            $pos_sepa = strpos($item, '=');
            $array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
        }
        $module = isset($array_params['module']) ? $array_params['module'] : '';
        $view = isset($array_params['view']) ? $array_params['view'] : $module;
        $task = isset($array_params['task']) ? $array_params['task'] : 'display';
        $Itemid = isset($array_params['Itemid']) ? $array_params['Itemid'] : 0;
        //$location  = isset($array_params['location'])?$array_params['location']: CITY;

        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        $url_first = URL_ROOT;
        $url1 = '';
        switch ($module) {
            case 'api_xml':
                switch ($view) {
                    case 'getxml':
                        switch ($task) {
                            case 'display':
                                return $url_first . 'update/quantity/products.html';
                        }
                }

            case 'news':
                switch ($view) {
                    case 'news':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $code . '-' . FSRoute::get_name_encode('n', $lang) . $id . '.html';
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $ccode . '-' . FSRoute::get_name_encode('cn', $lang) . $id . '.html';
                    case 'home':
                        return $url_first . 'tin-tuc.html';
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = $url_first . FSRoute::get_name_encode('tim-kiem-tin-tuc', $lang);
                        if ($keyword) {
                            $url .= '/' . $keyword . '.html';
                        }
                        return $url;
                    default:
                        return $url_first . $url;
                }
                break;
            case 'combo':
                switch ($view) {
                    case 'combo':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $code . '-' . FSRoute::get_name_encode('n', $lang) . $id . '.html';

                    case 'home':
                        return $url_first . 'combo.html';
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = $url_first . FSRoute::get_name_encode('tim-kiem-tin-tuc', $lang);
                        if ($keyword) {
                            $url .= '/' . $keyword . '.html';
                        }
                        return $url;
                    default:
                        return $url_first . $url;
                }
                break;
            case 'products':
                switch ($view) {
                    case 'product':
                        switch ($task) {
                            case 'edel':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return $url_first . 'del' . $id . '.html';
                            default:
                                $code = isset($array_params['code']) ? $array_params['code'] : '';
//                                $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return $url_first . $code . '-dp' . $id . '.html';
                        }
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['cid']) ? $array_params['cid'] : '';
                        $url_first .= $ccode . '-' . FSRoute::get_name_encode('pc', $lang) . $id;

                        $sort = isset($array_params['sort']) ? $array_params['sort'] : '';
                        $prices = isset($array_params['prices']) ? $array_params['prices'] : '';
                        $object = isset($array_params['object']) ? $array_params['object'] : '';
                        $color = isset($array_params['color']) ? $array_params['color'] : '';
                        $producer = isset($array_params['producer']) ? $array_params['producer'] : '';
                        $origin = isset($array_params['origin']) ? $array_params['origin'] : '';
                        if ($sort)
                            $url_first .= '/sap-xep:' . $sort;
                        if ($prices)
                            $url_first .= '/loc-gia:' . $prices;
                        if ($object)
                            $url_first .= '/doi-tuong:' . $object;
                        if ($color)
                            $url_first .= '/mau-sac:' . $color;
                        if ($producer)
                            $url_first .= '/nha-san-xuat:' . $producer;
                        if ($origin)
                            $url_first .= '/xuat-xu:' . $origin;

                        return $url_first .= '.html';
                    case 'shop':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['cid']) ? $array_params['cid'] : '';
                        $url_first .= $ccode . '-' . FSRoute::get_name_encode('shop', $lang) . $id;

                        $sort = isset($array_params['sort']) ? $array_params['sort'] : '';
                        $prices = isset($array_params['prices']) ? $array_params['prices'] : '';
                        $object = isset($array_params['object']) ? $array_params['object'] : '';
                        $color = isset($array_params['color']) ? $array_params['color'] : '';
                        $producer = isset($array_params['producer']) ? $array_params['producer'] : '';
                        $origin = isset($array_params['origin']) ? $array_params['origin'] : '';
                        if ($sort)
                            $url_first .= '/sap-xep:' . $sort;
                        if ($prices)
                            $url_first .= '/loc-gia:' . $prices;
                        if ($object)
                            $url_first .= '/doi-tuong:' . $object;
                        if ($color)
                            $url_first .= '/mau-sac:' . $color;
                        if ($producer)
                            $url_first .= '/nha-san-xuat:' . $producer;
                        if ($origin)
                            $url_first .= '/xuat-xu:' . $origin;

                        return $url_first .= '.html';
                    case 'author':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        return $url_first . 'author/' . $code . '.html';
                    case 'company':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        return $url_first . 'nha-xuat-ban/' . $code . '.html';
                    case 'producer':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        return $url_first . 'nha-cung-cap/' . $code . '.html';
                    case 'see':
                        return $url_first . 'san-pham-da-xem.html';
                    case 'home':
                        $url_first .= 'san-pham';
                        $sort = isset($array_params['sort']) ? $array_params['sort'] : '';
                        $prices = isset($array_params['prices']) ? $array_params['prices'] : '';
                        if ($sort)
                            $url_first .= '/sap-xep:' . $sort;
                        if ($prices)
                            $url_first .= '/loc-gia:' . $prices;
                        return $url_first . '.html';
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = $url_first . FSRoute::get_name_encode('tim-kiem', $lang);
                        if ($keyword) {
                            $url .= '/' . $keyword . '.html';
                        }
                        return $url;
                    case 'cart':
                        return $url_first . 'gio-hang.html';
                    case 'pay':
                        switch ($task) {
                            case 'vnp_returnurl':
                                return URL_ROOT . 'thanh-toan-vnpay-vinashoe.html';
                            case 'vnp_ipn':
                                return URL_ROOT . 'vnp-ipn-vinashoe.html';
                            case 'step_address':
                                return URL_ROOT . 'dia-chi-thanh-toan.html';
                            case 'pay_code':
                                return URL_ROOT . 'phuong-thuc-thanh-toan.html';
                            case 'order_products':
                                return URL_ROOT . 'thanh-toan-dat-mua.html';
                            case 'success':
                                return URL_ROOT . 'thanh-toan-thanh-cong.html';
                            case 'finished':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return $url_first . 'success-' . $id . '.html';
                            case 'returnurl_momo':
                                return URL_ROOT . 'returnurl_momo.html';
                            case 'notifyurl_momo':
                                return URL_ROOT . 'notifyurl_momo.html';
                            default:
                                return $url_first . 'thanh-toan.html';
                        }
                    case 'pay_not':
                        switch ($task) {
                            case 'step_address':
                                return URL_ROOT . 'dia-chi-thanh-toan-adc.html';
                            case 'order_products':
                                return URL_ROOT . 'thanh-toan-dat-mua-geni.html';
                            case 'pay_code':
                                return URL_ROOT . 'phuong-thuc-thanh-toan-geni.html';
                            //thanh toán vnpay thành công
                            case 'vnp_returnurl':
                                return URL_ROOT . 'thanh-toan-vnpay-geni.html';
                            case 'success':
                                return URL_ROOT . 'thanh-toan-thanh-cong-adc.html';
                            default:
                                return $url_first . 'thanh-toan.html';
                        }
                    case 'vnpay':
                        switch ($task) {
                            case 'vnp_returnurl':
                                return URL_ROOT . 'thanh-toan-vnpay-geni.html';
                            default:
                                return $url_first . 'thanh-toan.html';
                        }
                    default:
                        return $url_first . $url;
                }
                break;
            case 'video':
                $code = isset($array_params['code']) ? $array_params['code'] : '';
                $id = isset($array_params['id']) ? $array_params['id'] : '';
                return $url_first . $code . '-' . FSRoute::get_name_encode('v', $lang) . $id . '.html';
            case 'contents':
                switch ($view) {
                    case 'cat':
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode . '-cc' . $id . '.html';
                    case 'content':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        //return $url_first.FSRoute::get_name_encode('ct',$lang).'-'.$code.'.html';
                        return $url_first . $code . '-' . FSRoute::get_name_encode('c', $lang) . $id . '.html';
                }
                break;

            case 'contact':
                return $url_first . 'lien-he.html';
                break;

            case 'faq':
                switch ($view) {
                    case 'faq':
                        return $url_first . 'hoi-dap.html';
                }
                break;

            case 'home':
                switch ($view) {
                    case 'home':
                        return $url_first;
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = $url_first . FSRoute::get_name_encode('tim-kiem-trang-chu', $lang);
                        if ($keyword) {
                            $url .= '/' . $keyword . '.html';
                        }
                        return $url;
                }
                break;

            case 'notfound':
                switch ($view) {
                    case 'notfound':
                        return $url_first . '404-page.html';
                    default:
                        return $url_first . $url;
                }
                break;

            case 'promotion':
                switch ($view) {
                    case 'promotion':
                        return $url_first . 'khuyen-mai.html';
                }
                break;

            case 'department':
                switch ($view) {
                    case 'department':
                        return $url_first . 'he-thong-cua-hang.html';
                }
                break;

            case 'autoget':
                switch ($view) {
                    case 'autoget':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . 'auto-get-product-gd' . $id . '.html';
                }
                break;

            case 'cache':
                return $url_first . 'delete-cache.html';

            case 'sitemap':
                return $url_first . 'site-map.html';

            case 'users':
                switch ($view) {
                    case 'users':
                        switch ($task) {
                            case 'login':
                                $url1 = '';
                                foreach ($array_params as $key => $value) {
                                    if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'task')
                                        continue;
                                    $url1 .= '&' . $key . '=' . $value;
                                }
                                return URL_ROOT . 'dang-nhap.html' . $url1;
                            case 'register':
                                $url1 = '';
                                foreach ($array_params as $key => $value) {
                                    if ($key == 'module' || $key == 'view' || $key == 'Itemid' || $key == 'task')
                                        continue;
                                    $url1 .= '&' . $key . '=' . $value;
                                }
                                return URL_ROOT . 'dang-ky.html' . $url1;
                            case 'forget':
                                return URL_ROOT . 'quen-mat-khau.html';
                            case 'changepass':
                                return URL_ROOT . 'doi-mat-khau.html';
                            case 'email_1':
                                return URL_ROOT . 'doi-hop-thu-b1.html';
                            case 'email_2':
                                return URL_ROOT . 'doi-hop-thu-b2.html';

                            case 'logout':
                                return URL_ROOT . 'dang-xuat.html';
                            case 'set_orderstatus':
                                return URL_ROOT . 'trang-thai-order.html';
                            case 'order_status':
                                return URL_ROOT . 'theo-doi-don-hang.html';
                            default:
                                return URL_ROOT . 'thong-tin-ca-nhan.html';

                        }
                    case 'google':
                        switch ($task) {
                            case 'google_login':
//                                $id = isset($array_params['id']) ? $array_params['id'] : '';
//                                return URL_ROOT . 'chi-tiet-don-hang-' . $id . '.html';
//                            default:
                                return URL_ROOT . 'oauth2callback';
                        }
                        break;
                    case 'order':
                        switch ($task) {
                            case 'show_order':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return URL_ROOT . 'chi-tiet-don-hang-' . $id . '.html';
                            default:
                                return URL_ROOT . 'quan-ly-don-hang.html';
                        }
                        break;
                    case 'products_sort':
                        switch ($task) {
                            case 'products_hot':
                                return URL_ROOT . 'ban-chay-nhat.html';
                            case 'products_new':
                                return URL_ROOT . 'sach-moi.html';
                            case 'products_dis':
                                return URL_ROOT . 'san-pham-khuyen-mai.html';
                                case 'products_coming':
                                return URL_ROOT . 'sap-ra-mat.html';
                        }
                        break;
                    case 'address':
                        switch ($task) {
                            case 'add_address':
                                return URL_ROOT . 'them-so-dia-chi.html';
                            case 'edit_address':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return URL_ROOT . 'sua-so-dia-chi-' . $id . '.html';
                            default:
                                return URL_ROOT . 'so-dia-chi.html';
                        }
                        break;
                    case 'level':
                        return URL_ROOT . 'cap-tai-khoan.html';
                    case 'favourite':
                        return URL_ROOT . 'san-pham-yeu-thich.html';
                    case 'formregister':
                        switch ($task) {
                            case 'xacminh':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return URL_ROOT . 'xac-minh-so-dien-thoai-' . $id . '.html';
                            case 'thietlap':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return URL_ROOT . 'thiet-lap-mat-khau-' . $id . '.html';
                            case 'thanhcong':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return URL_ROOT . 'dang-ky-thanh-cong-' . $id . '.html';
                            case 'method':
                                return URL_ROOT . 'phuong-thuc-quen-mat-khau.html';
                            case 'pass_reset':
                                return URL_ROOT . 'dat-lai-mat-khau.html';
                            case 'method_smt':
                                return URL_ROOT . 'dat-lai-mat-khau-email.html';
                            case 'xacminh_email':
                                return URL_ROOT . 'ma-xac-minh-email.html';
                            case 'xacminh_phone':
                                return URL_ROOT . 'ma-xac-minh-telephone.html';
                           
                            default:
                                return URL_ROOT . 'dang-ky.html';

                        }
                    case 'login':
                        return URL_ROOT . 'dang-nhap.html';
                    case 'face':
                        switch ($task) {
                            case 'face_login':
                                return URL_ROOT . 'dang-nhap-fb.html';
                        }


                }
                break;

            default:
                return URL_ROOT . $url;
        }
    }

    /*
     * get real url from virtual url
     */

    function deURL($url)
    {
        if (!IS_REWRITE)
            return $url;
        return $url;
        if (strpos($url, URL_ROOT_REDUCE) !== false) {
            $url = substr($url, strlen(URL_ROOT_REDUCE));
        }
        if ($url == 'news.html')
            return 'index.php?module=news&view=home&Itemid=1';
        if (strpos($url, 'news-page') !== false) {
            $f = strpos($url, 'news-page') + 9;
            $l = strpos($url, '.html');
            $page = intval(substr($url, $f, ($l - $f)));
            return "index.php?module=news&view=home&page=$page&Itemid=1";
        }
        $array_url = explode('/', $url);
        $module = isset($array_url[0]) ? $array_url[0] : '';
        switch ($module) {
            case 'news':
                // if cat
                if (preg_match('#news/([^/]*)-c([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $url, $arr)) {
                    return "index.php?module=news&view=cat&id=" . @$arr[2] . "&Itemid=" . @$arr[3] . '&page=' . @$arr[5];
                }
                // if article
                if (preg_match('#news/detail/([^/]*)-i([0-9]*)-it([0-9]*).html#s', $url, $arr)) {
                    return "index.php?module=news&view=news&id=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            case 'companies':
                $str_continue = ($module = isset($array_url[1])) ? $array_url[1] : '';
                if ($str_continue == 'register.html')
                    return "index.php?module=companies&view=company&task=register&Itemid=5";
                if (preg_match('#category-id([0-9]*)-city([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $str_continue, $arr)) {
                    if (isset($arr[5]))
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3] . "&page=" . @$arr[5];
                    else
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            default:
                return $url;
        }
    }

    function get_home_link()
    {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        if ($lang == 'vi') {
            return URL_ROOT;
        } else {
            return URL_ROOT . 'en';
        }
    }

    /*
     * Dịch ngang
     */

    static function change_link_by_lang($lang, $link = '')
    {
        $module = FSRoute::get_param('module', $link);
        $view = FSRoute::get_param('view', $link);
        if (!$view)
            $view = $module;
        if (!$module || ($module == 'home' && $view == 'home')) {
            if ($lang == 'en') {
//				return URL_ROOT;
            } else {
                return URL_ROOT . 'vi';
            }
        }
        switch ($module) {

            case 'contents':
                switch ($view) {
                    case 'content':
                        $code = FSRoute::get_param('code', $link);
                        $record = FSRoute::trans_record_by_field($code, 'alias', 'fs_contents', $lang, 'id,alias,category_alias');
                        if (!$record)
                            return;
                        $url = URL_ROOT . FSRoute::get_name_encode('ct', $lang) . '-' . $record->alias;
                        return $url . '.html';
                        return $url;
                }
                break;
            default:
                $url = URL_ROOT . 'ce-information';
                return $url . '.html';
        }
    }

    /*
     * Hàm trả lại tham số: có thể từ biến $_REQUEST hay từ phân tích URL truyền vào
     */

    static function get_param($param_name, $link = '')
    {
        if (!$link)
            return FSInput::get($param_name);
        $url = str_replace('&amp;', '&', $link);
        $url_reduced = substr($url, 10); // width : index.php
        $array_buffer = explode('&', $url_reduced, 10);
        $array_params = array();
        for ($i = 0; $i < count($array_buffer); $i++) {
            $item = $array_buffer[$i];
            $pos_sepa = strpos($item, '=');
            $array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
        }
        return @$array_params[$param_name];
    }

    function get_record_by_id($id, $table_name, $lang, $select)
    {
        if (!$id)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name = $fs_table->getTable($table_name);

        $query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    /*
     * Lấy bản ghi dịch ngôn ngữ
     */

    static function trans_record_by_field($value, $field = 'alias', $table_name, $lang, $select = '*')
    {
        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE " . $field . " = '" . $value . "' ";

        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $select . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getObject();
        return $rs;
    }

    /*
     * Dịch từ field -> field ( tìm lại id rồi dịch ngược)
     */

    function translate_field($value, $table_name, $field = 'alias')
    {

        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE $field = '" . $value . "' ";
        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $field . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getResult();
        return $rs;
    }

}
