<?php
class modeldirektori extends Database {
	
	var $prefix = "api";	
	function get_category($type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_category WHERE n_status = '1' ORDER BY create_date DESC";
		
		$result = $this->fetch($query,1);

		
		return $result;
	}

	function getKepakaran($categoryid=1, $content=false, $type=1, $start=0, $limit=5)
	{
		
		$filter = "";
		if ($content) $filter = " AND content LIKE '%{$content}%' ";

		$sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
				AND articleType = {$type} {$filter} LIMIT {$start},{$limit}";
		// pr($sql);

		$res = $this->fetch($sql,1);

		$sqlC = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
				AND articleType = {$type} {$filter}";
		// pr($sql);

		$resC = $this->fetch($sqlC,1);

		$dataCount['countData']=count($resC);
		$dataCount['limit']=$limit;

		if ($res) return array('dataArr'=>$res, 'dataCount'=>$dataCount);;
		return false;
	}
	
}
?>