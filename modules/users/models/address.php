<?php

class UsersModelsAddress extends FSModels {

    function __construct() {
        parent::__construct();
        $this->limit = 20;
        $fstable = FSFactory::getClass('fstable');
        $this->table_address = $fstable->_('fs_members_address');
    }

   
    function get_list() {

        global $db;
        $user_id = $_SESSION['user_id'];
        $where = ' member_id = '.$user_id;
        $query = 'SELECT * FROM '.$this->table_address.'
                  WHERE' . $where .
                ' ORDER BY id ASC ';
        
        $sql = $db->query($query);
        $result = $db->getObjectList();
       
        return $result;
    }
    
    function getAddress($id) {

        global $db;
        $where = ' id = '.$id;
        $query = 'SELECT * FROM '.$this->table_address.'
                  WHERE' . $where . '';
        
        $sql = $db->query($query);
        $result = $db->getObject();
       
        return $result;
    }
  
    function getMember() {
        global $db;
        $user_id = $_SESSION['user_id'];
        $sql = " SELECT * 
					FROM fs_members
					WHERE id  = $user_id ";
        $db->query($sql);
        return $db->getObject();
    }

     function getTotal($query_body) {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total) {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }
    
    function getProvince() {
        global $db;
        $sql = " SELECT id,name,alias
					FROM fs_cities ORDER BY name ASC";
        $db->query($sql);
        return $db->getObjectList();
    }
    function getDistrict($provinceid) {
        global $db;
        $sql = " SELECT id,name,alias
					FROM fs_districts WHERE city_id = '".$provinceid."' ORDER BY id ASC";
        $db->query($sql);
        return $db->getObjectList();
    }


    function getWard($districts_id) {
        global $db;
        $sql = " SELECT id,name,alias
					FROM fs_wards WHERE districts_id = '".$districts_id."' ORDER BY name ASC";
        $db->query($sql);
        return $db->getObjectList();
    }

    function save_address(){
        $row = array();
        
        $row['username'] = FSInput::get('full_name');
        $row['telephone'] = FSInput::get('telephone');
        $row['email'] = FSInput::get('email');
        $row['province_id'] = FSInput::get('province');
        $row['district_id'] = FSInput::get('district');
        $row['ward_id'] = FSInput::get('wards');
        $row['content'] = FSInput::get('content');
        $id_member = FSInput::get('member_id');
        $row['member_id'] = $id_member;
        $time = date('Y-m-d H:i:s');
        $row['created_time'] = $time;
        $row['published'] = 1;
        
        $is_default = FSInput::get('address_default');
        if($is_default){
            $row['defau'] = $is_default;
            
            $zow = array();
            $zow['defau'] = 0;
            $where = 'member_id = '.$id_member ;
            $re = $this->_update($zow, $this->table_address, $where);
        } else {
            $row['defau'] = 0;
        }
        
        $count_address = $this->check_address($id_member);
        if(!$count_address){
            $row['defau'] = 1;
        }

            $id_return = $this->_add($row, $this->table_address);
        return $id_return;
    }
    
    function editing_address(){
        $row = array();
        
        $row['username'] = FSInput::get('full_name');
        $row['telephone'] = FSInput::get('telephone');
        $row['email'] = FSInput::get('email');
        $row['province_id'] = FSInput::get('province');
        $row['district_id'] = FSInput::get('district');
        $row['ward_id'] = FSInput::get('wards');
        $row['content'] = FSInput::get('content');
        $id_member = FSInput::get('member_id');
        $row['member_id'] = $id_member;
        $time = date('Y-m-d H:i:s');
        $row['created_time'] = $time;
        $row['published'] = 1;
        
        $id = FSInput::get('id');
        
        $is_default = FSInput::get('address_default');
        $row['defau'] = $is_default;
        
        if(!$is_default){
            $have_defau = $this->check_address_eddit($id_member,$id);
            if(!$have_defau){
                $row['defau'] = 1;
            } else {
                $row['defau'] = 0;
            }
        } else {
            $row['defau'] = 1;
            $zow = array();
            $zow['defau'] = 0;
            $where = 'member_id = '.$id_member ;
            $re = $this->_update($zow, $this->table_address, $where);
        }
        
        $where_secon = 'id = '.$id;
        $id_return = $this->_update($row, $this->table_address, $where_secon);
        return $id_return;
    }
    
    function check_address($id_member){
        global $db;
        $sql = " SELECT count(*) 
					FROM ".$this->table_address." 
					WHERE 
						member_id = '$id_member'";
        $db->query($sql);
        $count = $db->getResult();
        if (!$count) {
            return false;
        }
        return true;
    }
    
    function check_address_eddit($id_member,$id){
        global $db;
        $sql = " SELECT count(*) 
					FROM ".$this->table_address." 
					WHERE 
						member_id = '$id_member' AND defau = 1 AND id <> ".$id;
        $db->query($sql);
        $count = $db->getResult();
        if (!$count) {
            return false;
        }
        return true;
    }

}

?>