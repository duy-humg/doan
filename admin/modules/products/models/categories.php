<?php

class ProductsModelsCategories extends ModelsCategories
{
    function __construct()
    {

        $this->table_items = FSTable_ad::_('fs_products');
        $this->table_name = FSTable_ad::_('fs_products_categories');
        $this->table_data_ds = FSTable_ad::_('fs_sp_properties_ds');
        $this->check_alias = 1;
        $this->arr_img_paths = array(array('resized', 248, 324, 'resize_image'), array('small', 98, 150, 'resize_image'), array('lager', 975, 260, 'resize_image'));
        // exception: key (field need change) => name ( key change follow this field)
        $this->field_except_when_duplicate = array(array('list_parents', 'id'), array('alias_wrapper', 'alias'));
        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        //$cday = date('d');
        $this->img_folder = 'images/products/cat/' . $cyear . '/' . $cmonth;
        $this->field_img = 'image';
        parent::__construct();
        $this->limit = 100;

        // $this -> array_synchronize = array($this -> table_items=>array('id'=>'category_id','alias'=>'category_alias','name'=>'category_name'
//                                                                            ,'published'=>'published_cate','alias_wrapper'=>'category_alias_wrapper'));
    }

    function save($row = array(), $use_mysql_real_escape_string = 1)
    {
        $name = FSInput::get('name');
        if (!$name)
            return false;

        $id = FSInput::get('id', 0, 'int');
        $time = date('Y-m-d H:i:s');
        if ($id) {
            $row['updated_time'] = $time;
//            $row['author_last'] = $user->username;
//            $row['author_last_id'] = $user_id;
        } else {
            $row['created_time'] = $time;
            $row['updated_time'] = $time;
        }

        $ord = FSInput::get('ordering', 0, 'int');
        if ($ord) {
            $row['ordering'] = $ord;
        } else {
            $row['ordering'] = 0;
        }
        $total_data = FSInput::get('total_data');
//        echo $total_data;die;
        $session_data = FSInput::get('session_data');
        $total_data_up = FSInput::get('total_data_up');



        $id = parent::save($row);


        if ($id){
            $this->update_data_list($id,$session_data);
            $this->save_and_news_items($id,$total_data,$session_data);
        }
        if($total_data_up){
             $this->update_data_list_($id,$total_data_up);
             $this->update_data_list_2($id,$total_data_up);
        }



        return $id;

    }

    function get_categories_tree_all()
    {
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);

        return $list;
    }

    function type()
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_type') . "
                                  WHERE 
                                     published = 1 
                    ORDER BY id ASC 
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }
    function table_data()
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_products_producer') . "
                                  WHERE 
                                     published = 1 
                    ORDER BY id ASC 
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }
    function save_item_service()
    {
        $published = 1;
//        $model = $this->model;

        $session_service = FSInput::get('session_service');
        $name_data = FSInput::get('name_data');
        $field_type = FSInput::get('field_type');
        $get_name_type= $this->get_name_field_type($field_type);
        $name_type = $get_name_type->title;
        $get_field_table = FSInput::get('field_table');
        if ($get_field_table){
            $field_table= $get_field_table;
            $get_name_table= $this->get_name_field_table($field_table);
            $name_table = $get_name_table->name;
        }else{
            $field_table= 0;
            $name_table = '';
        }

        $ordering_data = FSInput::get('ordering_data');
        if($ordering_data){
            $ordering = $ordering_data;
        }else{
            $ordering = 1;
        }

        $record_id = FSInput::get('data_id');

        $published = 1;
        $time = date("Y-m-d H:i:s");

        $sql = " INSERT INTO 
						" . $this->table_data_ds . " (title,field_type,name_type,field_table,name_table,ordering,sessions,created_time,edited_time,published,record_id)
						VALUES ('$name_data','$field_type','$name_type','$field_table','$name_table','$ordering','$session_service','$time','$time','$published',$record_id)";
//        var_dump($sql);die;
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;

    }

    function list_services($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_properties_ds') . "
                                  WHERE 
                                     published = 1 and sessions = $id
                    ORDER BY id ASC ,ordering ASC
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }

    function list_services_edit($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_properties_ds') . "
                                  WHERE 
                                     published = 1 and record_id = $id
                    ORDER BY id ASC ,ordering ASC
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }

    function update_data($id)
    {
        $time = date("Y-m-d H:i:s");
        $session_service = FSInput::get('session_service');
        $name_data = FSInput::get('name_data');
        if($name_data){
            $fstring = FSFactory::getClass('FSString','','../');
            $alias = $row_field['alias'] = $fstring->stringStandart($name_data);
            $field_type = FSInput::get('field_type');
            $get_name_type= $this->get_name_field_type($field_type);
            $name_type = $get_name_type->title;
            $get_field_table = FSInput::get('field_table');
            if ($get_field_table){
                $field_table= $get_field_table;
                $get_name_table= $this->get_name_field_table($field_table);
                $name_table = $get_name_table->name;
            }else{
                $field_table= 0;
                $name_table = '';
            }

            $ordering_data = FSInput::get('ordering_data');
            if($ordering_data){
                $ordering = $ordering_data;
            }else{
                $ordering = 1;
            }

            $record_id = FSInput::get('record_id');

            global $db;
            $fs_table = FSFactory::getClass('fstable');
            $query = "UPDATE " . $fs_table->getTable('fs_sp_properties_ds') . "
                                SET title = '$name_data',alias = '$alias', field_type = '$field_type', name_type = '$name_type',field_table = '$field_table',name_table = '$name_table',ordering = '$ordering',edited_time = '$time'
                                  WHERE 
                                     published = 1 and id = $id
                    
                                 ";
            $db->query($query);
            $list = $db->getObject();

            return $list;
        }

//        echo $query;die;

    }
    function update_data_2($id)
    {
        $time = date("Y-m-d H:i:s");
//        $session_service = FSInput::get('session_service');
        $name_data = FSInput::get('name_data');
        $field_type = FSInput::get('field_type');
        $get_name_type= $this->get_name_field_type($field_type);
        $name_type = $get_name_type->title;
        $get_field_table = FSInput::get('field_table');
        if ($get_field_table){
            $field_table= $get_field_table;
            $get_name_table= $this->get_name_field_table($field_table);
            $name_table = $get_name_table->name;
        }else{
            $field_table= 0;
            $name_table = '';
        }

        $ordering_data = FSInput::get('ordering_data');
        if($ordering_data){
            $ordering = $ordering_data;
        }else{
            $ordering = 1000;
        }

        $record_id = FSInput::get('record_id');

        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "UPDATE " . $fs_table->getTable('fs_sp_properties_noidung') . "
                                SET title = '$name_data', field_type = '$field_type', name_type = '$name_type',field_table = '$field_table',name_table = '$name_table',ordering = '$ordering',edited_time = '$time'
                                  WHERE 
                                     published = 1 and category_id = $id
                    
                                 ";
//        echo $query;die;
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }
    function list_services2($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_properties_ds') . "
                                  WHERE 
                                     published = 1 and record_id = $id
                    ORDER BY id ASC ,ordering ASC
                                 ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }

    function update_data_list($id,$session_data)
    {


        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "UPDATE " . $fs_table->getTable('fs_sp_properties_ds') . "
                                SET record_id = '$id'
                                  WHERE 
                                     published = 1 and sessions = $session_data
                    
                                 ";
//        echo $query;die;
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }

    function update_data_list_($id,$total_up)
    {
//        echo $total_up;die;
        for ($i = 1; $i <= $total_up; $i++) {

            $id_data = FSInput::get('id_data'.$i);
            $name_data = FSInput::get('name_data2_'.$i);
            $fstring = FSFactory::getClass('FSString','','../');
            $alias = $row_field['alias'] = $fstring->stringStandart($name_data);

            $field_type = FSInput::get('field_type2_'.$i);
            if($field_type){
                $get_name_type= $this->get_name_field_type($field_type);
            }

            $name_type = $get_name_type->title;
            $get_field_table = FSInput::get('field_table2_'.$i);
            if($name_data){
                if ($get_field_table){
                    $field_table= $get_field_table;
                    $get_name_table= $this->get_name_field_table($field_table);
                    $name_table = $get_name_table->name;
                }else{
                    $field_table= 0;
                    $name_table = '';
                }

                $ordering_data = FSInput::get('ordering_data2_'.$i);
                if($ordering_data){
                    $ordering = $ordering_data;
                }else{
                    $ordering = 1;
                }
                $published = 1;
                $time = date("Y-m-d H:i:s");

                global $db;
                $fs_table = FSFactory::getClass('fstable');
                $query = "UPDATE " . $fs_table->getTable('fs_sp_properties_ds') . "
                                SET title = '$name_data',alias = '$alias', field_type = '$field_type', name_type = '$name_type',field_table = '$field_table',name_table = '$name_table',ordering = '$ordering',edited_time = '$time'
                                  WHERE 
                                     published = 1 and record_id = $id and id = $id_data 
                    
                                 ";
//        echo $query;die;
                $db->query($query);
                $list = $db->getObject();
            }



        }
        return $list;



    }
    function update_data_list_2($id,$total_up)
    {

        for ($i = 1; $i <= $total_up; $i++) {

            $id_data = FSInput::get('id_data'.$i);
            $name_data = FSInput::get('name_data2_'.$i);
            $field_type = FSInput::get('field_type2_'.$i);
            if($field_type){
                $get_name_type= $this->get_name_field_type($field_type);
            }
            if($name_data){
                $name_type = $get_name_type->title;
                $get_field_table = FSInput::get('field_table2_'.$i);
                if ($get_field_table){
                    $field_table= $get_field_table;
                    $get_name_table= $this->get_name_field_table($field_table);
                    $name_table = $get_name_table->name;
                }else{
                    $field_table= 0;
                    $name_table = '';
                }

                $ordering_data = FSInput::get('ordering_data2_'.$i);
                if($ordering_data){
                    $ordering = $ordering_data;
                }else{
                    $ordering = 1;
                }
                $published = 1;
                $time = date("Y-m-d H:i:s");

                global $db;
                $fs_table = FSFactory::getClass('fstable');
                $query = "UPDATE " . $fs_table->getTable('fs_sp_properties_noidung') . "
                                SET title = '$name_data', field_type = '$field_type', name_type = '$name_type',field_table = '$field_table',name_table = '$name_table',ordering = '$ordering',edited_time = '$time'
                                  WHERE 
                                     published = 1 and record_id = $id and category_id = $id_data 
                    
                                 ";

                $db->query($query);
                $list = $db->getObject();
            }




        }
        return $list;



    }

    function save_and_news_items($id,$total_data,$session_data)
    {

        global $db;

        $prd_id_array = array();

        $product_list = $_SESSION['cart'];


        $sql = " INSERT INTO $this->table_data_ds(record_id,alias,title,field_type,name_type,field_table,name_table,ordering,published,created_time,edited_time)
					VALUES ";


        $array_insert = array();
        $array_insert_2 = array();

        // Repeat products
        for ($i = 1; $i <= $total_data; $i++) {

            $name_data = FSInput::get('name_data'.$i);
            $fstring = FSFactory::getClass('FSString','','../');
            $alias = $row_field['alias'] = $fstring->stringStandart($name_data);
            $field_type = FSInput::get('field_type'.$i);
            if($field_type){
                $get_name_type= $this->get_name_field_type($field_type);
            }

            $name_type = $get_name_type->title;
            $get_field_table = FSInput::get('field_table_'.$i);
            if ($get_field_table){
                $field_table= $get_field_table;
                $get_name_table= $this->get_name_field_table($field_table);
                $name_table = $get_name_table->name;
            }else{
                $field_table= 0;
                $name_table = '';
            }

            $ordering_data = FSInput::get('ordering_data'.$i);
            if($ordering_data){
                $ordering = $ordering_data;
            }else{
                $ordering = 1;
            }
            $published = 1;
            $time = date("Y-m-d H:i:s");

            $array_insert[] = "('$id','$alias','$name_data','$field_type','$name_type','$field_table','$name_table','$ordering','$published','$time','$time') ";

        }

        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
            $db->query($sql);
            $rows = $db->affected_rows();
            return true;
        } else {
            return;
        }

    }

    function detele_file($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "DELETE FROM " . $fs_table->getTable('fs_sp_properties_ds') . "
                                  WHERE 
                                     published = 1 and id = $id
                    ORDER BY id DESC 
                                 ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }



    function get_name_field_type($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_type') . "
                                  WHERE 
                                     published = 1 and id = $id
                    ORDER BY id ASC 
                                 ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }
    function get_name_field_table($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_products_producer') . "
                                      WHERE 
                                         published = 1 and id = $id
                        ORDER BY id ASC 
                                     ";
        $db->query($query);
        $list = $db->getObject();

        return $list;
    }

    function list_item($id)
    {
        global $db;
        $fs_table = FSFactory::getClass('fstable');
        $query = "SELECT * FROM " . $fs_table->getTable('fs_sp_properties_ds') . "
                                      WHERE 
                                         published = 1 and record_id = $id
                        ORDER BY id ASC 
                                     ";
        $db->query($query);
        $list = $db->getObjectList();

        return $list;
    }
}

?>