<?php

class ProductsModelsProducts extends FSModels
{

    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 100;
        $this->view = 'products';
        $this->type = 'products';
// ảnh đại diện
        $this->arr_img_paths = array(
            array('large', 480, 480, 'resize_image'),
            array('resized', 216, 216, 'resize_image'),
            array('tiny', 216, 216, 'cut_image'),
//            array('tiny1', 80, 120, 'resize_image'),
            array('small', 216, "", 'resize_image_fix_width')
        );
        // up nhiều ảnh
        $this->arr_img_paths_other = array(
            array('large', 480, 480, 'resize_image'),
            array('resized', 180, 180, 'resize_image'),
            array('tiny', 280, 280, 'resize_image'),
            array('tiny1', 88, "", 'resize_image'),
            array('small', 88, 88, 'cut_image')
        );

        $this->table_category_name = FSTable_ad::_('fs_products_categories');
        $this->table_name = FSTable_ad::_('fs_products');
        $this->table_excel = FSTable_ad::_('fs_products_add');
        $this->table_image = FSTable_ad::_('fs_products_images');
        $this->table_author = FSTable_ad::_('fs_products_authors');
        $this->table_companys = FSTable_ad::_('fs_products_companys');
        $this->table_xuatban = FSTable_ad::_('fs_products_xuat_ban');
        $this->table_loaibia = FSTable_ad::_('fs_products_type');
        $this->table_xuat_xu = FSTable_ad::_('fs_products_origin');
        $this->table_mau_sac = FSTable_ad::_('fs_products_color');
        $this->table_size = FSTable_ad::_('fs_products_size');
        $this->table_object = FSTable_ad::_('fs_products_object');
        $this->table_producer = FSTable_ad::_('fs_products_producer');
        $this->table_chatlieu = FSTable_ad::_('fs_products_chatlieu');
        $this->table_tags = FSTable_ad::_('fs_tags');
        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        $this->img_folder = 'images/products/' . $cyear . '/' . $cmonth . '/' . $cday;
        $this->check_alias = 1;
        $this->field_img = 'image';

        parent::__construct();
    }

    function setQuery()
    {

        // ordering
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }

        // estore
        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter) {
                $where .= ' AND a.category_id_wrapper like  "%,' . $filter . ',%" ';
            }
        }

        if (isset($_SESSION[$this->prefix . 'filter1'])) {
            $filter = $_SESSION[$this->prefix . 'filter1'];
            if ($filter) {
                //$filter = (int)$filter - 1;
                if ($filter == 2) {
                    $where .= ' AND a.published =  "0" ';
                } else {
                    $where .= ' AND a.published =  "' . $filter . '" ';
                }


            }
        }

        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";


        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.name LIKE '%" . $keysearch . "%' ";
            }
        }

        $query = " SELECT name,author,created_time,image,updated_time,is_hot,hits,published,id,category_id,category_name,alias,show_in_homepage,price_old,discount_unit,discount,quantity,ma_kho_tiki
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " .
            $where .
            $ordering . " ";
        return $query;
    }

    function save($row = array(), $use_mysql_real_escape_string = 1)
    {
        $name = FSInput::get('name');
        if (!$name)
            return false;
//        $category_id = FSInput::get('category_id', array(), 'array');

//        $str_category_id = implode(',', $category_id);
//        var_dump($str_category_id);die;
//        $row['category_id'] = ',' . $str_category_id . ',';
//var_dump($row);die;
//        $cat_parent = '';
//        $trcat_parent = '';
//        $i = 1;
//        foreach ($category_id as $key) {
//            $cat = $this->get_record_by_id($key, $this->table_category_name);
////            var_dump($cat);die;
//            if ($i == 1) {
//                $cat_parent .= $cat->list_parents;
//            }
////            var_dump($cat);
//            if ($i >= 2) {
//                $trcat_parent .= ltrim($cat->list_parents, ',');
//            }
//            $cat_parent .= $trcat_parent;
//            $i++;
//        }
//        var_dump($cat_parent);
//        var_dump($category_id);
//        var_dump($cat_parent);die;
        $id = FSInput::get('id', 0, 'int');
        $category_id = FSInput::get('category_id');
        $row['category_id'] = $category_id;
        $cat = $this->get_record_by_id($category_id, $this->table_category_name);
        $row ['category_id_wrapper'] = $cat->list_parents;
//        $row ['category_root_alias'] = $cat->root_alias;
        $row ['category_alias_wrapper'] = $cat->alias_wrapper;
        $row ['category_name'] = $cat->name;
        $row ['category_alias'] = $cat->alias;
        $row ['category_published'] = $cat->published;
        $row ['quantity'] =10000;
//        $row['category_id_wrapper'] = $cat_parent;
//        var_dump($row);die;
//        $row['category_alias_wrapper'] = $cat->alias_wrapper;
//        $row['category_name'] = $cat->name;
//        $row['category_alias'] = $cat->alias;
        if (!$category_id) {
            Errors::_('Bạn phải chọn danh mục');
            return;
        }

        $ord = FSInput::get('ordering', 0, 'int');
        $id_shop = FSInput::get('id_shop');
        $get_name_shop = $this->get_name_shop($id_shop);
        if($get_name_shop){
            $row ['name_shop'] =$get_name_shop->name;
        }

        if ($ord) {
            $row['ordering'] = $ord;
        } else {
            $row['ordering'] = 0;
        }


        $coming = FSInput::get('coming_soon', 0, 'int');
        $row['coming_soon'] = $coming;
//        var_dump($row);die;


//        var_dump($row);die;
        if (!FSInput::get('so_trang')) {
            $row['so_trang'] = 0;
        }

//        tac gia
//        $author_book_id = FSInput::get('author_book_id', 0, 'int');
//        $author_book_id = FSInput::get('author_book_id', array(), 'array');
//        $str_author_book_id = implode(',', $author_book_id);
//        $row ['author_book_id'] = ',' . $str_author_book_id . ',';
//        $author_book = '';
//        foreach ($author_book_id as $key) {
//            $author = $this->get_record_by_id($key, $this->table_author);
//            $author_book .= $author->name . ', ';
//        }
//        $str_author_book = rtrim($author_book, ', ');
////        var_dump($str_author_book);die;
//        $row['author_book'] = $str_author_book;

//        $author = $this->get_record_by_id($author_book_id, $this->table_author);
//        $row['author_book'] = $author->name;
//        $row['author_book_alias'] = $author->alias;

//        cty phat hanh
//        $company_ex_id = FSInput::get('company_ex_id', 0, 'int');
//        $company_ex = $this->get_record_by_id($company_ex_id, $this->table_companys);
//        $row['company_ex'] = $company_ex->name;
//        $row['company_ex_alias'] = $company_ex->alias;

//        nha xuat ban
//        $home_ex_id = FSInput::get('home_ex_id', 0, 'int');
//        $home_ex = $this->get_record_by_id($home_ex_id, $this->table_xuatban);
//        $row['home_ex'] = $home_ex->name;
//        $row['home_ex_alias'] = $home_ex->alias;

//        loai bia
//        $loai_bia_id = FSInput::get('loai_bia_id', 0, 'int');
//        $loai_bia = $this->get_record_by_id($loai_bia_id, $this->table_loaibia);
//        $row['loai_bia'] = $loai_bia->name;
//        $row['loai_bia_alias'] = $loai_bia->alias;


//        mau sac
//        $mau_sac_id = FSInput::get('color_id', array(), 'array');
//        $mau_sac_ = '';
//        $mau_sac_alias = '';
//        foreach ($mau_sac_id as $key) {
//            $mau_sac = $this->get_record_by_id($key, $this->table_mau_sac);
//            $mau_sac_ .= $mau_sac->name . ', ';
//            $mau_sac_alias .= $mau_sac->alias . ', ';
//        }
//        $str_mau_sac_ = rtrim($mau_sac_, ', ');
//        $str_mau_alias = rtrim($mau_sac_alias, ', ');
////        var_dump($str_mau_alias);die;
//        $str_mau_sac_id = implode(',', $mau_sac_id);
//        $row['color_id'] = ',' . $str_mau_sac_id . ',';
//
////        $mau_sac = $this->get_record_by_id($mau_sac_id, $this->table_mau_sac);
//        $row['color'] = $str_mau_sac_;
//        $row['color_alias'] = $str_mau_alias;

//        origin
//        $origin_id = FSInput::get('origin_id', 0, 'int');
//        $origin = $this->get_record_by_id($origin_id, $this->table_xuat_xu);
//        $row['origin'] = $origin->name;
//        $row['origin_alias'] = $origin->alias;

//        producer
//        $producer_id = FSInput::get('producer_id', 0, 'int');
//        $producer = $this->get_record_by_id($producer_id, $this->table_producer);
//        $row['producer'] = $producer->name;
//        $row['producer_alias'] = $producer->alias;

//        chatlieu
//        $chatlieu_id = FSInput::get('chatlieu_id', 0, 'int');
//        $chatlieu = $this->get_record_by_id($chatlieu_id, $this->table_chatlieu);
//        $row['chatlieu'] = $chatlieu->name;
//        $row['chatlieu_alias'] = $chatlieu->alias;


        $price_old = FSInput::get('price_old');
        $price_old = $this->standart_money($price_old, 0);
        $price = FSInput::get('price');
        $price = $this->standart_money($price, 0);
        $discount = FSInput::get('discount');
        $discount = $this->standart_money($discount, 0);
        $discount_unit = FSInput::get('discount_unit', 'percent');
//        if ($discount_unit == 'percent') {
//            if ($discount > 100 || $discount < 0) {
//                $row ['price_old'] = $price_old;
//                $row ['price'] = $price_old;
//                $row ['discount'] = 0;
//                $row ['discount_percent'] = 0;
//            } else {
//                $row ['price_old'] = $price_old;
//                $row ['discount'] = $discount;
//                $row ['discount_percent'] = $discount;
//                $row ['price'] = $price_old * (100 - $discount) / 100;
//            }
//        } else {
        if ($discount > $price_old || $discount < 0) {
            echo 2;
            $row ['price_old'] = $price_old;
            $row ['price'] = $price_old;
            $row ['discount'] = 0;
            $row ['discount_percent'] = 0;
        } else {

            $row ['price_old'] = $price_old;
//            $row ['discount'] = $discount;
            $row ['price'] = $price;
            if ($price_old > $price && $price > 0) {
                $row ['discount'] = round(100 - (100 * ($price / $price_old)));
                $row ['discount_percent'] = $price_old - $price;

            } elseif ($price_old > 0 && $price == 0) {
                $row ['price_old'] = $price_old;
                $row ['price'] = $price_old;
                $row ['discount'] = 0;
                $row ['discount_percent'] = 0;
            } elseif ($price_old == 0 && $price > 0) {
                $row ['price_old'] = $price;
                $row ['price'] = $price;
                $row ['discount'] = 0;
                $row ['discount_percent'] = 0;
//                $row ['price_old'] = $price;

            }
        }

        $price_old = FSInput::get('price_old');
        $row['price_old'] = $price_old;

        $price_old = FSInput::get('price_old');
        $price = FSInput::get('price');
        if($price_old){
            $row['giamgia'] = ceil(100 - ($price/$price_old)*100);
        }


//var_dump($row ['price']);die;
//        }

        $row['content'] = htmlspecialchars_decode(FSInput::get('content'));
        $time = date('Y-m-d H:i:s');

        $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
        if (!$user_id)
            return false;

        $user = $this->get_record_by_id($user_id, 'fs_users', 'username');
        if ($id) {
            $row['updated_time'] = $time;
//            $row['author_last'] = $user->username;
//            $row['author_last_id'] = $user_id;
        } else {
            $row['created_time'] = $time;
            $row['updated_time'] = $time;
            $row['author'] = $user->username;
            $row['author_id'] = $user_id;
        }



        $menu_object = FSInput::get('menu_object', array(), 'array');
        $list_object = implode(',', $menu_object);
        if ($list_object) {
            $list_object = ',' . $list_object . ',';
        }
        $row['list_object'] = $list_object;

        //                     related products
        $record_relate = FSInput::get('package_record_related', array(), 'array');
        $row['package_related'] = '';
        if (count($record_relate)) {
            $record_relate = array_unique($record_relate);
            $row['package_related'] = ',' . implode(',', $record_relate) . ',';
        }

        $tags = FSInput::get('tag_id', '', 'array');
        $list_tags_id = implode(',', $tags);
        $row['tag_alias'] = $list_tags_id;




        $id = parent::save($row);
        $rs = $this->save_edit($id);
        $type_save = FSInput::get('type_save');
        if($type_save==1){
            $this->save_thuoctinh_add($id);
            $this->update_img_sp($id,session_id());


        }elseif ($type_save==2){
            $this->save_thuoctinh_save($id);
        }

        $count_thuoctinh_2 = FSInput::get('count_thuoctinh');
        if(!$count_thuoctinh_2){
            $this->dete_extend($id);
        }


        $get_id_thuoctinh = $this->get_id_thuoctinh($id);
        if($get_id_thuoctinh){
            $arr_exten = '';
            $arr_construction = array();
            foreach ($get_id_thuoctinh as $item){
                $arr_construction[] =  $item->noidung;
//                var_dump($arr_construction);die;
            }
            $array_unique = array_unique($arr_construction);
            $a = implode ( ',', $array_unique );
            $this->up_extend($id,$a);
        }else{
            $a = '';
            $this->up_extend($id,$a);
        }

        unset($_SESSION['category']);

        // file excel

        return $id;

    }

    function update_img_sp($id,$sess)
    {

        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "UPDATE " . $fs_table->getTable('fs_products_images') . "
                                SET record_id = $id
                                  WHERE 
                                      session_id = '$sess'
                
                                 ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }

    function dete_extend($id)
    {

        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "DELETE FROM  " . $fs_table->getTable('fs_sp_properties_noidung') . "
                             
                                  WHERE 
                                     product_id = $id
                
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }

    function up_extend($id,$a)
    {

        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "UPDATE " . $fs_table->getTable('fs_products') . "
                                SET extend = '$a'
                                  WHERE 
                                     published = 1 and id = $id
                
                                 ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }

    function get_id_thuoctinh($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_properties_noidung') . "
                                  WHERE 
                                     published = 1 and product_id = $id
                    ORDER BY id ASC ,ordering ASC
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }

    /*
     * select in category of home
     */
    function save_edit($id)
    {
        global $db;

        $tablename = 'fs_products_sub';

//        var_dump($tablename); die;

        // remove field
        if (!$this->remove_exist_field($tablename, $id)) {
            return false;
        }

        // save exist field
        if (!$this->save_exist_field($tablename)) {
            return false;
        }

        // save new field
        if (!$this->save_new_field($tablename, $id)) {
            return false;
        }

        return true;
    }

    function save_thuoctinh_save($id)
    {
        global $db;
        $tablename = 'fs_sp_properties_noidung';

        if (!$this->save_exist_field_thuoctinh($tablename,$id)) {
            return false;
        }
    }
    function save_thuoctinh_add($id)
    {
        global $db;
        $tablename = 'fs_sp_properties_noidung';

        if (!$this->save_new_field_thuoctinh($tablename, $id)) {
            return false;
        }

        return true;
    }

    function save_exist_field_thuoctinh($table_name,$id_p)
    {
//        echo $id_p;
        global $db;

        // EXIST FIELD
        $field_extend_exist_total = FSInput::get('count_thuoctinh');

        $arr_sql_alter = array();
        $time = date("Y-m-d H:i:s");
//var_dump($api);
        for ($i = 1; $i <= $field_extend_exist_total; $i++) {
            $sql_update = " UPDATE " . $table_name . "
							SET ";

            $id_exist = FSInput::get('id_thuoctinh' . $i);
//            $get_nd = $this->get_nd_extend($id_exist);

            $get_sp = $this->get_sp($id_p);
            $category_id = $get_sp->category_id;
            $category_name = $get_sp->category_name;
            $category_id_wrapper = $get_sp->category_id_wrapper;
            $category_alias_wrapper = $get_sp->category_alias_wrapper;


            $field_type= FSInput::get('field_type' . $i);
            $name_type = FSInput::get('name_type' . $i);
            $field_table = FSInput::get('field_table' . $i);
            $name_table = FSInput::get('name_table' . $i);
            $record_id = FSInput::get('record_id' . $i);




            $title = FSInput::get('title' . $i);
            if($field_type==34){
                $thuoctinh = FSInput::get('thuoctinh' . $i);
            }elseif ($field_type==35){
                $author_book_id = FSInput::get('thuoctinh'. $i, array(), 'array');
                $str_author_book_id = implode(',', $author_book_id);
                $thuoctinh = ',' . $str_author_book_id . ',';


            }

            if($id_exist){
                $sql_update .= " 	  
											noidung = '$thuoctinh', 
											category_id = '$category_id', 
											category_name = '$category_name', 
											category_id_wrapper = '$category_id_wrapper', 
											category_alias_wrapper = '$category_alias_wrapper', 
											title = '$name_table', 
										
											edited_time = '$time'
											";
                $sql_update .= " WHERE id = $id_exist ";


                $db->query($sql_update);
                $rows = $db->affected_rows();
            }else{
                $row['title'] = FSInput::get('name_table' . $i);
                $row['product_id'] = $id_p;
                $row['category_id'] = $get_sp->category_id;
                $row['category_name'] = $get_sp->category_name;
                $row['category_id_wrapper'] = $get_sp->category_id_wrapper;
                $row['category_alias_wrapper'] = $get_sp->category_alias_wrapper;
//                var_dump($row['title']);die;
                $row['record_id'] = FSInput::get('record_id' . $i);
                $row['field_type'] = FSInput::get('field_type' . $i);
                $row['name_type'] = FSInput::get('name_type' . $i);
                $row['field_table'] = FSInput::get('field_table' . $i);
                $row['name_table'] = FSInput::get('name_table' . $i);
                if($row['field_type']==34){
                    $row['noidung'] = FSInput::get('thuoctinh' . $i);
//                    var_dump( $row['noidung']);die;
                }elseif ($row['field_type']==35){
//                    $author_book_id = FSInput::get('thuoctinh', 0, 'int');
                    $author_book_id = FSInput::get('thuoctinh' . $i, array(), 'array');
//                    var_dump($author_book_id);
                    $str_author_book_id = implode(',', $author_book_id);
                    $row['noidung'] = ',' . $str_author_book_id . ',';
//                    var_dump( $row['noidung']);die;
                }
                $row['published'] = 1;
                $row['created_time'] = $time;
                $row['edited_time'] = $time;

                $id_sub = $this->_add($row, $table_name);
            }












        }
        return true;
    }

    function save_new_field_thuoctinh($table_name, $id)
    {
//        echo $id;

        global $db;

        $time = date("Y-m-d H:i:s");
        $new_field_total = FSInput::get('count_thuoctinh');
//        var_dump($new_field_total);die();
        if ($new_field_total) {
            $row = array();

            for ($i = 1; $i <= $new_field_total; $i++) {

                $get_sp = $this->get_sp($id);
                $row['product_id'] = $id;
                $row['category_id'] = $get_sp->category_id;
                $row['category_name'] = $get_sp->category_name;
                $row['category_id_wrapper'] = $get_sp->category_id_wrapper;
                $row['category_alias_wrapper'] = $get_sp->category_alias_wrapper;
//                var_dump($row['title']);die;
                $row['record_id'] = FSInput::get('record_id' . $i);
                $row['field_type'] = FSInput::get('field_type' . $i);
                $row['name_type'] = FSInput::get('name_type' . $i);
                $row['field_table'] = FSInput::get('field_table' . $i);
                $row['name_table'] = FSInput::get('name_table' . $i);
                $row['title'] = FSInput::get('name_table' . $i);
                if($row['field_type']==34){
                    $row['noidung'] = FSInput::get('thuoctinh' . $i);
//                    var_dump( $row['noidung']);die;
                }elseif ($row['field_type']==35){
//                    $author_book_id = FSInput::get('thuoctinh', 0, 'int');
                    $author_book_id = FSInput::get('thuoctinh' . $i, array(), 'array');
//                    var_dump($author_book_id);
                    $str_author_book_id = implode(',', $author_book_id);
                    $row['noidung'] = ',' . $str_author_book_id . ',';
//                    var_dump( $row['noidung']);die;
                }
                $row['published'] = 1;
                $row['created_time'] = $time;
                $row['edited_time'] = $time;
                $id_sub = $this->_add($row, $table_name);
            }
            if (!$id_sub) {
                Errors::setError("Không thể thêm mới sản phẩm !");
                return false;
            }

        }
        return true;
    }


    function get_sp($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_products') . "
                                  WHERE 
                                     published = 1 and id = $id
                    ORDER BY id ASC ,ordering ASC
                                 ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }

    function get_nd_extend($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_properties_noidung') . "
                                  WHERE 
                                     published = 1 and id = $id
                    ORDER BY id ASC ,ordering ASC
                                 ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }

    function remove_exist_field($tablename)
    {
        $tablename_2 = 'fs_products_sub_2';
        // var_dump($tablename_2);die;
        global $db;
        $field_remove = trim(FSInput::get('field_remove'),',');
        // var_dump($field_remove);die;
        if ($field_remove) {
            $array_field_remove = explode(",", $field_remove);
            if (count($array_field_remove) > 0) {
                foreach ($array_field_remove as $item) {
                    // var_dump($item);
                    $this->_remove('id = ' . $item, $tablename_2);
                    $this->_remove('sub_id = ' . $item, $tablename);
                    
                   
                }
            }
        }
        return true;
    }

    function save_exist_field($table_name)
    {
        global $db;

        $id_pd = FSInput::get('id');
        // var_dump($id_pd);

        $table_name_2 = 'fs_products_sub_2';

        // EXIST FIELD
        $field_extend_exist_total = FSInput::get('field_extend_exist_total');

        $arr_sql_alter = array();
        $time = date("Y-m-d H:i:s");

        for ($i = 0; $i < $field_extend_exist_total; $i++) {
            $sql_update = " UPDATE " . $table_name_2 . "
							SET ";

            $id_exist = FSInput::get('id_exist_' . $i);
           

            $new_color = FSInput::get('color_id_exist_'. $i, array(), 'array');
            // echo '<br>';
            // var_dump($new_color);

            sort($new_color);
            $arr_color_id_new = '';
            foreach($new_color as $item){
                $arr_color_id_new .= $item.',';
            }
            $list_sub_color_dete = $this->get_sub_3(rtrim($arr_color_id_new,','),$id_exist);
           
            foreach($list_sub_color_dete as $item){
                $this->dete_color($item->id);
            }

            $list_sub_color = $this->get_sub_2($id_exist);

            $arr_color_id_2 = '';
            foreach($list_sub_color as $item){
                $arr_color_id_2 .= $item->color_id.',';
            }
     
            $arr_color_id_3 = explode(',',rtrim($arr_color_id_2,','));
     
            sort($arr_color_id_3);
            $arr_color_id_4 = '';
            foreach($arr_color_id_3 as $item){
                $arr_color_id_4 .= $item.',';
            }

            $arr_color_id_old = $arr_color_id_4;
            // var_dump($arr_color_id_new);
            // echo '<br>';
            // var_dump($arr_color_id_old );
            // echo '<br>';
            $list_inser_color_2 = str_replace($arr_color_id_old,'',$arr_color_id_new);
            $list_inser_color = rtrim( $list_inser_color_2,',');
            
// echo 1;
            

            // var_dump($arr_color_id_new);


            // $arr_color_dete = str_replace($arr_color_id_new,);


            // $str_author_book_id = implode(',', $mau_sac_id);
           
            // var_dump($new_color);
          

            // var_dump(rtrim($arr_color_id_old,','));

            // var_dump($id_exist);die;


            $quan_exist = 1000;
            $quan_exist_begin = 1000;

            $price_exist = FSInput::get('price_exist_' . $i);
            $price_exist_begin = FSInput::get('price_exist_' . $i . '_begin');
           

            // $new_color = FSInput::get('color_id_exist_' . $i);
//            $row['color_id'] = $new_color;
            // $color = $this->get_record_by_id($new_color, 'fs_products_color');
            // $color_name = $color->name;
//            $row['color_name'] = $color_name;
            $new_products_type = FSInput::get('products_type_id_exist_' . $i);
//            $row['size_id'] = $new_products_type;
            $products_type = $this->get_record_by_id($new_products_type, 'fs_products_size');
            $products_type_name = $products_type->name;
            $products_type_id_exist = FSInput::get('products_type_id_exist_' . $i);
            $products_type_id_exist_begin = FSInput::get('products_type_id_exist_' . $i . '_begin');
            $published_exist = FSInput::get('is_published_exist_' . $i);
            $published_exist_begin = FSInput::get('is_published_exist_' . $i . '_begin');
            $discount_exist = FSInput::get('discount_exist_' . $i);
            $discount_exist_begin = FSInput::get('discount_exist_' . $i . '_begin');
            $price_h_exist = FSInput::get('price_h_exist_' . $i);
            $price_h_exist_begin = FSInput::get('price_h_exist_' . $i . '_begin');
            if ($price_exist == 0 && $price_h_exist > 0) {
                $price_exist = $price_h_exist;
            } elseif ($price_h_exist == 0 && $price_exist > 0) {
                $price_h_exist = $price_exist;
            }
            if (@$price_exist && @$price_h_exist) {
                $discount_exist = ($price_exist - $price_h_exist) * 100 / $price_exist;
            }
            
            if (($price_exist != $price_exist_begin) || ($discount_exist != $discount_exist_begin) || ($price_h_exist != $price_h_exist_begin) || ($quan_exist != $quan_exist_begin)
                || ($published_exist != $published_exist_begin) || ($products_type_id_exist != $products_type_id_exist_begin)
            ) {

            foreach($arr_color_id_3 as $item){
                $sql_update_2 = " UPDATE " . $table_name . "
                SET ";

                $sql_update_2 .= " 	  
                     	    			
                     	    				
                     	    				size_id = '$new_products_type',
                     	    				size_name = '$products_type_name',
											price = '$price_exist', 
											price_h = '$price_h_exist', 
											discount = '$discount_exist', 
											
											name = '$products_type_id_exist',
											edited_time = '$time'
											";
                if($item){
                    $sql_update_2 .= " WHERE sub_id = $id_exist  and color_id = $item";
                }else{
                    $sql_update_2 .= " WHERE sub_id = $id_exist";
                }
                

                $db->query($sql_update_2);
                $rows = $db->affected_rows();
            }
            // echo
            $row_2 = array();
            // var_dump($list_inser_color);
            if($list_inser_color){
                foreach(explode(',',$list_inser_color) as $item){

                    if($item){
                        $color = $this->get_record_by_id($item, 'fs_products_color');

                        $color_name = $color->name;
                        $row_2['color_id'] = $item;
                        $row_2['color_name'] = $color_name;
                    }

                    
                    $row_2['size_id'] = $new_products_type;
                    $row_2['size_name'] = $products_type_name;

                    $row_2['price'] = $price_exist;
                    $row_2['price_h'] = $price_h_exist;
                    $row_2['discount'] = $discount_exist;
                    $row_2['name'] = $products_type_id_exist;
                    $row_2['published'] = 1;
                    $row_2['created_time'] = $time;
                    $row_2['sub_id'] = $id_exist;
                    $row_2['product_id'] = $id_pd;
                    $row_2['quantity'] = 1000;
                    // var_dump( $table_name);
                    
                    $id_sub = $this->_add($row_2, $table_name);
                }
                
            }
            $list_sub_color_2 = $this->get_sub_2($id_exist);
            if(count($list_sub_color_2) == 0){
                $row_2['size_id'] = $new_products_type;
                $row_2['size_name'] = $products_type_name;

                $row_2['price'] = $price_exist;
                $row_2['price_h'] = $price_h_exist;
                $row_2['discount'] = $discount_exist;
                $row_2['name'] = $products_type_id_exist;
                $row_2['published'] = 1;
                $row_2['created_time'] = $time;
                $row_2['sub_id'] = $id_exist;
                $row_2['product_id'] = $id_pd;
                $row_2['quantity'] = 1000;
                   
                $id_sub = $this->_add($row_2, $table_name);
            }
            // var_dump(  count($list_sub_color_2));




                $sql_update .= " 	  
                     	    				color_id = '$arr_color_id_new',
                     	    				
                     	    				size_id = '$new_products_type',
                     	    				size_name = '$products_type_name',
											price = '$price_exist', 
											price_h = '$price_h_exist', 
											discount = '$discount_exist', 
											
									
											name = '$products_type_id_exist',
											published = '$published_exist',
											edited_time = '$time'
											";
                $sql_update .= " WHERE id = $id_exist ";

//                    print_r($sql_update);die();

                $db->query($sql_update);
              
                $rows = $db->affected_rows();

            }
           
//            }
        }
        // die;
//die;
        return true;

        // END EXIST FIELD
    }

    function save_new_field($table_name, $id)
    {
//        echo ($table_name);
//        echo 1;die;
        global $db;
//        $cid = FSInput::get('cid');
//        var_dump($cid);die;
        $time = date("Y-m-d H:i:s");
        // NEW FIELD
        $new_field_total = FSInput::get('new_field_total');
//        var_dump($new_field_total);die();
        if ($new_field_total) {
            $row = array();
            $row_2 = array();
//            $arr_insert_table = array();
            for ($i = 0; $i < $new_field_total; $i++) {

                $new_products_type = FSInput::get('new_size_id_' . $i);
                $mau_sac_id = FSInput::get('new_color_id_'. $i, array(), 'array');
                // var_dump($mau_sac_id);die;
                if($new_products_type){
                    $new_price = FSInput::get('new_price_' . $i);
                    $new_price_h = FSInput::get('new_price_h_' . $i);
                    
                    $row_2['product_id'] = $id;
    
                    
                    // var_dump($mau_sac_id);
                    $str_author_book_id = implode(',', $mau_sac_id);
                   
                    $arry_color = explode(',',$str_author_book_id);
                    // var_dump($arry_color[0]);
    
                    $row_2['color_id']= $str_author_book_id;
                    $row_2['quantity'] = 1000;
                    $row_2['size_id'] = $new_products_type;
    
                 
    
                    $products_type = $this->get_record_by_id($new_products_type, 'fs_products_size');
                    $products_type_name = $products_type->name;
                    $row_2['size_name'] = $products_type_name;
    
                    if ($new_price == 0 && $new_price_h > 0) {
                        $new_price = $new_price_h;
                    }
                    $new_discount = ($new_price - $new_price_h) * 100 / $new_price;
                    $row_2['price'] = $new_price;
                    $row_2['discount'] = $new_discount;
                    $row_2['price_h'] = $new_price_h;
                    
                    if ($new_price > $new_price_h && $new_price_h == 0 && $new_price > 0) {
                        $row_2['price'] = $new_price;
                        $row_2['price_h'] = $new_price;
                    } elseif ($new_price < $new_price_h && $new_price == 0 && $new_price_h > 0) {
                        $row_2['price'] = $new_price_h;
                        $row_2['price_h'] = $new_price_h;
                    }
                    $new_products_type_2 = FSInput::get('new_products_type_id_' . $i);
                    $row_2['name'] = $new_products_type_2;
    
                    $new_published = FSInput::get('new_published_' . $i);
                    $row_2['published'] = $new_published;
    
                    $row_2['created_time'] = $time;
                    $row_2['edited_time'] = $time;
    
    
    
                    $id_sub2 = $this->_add($row_2, 'fs_products_sub_2');
    
                    // var_dump($id_sub2);die;
    
                    // var_dump($new_products_type);
                    var_dump(count($arry_color));
                    if($arry_color[0] != 0){
                        foreach($arry_color as $item){
                     
                            $row['sub_id'] = $id_sub2;
        
                            $new_color = $item;
                            $row['color_id'] = $new_color;
                            $color = $this->get_record_by_id($new_color, 'fs_products_color');
                            $color_name = $color->name;
                            $row['color_name'] = $color_name;
                            
            
                            $row['product_id'] = $id;
                            $new_quan = 1000;
                            $row['quantity'] = $new_quan;
                            
                            $row['size_id'] = FSInput::get('new_size_id_' . $i);
                            $products_type = $this->get_record_by_id(FSInput::get('new_size_id_' . $i), 'fs_products_size');
                            $products_type_name = $products_type->name;
                            $row['size_name'] = $products_type_name;
                            // var_dump($row['size_name']);
                            if ($new_price == 0 && $new_price_h > 0) {
                                $new_price = $new_price_h;
                            }
                            $new_discount = ($new_price - $new_price_h) * 100 / $new_price;
                            $row['price'] = $new_price;
                            $row['discount'] = $new_discount;
                            $row['price_h'] = $new_price_h;
                            if ($new_price > $new_price_h && $new_price_h == 0 && $new_price > 0) {
                                $row['price'] = $new_price;
                                $row['price_h'] = $new_price;
                            } elseif ($new_price < $new_price_h && $new_price == 0 && $new_price_h > 0) {
                                $row['price'] = $new_price_h;
                                $row['price_h'] = $new_price_h;
                            }
                            $new_products_type = FSInput::get('new_products_type_id_' . $i);
                            $row['name'] = $new_products_type;
            
                            // $upload_area = "new_other_image_" . $i;
            
                            // if ($_FILES [$upload_area] ["name"]) {
                            //     $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_other);
                            //     $row ['image'] = $image;
                            // }
            
                            $new_published = FSInput::get('new_published_' . $i);
                            $row['published'] = $new_published;
            
                            $row['created_time'] = $time;
                            $row['edited_time'] = $time;
                            // var_dump($table_name)
                            
                            $id_sub = $this->_add($row, $table_name);
                        }
                    }else{
                        $row['sub_id'] = $id_sub2;
        
                            // $new_color = 0;
                            // $row['color_id'] = $new_color;
                            // $color = $this->get_record_by_id($new_color, 'fs_products_color');
                            // $color_name = 'Không màu';
                            // $row['color_name'] = $color_name;
                            
            
                            $row['product_id'] = $id;
                            $new_quan = 1000;
                            $row['quantity'] = $new_quan;
                            
                            $row['size_id'] = FSInput::get('new_size_id_' . $i);
                            $products_type = $this->get_record_by_id(FSInput::get('new_size_id_' . $i), 'fs_products_size');
                            $products_type_name = $products_type->name;
                            $row['size_name'] = $products_type_name;
                            // var_dump($row['size_name']);
                            if ($new_price == 0 && $new_price_h > 0) {
                                $new_price = $new_price_h;
                            }
                            $new_discount = ($new_price - $new_price_h) * 100 / $new_price;
                            $row['price'] = $new_price;
                            $row['discount'] = $new_discount;
                            $row['price_h'] = $new_price_h;
                            if ($new_price > $new_price_h && $new_price_h == 0 && $new_price > 0) {
                                $row['price'] = $new_price;
                                $row['price_h'] = $new_price;
                            } elseif ($new_price < $new_price_h && $new_price == 0 && $new_price_h > 0) {
                                $row['price'] = $new_price_h;
                                $row['price_h'] = $new_price_h;
                            }
                            $new_products_type = FSInput::get('new_products_type_id_' . $i);
                            $row['name'] = $new_products_type;
            
                            // $upload_area = "new_other_image_" . $i;
            
                            // if ($_FILES [$upload_area] ["name"]) {
                            //     $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_other);
                            //     $row ['image'] = $image;
                            // }
            
                            $new_published = FSInput::get('new_published_' . $i);
                            $row['published'] = $new_published;
            
                            $row['created_time'] = $time;
                            $row['edited_time'] = $time;
                            // var_dump($table_name)
                            
                            $id_sub = $this->_add($row, $table_name);
                    }
                    
                }

               

                // die;

              

              


                
            }
            if (!$id_sub) {
                Errors::setError("Không thể thêm mới sản phẩm phụ !");
                return false;
            }

        }
        return true;
    }


    function get_categories_tree()
    {
        $this->table_category_name = 'fs_products_categories';
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
    function dm()
    {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_category_name . "
						  	WHERE published = 1 and level = 0 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function dm2($id)
    {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_category_name . "
						  	WHERE published = 1 and parent_id = $id ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_name_shop($id)
    {
        global $db;
        $this->table_shop = 'fs_products_shop';
        $query = " SELECT *
						  FROM 
						  	" . $this->table_shop . "
						  	WHERE published = 1 and id = $id ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function thuoctinh($parent_id,$id)
    {
        global $db;
        $this->table_category_name = 'fs_sp_properties_ds';
        $query = " SELECT *
						  FROM 
						  	" . $this->table_category_name . "
						  	WHERE published = 1 and (record_id = $parent_id or record_id = $id)  ORDER BY ordering ";
//        var_dump($query);
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

//    function thuoctinh_level_1($parent_id,$id)
//    {
//        global $db;
//        $this->table_category_name = 'fs_sp_properties_ds';
//        $query = " SELECT *
//						  FROM
//						  	" . $this->table_category_name . "
//						  	WHERE published = 1 and record_id = $parent_id or   ORDER BY ordering ";
//        $sql = $db->query($query);
//        $result = $db->getObjectList();
//        return $result;
//    }

    function dete_color($id)
    {
        global $db;
        $this->table_category_name = 'fs_products_sub';
        $query = " DELETE
                        FROM 
                            " . $this->table_category_name . "
                            WHERE published = 1 and id = $id ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_sub_2($id)
    {
        global $db;
        $this->table_category_name = 'fs_products_sub';
        $query = " SELECT *
                        FROM 
                            " . $this->table_category_name . "
                            WHERE published = 1 and sub_id = $id ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_sub_3($arr,$id_sub)
    {

        // var_dump($arr);die;
        $where = '';
        // var_dump($arr);
        if($arr != ''){
            $i=1;
            $arr_2 = explode(',',$arr);
           
            foreach($arr_2 as $item){
                if($i==1){
                    $where .= 'and color_id != '.$item;
                }else{
                    $where .= ' and color_id != '.$item;
                }
               
                $i++;
            }
        }

        global $db;
        $this->table_category_name = 'fs_products_sub';
        $query = " SELECT *
                        FROM 
                            " . $this->table_category_name . "
                            WHERE published = 1 and sub_id = $id_sub  $where ORDER BY ordering ";

        // echo $query;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_dm($id)
    {
        global $db;
        $this->table_category_name = 'fs_products_categories';
        $query = " SELECT *
						  FROM 
						  	" . $this->table_category_name . "
						  	WHERE published = 1 and id = $id ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    function list_thuoctinh($id)
        {
            global $db;
            $this->table_category_name = 'fs_products_chebien';
            $query = " SELECT *
                              FROM 
                                " . $this->table_category_name . "
                                WHERE published = 1 and category_id = $id ORDER BY ordering ";
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }

    function list_thuoctinh_nd($id_table,$id_sp)
    {
        global $db;
        $this->table_category_name = 'fs_sp_properties_noidung';
        $query = " SELECT *
                              FROM 
                                " . $this->table_category_name . "
                                WHERE published = 1 and product_id = $id_sp and field_table = $id_table ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_author()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_author . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_company_ex()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_companys . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_xuat_ban()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_xuatban . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_products_type()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_loaibia . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_object()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_object . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_xuat_xu()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_xuat_xu . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_mau_sac()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_mau_sac . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_shop()
    {
        $this->table_shop= 'fs_products_shop';
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_shop . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    function get_size()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_size . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_producer()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_producer . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_chatlieu()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_chatlieu . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_tags()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_tags . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    /*
     * Save all record for list form
     */

    function save_all()
    {
        $total = FSInput::get('total', 0, 'int');
        if (!$total)
            return true;
        $field_change = FSInput::get('field_change');
        if (!$field_change)
            return false;
        $field_change_arr = explode(',', $field_change);
        $total_field_change = count($field_change_arr);
        $record_change_success = 0;
        for ($i = 0; $i < $total; $i++) {
//	        	$str_update = '';
            $row = array();
            $update = 0;
            foreach ($field_change_arr as $field_item) {
                $field_value_original = FSInput::get($field_item . '_' . $i . '_original');
                $field_value_new = FSInput::get($field_item . '_' . $i);
                if (is_array($field_value_new)) {
                    $field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) . ',' : '';
                }

                if ($field_value_original != $field_value_new) {
                    $update = 1;
                    // category
                    if ($field_item == 'category_id') {
                        $cat = $this->get_record_by_id($field_value_new, $this->table_category_name);
                        $row['category_id_wrapper'] = $cat->list_parents;
                        $row['category_alias_wrapper'] = $cat->alias_wrapper;
                        $row['category_name'] = $cat->name;
                        $row['category_alias'] = $cat->alias;
                        $row['category_id'] = $field_value_new;
                    } else {
                        $row[$field_item] = $field_value_new;
                    }
                }
            }
            if ($update) {
                $id = FSInput::get('id_' . $i, 0, 'int');
                $str_update = '';
                global $db;
                $j = 0;
                foreach ($row as $key => $value) {
                    if ($j > 0)
                        $str_update .= ',';
                    $str_update .= "`" . $key . "` = '" . $value . "'";
                    $j++;
                }

                $sql = ' UPDATE  ' . $this->table_name . ' SET ';
                $sql .= $str_update;
                $sql .= ' WHERE id =    ' . $id . ' ';
                $db->query($sql);
                $rows = $db->affected_rows();
                if (!$rows)
                    return false;
                $record_change_success++;
            }
        }
        return $record_change_success;
    }

    function standart_money($money, $method)
    {
        $money = str_replace(',', '', trim($money));
        $money = str_replace(' ', '', $money);
        $money = str_replace('.', '', $money);
        //		$money = intval($money);
        $money = (double)($money);
        if (!$method)
            return $money;
        if ($method == 1) {
            $money = $money * 1000;
            return $money;
        }
        if ($method == 2) {
            $money = $money * 1000000;
            return $money;
        }
    }

    function get_document_word($document_id)
    {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_excel . "
						  	WHERE document_id = $document_id
						  	ORDER BY id ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }



    /*
     * ==================== OTHER IMAGES==============================
     */

    /**
     * Lấy danh sách ảnh
     *
     * @return Object list
     */
    function get_other_images()
    {
        $data = base64_decode(FSInput::get('data'));
        $data = explode('|', $data);
        $where = 'record_id = ' . $data[1];
        if ($data[0] == 'add')
            $where = 'session_id = \'' . $data[1] . '\'';
        global $db;
        $query = '  SELECT *
                        FROM ' . 'fs_' . $this->type . '_images' . ' 
                        WHERE ' . $where . '
                        ORDER BY ordering, id DESC';
        $sql = $db->query($query);
        return $db->getObjectList();
    }

    /**
     * Update product id vào images
     */
    function update_other_images($id = 0)
    {
        global $db;
        $session_id = FSInput::get('session_id');
        $query = '  UPDATE fs_' . $this->type . '_images SET record_id = ' . $id . ', session_id = \'\'
                        WHERE session_id = \'' . $session_id . '\'';
        $db->query($query);
        $rows = $db->affected_rows();
        return $rows;
    }

    /**
     * Upload và resize ảnh
     *
     * @return Bool
     */
    function upload_other_images()
    {

        global $db;
        $path = PATH_BASE . $this->img_folder . DS . 'original' . DS;
        require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
        $upload = new Upload ();
        $upload->create_folder($path);
        $file_name = $upload->uploadImage('file', $path, 10000000, '_' . time());
        //            $upload->create_folder ( $path );
        // xoay ảnh trên IOS và save ghi đè lên ảnh cũ.
        //            require_once($_SERVER['DOCUMENT_ROOT'].'/libraries/lib/WideImage.php'); // Gọi thư viện WideImage.php
        //            $uploadedFileName = $path.$file_name;  // lấy ảnh từ  đã upload lên
        //            $load_img = WideImage::load($uploadedFileName);
        //            $exif = exif_read_data($uploadedFileName); //
        //            $orientation = @$exif['Orientation'];
        //            if(!empty($orientation)) {
        //                switch($orientation) {
        //                    case 8:
        //                        $image_p = imagerotate($uploadedFileName,90,0);
        //                        //echo 'It is 8';
        //                        break;
        //                    case 3:
        //                        $image_p = imagerotate($uploadedFileName,180,0);
        //
        //                        //echo 'It is 3';
        //                        break;
        //                    case 6:
        //                        $load_img->rotate(90)->saveToFile($uploadedFileName);
        //                        //$image_p = imagerotate($uploadedFileName,-90,0);
        //                        //echo 'It is 6';
        //                        break;
        //
        //                }
        //                //imagejpeg ( $image_p , $path.'test.jpg' ,  100 );
        //            }
        //
        // END save ảnh xoay trên IOS
        if (is_string($file_name) and $file_name != '' and !empty($this->arr_img_paths_other)) {
            $fsFile = FSFactory::getClass('FsFiles');
            foreach ($this->arr_img_paths_other as $item) {
                $path_resize = str_replace(DS . 'original' . DS, DS . $item [0] . DS, $path);
                $fsFile->create_folder($path_resize);
                $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
                $fsFile->$method_resize($path . $file_name, $path_resize . $file_name, $item [1], $item [2]);
            }
        }
        $data = base64_decode(FSInput::get('data'));
        $data = explode('|', $data);
//        var_dump();
//        var_dump($data[1]);
        $row = array();
        if ($data [0] == 'add') {
            $row ['session_id'] = $data [1];

        } else
            $row ['record_id'] = $data [1];
        $fsFile->add_logo($path, $file_name, PATH_BASE . str_replace('/', DS, 'images/mask/watermark.png'), 9);
        $row ['image'] = $this->img_folder . '/original/' . $file_name;
        $this->type = 'products';
//        echo 1;die;
        $rs = $this->_add($row, 'fs_' . $this->type . '_images');
//        echo 1;die;
        $row ['id'] = $rs;
        echo json_encode($row);
        return true;
    }

    /**
     * Sửa thuộc tính của ảnh
     *
     * @return Bool
     */
    function change_attr_image()
    {
        global $db;
        $data = base64_decode(FSInput::get('data'));
        $data = explode('|', $data);
        $row = array();
        $where = '';
        if ($data [0] == 'add') {
            $where .= ' AND  session_id = "' . $data [1] . '" ';
        } else {
            $where .= ' AND record_id = "' . $data [1] . '" ';
        }
        $field = FSInput::get('field');
        $value_color = FSInput::get('value_color');
        $value_type = FSInput::get('value_type');

        $id = FSInput::get('id');
        if (!$id)
            return;
//        if ($field == 'color') {
//            $row ['color_id'] = $value_color;
//        }
        if ($field == 'prd_type') {
            $row ['prd_type_id'] = $value_type;
        }
//                if ($data [0] == 'add') {
//                    $row["record_id"]=$data [1];
//                    $rs = $this->_update ( $row, 'fs_' . $this->type . '_images' );
//                }else{
        $rs = $this->_update($row, 'fs_' . $this->type . '_images', ' id = ' . $id . $where);
//                }
        return $rs;
    }


    function delete_other_image($record_id = 0)
    {
        global $db;
        $record_id = FSInput::get('record_id');
        if ($record_id)
            $where = 'record_id = \'' . $record_id . '\'';

        $id = FSInput::get('id');
        $where = 'id = \'' . $id . '\'';

        $query = '  SELECT *
                        FROM fs_' . $this->type . '_images
                        WHERE ' . $where;
        $db->query($query);
        $listImages = $db->getObjectList();
        if ($listImages) {
            foreach ($listImages as $item) {
                $query = '  DELETE FROM fs_' . $this->type . '_images
                                WHERE id = \'' . $item->id . '\'';
                $db->query($query);
                $path = PATH_BASE . $item->image;
                @unlink($path);
                foreach ($this->arr_img_paths_other as $image) {
                    @unlink(str_replace('/original/', '/' . $image [0] . '/', $path));
                }
            }
        }
    }

    function sort_other_images()
    {
        global $db;
        if (isset($_POST ["sort"])) {
            if (is_array($_POST ["sort"])) {
                foreach ($_POST ["sort"] as $key => $value) {
                    $db->query("UPDATE fs_" . $this->type . "_images SET ordering = $key WHERE id = $value");
                }
            }
        }
    }

    /*
     * ==================== end.OTHER IMAGES==============================
     */

    function get_product_images($product_id)
    {
        if (!$product_id)
            return;
        $query = " SELECT *
						FROM " . $this->table_image . "
						WHERE record_id = $product_id";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function ajax_get_package_related()
    {
        $news_id = FSInput::get('new_id', 0, 'int');
        // category_id danh muc
        $category_id = FSInput::get('category_id', 0, 'int');
        // tim kiem keyword
        $keyword = FSInput::get('keyword');
        $keyword_tag = FSInput::get('keyword_tag');
        // chuoi id tin lien quan keyword tag
        $str_related = FSInput::get('str_related');
        // id khi click vao xoa tin lien quan
        $id = FSInput::get('id', 0, 'int');

        $where = ' WHERE published = 1 AND id != ' . $news_id;

        if ($category_id) {
            $where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
        }
        if ($keyword) {
            $where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' OR author_book LIKE '%" . $keyword . "%' OR author_book_alias LIKE '%" . $keyword . "%' )";
        }
        if ($keyword_tag) {
            $keyword_tag = explode(',', $keyword_tag);
            //$keyword_tag = str_replace(',','',$keyword_tag);
            $total = count($keyword_tag);
            $where .= ' AND ( ';
            for ($i = 0; $i < $total; $i++) {
                if ($i == 0) {
                    $where .= " name LIKE '%" . $keyword_tag[$i] . "%' OR alias LIKE '%" . $keyword_tag[$i] . "%' ";
                } else {
                    $where .= " OR name LIKE '%" . $keyword_tag[$i] . "%' OR alias LIKE '%" . $keyword_tag[$i] . "%' ";
                }
            }
            $where .= ' ) ';
        }
        if ($str_related) {
            if ($id) {
                $str_related = str_replace(',' . $id, '', $str_related);
            }
            $where .= ' AND id NOT IN(0' . $str_related . '0) ';
        }

        $query_body = ' FROM ' . $this->table_name . ' ' . $where;
        $ordering = " ORDER BY created_time DESC , id DESC ";
        $query = ' SELECT id,category_id,name,category_name,image' . $query_body . $ordering . ' LIMIT 100 ';
        //print_r($query);
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_package_related($package_related)
    {
        if (!$package_related)
            return;
        $query = " SELECT id, name,image 
                                FROM " . $this->table_name . "
                                WHERE id IN (0" . $package_related . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $package_related . "0')
                                ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function remove_excel($record_id)
    {
        if (!$record_id)
            return true;
        $other_excel_remove = FSInput::get('other_excel', array(), 'array');
        $str_other_excel = implode(',', $other_excel_remove);
        if ($str_other_excel) {
            global $db;
            // remove in database
            $sql = " DELETE FROM " . $this->table_excel . "
							WHERE document_id = $record_id AND id IN ($str_other_excel)";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return true;
    }

    function save_exist_excel($id)
    {
        $document = $this->get_record_by_id($id, '' . $this->table_name . '');
        global $db;
        // EXIST FIELD
        $exist_total = FSInput::get('exist_total_excel');

        $sql_alter = "";
        $arr_sql_alter = array();
        $rs = 0;

        for ($i = 0; $i < $exist_total; $i++) {

            $id_exist = FSInput::get('id_exist_' . $i);

            $name_exist = FSInput::get('name_exist_excel' . $i);
            $name_exist_begin = FSInput::get('name_exist_excel' . $i . "_original");

            $excel_exist = $_FILES["excel_exist_" . $i]["name"];
            $excel_exist_begin = FSInput::get('excel_exist_' . $i . "_begin");

            if (($name_exist != $name_exist_begin) || ($excel_exist != $excel_exist_begin)) {

                $name = FSInput::get('name_exist_excel_' . $i);

                $cyear = date('Y');
                $cmonth = date('m');
                $cday = date('d');
                $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
                require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
                $upload = new Upload();
                $upload->create_folder($path);

                $file_upload = $_FILES["excel_exist_" . $i]["name"];
                if ($file_upload) {
                    $path_original = $path;
                    // remove old if exists record and img
                    if ($id) {
                        $img_paths = array();
                        $img_paths[] = $path_original;
                    }
                    $fsFile = FSFactory::getClass('FsFiles');
                    // upload
                    $file_upload_name = $fsFile->upload_file("excel_exist_" . $i, $path_original, 6000000, '_' . time());
                    if (!$file_upload_name)
                        return false;
                    $content = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
                } else {
                    $content = $excel_exist_begin;
                }

                $row = array();
                $row ['name'] = $name;
                $row ['content'] = $content;

                if (!$row ['name'] && !$row ['content']) {
                    continue;
                }
                $row ['document_name'] = $document->name;
                $u = $this->_update($row, '' . $this->table_excel . '', ' id =' . $id_exist);
                if ($u)
                    $rs++;
            }
        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_excel($record_id)
    {
        $document = $this->get_record_by_id($record_id, '' . $this->table_name . '');
        global $db;
        for ($i = 0; $i < 20; $i++) {

            $name = FSInput::get('new_name_excel_' . $i);

            $row = array();
            $cyear = date('Y');
            $cmonth = date('m');
            $cday = date('d');
            $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS;
            require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
            $upload = new Upload();
            $upload->create_folder($path);

            $file_upload = $_FILES["new_file_excel_" . $i]["name"];
            if ($file_upload) {
                $path_original = $path;
                // remove old if exists record and img
                if ($record_id) {
                    $img_paths = array();
                    $img_paths[] = $path_original;
                }
                $fsFile = FSFactory::getClass('FsFiles');
                // upload
                $file_upload_name = $fsFile->upload_file("new_file_excel_" . $i, $path_original, 6000000, '_' . time());
                if (!$file_upload_name)
                    return false;
                $row ['content'] = 'images/upload_file/' . $cyear . '/' . $file_upload_name;
            }
            $row ['name'] = $name;

            if (!$row ['name'] && !$row ['content']) {
                continue;
            }

            $row ['document_id'] = $record_id;
            $row ['document_name'] = $document->name;
            $row ['published'] = 1;
            $time = date('Y-m-d H:i:s');
            $row['published_time'] = $time;
            $rs = $this->_add($row, '' . $this->table_excel . '', 1);
        }
        return true;
    }

    function get_data($value = '')
    {
        $value = $value ? $value : '';
        global $db;
        $query = $this->setQuery($value);
        if (!$query)
            return array();
        $sql = $db->query_limit($query, 100, $this->page);
        $result = $db->getObjectList();
        return $result;
    }

    function getPagination($value = '')
    {
        $value = $value ? $value : '';
        $total = $this->getTotal($value);
        $pagination = new Pagination(100, $total, $this->page);
        return $pagination;

    }

}

?>