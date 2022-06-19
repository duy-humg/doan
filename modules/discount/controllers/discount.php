<?php

/*
 * Huy write
 */

// controller

class DiscountControllersDiscount extends FSControllers {

    var $module;
    var $view;

    function save() {
        $model = $this->model;
        $return = FSInput::get('return');
        if ($return)
            $url = base64_decode($return);
        else
            $url = URL_ROOT;
        $email = FSInput::get('email');
//        $cat = FSInput::get('cat');

        // check exist
        if ($model->check_exist($email)) {
            $msg = FSText::_('Email này đã được đăng kí trong hệ thống!');
            setRedirect($url, $msg);
        }

        $rs = $model->save();

        if ($rs)
            $msg = FSText::_('Bạn đã đăng ký nhận email thành công.!');
        else
            $msg = FSText::_('Xin lỗi. Bạn chưa đăng kí nhận email thành công!');

        setRedirect($url, $msg);
    }
}

?>