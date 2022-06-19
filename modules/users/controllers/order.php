<?php

/*
 * Huy write
 */

// controller
class UsersControllersOrder extends FSControllers
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
        $query_body = $model->set_query_body();
        $list_order = $model->get_list($query_body);
        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);
        $product = array();
        foreach ($list_order as $item) {
            $product[$item->id] = $model->get_order_id($item->id);
        }
        $data_2 = $model->getMember();

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Quản lý đơn hàng', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function show_order()
    {
        $user_id = $_SESSION['user_id'];
        $model = $this->model;
        if (isset($user_id)){
            $fssecurity = FSFactory::getClass('fssecurity');
            $fssecurity->checkLogin();
            $member = $model->getMember();
        }

        $data = $model->get_order();

        $data_2 = $model->getMember();
//        var_dump($data);
        $list_cart = $model->get_order_id($data->id);
//        var_dump($list_cart);
//var_dump($list_cart);
        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đơn hàng chi tiết', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
      

        include 'modules/' . $this->module . '/views/' . $this->view . '/show_order.php';
    }
    function cancel_order() {
        $model = $this->model;

        $order_id = FSInput::get('order_id');
        $where = 'published = 1 and id = '.$order_id;
        $table = 'fs_order';
        $row = array();
        $row['status']=6;
        $cancle_order= $model->_update($row,$table,$where);
        if (@$cancle_order){
//        var_dump($order);die;$msg = 'Bạn đã thêm sản phẩm yêu thích thành công.';
        $msg = 'Đã hủy đơn hàng DH' . str_pad($order_id, 8, "0", STR_PAD_LEFT);
        setRedirect(FSRoute::_("index.php?module=users&view=order&Itemid=22"), $msg);
        }else{
            $msg = 'Hủy không thành công';
            setRedirect(FSRoute::_("index.php?module=users&view=order&Itemid=22"), $msg, 'error');
        }
    }
    function ajax_load_infor()
    {
        $model = $this->model;
        $infor = FSInput::get('id');
        $infor1 = $model->get_order_id($infor);
//        var_dump($infor1);
        $data = $model->get_order();

//        var_dump($data);
        $html = '   <td colspan="3" class="left_right3">';

        foreach ($infor1 as $item) {
//            var_dump($data->id, $data->sender_email);
            $image = URL_ROOT . str_replace('original', 'tiny', $item->image);
            $html .= '
                    <div class="row bg">
                        <div class="img_left_right3 col-md-8">
                            <img  style="max-width: 115px; float: left;" src="' . $image . '">
                            <div class="text_left_right3">
                                <p class="p8">' . $item->product_name . '</p>
                                <p class="p9">Giá: <span class="span1">' . format_money($item->total) . '</span></p>
                                <p class="p10">Số lượng: <span class="span2">' . $item->count . '</span> <span class="spann"><a href="#" onclick="thugon(' . $item->order_id . ')">Thu gọn</a></span></p>
                                <p><a class="a2" href="#" onclick="order('.$item->product_id.')">MUA LẠI SẢN PHẨM</a></p>	
                            </div>
						</div>
						<div class="right_right2 col-md-4">
							<form action="'.FSRoute::_("index.php?module=users&view=users&task=order_status&Itemid=22 ").'" method="post" name="form" id="form">
                                <input type="submit" class="a3" value="Theo dõi đơn hàng">
                                <input type="hidden" name="madh" id="madh" value="DH' . str_pad($data->id, 8, "0", STR_PAD_LEFT).'" required="">
                                <input type="hidden" name="email" id="email" value="'.$data->sender_email.'" required>
                            </form>
							<a class="a3" href="'.FSRoute::_('index.php?module=products&view=product&ccode=' . $item->category_alias . '&code=' . $item->product_alias . '&id=' . $item->product_id).'">Viết cảm nhận về sản phẩm</a>';
                        if ($data->status == 0 or $data->status == 1){
                            $html .= '<a class="a3" href="index.php?module=users&view=order&task=cancel_order&raw=1&order_id='.$data->id.'">Hủy đơn hàng</a>';
                        }
            $html .='</div>
						<script>
						function thugon(i) {
//                            alert(i);
                            $(".infor" + i).addClass("hidden");
                            }
						</script>
                    </div>
                  
                    ';
        }
        $html .= '	</td>';
   echo $html;

}
}
?>
