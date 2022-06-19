<?php

class ProductsModelsProduct extends FSModels
{

    function __construct()
    {
        $limit = 10;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->page = $page;
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_products');
        $this->table_category = $fstable->_('fs_products_categories');
        $this->table_comment = $fstable->_('fs_products_comments');
        $this->table_author = $fstable->_('fs_products_authors');

    }

    /*
     * get Category current
     */

    function get_category_by_id($category_id)
    {
        if (!$category_id)
            return "";
        $query = " SELECT id,name,alias
						FROM " . $this->table_category . "  
						WHERE id = $category_id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    /*
     * get Article
     */
    function get_product_sub($where){
//        var_dump($where);
        global $db;
        $query = " SELECT a.id,a.name,a.alias,a.image,a.category_alias,a.category_id,a.price,a.price_old,a.quantity,a.discount,b.color_id,b.color_name, b.products_type, b.products_type_name, b.id as id_sub, b.price as price_old_sub, b.price_old, b.price_h as price_sub, b.discount as discount_sub
						 FROM fs_products as a LEFT JOIN fs_products_sub as b ON a.id = b.product_id
						 WHERE  a.published = 1 and a.category_published = 1 and b.published = 1 ".$where;
        if(!$query)
            return;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    function getProduct($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT *
						FROM " . $this->table_name . " 
						WHERE published = 1 AND 
						" . $where . " ";
        //print_r($query) ;   
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }
    function get_list_parent($list_parents) {
        if (! $list_parents)
            return;
        $fs_table = FSFactory::getClass ( 'fstable' );
        $query = 'SELECT name,id,alias,parent_id FROM ' . $fs_table->getTable ( 'fs_products_categories' ) . ' WHERE id IN (0' . $list_parents . '0) 
					ORDER BY level ASC' ;
        global $db;
        $db->query ( $query );
        $list = $db->getObjectList ();
        return $list;
    }
    function getRelateProductsList($cid)
    {
        if (!$cid)
            die;

        global $db;
        $limit = 4;
        $id = FSInput::get2('id', 0, 'int');
        $query = ' SELECT id,name,alias, category_id ,image,price,price_old,unit,giamgia
						FROM ' . $this->table_name . '
						WHERE category_id like "%' . $cid . '%"
							AND published = 1 AND id != ' . $id . '
						ORDER BY  created_time DESC, ordering DESC
						LIMIT ' . $limit;
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function getImageProducts($record_id)
    {
        if (!$record_id)
            return;
        $limit = 20;
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT id,image, record_id, prd_type_id
						  FROM " . $fs_table->getTable('fs_products_images') . "
						  WHERE record_id =  $record_id
						     
						 ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function list_products_see($id_products)
    {
        global $db;
        $query = " SELECT *
                                FROM " . $this->table_name . "
                                WHERE id IN (0" . $id_products . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $id_products . "0')
                                ";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }


    function list_products_add($id_products)
    {
        global $db;
        $query = " SELECT id,name,alias, category_id,updated_time ,image,category_alias,created_time,discount,price,price_old,quantity 
                                FROM " . $this->table_name . "
                                WHERE id IN (0" . $id_products . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $id_products . "0')
                                ";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function nhomhang()
    {
        global $db;
        $query = " SELECT id,name,image,alias,icon
					FROM fs_products_categories
					WHERE
						published = 1 and is_hot = 1
					 ORDER BY  ordering ASC
					 LIMIT 10
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function list_sp()
    {
        global $db;
        $query = " SELECT *
					FROM fs_products
					WHERE
						published = 1 
					 ORDER BY  ordering ASC
							";
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function list_news()
    {
        global $db;
        $query = " SELECT *
					FROM fs_news
					WHERE
						published = 1 and category_id = 9
					 ORDER BY  id DESC
					 LIMIT 4
							";
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function list_tienich()
    {
        global $db;
        $query = " SELECT id,name,image
					FROM fs_products_tienich
					WHERE
						published = 1 and category = 1936
					 ORDER BY id ASC
					 LIMIT 3
							";
//            var_dump($query);
        $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function get_comments($news_id)
    {
        global $db;
        if (!$news_id)
            return;

        //			$limit = 5;
        //			$id = FSInput::get('id');
        $query = " SELECT *
    						FROM " . $this->table_comment . "
    						WHERE record_id = $news_id
    							AND published = 1
    						ORDER BY  created_time  DESC
    						";
        $db->query($query);
        $result = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }

    function save_comment()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $data = base64_decode(FSInput::get('data'));
        $data = explode('|', $data);
        $row = array();
//        if($data[0] == 'add')
        $row['session_id'] = $data[1];
//        var_dump($row['session_id']);die;

        $title = FSInput::get('title');
        $content = FSInput::get('content');
        $rating = FSInput::get('score');
        $user_id = FSInput::get('user_id');
        $user_name = $_SESSION['user_name'];

        $record_id = FSInput::get('record_id', 0, 'int');
        $parent_id = FSInput::get('parent_id', 0, 'int');

        if (!$content || !$record_id)
            return false;

        //print_r(123);die;
        $time = date('Y-m-d H:i:s');
        $published = 1;

//        $row['name'] = $name;
//        $row['email'] = $email;
//        $row['comment'] = $text;
        $row['title'] = $title;
        $row['comment'] = $content;
        $row['rating'] = $rating;
        $row['user_id'] = $user_id;
        $row['name'] = $user_name;
        $row['record_id'] = $record_id;
        $row['parent_id'] = $parent_id;
        $row['published'] = $published;
        $row['edited_time'] = $time;
        $row['created_time'] = $time;
//var_dump($row); die;
        global $db;

        $id = $this->_add($row, $this->table_comment, 1);
        //print_r($id);die;
        if ($id) {
            $row = array();
            $row['record_id'] = $id;
//            var_dump($row);die;
            $where = "session_id ='" . $data[1] . "'";
//            var_dump($data[1]);die;
            $this->recalculate_comment($record_id, $time);
//            $this->save_rating($record_id, $rating);
//            $record_id = $this->get_record();
            $record_id = $this->_update($row, 'fs_contact_uploadfile', $where);
            if ($record_id) {
                $row1 = array();
                $row1['session_id'] = '';
                $record = $this->_update($row1, 'fs_contact_uploadfile', 'record_id=' . $id);
            }
        }
        return $id;
    }

    function save_reply()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $row = array();
//        $name = FSInput::get('name');
//        $email = FSInput::get('email');
//        $text = FSInput::get('text');
//        $news_id = FSInput::get('id');
        $content = FSInput::get('content');
//        $rating= FSInput::get('score');
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];

        $record_id = FSInput::get('record_id', 0, 'int');
        $parent_id = FSInput::get('parent_id', 0, 'int');

        if (!$content || !$record_id)
            return false;

        //print_r(123);die;
        $time = date('Y-m-d H:i:s');
        $published = 1;

//        $row['name'] = $name;
//        $row['email'] = $email;
//        $row['comment'] = $text;
//        $row['title']=$title;
        $row['comment'] = $content;
//        $row['rating']=$rating;
        $row['user_id'] = $user_id;
        $row['name'] = $user_name;
        $row['record_id'] = $record_id;
        $row['parent_id'] = $parent_id;
        $row['published'] = $published;
        $row['edited_time'] = $time;
        $row['created_time'] = $time;
//var_dump($row); die;
        global $db;

        $id = $this->_add($row, $this->table_comment, 1);
//        var_dump($id);die;
        //print_r($id);die;
//        if ($id) {
//            $this->recalculate_comment($record_id, $time);
//            $this->clean_cache();
//        }
        return $id;
    }

    function update_useful($id)
    {
        if (!$id)
            return;
//var_dump($id);die;
        // count
        global $db, $econfig;
        $sql = " UPDATE fs_products_comments
                                    SET useful = useful + 1 
                                    WHERE  id = " . $id
                             ;
//        echo $sql; die;
        $db->query($sql);
        $rows = $db->affected_rows();
//        var_dump($rows);die;
//        return $rows;
    }

    function recalculate_comment($record_id, $time)
    {
        $sql = " UPDATE  fs_products
						SET comments_total = comments_total + 1,
						    comments_unread = comments_unread + 1,
						    comments_last_time = '" . $time . "' 
						    WHERE id = " . $record_id . "
						";
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
    }

    function save_rating($record_id, $rating)
    {
//        $id = FSInput::get('record_id', 0, 'int');
//        var_dump($id);
//        $rate = FSInput::get('score', 0, 'int');

        $sql = " UPDATE  fs_products
						SET rating_count = rating_count + 1,
						    rating_sum = rating_sum + " . $rating . "
						    WHERE id = " . $record_id . "
						";
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();

        // save cookies
//        if ($rows) {
//            $cookie_rating = isset($_COOKIE['rating_news']) ? $_COOKIE['rating_news'] : '';
//            $cookie_rating .= $id . ',';
//            setcookie("rating_news", $cookie_rating, time() + 60); //60s
//        }
        return $rows;
    }

    function get_comment_by_id($comment_id)
    {
        if (!$comment_id)
            return false;
        $query = " SELECT * 
						FROM fs_contents_comments
						WHERE id =  $comment_id
							AND published = 1
						";
        global $db;
        $db->query($query);
        return $result = $db->getObject();
    }

    function update_hits($news_id)
    {
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'array_hits';

            $data_in_memcache = $fsmemcache->get($mem_key);
            if (!isset($data_in_memcache))
                $data_in_memcache = array();
            if (isset($data_in_memcache[$news_id])) {
                $data_in_memcache[$news_id]++;
            } else {
                $data_in_memcache[$news_id] = 1;
            }
            $fsmemcache->set($mem_key, $data_in_memcache, 10000);

        } else {
            if (!$news_id)
                return;

            // count
            global $db, $econfig;
            $sql = " UPDATE fs_products
                                    SET hits = hits + 1 
                                    WHERE  id = '$news_id' 
                             ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
    }

    function getAuthor($author_book_id)
    {

        $id = FSInput::get('id');
        $where = " AND id IN(0".$author_book_id."0 )";

        $query = " SELECT id,image,name, alias,content,seo_title,seo_keyword,seo_description
						FROM " . $this->table_author . " 
						WHERE published = 1 " . $where;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    //  upload multi files

    function upload_data()
    {

        global $db;
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');

        $path = PATH_BASE . 'images' . DS . 'upload_file' . DS . $cyear . DS . $cmonth . DS . $cday . DS;
        require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
        $upload = new  Upload();
        $upload->create_folder($path);

        $file_name = $upload->uploadImage('file', $path, 100000000, '_' . time());


        $data = base64_decode(FSInput::get('data'));
        $data = explode('|', $data);
        $row = array();
//        if($data[0] == 'add')
        $row['session_id'] = $data[1];
//        var_dump($row['session_id']);die;
//        else
        $row['record_id'] = '';

        $row['file_up'] = 'images/upload_file/' . $cyear . '/' . $cmonth . '/' . $cday . '/' . $file_name;
        $size = $_FILES['file']['size'];
        $row['name'] = $_FILES['file']['name'];
        if ($size >= 1024 * 1024 * 1024 * 1024 / 10) {
            $row['size'] = $size / (1024 * 1024 * 1024 * 1024 / 10);
            $row['type_size'] = "TB";
        } else if ($size >= 1024 * 1024 * 1024 / 10) {
            $row['size'] = $size / (1024 * 1024 * 1024 / 10);
            $row['type_size'] = "GB";
        } else if ($size >= 1024 * 1024 / 10) {
            $row['size'] = $size / (1024 * 1024 / 10);
            $row['type_size'] = "MB";
        } else if ($size >= 1024 / 10) {
            $row['size'] = $size / (1024 / 10);
            $row['type_size'] = "KB";
        } else {
            $row['size'] = $size * 10;
            $row['type_size'] = "B";
        }
        $row['created_time'] = date("Y-m-d H:i:s");
        $user_id = !empty($_COOKIE['user_id']) ? $_COOKIE['user_id'] : $_SESSION['user_id'];
        $row['member_id'] = $user_id;
        $rs = $this->_add($row, 'fs_contact_uploadfile');
        return true;
    }

    function deleteFile()
    {
        $id = FSInput::get('id', 0, 'int');
        $file_name = FSInput::get('name');
        global $db;
        if ($file_name) {
            if ($id) {
                $where_id = ' record_id = ' . $id;
            } else {
                $where_id = ' record_id =  0 ';
            }
            $where = ' AND name = \'' . $file_name . '\'';
            $query = '  SELECT *
                            FROM fs_contact_uploadfile
                            WHERE ' . $where_id . $where;
            $db->query($query);
            $list_name_File = $db->getObject();

            if ($list_name_File) {
                $query = '  DELETE FROM fs_contact_uploadfile
                                    WHERE id = \'' . $list_name_File->id . '\'';
                $db->query($query);
                $path = PATH_BASE . $list_name_File->file_up;
                @unlink($path);
            }
        }
    }
    function get_product()
    {
        $id = FSInput::get('id');
        if ($id) {
            $where = " id = '$id' ";
        } else {
//            $code = FSInput::get('code');
//            if (!$code)
                die('Not exist this url');
//            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT id,name,alias,code,unit,image,price,user_id,minimum
						FROM fs_products 
						WHERE
						" . $where . " ";
//        print_r($query) ;die;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
}

?>