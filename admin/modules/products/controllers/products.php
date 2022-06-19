<?php

// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class ProductsControllersProducts extends Controllers {

    function __construct() {
        $this->view = 'products';
        parent::__construct();


        $publish_array = array(
            1=>FSText::_('Hiển thị'),
            2=>FSText::_('Ẩn'),
        );
        $this -> publish_array = $publish_array;
    }

    function display() {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        //$categories = $model->get_categories_tree();
        $list = $model->get_data();
        $categories = $model->get_categories_tree();

        $publish_array = $this -> publish_array;
        $array_publish = array();
        foreach($publish_array as $key => $name){
            $array_publish[] = (object)array('id'=>$key,'name'=>$name);
        }


        $list_key = array();
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }



    function unset_dm() {
        unset($_SESSION['category']);

        return;

    }

    function add() {
        $type_save =1;
        if(@$_SESSION['category']){
            $model = $this->model;
            $get_dm = $model->get_dm($_SESSION['category']);
//            var_dump($get_dm->level);
            if($get_dm->level == 1){
                $thuoctinh = $model->thuoctinh($get_dm->parent_id,$get_dm->id);
            }else{
                $thuoctinh = $model->thuoctinh($_SESSION['category'],$_SESSION['category']);
            }

            $categories = $model->get_categories_tree();
//            var_dump($categories);
            $author_book = $model->get_author();
            $list_shop = $model->get_shop();
            $company_ex = $model->get_company_ex();
            $xuatban = $model->get_xuat_ban();
//        $loaibia = $model->get_loai_bia();
            $origin = $model->get_xuat_xu();
            $color = $model->get_mau_sac();
            $list_size = $model->get_size();
//            var_dump($size);
            $products_type = $model->get_products_type();
            $prd_cl = array_merge($color, $list_size);
            $list_object = $model->get_object();
            $list_producer = $model->get_producer();
            $list_chatlieu = $model->get_chatlieu();
            $tag = $model->get_tags();
            // data from fs_news_categories
//        $categories_home = $model->get_categories_tree();
            $maxOrdering = $model->getMaxOrdering();
            $uploadConfig = base64_encode('add|' . session_id());

            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        }else{
            $model = $this->model;
            $dm = $model->dm();
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail_category.php';
        }


    }

    function edit() {
        $type_save =2;
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_categories_tree();
        $data = $model->get_record_by_id($id);
//        var_dump($data);

        $get_dm = $model->get_dm($data->category_id);
//            var_dump($get_dm->level);
        if($get_dm->level == 1){
            $thuoctinh = $model->thuoctinh($get_dm->parent_id,$get_dm->id);
        }else{
            $thuoctinh = $model->thuoctinh($data->category_id,$data->id);
        }
        $list_shop = $model->get_shop();
        $author_book = $model->get_author();
        $company_ex = $model->get_company_ex();
        $xuatban = $model->get_xuat_ban();
        $products_type = $model->get_products_type();
        $origin = $model->get_xuat_xu();
        $color = $model->get_mau_sac();
        $list_size = $model->get_size();
        $prd_cl = array_merge($color, $list_size);
        $products = $model->get_records('product_id ='.$id,'fs_products_sub_2');
        // var_dump($products);

//        var_dump($products[0]);
        $list_object = $model->get_object();
        $list_producer = $model->get_producer();
        $list_chatlieu = $model->get_chatlieu();
        $tag = $model->get_tags();
        $document_excel = $model -> get_document_word($data -> id);
        $images = $model->get_product_images($data -> id);
        $package_related = $model->get_package_related($data->package_related);
        // data from fs_news_categories
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
    
     
    function get_other_images(){
        $list_other_images = $this->model->get_other_images();   
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail_images_list.php';
    } 
/**
     * Upload nhiều ảnh cho sản phẩm
     */ 
    function upload_other_images(){
//        echo 1;die;
        $this->model->upload_other_images();

    }
    /**
     * Xóa ảnh
     */ 
    function delete_other_image(){
        $this->model->delete_other_image();
    }


    function show_in_homepage() {
        $this->is_check('show_in_homepage', 1, 'show home');
    }

    function unshow_in_homepage() {
        $this->unis_check('show_in_homepage', 0, 'un home');
    }
    function is_hot() {
        $this->is_check('is_hot', 1, 'is hot');
    }

    function unis_hot() {
        $this->unis_check('is_hot', 0, 'un is hot');
    }
    
    function ajax_get_package_related(){
        $model = $this->model;
        $data = $model->ajax_get_package_related();
        $str_related = FSInput::get('str_related');
        $id = FSInput::get('id', 0, 'int');
        $html = $this->package_genarate_related($data, $str_related, $id);
        echo $html;
        return;
    }
    function package_genarate_related($data, $str_related = 0, $id) {
        $str_exist = FSInput::get('str_exist');
//        $error_img = "this.src='/images/1443089194_picture-01.png'";
        if ($str_related) {
            if ($id) {
                $str_related = str_replace(',' . $id, '', $str_related);
            }
        }

        $html = '';
        $html .= '<div class="package_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red package_related_item  package_related_item_' . $item->id . '" onclick="javascript: set_package_related(' . $item->id . ')" style="display:none" >';
                $html .= $item->name;
//                $html .= '<img onerror="' . $error_img . '" src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '">';
                $html .= '</div>';
            } else {
                $html .= '<div class="package_related_item  package_related_item_' . $item->id . '" onclick="javascript: set_package_related(' . $item->id . ')">';
                $html .= $item->name;
//                $html .= '<img onerror="' . $error_img . '" src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        $html .= '<input type="hidden" value="' . $str_related . '" id="str_related" name="str_related" />';
        return $html;
    }

    function export(){
        setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
    }
    function export_file(){
        FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
        $model  = $this -> model;
        $filename = 'products-export';
        $list = $model->get_data_all();
        if(empty($list)){
            echo 'error';exit;
        }else {
            $excel = FSExcel();
            $excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
            $style_header = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb'=>'ffff00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $style_header1 = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

            $excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'ma_kho');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B2', 'price');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C2', 'discount_unit');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'percent: phần trăm, price:giá trị');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D2', 'discount');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E2', 'quantity');
            foreach ($list as $item){
                $key = isset($key)?($key+1):3;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item -> ma_kho_tiki );
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item -> price_old);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item-> discount_unit);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->discount);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->quantity);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A2')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A2')->applyFromArray( $style_header );
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A2'), 'B2:E2' );
            $output = $excel->write_files();

            $path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".filesize($path_file));
            readfile($path_file);
        }
    }
    function import(){
        include 'modules/'.$this->module.'/views/'.$this -> view.'/import.php';
    }



    /**
     * Import MGS
     */
    function do_import(){
//        echo 1;die;
        global $db;
        var_dump($_FILES['import']["name"]);die;
        if(empty($_FILES['import']["name"])) {
            setRedirect('index.php?module=products&view=products&task=import', FSText :: _('Bạn vui lòng chọn file excel'));
            return false;
        }
//        echo 1;die;
        require(PATH_BASE.'libraries/PHPExcel/PHPExcel.php');
        require(PATH_BASE.'libraries/fsstring.php');

        $string = new FSString();
        $objPHPExcel = PHPExcel_IOFactory::load($_FILES['import']['tmp_name']);
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $numberRow = $sheet->getHighestRow();
        $i = 0;
        for($row = 2; $row <= $numberRow; $row++){
            $name = $sheet->getCell('A'.$row)->getValue();
            $data = array(
                'code' => $sheet->getCell('E'.$row)->getValue(),
                'name' => $db->escape_string($name),
                'alias' => $string->stringStandart($name),
                'created_time' => date('Y-m-d H:i:s'),
                'published' => 1,
                'content' => $sheet->getCell('N'.$row)->getValue(),
                'price' => $sheet->getCell('C'.$row)->getValue(),
                'price_old' => $sheet->getCell('D'.$row)->getValue(),
            );

            $data['discount'] = $data['price_old'] - $data['price'];

            $data['company_ex_title'] = $db->escape_string($sheet->getCell('F'.$row)->getValue());
            $data['company_ex'] = $this->checkData('fs_products_companys', $data['company_ex_title'], 0);

            $arrMaterial = array();
//            $arrMaterialTitle = array();

            $material_title = $sheet->getCell('M'.$row)->getValue();
            if(trim($material_title) != '') {
                $material = $this->checkData('fs_products_loai_bia', $material_title, 0);
                $arrMaterial[] = $material;
//                $arrMaterialTitle[] = $material_title;
            }

//            $material_title = $sheet->getCell('F'.$row)->getValue();
//            if(trim($material_title) != '') {
//                $material = $this->checkData('fs_material', $material_title, 0);
//                $arrMaterial[] = $material;
//                $arrMaterialTitle[] = $material_title;
//            }
//
//            $material_title = $sheet->getCell('G'.$row)->getValue();
//            if(trim($material_title) != '') {
//                $material = $this->checkData('fs_material', $material_title, 0);
//                $arrMaterial[] = $material;
//                $arrMaterialTitle[] = $material_title;
//            }

            if(!empty($arrMaterial))
                $data['loai_bia'] = ','.implode(',', $arrMaterial).',';

//            if(!empty($arrMaterial))
//                $data['material_title'] = implode(',', $arrMaterialTitle);

//            $data['category_name'] = $db->escape_string($sheet->getCell('H'.$row)->getCalculatedValue());
//            $data['category_id'] = $this->checkData('fs_products_categories', $data['category_name'], 1);
//            $data['category_id_wrapper'] = ','.$data['category_id'].',';
            $data['ordering']  = $i;
//            var_dump($data);die;
            $this->model->_add($data, 'fs_products');
            $i++;
        }

        setRedirect(URL_ADMIN.'index.php?module=products&view=products&task=import', FSText :: _('Bạn đã cập nhật <b>'.$i.'</b> bản ghi'));
    }

    function check_dm()
    {
//        echo 1;die;
        echo 1;

        $id = FSInput::get("id");

        $_SESSION['category'] = $id;

       var_dump($_SESSION['category']);
    }
}

?>