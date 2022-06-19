<?php

/*
 * Huy write
 */

// controller
class UsersControllersAddress extends FSControllers
{

    var $module;
    var $view;

    function __construct()
    {
        global $user;
        parent::__construct();
    }

    function display()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $user_id = $_SESSION['user_id'];

        $global_class = FSFactory::getClass('FsGlobal');
        $model = $this->model;
        $list_address = $model->get_list();
        $data = $model->getMember();


        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin cá nhân', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function add_address()
    {
        $model = $this->model;
        $data = $model->getMember();
        $province = $model->getProvince();

        include 'modules/' . $this->module . '/views/' . $this->view . '/add_address.php';
    }

    function edit_address()
    {
        $model = $this->model;
        $data = $model->getMember();
//var_dump($data);
        $id_address = FSInput::get('id');
        $data_address = $model->getAddress($id_address);
//var_dump($data_address);
        $province = $model->getProvince();
        $district = $model->getDistrict($data_address->province_id);
        $wards = $model->getWard($data_address->district_id);

        include 'modules/' . $this->module . '/views/' . $this->view . '/edit_address.php';
    }

    function ajax_load_district()
    {
        $html = '';
        $html .= '<option value="">Chọn Quận/Huyện</option>';
        $model = $this->model;
        $provinceid = FSInput::get('city_id');
        $district = $model->getDistrict($provinceid);
//        var_dump();
        foreach ($district as $item) {
            $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        echo $html;
    }

    function ajax_load_districtstore()
    {
        $html = '';
        $html .= '<option value="">Chọn Quận/Huyện</option>';
        $model = $this->model;
        $provinceid = FSInput::get('city_id');
        $store = '';
        if($provinceid){
        $district = $model->getDistrict($provinceid);
        foreach ($district as $item) {
            $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
            $storee = $model->get_records('published =1 and city= ' . $provinceid ,'fs_store');
            foreach ($storee as $item) {
                $store .= '<div class="radio-cuahang'.$item->id.'">
                            <input type="radio" name="cuahang1" id="cuahang'.$item->id.'" value=""
                              onclick="loadstoreinfor('.$item->id.')">
                            <label for="cuahang'.$item->id.'">
                                <span></span>&nbsp; '.$item->name.'
                                <small>'.$item->address.'
                                </small>
                            </label>
                        </div>';
            }
        }
        else{
            $district = $model->get_records('published =1','district');
            foreach ($district as $item) {
                $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
            $storee = $model->get_records('published','fs_store');
            foreach ($storee as $item) {
                $store .= '<div class="radio-cuahang'.$item->id.'">
                            <input type="radio" name="cuahang1" id="cuahang'.$item->id.'" value=""
                              onclick="loadstoreinfor('.$item->id.')">
                            <label for="cuahang'.$item->id.'">
                                <span></span>&nbsp; '.$item->name.'
                                <small>'.$item->address.'
                                </small>
                            </label>
                        </div>';
            }
        }
        ;


//        echo $store;
        $data=array(
            'distric'=>$html,
            'store'=>$store
        );
//        var_dump($data);
        echo json_encode($data);
    }

    function ajax_load_ward()
    {
        $html = '';
        $html .= '<option value="">Chọn Phường/Xã</option>';
        $model = $this->model;
        $districtid = FSInput::get('district_id');
        $wards = $model->getWard($districtid);
        foreach ($wards as $item) {
            $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        echo $html;
    }
function ajax_load_store()
    {
        $html = '';
        $model = $this->model;
        $districtid = FSInput::get('district_id');
//        echo $districtid;
    if($districtid){
        $store_district = $model->get_records('published =1 and district= ' . $districtid ,'fs_store');

//        $wards = $model->getWard($districtid);
    foreach ($store_district as $item) {
        $html .= '<div class="radio-cuahang'.$item->id.'">
                            <input type="radio" name="cuahang1" id="cuahang'.$item->id.'" value=""
                                  onclick="loadstoreinfor('.$item->id.')">
                            <label for="cuahang'.$item->id.'">
                                <span></span>&nbsp; '.$item->name.'
                                <small>'.$item->address.'
                                </small>
                            </label>
                        </div>';
    }
    }
    else{
        $store_district = $model->get_records('published =1','fs_store');

//        $wards = $model->getWard($districtid);
        foreach ($store_district as $item) {
            $html .= '<div class="radio-cuahang'.$item->id.'">
                            <input type="radio" name="cuahang" id="cuahang'.$item->id.'" value=""
                                  onclick="loadstoreinfor('.$item->id.')">
                            <label for="cuahang'.$item->id.'">
                                <span></span>&nbsp; '.$item->name.'
                                <small>'.$item->address.'
                                </small>
                            </label>
                        </div>';
        }
    }
        echo $html;
    }
    function ajax_load_storeinfor()
    {
        $html = '';
        $model = $this->model;
        $store_infor = FSInput::get('store_id');
//        echo $districtid;
        $store_infor1 = $model->get_record('published =1 and id= ' . $store_infor ,'fs_store');

//        $wards = $model->getWard($districtid);
            $html .= '<p>'.$store_infor1->name.'</p>
                    <p>'.$store_infor1->address.'</p>';
        echo $html;
    }
    function save_address()
    {
        $username = FSInput::get('full_name');
        $email = FSInput::get('email');
        $telephone = FSInput::get('telephone');
        $province = FSInput::get('province');
        $district = FSInput::get('district');
        $ward = FSInput::get('wards');
        $content = FSInput::get('content');
        $default = FSInput::get('address_default');
        $model = $this->model;
        $id = $model->save_address();
        if ($id) {
            $url = FSRoute::_('index.php?module=users&view=address');
            $msg = FSText::_('Thêm địa chỉ thành công');
            setRedirect($url, $msg);
        } else {
            $url = FSRoute::_('index.php?module=users&view=address');
            $msg = FSText::_('Thêm địa chỉ không thành công');
            setRedirect($url, $msg, 'error');
        }
    }

    function editing_address()
    {
        $model = $this->model;
        $id = $model->editing_address();
        if ($id) {
            $url = FSRoute::_('index.php?module=users&view=address');
            $msg = FSText::_('Sửa địa chỉ thành công');
            setRedirect($url, $msg);
        } else {
            $url = FSRoute::_('index.php?module=users&view=address');
            $msg = FSText::_('Sửa địa chỉ không thành công');
            setRedirect($url, $msg, 'error');
        }
    }

    function delete_address()
    {

        $model = $this->model;
        $id = FSInput::get('id');

        $where = ' id = ' . $id;
        $table = 'fs_members_address';
        $ddd = $model->_remove($where, $table);
        return true;
    }
    function update_default()
    {

        $model = $this->model;
        $id = FSInput::get('id');
        $id_default = FSInput::get('id_default');
//        echo $id_default;
//        return;
        $where = ' id = ' . $id;
        $where1 = 'id = ' . $id_default;
        $table = 'fs_members_address';
        $row=array();
        $row1=array();
        $row['defau']=1;
        $row1['defau']=0;
        $ddd1 = $model->_update($row1,$table,$where1);
        $ddd = $model->_update($row,$table,$where );
        echo $ddd ;
    }
}

?>
