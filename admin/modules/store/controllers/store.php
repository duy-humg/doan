<?php
	class StoreControllersStore extends Controllers
	{
		function __construct()
		{
			$this->view = 'store' ;
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

        function add()
        {
            $model = $this -> model;
            $city= $model->get_records("published=1","province");
            $district= $model->get_records("published=1","district");
            $maxOrdering = $model->getMaxOrdering();
//            var_dump($city);die;
            include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
        }

        function edit()
        {
            $ids = FSInput::get('id',array(),'array');
            $id = $ids[0];
            $model = $this -> model;
            $data = $model->get_record_by_id($id);
            $city= $model->get_records("published=1","province");
            $district= $model->get_records("published=1","district");
            include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
        }
		
		function bold()
		{
			$model = $this -> model;
			$rows = $model->bold(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was bold'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when bold record'),'error');	
			}
		}
		function unbold()
		{
			$model = $this -> model;
			$rows = $model->bold(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was unbold'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when unbold record'),'error');	
			}
		}
		function district(){
            $city = FSInput::get('city',0);
            $model = $this -> model;
            $district= $model->get_records("published=1 and provinceid=".$city,"district");
            $html='';
            foreach ($district as $item){
                $html.='<option value="'.$item->id.'">'.$item->name.'</option>';
            }
            echo $html;
        }
	}
	
?>