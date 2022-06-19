<?php

class VoteBModelsVote extends FSModels {

    function __construct() {
        $fstable = FSFactory::getClass('fstable');
            $this->table_name  = $fstable->_('fs_products_company_ex');	
    }
    function save($base){
        
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
        $fsstring = FSFactory::getClass('FSString', '', '../');
        $row = array();
        foreach ($html->find('#collapse-publisher_vn a.list-group-item') as $article) {
            foreach($article->find('span') as $e)
            {
                $e->outertext = '';
            }
            $row['name'] = trim($article->innertext);
            $row['alias'] = trim($fsstring->stringStandart($row['name']));
            $time = date('Y-m-d H:i:s');
            $row['created_time'] = $time;
            $row['updated_time'] = $time;
//            $articles[] = $row;
//            $id = $this->_add($row, $this->table_name);
        }
    }

}

?>