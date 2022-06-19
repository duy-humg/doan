<?php
/*
 * Huy write
 */
	// controller
	
	class CommentsControllersComments extends FSControllers
	{
		var $module;
		var $view;
		function display(){
			$model = $this->model;
			// $comments = $model->get_comments ( $id);
			
			$query_body = $model->set_query_body();
			$comments = $model->get_list($query_body);



			$comments_children = $model->get_list($query_body);

			$total_comment = count ( $comments );
//			var_dump($total_comment);
			if ($total_comment) {
				$list_parent = array ();
				$list_children = array ();
				foreach ( $comments as $item ) {
					// var_dump($item);
					if (! $item->parent_id) {

						$list_parent [] = $item;
						$comments_children = $model->get_comments_child($item->id);
						$count_comments_children = count($comments_children);
						// var_dump(count($comments_children));
						foreach ( $comments_children as $child ) {
							
							if (! isset ( $list_children [$item->id] ))
								$list_children [$item->id] = array ();
							$list_children [$item->id] [] = $child;
						}
					} 
				}
			}
		
			$total = $model -> getTotal($query_body);
	
			$pagination = $model->getPagination($total);
//			var_dump($pagination);

			$return = array();
	
			include 'modules/'.$this->module.'/views/'.$this->view.'/fetch_pages.php';
			// $return['content']= $html;
			
			// echo json_encode($return);
		}

	}
	
?>