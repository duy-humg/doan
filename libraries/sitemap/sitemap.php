<?php

class SITEMAP
{
	public function SITEMAP()
	{
	}
	
	public function GetFeed()
	{
		return $this->getDetails().$this->getItems_contents().$this->getItems_news().$this->getItems_news_cat().$this->getItems_contents().$this->getItems_products().$this->getItems_products_cat() ;
	}
	
	
	private function getDetails()
	{
		$details = '
                    <url>
                      <loc>'.URL_ROOT.'</loc>
                      <lastmod>'.date("Y-m-d").'</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>1</priority>
                    </url>
                 
                    <url>
                      <loc>'.URL_ROOT.'lien-he.html</loc>
                      <lastmod>'.date("Y-m-d").'</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.8</priority>
                    </url>    
                    <url>
                      <loc>'.URL_ROOT.'he-thong-cua-hang.html</loc>
                      <lastmod>'.date("Y-m-d").'</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.8</priority>
                    </url>    
                    <url>
                      <loc>'.URL_ROOT.'khuyen-mai.html</loc>
                      <lastmod>'.date("Y-m-d").'</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.8</priority>
                    </url>    
                    <url>
                      <loc>'.URL_ROOT.'hoi-dap.html</loc>
                      <lastmod>'.date("Y-m-d").'</lastmod>
                      <changefreq>daily</changefreq>
                      <priority>0.8</priority>
                    </url>    
                    ';
		return $details;
	}
	
     private function getItems_news()
	{
		global $db;
		
		$query = " SELECT id,title,alias,created_time,updated_time,category_alias
				FROM fs_news
				WHERE published = 1
				ORDER BY ID DESC
				";
		//$db->query($query);
		$result = $db->getObjectList($query);
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=news&view=news&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.85</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
    private function getItems_news_cat()
	{
		global $db;
		
		$query = " SELECT id,name,alias,created_time,updated_time
				FROM fs_news_categories
				WHERE published = 1
				ORDER BY ID DESC
				";
		//$db->query($query);
		$result = $db->getObjectList($query);
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_('index.php?module=news&view=cat&id='.$row->id.'&ccode='.$row->alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.85</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
     private function getItems_contents()
	{
		global $db;
		
		$query = "SELECT id,title,alias,created_time,updated_time,category_alias
				FROM fs_contents
				WHERE published = 1
				ORDER BY ID DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
            $link = FSRoute::_("index.php?module=contents&view=content&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.85</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
    //private function getItems_images()
//	{
//		global $db;
//		
//		$query = "SELECT *
//				FROM fs_images
//				WHERE published = 1
//				ORDER BY ID DESC
//				";
//		$db->query($query);
//		$result = $db->getObjectList();
//		$xml = '';
//        
//		for($i = 0; $i < count($result); $i ++ ){
//			$row = $result[$i];
//            $link = FSRoute::_("index.php?module=image&view=image&task=detail&id=".$row->id."&code=".$row->alias);
//			$xml .= '
//                      <url>
//                          <loc>'.$link.'</loc>
//                          <lastmod>2005-01-01+00:00</lastmod>
//                          <changefreq>daily</changefreq>
//                          <priority>0.85</priority>
//                        </url>  
//                    ';
//		}
//
//		return $xml;
//	}
    
 //   private function getItems_video()
//	{
//		global $db;
//		
//		$query = "SELECT *
//				FROM fs_video
//				WHERE published = 1
//				ORDER BY ID DESC
//				";
//		$db->query($query);
//		$result = $db->getObjectList();
//		$xml = '';
//        
//		for($i = 0; $i < count($result); $i ++ ){
//			$row = $result[$i];
//            //                  index.php?module=image&view=image&task=detail&code=$item->alias&id=$item->id
//            $link = FSRoute::_("index.php?module=image&view=video&task=detail&id=".$row->id."&code=".$row->alias);
//			$xml .= '
//                      <url>
//                          <loc>'.$link.'</loc>
//                          <lastmod>2005-01-01+00:00</lastmod>
//                          <changefreq>daily</changefreq>
//                          <priority>0.85</priority>
//                        </url>  
//                    ';
//		}
//
//		return $xml;
//	}
      
    
	private function getItems_products()
	{
		global $db;
		
		$query = "SELECT id,name,alias,created_time,updated_time,category_alias
				FROM fs_products
				WHERE published = 1
				ORDER BY ID DESC
				
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_('index.php?module=products&view=product&code='.$row -> alias.'&ccode='.$row->category_alias.'&id='.$row->id);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.85</priority>
                        </url>  
                    ';
		}

		return $xml;
	}
    
    private function getItems_products_cat()
	{
		global $db;
		
		$query = " SELECT id,name,alias,created_time,updated_time
				FROM fs_products_categories
				WHERE published = 1
				ORDER BY ID DESC
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
        
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			//$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$row->alias);
            $link = FSRoute::_('index.php?module=products&view=cat&cid='.$row->id.'&ccode='.$row->alias);
			$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                          <lastmod>'.date("Y-m-d",strtotime($row->updated_time)).'</lastmod>
                          <changefreq>daily</changefreq>
                          <priority>0.85</priority>
                        </url>  
                    ';
		}

		return $xml;
	}

}

?>