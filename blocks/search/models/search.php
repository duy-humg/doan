<?php 
	class SearchBModelsSearch
	{
		function __construct()
		{
		}
        function get_list_quick()
        {
            $query = "SELECT name,alias,id
						  FROM fs_quick_search AS a
						  WHERE published = 1 
						  ORDER BY ordering ASC, id ASC
						 ";
//                        echo $query;
            global $db;
            $db->query($query);
            $result = $db->getObjectList();
            return $result;
//


        }
	}
?>