<?php

/*
 * Linh write
 */

// controller

class AutogetControllersAutoget extends FSControllers {

    var $module;
    var $view;

    function display() {
        // call models
        $model = $this->model;

        $data = $model->get_data();

        $i = $data->limit;
        $articles = array();
        for ($x = 1; $x <= $i; $x++) {
            if ($x == 1) {
                $base = $data->url;
            } else {
                $base = $data->url . '&page=' . $x;
            }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_URL, $base);
            curl_setopt($curl, CURLOPT_REFERER, $base);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $str = curl_exec($curl);
            curl_close($curl);
            // Create a DOM object
            $html = new simple_html_dom();
            // Load HTML from a string
            $html->load($str);
            $all_products = $html->find('.product-item');
            if(!$all_products)
                break;
            
            foreach ($all_products as $article) {
                if(!$model->check_exist_link($article->find('a', 0)->href)){
                    if (isset($article->find('a', 0)->href) && isset($article->find('.image img', 0)->src)) {
                        $item['link'] = $article->find('a', 0)->href;
                        $item['image'] = $article->find('.image img', 0)->src;
                        $articles = $item;
                        $model->save($articles, $data->category_id, $data->category_alias, $data->category_name, $data->category_alias_wrapper, $data->category_id_wrapper);
                    }
                }
            }
        }
        
        // call views			
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function stock(){
        $model = $this->model;

        $re = $model->set_stock();
        echo $re;
    }

}

?>