<?php 
	class ProductsModelsImport extends FSModels
	{
		function __construct() {
			
//			$this->type = 'products';
			$this->table_name = 'fs_products';
			$this->use_table_extend = 1;
			$this->calculate_filters = 1;
			
			parent::__construct ();
			$this->load_params ();
		}
		
		function get_data_for_export($tablename)
		{
			
			global $db;
			$query = " SELECT * ";
			$query .= " FROM fs_products";
			$query .= " ORDER BY  ordering DESC, id DESC ";
			$query .= "LIMIT 0, 1 ";
			global $db;
			$db -> query($query);
			$rs = $db->getObjectList();
				return $rs;
		}
		// Cập nhật thông tin  sản phẩm
		function import_film_info($excel,$path){
			$fsstring = FSFactory::getClass('FSString','','../');	
			$file_path = $path.$excel;
			require_once("../libraries/excel/phpExcelReader/Excel/reader.php");
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($file_path);
			unset($total_product);			
			$total_product =count($data->sheets[0]['cells']);
			$info_import_product =array();
			unset($j);

            //Lấy  tên trong bang exel
			$arr_field_name = $data->sheets['0']['cells']['1'];
//			var_dump($arr_field_name);die;
			$total_field_name =count($arr_field_name);
//			var_dump($total_field_name);die;
            //end Lấy  tên trong bang exel	
			$rs = 0;
			for($j=2;$j<=$total_product;$j++){
				$row = array();
				$info_import_product['ma_kho_tiki'] = $this->get_cell_content_by_name($data,0,$j,'ma_hang',$arr_field_name);
                if(!$info_import_product['ma_kho_tiki'])
					continue;

				// Danh muc

                $info_import_product['name'] = $this->get_cell_content_by_name($data,0,$j,'tieu_de',$arr_field_name);
                $info_import_product['price_old'] = preg_replace('/[.*]+/i','',$this->get_cell_content_by_name($data,0,$j,'old_price',$arr_field_name));
                $info_import_product['price'] = preg_replace('/[.*]+/i','',$this->get_cell_content_by_name($data,0,$j,'normal_price',$arr_field_name));
//                $info_import_product['company_ex'] = $this->get_cell_content_by_name($data,0,$j,'nha_cung_cap',$arr_field_name);
                $info_import_product['released_time'] = $this->get_cell_content_by_name($data,0,$j,'nam_xb',$arr_field_name);
//                var_dump($data);
//                die;
                $info_import_product['weight'] = $this->get_cell_content_by_name($data,0,$j,'trong_luong',$arr_field_name);
                $info_import_product['measure_book'] = $this->get_cell_content_by_name($data,0,$j,'kich_thuoc',$arr_field_name);
                $info_import_product['so_trang'] = $this->get_cell_content_by_name($data,0,$j,'so_trang',$arr_field_name);
                $info_import_product['content'] = $this->get_cell_content_by_name($data,0,$j,'description',$arr_field_name);
//                $info_import_product['so_trang'] = $this->get_cell_content_by_name($data,0,$j,'hinh_thuc',$arr_field_name);

//                $info_import_product['discount_unit'] = preg_replace('/[.*]+/i','',$this->get_cell_content_by_name($data,0,$j,'discount_unit',$arr_field_name));
//                $info_import_product['discount'] = preg_replace('/[.*]+/i','',$this->get_cell_content_by_name($data,0,$j,'discount',$arr_field_name));
//                $info_import_product['quantity'] = preg_replace('/[.*]+/i','',$this->get_cell_content_by_name($data,0,$j,'quantity',$arr_field_name));
                $price_old = $info_import_product['price_old'];
                $price_old = $this->standart_money($price_old, 0);
                $price = $info_import_product['price'];
                $price = $this->standart_money($price, 0);
//                $discount = $info_import_product['discount'];
//                $discount = $this->standart_money($discount, 0);
//                $discount_unit = $info_import_product['discount_unit'];
//                if ($discount_unit == 'percent') {
//                    if ($discount > 100 || $discount < 0) {
//                        $info_import_product ['price_old'] = $price_old;
//                        $info_import_product ['price'] = $price_old;
//                        $info_import_product ['discount'] = 0;
//                        $info_import_product ['discount_percent'] = 0;
//                    } else {
//                        $info_import_product ['price_old'] = $price_old;
//                        $info_import_product ['discount'] = $discount;
//                        $info_import_product ['discount_percent'] = $discount;
//                        $info_import_product ['price'] = $price_old * (100 - $discount) / 100;
//                    }
//                } else {
//                    if ($discount > $price_old || $discount < 0) {
//                        $info_import_product ['price_old'] = $price_old;
//                        $info_import_product ['price'] = $price_old;
//                        $info_import_product ['discount'] = 0;
//                        $info_import_product ['discount_percent'] = 0;
//                    } else {
//                        $info_import_product ['price_old'] = $price_old;
//                        $info_import_product ['discount'] = $discount;
//                        $info_import_product ['price'] = $price_old - $discount;
//                        $info_import_product ['discount_percent'] = round(100 * ($discount / $price_old));
//                    }
//                }
//                print_r($info_import_product);die;
                $row = $info_import_product;
//var_dump($row);die;
                $price_exist =$this -> get_record('ma_kho_tiki="'.$info_import_product['ma_kho_tiki'].'" ',
			                                        'fs_products','*');
//                var_dump($price_exist);die;
				$table_name = isset($cat->tablename)?$cat->tablename:'';
                if(!$price_exist){
					$row['created_time'] =date('Y-m-d H:i:s');
//                    var_dump($row);


                    $product_new_id = $this -> _add($row,'fs_products',1);
				}else{
				    unset($row['ma_kho_tiki']);
//                    var_dump($row);
					$result = $this -> _update($row,'fs_products','ma_kho_tiki = "'.$price_exist -> ma_kho_tiki.'"',1);
				die();
						$rs++;
				}
			}
//			var_dump($rs);die;
			return $rs;
		}
                

		// Thực hiện lấy thông tin san pham
		function get_cell_content($data,$sheet_index,$row_index,$col_index){
			$content = isset($data->sheets[$sheet_index]['cells'][$row_index][$col_index])?$data->sheets[$sheet_index]['cells'][$row_index][$col_index]:'';
			return $content;
		}
		
		function get_cell_content_by_name($data,$sheet_index,$row_index,$field_name,$arr_field_name){
			$dem=1;
			foreach ($arr_field_name as $key=>$item) {
				if($field_name == $item){
					if($dem > 1){
						Errors::_ ( 'File bạn vừa nhập có '.$dem.' : '.$field_name);
						return false;
					}
					else
						$content = isset($data->sheets[$sheet_index]['cells'][$row_index][$key])?$data->sheets[$sheet_index]['cells'][$row_index][$key]:'';
					$dem++;
				}
			} 
			return $content;
		}
		  
	  function seems_utf8($str) {
	        for ($i=0; $i<strlen($str); $i++) {
	            if (ord($str[$i]) < 0x80) continue; # 0bbbbbbb
	            elseif ((ord($str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
	            elseif ((ord($str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
	            elseif ((ord($str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
	            elseif ((ord($str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
	            elseif ((ord($str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
	            else return false; # Does not match any model
	            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
	                if ((++$i == strlen($str)) || ((ord($str[$i]) & 0xC0) != 0x80))
	                    return false;
	            }
	        }
	        return true;
	    }

        function standart_money($money, $method) {
            $money = str_replace(',', '', trim($money));
            $money = str_replace(' ', '', $money);
            $money = str_replace('.', '', $money);
            //		$money = intval($money);
            $money = (double) ($money);
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
	    /*
	     * Xử lý datetime trong excel khi import
	     * Trả ra dạng integer
	     */
	    
	    function get_datetime_from_excel($value){
	    	if(strlen($value) > 5){
	    		return strtotime($value);
	    	}else{
	    		return strtotime('1899-12-31+'.($value-1).' days');
	    	}
	    }
	}
	
?>