<?php
class mcategory extends Database {
	
	function getData()
	{
		$sql = "SELECT * FROM code_activity";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
}
?>