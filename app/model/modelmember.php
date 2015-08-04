<?php
class modelmember extends Database {
	
	var $prefix = "api";	
	function get_category($type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_category WHERE n_status = '1' ORDER BY create_date DESC";
		
		$result = $this->fetch($query,1);

		// foreach ($result as $key => $value) {
		// 	$query = "SELECT username FROM admin_member WHERE id=1 LIMIT 1";
		// 	// $query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

		// 	$username = $this->fetch($query,0);

		// 	$result[$key]['username'] = $username['username'];
		// }
		
		return $result;
	}
	function Allmember($kategori,$fleg,$start=false,$limit=false)
	{
		if($fleg==0){
			$query = "SELECT * FROM social_member WHERE name LIKE '".$kategori."%' AND n_status = '1' ORDER BY name DESC";
		}else{
			$query = "SELECT * FROM social_member WHERE name LIKE '".$kategori."%' AND n_status = '1' ORDER BY name DESC limit $start,$limit";
		
		}
		$result = $this->fetch($query,1);
		// pr($result);
		// foreach ($result as $key => $value) {
		// 	$query = "SELECT username FROM admin_member WHERE id=1 LIMIT 1";
		// 	// $query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

		// 	$username = $this->fetch($query,0);

		// 	$result[$key]['username'] = $username['username'];
		// }
		
		return $result;
	}
	
}
?>