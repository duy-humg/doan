<?php
	class ProductsControllersImport  extends Controllers
	{
		function __construct()
		{
			parent::__construct(); 
		}
		function display()
		{
			$model = $this -> model;
			
			include 'modules/'.$this->module.'/views/import/default.php';
		}
		function import_product(){
			$excel_file = $this->upload_excel('excel');
			if(!empty($excel_file)){
				echo json_encode(array('status'=>'success'));
			}else {
				echo json_encode(array('status'=>'empty_excel'));
			}
		} 
		function upload_excel($input_name)
		{
			$model = $this -> model;
			global $db;
			$cid =  FSInput::get('cid');
			$fsFile = FSFactory::getClass('FsFiles');
			// upload
			$path =  PATH_BASE.'images'.DS.'excel'.DS;
//			var_dump($input_name);die;
			$excel = $fsFile -> uploadExcel($input_name, $path,2000000, '_'.time());
			if(	!$excel){
				return false;
			}
			else{
				$rs=$model->import_film_info($excel,$path);
//				var_dump($rs);die;
				file_put_contents("log.log", var_export($rs,true));
				if($rs)
				{
					setRedirect("index.php?module=products&view=import",FSText::_('Có').'<strong> '.$rs.'</strong> '.'bản ghi được cập nhật','suc');
				}
				else 
				{
					setRedirect("index.php?module=products&view=import",FSText::_('Thêm mới danh sách thành công'),'alert');
				}	
			
				return TRUE;
			}
            
		}
		function extract_file(){
		  
			FSFactory::include_class('excel','excel');
			$cat_id =FSInput::get('cid',0,'int');
			
			$model  = $this -> model;

			
			//Get tablename of catagory
			$tablename = $catagories->tablename;
			$tablename_name = explode('_', $tablename);
			$tablename_name = $tablename_name[2];
			
			$filename = 'export_table_'.$tablename_name;
			
			$arr_data_extend = $model->get_records('table_name="'.$tablename.'"','fs_products','id,field_name,field_name_display,foreign_id,foreign_name,foreign_tablename');
			
			$list = $model->get_data_for_export($tablename);
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
				
				/*
				 * Nối danh sách sản phâm của bảng fs_products với
				 * Trường mở trong bảng mở rộng
				 *
				 */				
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

				
				
				$h =74;
				foreach ($arr_data_extend as $data_extend) {
					if($h <= 90){
						$str = chr ( $h );
					}else if($h <= 116)
					{
						$str ='A'.chr ( $h-26 );
					}else if($h <= 142)
					{
						$str ='B'.chr ( $h-52 );
					}
					else 
						break;
					$excel->obj_php_excel->getActiveSheet()->getColumnDimension($str)->setWidth(30);
					
					$excel->obj_php_excel->getActiveSheet()->setCellValue($str.'1', $data_extend->field_name);
					$h++;
				}
				
				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Id');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Ma_KS');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Ma_phong');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Room_type');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Start_time');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'End_time');                           

				
				
				$i = 0;
				$total_money = 0;
				$total_quantity = 0;
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				
				$m =74;
				foreach ($arr_data_extend as $data_extend) {
					if($m <= 90){
						$str = chr ( $m );
					}else if($m <= 116)
					{
						$str ='A'.chr ( $m-26 );
					}else if($m <= 142){
						$str ='B'.chr ( $m-52 );
					}
					else 
						break;
					$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:'.$str.'1' );
					
					$m++;
				}			
				
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
//			}
		}
		function download_file(){
		
			$path_file = PATH_BASE.DS.'mau_import'.DS.'mau_import_products.xls'; 
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'mau_import_products';
			$file_ext = $this -> getExt(basename('mau_import'.DS.'mau_import_products.xls'));
			$file_export_name = $file_export_name.'.'.$file_ext;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );			
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($path_file));
			readfile($path_file);
			exit();	
		}
		function getExt($file){
			return strtolower(substr($file, (strripos($file, '.')+1),strlen($file)));
		}
		
	}
	
?>