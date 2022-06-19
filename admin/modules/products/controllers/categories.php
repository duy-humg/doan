<?php
	class ProductsControllersCategories extends ControllersCategories{
	   function __construct()
		{
			$this->view = 'categories' ; 
			parent::__construct(); 
		}
        
        function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
            $list_item = $model->list_item($id);

//            $total_up = count($list_item);

            $type = $model->type();
            $table = $model->table_data();
			$data = $model->get_record_by_id($id);
			$categories = $model->get_categories_tree_all();
 
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

        function adddata()
        {

            $model = $this->model;


            $id = FSInput::get('id');
            $a = FSInput::get('a');
            $type = $model->type();
            $table_data = $model->table_data();
            $time = date("d/m/Y");

            $data = array(
                'error' => true,
                'message' => '',
                'html' => '',
                'id' => '',
            );

            $html = '';



            $html .= '<div class="list-item-data list-item-data'.$a.'">';

            $html .= '<div class="name-data text-list-data">';
            $html .= '<input class="input-date" id="name_data'.$a.'" name="name_data'.$a.'" type="text" required="required">';
            $html .= '</div>';

            $html .= '<div class="type-data text-list-data">';
            $html .= '<select class="select target_type" key_type="'.$a.'" required="required" name="field_type'.$a.'" id="field_type'.$a.'" onclick="change_field_type('.$a.');">';
            $html .= '<option value="">'. FSText::_("Kiểu trường").'</option>';
            foreach ($type as $item_ser){
                $html .= '<option value="'.$item_ser->id.'">'.$item_ser->title.'</option>';
            }
            $html .= '</select>';
            $html .= '</div>';
            $html .= '<div class="table-list-data text-list-data table-list-data'.$a.'">';
            $html .= '<select disabled class="select select_dis" name="field_table_'.$a.'" id="field_table_'.$a.'" required="required">';
            $html .= '<option  value="">'. FSText::_("").'</option>';
            foreach ($table_data as $item_ser){
                $html .= '<option value="'.$item_ser->id.'">'.$item_ser->name.'</option>';
            }
            $html .= '</select>';
            $html .= '</div>';

            $html .= '<div class="ordering-data text-list-data">';

            $html .= '<input class="" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$a.'" name="ordering_data'.$a.'" type="text">';
            $html .= '</div>';
            $html .= '<div class="save-data text-list-data">';
            $html .= '<a href="javascript: void(0)" onclick="add_data_item('.$a.')" class="a-add">';
            $html .= '<img src="'.URL_ROOT.'images/save.png'.'" alt="png">';
            $html .= '</a>';
            $html .= '</div>';
            $html .= '<div class="detele-data text-list-data">';
            $html .= '<a href="javascript: void(0)" onclick="remove('.$a.')" class="detele">';
            $html .= '<img src="'.URL_ROOT.'images/remove.jpg'.'" alt="png">';
            $html .= '</a>';
            $html .= '</div>';

            echo $html;
        }

        function add_item_data()
        {

            $model = $this->model;

            $name_data = FSInput::get('name_data');
            if($name_data){
                $data_id = FSInput::get('data_id');
                $id = $model->save_item_service();
                $session_service = FSInput::get('session_service');

                if($data_id){
                    $rs = $model->list_services_edit($data_id);
                }else{
                    $rs = $model->list_services($session_service);
                }





                $type = $model->type();
                $table_data = $model->table_data();

                $data = array(
                    'error' => true,
                    'message' => '',
                    'html' => '',
                    'id' => '',
                );

                $html = '';

                if ($rs)
                    foreach ($rs as $service) {
                        $html .= '<div class="list-item-data list-item-data-'.$service->id.'">';

                        $html .= '<div class="name-data text-list-data">';
                        $html .= '<input class="input-date" id="name_data'.$service->id.'" name="name_data'.$service->id.'" type="text" value="'.$service->title.'">';
                        $html .= '</div>';

                        $html .= '<div class="type-data text-list-data">';
                        $html .= '<select class="select target_type" key_type="'.$service->id.'" name="field_type'.$service->id.'" id="field_type'.$service->id.'" onclick="change_field_type('.$service->id.');">';
                        $html .= '<option value="">'. FSText::_("Kiểu trường").'</option>';
                        foreach ($type as $item_ser){
                            $checked = (@$service->field_type == $item_ser->id) ? " selected = 'selected'" : "";
                            $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->title.'</option>';
                        }
                        $html .= '</select>';
                        $html .= '</div>';
                        $html .= '<div class="table-list-data text-list-data table-list-data'.$service->id.'">';
                        if($service->field_type == 33 or $service->field_type == 36){
                            $html .= '<select disabled class="select select_dis" name="field_table_'.$service->id.'" id="field_table_'.$service->id.'">';
                        }else{
                            $html .= '<select class="select" name="field_table_'.$service->id.'" id="field_table_'.$service->id.'">';
                        }

                        $html .= '<option  value="">'. FSText::_("").'</option>';
                        foreach ($table_data as $item_ser){
                            $checked = (@$service->field_table == $item_ser->id) ? " selected = 'selected'" : "";
                            $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->name.'</option>';
                        }
                        $html .= '</select>';
                        $html .= '</div>';

                        $html .= '<div class="ordering-data text-list-data">';
                        if($service->ordering==1){
                            $html .= '<input class="" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$service->id.'" name="ordering_data'.$service->id.'" type="text">';

                        }else{
                            $html .= '<input class="" value="'.$service->ordering.'" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$service->id.'" name="ordering_data'.$service->id.'" type="text">';
                        }
                        $html .= '</div>';
                        $html .= '<div class="save-data text-list-data">';
                        $html .= '<a href="javascript: void(0)" onclick="update_data_item('.$service->id.','.$service->sessions.')" class="a-add">';
                        $html .= '<img src="'.URL_ROOT.'images/save.png'.'" alt="png">';
                        $html .= '</a>';
                        $html .= '</div>';
                        $html .= '<div class="detele-data text-list-data">';
                        $html .= '<a href="javascript: void(0)" onclick="remove2('.$service->id.','.$service->sessions.')" class="detele">';
                        $html .= '<img src="'.URL_ROOT.'images/remove.jpg'.'" alt="png">';
                        $html .= '</a>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
            }
            else{
                $html = '';
            }


            echo $html;

        }

        function update_data_item()
        {

            $model = $this->model;
            $id_ = FSInput::get('id');
            $get_session = $model->update_data($id_);
            $session_service = FSInput::get('session_service');

            $rs = $model->list_services($session_service);
            $type = $model->type();
            $table_data = $model->table_data();
            $data = array(
                'error' => true,
                'message' => '',
                'html' => '',
                'id' => '',
            );

            $html = '';



            if ($rs)
                foreach ($rs as $service) {
                    $html .= '<div class="list-item-data list-item-data-'.$service->id.'">';

                    $html .= '<div class="name-data text-list-data">';
                    $html .= '<input class="input-date" id="name_data'.$service->id.'" name="name_data'.$service->id.'" type="text" value="'.$service->title.'">';
                    $html .= '</div>';

                    $html .= '<div class="type-data text-list-data">';
                    $html .= '<select class="select target_type" key_type="'.$service->id.'" name="field_type'.$service->id.'" id="field_type'.$service->id.'" onclick="change_field_type('.$service->id.');">';
                    $html .= '<option value="">'. FSText::_("Kiểu trường").'</option>';
                    foreach ($type as $item_ser){
                        $checked = (@$service->field_type == $item_ser->id) ? " selected = 'selected'" : "";
                        $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->title.'</option>';
                    }
                    $html .= '</select>';
                    $html .= '</div>';
                    $html .= '<div class="table-list-data text-list-data table-list-data'.$service->id.'">';
                    if($service->field_type == 33 or $service->field_type == 36){
                        $html .= '<select disabled class="select select_dis" name="field_table_'.$service->id.'" id="field_table_'.$service->id.'">';
                    }else{
                        $html .= '<select class="select" name="field_table_'.$service->id.'" id="field_table_'.$service->id.'">';
                    }

                    $html .= '<option  value="">'. FSText::_("").'</option>';
                    foreach ($table_data as $item_ser){
                        $checked = (@$service->field_table == $item_ser->id) ? " selected = 'selected'" : "";
                        $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->name.'</option>';
                    }
                    $html .= '</select>';
                    $html .= '</div>';

                    $html .= '<div class="ordering-data text-list-data">';
                    if($service->ordering==1){
                        $html .= '<input class="" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$service->id.'" name="ordering_data'.$service->id.'" type="text">';

                    }else{
                        $html .= '<input class="" value="'.$service->ordering.'" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$service->id.'" name="ordering_data'.$service->id.'" type="text">';
                    }
                    $html .= '</div>';
                    $html .= '<div class="save-data text-list-data">';
                    $html .= '<a href="javascript: void(0)" onclick="update_data_item('.$service->id.','.$service->sessions.')" class="a-add">';
                    $html .= '<img src="'.URL_ROOT.'images/save.png'.'" alt="png">';
                    $html .= '</a>';
                    $html .= '</div>';
                    $html .= '<div class="detele-data text-list-data">';
                    $html .= '<a href="javascript: void(0)" onclick="remove2('.$service->id.','.$service->sessions.')" class="detele">';
                    $html .= '<img src="'.URL_ROOT.'images/remove.jpg'.'" alt="png">';
                    $html .= '</a>';
                    $html .= '</div>';
                    $html .= '</div>';
                }


            echo $html;

        }
        function update_data_item_2()
        {

            $model = $this->model;
            $id_ = FSInput::get('id');
            $get_session = $model->update_data($id_);

            $get_session_2 = $model->update_data_2($id_);

            $record_id = FSInput::get('record_id');

            $rs = $model->list_services2($record_id);

            $type = $model->type();
            $table_data = $model->table_data();

            $data = array(
                'error' => true,
                'message' => '',
                'html' => '',
                'id' => '',
            );

            $html = '';



            if ($rs)
                $i=1;
            foreach ($rs as $service) {
                $html .= '<input type="hidden" name="id_data'.$i.'" id="id_data'.$i.'" value="'.$service->id.'">';
                $html .= '<div class="list-item-data list-item-data-'.$i.'">';

                $html .= '<div class="name-data text-list-data">';
                $html .= '<input class="input-date" id="name_data2_'.$i.'" name="name_data2_'.$i.'" type="text" value="'.$service->title.'">';
                $html .= '</div>';

                $html .= '<div class="type-data text-list-data">';
                $html .= '<select class="select target_type" key_type="'.$i.'" name="field_type2_'.$i.'" id="field_type2_'.$i.'" onclick="change_field_type_2('.$i.');">';
                $html .= '<option value="">'. FSText::_("Kiểu trường").'</option>';
                foreach ($type as $item_ser){
                    $checked = (@$service->field_type == $item_ser->id) ? " selected = 'selected'" : "";
                    $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->title.'</option>';
                }
                $html .= '</select>';
                $html .= '</div>';
                $html .= '<div class="table-list-data text-list-data table-list-data'.$i.'">';
                if($service->field_type==33 or $service->field_type==36){
                    $html .= '<select disabled class="select select_dis" name="field_table2_'.$i.'" id="field_table2_'.$i.'">';
                }else{
                    $html .= '<select class="select select_dis" name="field_table2_'.$i.'" id="field_table2_'.$i.'">';
                }

                $html .= '<option  value="">'. FSText::_("").'</option>';
                foreach ($table_data as $item_ser){
                    $checked = (@$service->field_table == $item_ser->id) ? " selected = 'selected'" : "";
                    $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->name.'</option>';
                }
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div class="ordering-data text-list-data">';
                if($service->ordering==1){
                    $html .= '<input class="" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data2_'.$i.'" name="ordering_data2_'.$i.'" type="text">';

                }else{
                    $html .= '<input class="" value="'.$service->ordering.'" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data2_'.$i.'" name="ordering_data2_'.$i.'" type="text">';
                }
                $html .= '</div>';
                $html .= '<div class="save-data text-list-data">';
                $html .= '<a href="javascript: void(0)" onclick="update_data_item_2('.$service->id.','.$record_id.','.$i.')" class="a-add">';
                $html .= '<img src="'.URL_ROOT.'images/save.png'.'" alt="png">';
                $html .= '</a>';
                $html .= '</div>';
                $html .= '<div class="detele-data text-list-data">';
                $html .= '<a href="javascript: void(0)" onclick="remove2('.$service->id.','.$record_id.')" class="detele">';
                $html .= '<img src="'.URL_ROOT.'images/remove.jpg'.'" alt="png">';
                $html .= '</a>';
                $html .= '</div>';
                $html .= '</div>';
                $i++;
            }


            echo $html;

        }

        function remove2()
        {

            $model = $this->model;

            $sessions = FSInput::get('sessions');
            $id = FSInput::get('id');
            $data_id = FSInput::get('data_id');

            $detele_file = $model->detele_file($id);
            $type = $model->type();
            $table_data = $model->table_data();
            if($data_id){
                $rs = $model->list_services_edit($data_id);
            }else{
                $rs = $model->list_services($sessions);
            }



            $data = array(
                'error' => true,
                'message' => '',
                'html' => '',
                'id' => '',
            );

            $html = '';

            if ($rs)
                foreach ($rs as $service) {
                    $html .= '<div class="list-item-data list-item-data-'.$service->id.'">';

                    $html .= '<div class="name-data text-list-data">';
                    $html .= '<input class="input-date" id="name_data'.$service->id.'" name="name_data'.$service->id.'" type="text" value="'.$service->title.'">';
                    $html .= '</div>';

                    $html .= '<div class="type-data text-list-data">';
                    $html .= '<select class="select target_type" key_type="'.$service->id.'" name="field_type'.$service->id.'" id="field_type'.$service->id.'" onclick="change_field_type('.$service->id.');">';
                    $html .= '<option value="">'. FSText::_("Kiểu trường").'</option>';
                    foreach ($type as $item_ser){
                        $checked = (@$service->field_type == $item_ser->id) ? " selected = 'selected'" : "";
                        $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->title.'</option>';
                    }
                    $html .= '</select>';
                    $html .= '</div>';
                    $html .= '<div class="table-list-data text-list-data table-list-data'.$service->id.'">';
                    if($service->field_table==33 or $service->field_table==36){
                        $html .= '<select disabled class="select select_dis" name="field_table_'.$service->id.'" id="field_table_'.$service->id.'">';
                    }else{
                        $html .= '<select class="select select_dis" name="field_table_'.$service->id.'" id="field_table_'.$service->id.'">';
                    }

                    $html .= '<option  value="">'. FSText::_("").'</option>';
                    foreach ($table_data as $item_ser){
                        $checked = (@$service->field_table == $item_ser->id) ? " selected = 'selected'" : "";
                        $html .= '<option value="'.$item_ser->id.'" '.$checked.'>'.$item_ser->name.'</option>';
                    }
                    $html .= '</select>';
                    $html .= '</div>';

                    $html .= '<div class="ordering-data text-list-data">';
                    if($service->ordering==1){
                        $html .= '<input class="" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$service->id.'" name="ordering_data'.$service->id.'" type="text">';

                    }else{
                        $html .= '<input class="" value="'.$service->ordering.'" onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,\'\')}" id="ordering_data'.$service->id.'" name="ordering_data'.$service->id.'" type="text">';
                    }
                    $html .= '</div>';
                    $html .= '<div class="save-data text-list-data">';
                    $html .= '<a href="javascript: void(0)" onclick="update_data_item('.$service->id.','.$service->sessions.')" class="a-add">';
                    $html .= '<img src="'.URL_ROOT.'images/save.png'.'" alt="png">';
                    $html .= '</a>';
                    $html .= '</div>';
                    $html .= '<div class="detele-data text-list-data">';
                    $html .= '<a href="javascript: void(0)" onclick="remove2('.$service->id.','.$service->sessions.')" class="detele">';
                    $html .= '<img src="'.URL_ROOT.'images/remove.jpg'.'" alt="png">';
                    $html .= '</a>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
            echo $html;

        }
	}
	
?>