
<?php 
	class ProductsModelsSearch extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
                    parent::__construct();
    		global $module_config;
			$limit = 20;
			$this->limit = $limit;
		}
		
		
		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */
		function get_product_from_ids($str_product_ids){
			if(!$str_product_ids)
				return;
			$query = " SELECT *
					FROM fs_products
					WHERE id IN ($str_product_ids) ";
			$query;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function set_query_body()
		{
			$keyword = addslashes(FSInput::get('keyword'));
			if(!$keyword)
				return ;
			$fs_table = FSFactory::getClass('fstable');
			$where = "";
            $arr_tags = explode ( ' ', $keyword );
            $total_tags = count ( $arr_tags );
            if ($total_tags) {
                $where .= ' AND (';
                $j = 0;
                for($i = 0; $i < $total_tags; $i ++) {
                    $item = trim ( $arr_tags [$i] );
                    if ($item) {
                        if ($j > 0)
                            $where .= ' AND ';
                        $where .= " `name` like '%" . $item . "%'";
                        $j ++;
                    }
                }
                $where .= ' )';
            }
//			$where .= " AND (name like '%".$keyword."%' OR tag_alias like '%".$keyword."%' OR category_name like '%".$keyword."%' ) ";
			$sql   = "	 FROM ".$fs_table -> getTable('fs_products')."
						WHERE published =1 ".
						$where ." ORDER BY stock DESC ";
			return $sql;
			
		}
		function get_list($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by();
			$query_select = $this -> set_query_select();
			$query = $query_select;
			$query .= $query_body;
			$query .= $query_ordering;
//			echo $query;
			global $db;

			$db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		
	/*
		 * Insert order by into query select
		 */
		function set_query_order_by(){
			$order  = FSInput::get('order');
			 $query_ordering = '';
			if($order){
				switch ($order){
					case 'asc':
						$query_ordering=' , price '.$order;
						break;
					case 'desc':
						$query_ordering=' , price '.$order;
						break;
					case 'old':
						$query_ordering=' , status ASC';
						break;	
					case 'new':
						$query_ordering=' , status DESC';
						break;	
					case 'alpha':
						$query_ordering=' , name asc';
						break;	
					case 'promotion':
						$query_ordering=' , is_promotion asc';
						break;				
				}
			}else{
//				$query_ordering=' , name DESC, id DESC';
			}
			
			return $query_ordering;
		}
		function set_query_select(){
			$query = " SELECT * ";
			return $query;
		}
		
		
		
		
		function getTotal($query_body)
		{
			global $db;
			$query = "SELECT count(*) ";
			$query .= $query_body;
			$db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		function get_breadcrumb(){
			$array_breadcrumb = array();
			$array_breadcrumb[0] = array();
			$array_breadcrumb[0][] = array('name'=>'Tìm kiếm','link'=>'','selected'=>1);
			
			return $array_breadcrumb;
		}

        function get_ajax_search(){
//		    echo 1;die;
            global $db;
            $where = '';
            $query = FSInput::get('query', '');
            $arr_tags = explode ( ' ', $query );
            $total_tags = count ( $arr_tags );
            //dùng khi tìm kiếm theo đoạn
            $where .= " AND `name` like '%" . $query . "%'";
            //dùng khi tìm kiếm theo từng từ
//            if ($total_tags) {
//                $where .= ' AND (';
//                $j = 0;
//                for($i = 0; $i < $total_tags; $i ++) {
//                    $item = addslashes(trim ( $arr_tags [$i] ));
//                    if ($item) {
//                        if ($j > 0)
//                            $where .= ' AND ';
//                        $where .= " `name` like '%" . $item . "%'";
//                        $j ++;
//                    }
//                }
//                $where .= ' )';
////                echo $where;die;
//            }
//             $where .= "AND MATCH(name) AGAINST ('".$query."' IN BOOLEAN MODE)";
//             $where .= " AND `name` like '%" .  $query . "%'";
             $query = '  SELECT *
                        FROM fs_products 
                        WHERE published = 1  '.$where.'
                      
                        LIMIT 20
                        ';

            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
	}
	
?>