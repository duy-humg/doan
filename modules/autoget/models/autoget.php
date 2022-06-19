
<?php

class AutogetModelsAutoget extends FSModels {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_products');
        $this->table_name_author = $fstable->_('fs_products_authors');
        $this->table_name_company = $fstable->_('fs_products_companys');
        $this->table_name_xuat_ban = $fstable->_('fs_products_xuat_ban');
        $this->table_name_loai_bia = $fstable->_('fs_products_loai_bia');
        $this->table_category = $fstable->_('fs_products_categories');
        $this->table_images = $fstable->_('fs_products_images');
        $this->table_auto = $fstable->_('fs_autoget');

        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');

        $this->img_folder = 'images/products/' . $cyear . '/' . $cmonth . '/' . $cday;
        $this->arr_img_paths_other = array(
            array('large', 550, 550, 'resize_image'),
            array('resized', 200, 200, 'resize_image'),
            array('tiny', 280, 280, 'resize_image'),
            array('small', 75, 75, 'resize_image')
        );
    }

    function get_data() {
        $id = FSInput::get('id', 0, 'int');
        if ($id) {
            $where = " AND id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " AND alias = '$code' ";
        }
        $query = " SELECT *
						FROM " . $this->table_auto . " 
						WHERE published = 1 
						" . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function check_exist_link($link) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name . "
					WHERE url_get = '" . $link . "' ";
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }

    function save($articles, $cat_id, $cat_alias, $cat_name, $cat_alias_wrapper, $cat_id_wrapper) {

        $fsstring = FSFactory::getClass('FSString', '', '../');
        $upload = new Upload();

        $cyear = date('Y');
        $cmonth = date('m');
        $cdate = date('d');

        $base = $articles['link'];

        $image = $articles['image'];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $base);
        curl_setopt($curl, CURLOPT_REFERER, $base);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $str = curl_exec($curl);
        curl_close($curl);
        // Create a DOM object
        $html = new simple_html_dom();
        // Load HTML from a string
        $html->load($str);

        $content_product = $html->find('.product-container');
        $row = array();
        foreach ($content_product as $article) {
            if (isset($article->find('h1#product-name', 0)->plaintext)) {

                $name = trim($article->find('h1#product-name', 0)->plaintext);
                $row['name'] = $name;
                

                if (isset($article->find('.item-price .brand-block-row p.item-bestseller', 0)->plaintext)) {
                    $bestseller = trim($article->find('.item-price .brand-block-row p.item-bestseller', 0)->plaintext);
                    $row['bestseller'] = $bestseller;
                }

                $image_product = str_replace('200x200', 'w1200', $image);
                $name_image = basename($image_product);
                $imagemain = 'images/products/' . $cyear . '/' . $cmonth . '/' . $cdate . '/original/' . $name_image;
                $row['image'] = $imagemain;

                $row['alias'] = $fsstring->stringStandart($name);
                $row['category_id'] = $cat_id;
                $row['category_alias'] = $cat_alias;
                $row['category_name'] = $cat_name;
                $row['category_alias_wrapper'] = $cat_alias_wrapper;
                $row['category_id_wrapper'] = $cat_id_wrapper;

                $price_old = $article->find('.old-price-item', 0)->attr['data-value'];
                $price = $article->find('.special-price-item', 0)->attr['data-value'];
                if (isset($article->find('#span-discount-percent', 0)->plaintext)) {
                    if (strpos($article->find('#span-discount-percent', 0)->plaintext, '%')) {
                        $discount_unit = 'percent';
                        $discount = rtrim($article->find('#span-discount-percent', 0)->plaintext, '% ');
                    } else {
                        $discount_unit = 'price';
                        $discount = $article->find('#span-discount-percent', 0)->plaintext;
                    }
                } else {
                    $discount_unit = 'price';
                    $discount = 0;
                }
                $row['discount_unit'] = $discount_unit;
                $row['discount'] = (double) $discount;
                $row['discount_percent'] = (double) $discount;

                $row['price'] = $price;
                $row['price_old'] = $price_old;
                $row['content'] = addslashes(htmlspecialchars_decode(trim($article->find('#gioi-thieu', 0)->innertext)));
                
                $row['seo_title'] = $name;
                $row['seo_keyword'] = $name;
//                $row['seo_description'] =  $row['content'];
                
                $time = date('Y-m-d H:i:s');
                $row['created_time'] = $time;
                $row['published'] = 0;

                //sửa lý bảng
//                    $theData = [];
                foreach ($article->find('#chi-tiet tr') as $list) {
                    $info = array();
                    foreach ($list->find('td') as $cell) {
                        $info[] = trim($cell->plaintext);
                    }
                    if ($info[0] == 'Công ty phát hành') {

                        $row['company_ex'] = trim($info[1]);
                        $row['company_ex_alias'] = $fsstring->stringStandart(trim($info[1]));
                        $company_ex = $row['company_ex'];
                        $company_ex_alias = $row['company_ex_alias'];
                        $where_company = ' alias = "' . $company_ex_alias . '"';
                        $id_check_company = $this->add_company($company_ex_alias, $company_ex);
                        $company_id = $this->get_result($where_company, $this->table_name_company);
                        if ($company_id) {
                            $row['company_ex_id'] = $company_id;
                        }
                    } else if ($info[0] == 'Nhà xuất bản') {

                        $row['home_ex'] = trim($info[1]);
                        $row['home_ex_alias'] = $fsstring->stringStandart(trim($info[1]));
                        $home_ex = $row['home_ex'];
                        $home_ex_alias = $row['home_ex_alias'];
                        $where_home = ' alias = "' . $home_ex_alias . '"';
                        $id_check_home = $this->add_xuatban($home_ex_alias, $home_ex);
                        $home_id = $this->get_result($where_home, $this->table_name_xuat_ban);
                        if ($home_id) {
                            $row['home_ex_id'] = $home_id;
                        }
                    } else if ($info[0] == 'Kích thước') {
                        $row['measure_book'] = trim($info[1]);
                    } else if ($info[0] == 'Tác giả') {

                        $row['author_book'] = trim($info[1]);
                        $row['author_book_alias'] = $fsstring->stringStandart(trim($info[1]));
                        
                        if (isset($article->find('.item-price .brand-block-row .item-brand p a', 0)->href)) {
                            $link_author = 'https://tiki.vn' . $article->find('.item-price .brand-block-row .item-brand p a', 0)->href;
                        } else {
                            $link_author = '';
                        }
                        $author_book = $row['author_book'];
                        $author_book_alias = $row['author_book_alias'];

                        $id_check_author = $this->add_author($author_book_alias, $author_book, $link_author);

                        $where_author = ' alias = "' . $author_book_alias . '"';
                        $author_id = $this->get_result($where_author, $this->table_name_author);
                        if ($author_id) {
                            $row['author_book_id'] = $author_id;
                        }
                    } else if ($info[0] == 'Dịch Giả') {
                        $row['author_translate'] = trim($info[1]);
                    } else if ($info[0] == 'Loại bìa') {

                        $row['loai_bia'] = trim($info[1]);
                        $row['loai_bia_alias'] = $fsstring->stringStandart(trim($info[1]));
                        $loai_bia = $row['loai_bia'];
                        $loai_bia_alias = $row['loai_bia_alias'];
                        $where_lb = ' alias = "' . $loai_bia_alias . '"';
                        $id_check_loaibia = $this->add_loaibia($loai_bia_alias, $loai_bia);
                        $lb_id = $this->get_result($where_lb, $this->table_name_loai_bia);
                        if ($lb_id) {
                            $row['loai_bia_id'] = $lb_id;
                        }
                    } else if ($info[0] == 'Số trang') {
                        $row['so_trang'] = trim($info[1]);
                    } else if ($info[0] == 'Ngày xuất bản') {

                        $released_time = explode('-', trim($info[1]));
                        $timestamp = mktime(0, 0, 0, $released_time[0], 01, $released_time[1]);
                        $released_time = date("Y-m-d H:i:s", $timestamp);
                        $row['released_time'] = $released_time;
                    } else if ($info[0] == 'SKU') {
                        $row['ma_kho_tiki'] = trim($info[1]);
                    } else {
                        continue;
                    }
                }

                $row['url_get'] = $base;
//                    echo '<pre>';
//                    var_dump($row);die;
                $check_product = $this->check_exist_link($base);
                if (!$check_product) {
                    $id = $this->_add($row, $this->table_name);
                    if ($id) {
                        if ($html->find('.product-feature-images img')) {
                            foreach ($html->find('.product-feature-images img') as $k => $image) {
                                if ($k != 0) {
                                    $imageSrc = $image->src;
                                    $imageSrc = str_replace('75x75', 'w1200', $imageSrc);
                                    $file_name = basename($imageSrc);
                                    $path = PATH_BASE . $this->img_folder . '/original/';
                                    if (!file_exists($path)) {
                                        $upload->create_folder($path);
                                        chmod($path, 0777);
                                    }
                                    $imageData = file_get_contents($imageSrc, false);
                                    file_put_contents($path . $file_name, $imageData);

                                    foreach ($this->arr_img_paths_other as $item) {
                                        $path_resize = str_replace('/original/', '/' . $item [0] . '/', $path);
                                        if (!file_exists($path_resize)) {
                                            $upload->create_folder($path_resize);
                                            chmod($path_resize, 0777);
                                        }
                                        $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
                                        $upload->$method_resize($path . $file_name, $path_resize . $file_name, $item [1], $item [2]);
                                    }
                                    $data_image = array();
                                    $data_image['record_id'] = $id;
                                    $data_image['image'] = $this->img_folder . '/original/' . $file_name;
                                    $rs = $this->_add($data_image, $this->table_images);
                                    continue;
                                } else {
                                    $imageSrc = $image->src;
                                    $imageSrc = str_replace('75x75', '550x550', $imageSrc);
                                    $file_name = basename($imageSrc);
                                    $path = PATH_BASE . $this->img_folder . '/original/';
                                    if (!file_exists($path)) {
                                        $upload->create_folder($path);
                                        chmod($path, 0777);
                                    }
                                    $imageData = file_get_contents($imageSrc, false);
                                    file_put_contents($path . $file_name, $imageData);

                                    foreach ($this->arr_img_paths_other as $item) {
                                        $path_resize = str_replace('/original/', '/' . $item [0] . '/', $path);
                                        if (!file_exists($path_resize)) {
                                            $upload->create_folder($path_resize);
                                            chmod($path_resize, 0777);
                                        }
                                        $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
                                        $upload->$method_resize($path . $file_name, $path_resize . $file_name, $item [1], $item [2]);
                                    }
                                    continue;
                                }
                            }
                        } else {
                            $imageSrc = str_replace('200x200', 'w1200', $image);
                            $file_name = basename($imageSrc);
                            $path = PATH_BASE . $this->img_folder . '/original/';
                            if (!file_exists($path)) {
                                $upload->create_folder($path);
                                chmod($path, 0777);
                            }
                            $imageData = file_get_contents($imageSrc, false);
                            file_put_contents($path . $file_name, $imageData);

                            foreach ($this->arr_img_paths_other as $item) {
                                $path_resize = str_replace('/original/', '/' . $item [0] . '/', $path);
                                if (!file_exists($path_resize)) {
                                    $upload->create_folder($path_resize);
                                    chmod($path_resize, 0777);
                                }
                                $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
                                $upload->$method_resize($path . $file_name, $path_resize . $file_name, $item [1], $item [2]);
                            }
                            continue;
                        }
                    }
                }
            }
        }
    }

    function add_author($author_book_alias, $author_book, $base) {
//        $base = 'https://tiki.vn/author/tac-gia.html';
//        $base = str_replace('tac-gia', $author_book_alias, $base);
        if ($base) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_URL, $base);
            curl_setopt($curl, CURLOPT_REFERER, $base);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $str = curl_exec($curl);
            curl_close($curl);
            // Create a DOM object
            $html = new simple_html_dom();
            // Load HTML from a string
            $html->load($str);
            $author_box = $html->find('.author-box');
            if ($author_box) {
                foreach ($author_box as $article) {
                    $row['content'] = htmlspecialchars_decode($article->find('.text', 0)->innertext);
                }
            }

            $row['name'] = $author_book;
            $row['alias'] = $author_book_alias;
            $time = date('Y-m-d H:i:s');
            $row['created_time'] = $time;
            $row['updated_time'] = $time;
            $check_author = $this->check_add_author($author_book_alias);
            if (!$check_author) {
                $id = $this->_add($row, $this->table_name_author);
            } else {
                return 0;
            }
        }
    }

    function check_add_author($author_book_alias) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name_author . "
					WHERE alias = '$author_book_alias' ";
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }
    
    function add_company($company_ex_alias, $company_ex) {
        $row['name'] = $company_ex;
        $row['alias'] = $company_ex_alias;
        $time = date('Y-m-d H:i:s');
        $row['created_time'] = $time;
        $row['updated_time'] = $time;
        $check_company = $this->check_add_company($company_ex_alias);
        if (!$check_company) {
            $id = $this->_add($row, $this->table_name_company);
        }
    }

    function check_add_company($company_ex_alias) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name_company . "
					WHERE alias = '$company_ex_alias' ";
        $db->query($sql);
        $count = $db->getResult();
         return $count;
    }
    
    function add_xuatban($xb_alias, $xb) {
        $row['name'] = $xb;
        $row['alias'] = $xb_alias;
        $time = date('Y-m-d H:i:s');
        $row['created_time'] = $time;
        $row['updated_time'] = $time;
        $check_xuaban = $this->check_add_xuatban($xb_alias);
        if (!$check_xuaban) {
            $id = $this->_add($row, $this->table_name_xuat_ban);
        }
    }

    function check_add_xuatban($xb_alias) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name_xuat_ban . "
					WHERE alias = '$xb_alias' ";
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }

    function add_loaibia($lb_alias, $lb){
        $row['name'] = $lb;
        $row['alias'] = $lb_alias;
        $time = date('Y-m-d H:i:s');
        $row['created_time'] = $time;
        $row['updated_time'] = $time;
        $check_loaibia = $this->check_add_loaibia($lb_alias);
        if (!$check_loaibia) {
            $id = $this->_add($row, $this->table_name_loai_bia);
        }
    }
    
    function check_add_loaibia($lb_alias) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name_loai_bia . "
					WHERE alias = '$lb_alias' ";
        $db->query($sql);
        $count = $db->getResult();
        return $count;
    }

    function set_stock(){
        global $db;
        $sql='UPDATE fs_products SET stock=0 WHERE quantity=0';
        $result=$db->affected_rows($sql);
        return $result;
    }


}

?>