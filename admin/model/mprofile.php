<?php
class mprofile extends Database {
	
	var $session;
	function __construct()
	{

		$this->session = new Session;
	}

	function updSettings($data,$id)
	{
		
		foreach ($data as $key => $val) {
			$tmpset[] = $key."='{$val}'";
		}

		$set = implode(',',$tmpset);

		$query = "UPDATE admin_member SET {$set} WHERE id = {$id}";

		$result = $this->query($query);

		return true;
	}

	function updSess($data)
	{
		// pr($_POST);exit;
		$username = $data['username'];
		$password = $data['password'];
		
		// pr($data);		
		
		$sql = "SELECT * FROM admin_member WHERE username = '{$username}' LIMIT 1";
		// pr($sql);exit;
		$res = $this->fetch($sql,0,0);
		// pr($res);
		if ($res){
			$salt = $password;
			// pr($salt);exit;
			// $getRule = "SELECT * FROM cdc_group_rule WHERE groupID = {$res['usertype']} LIMIT 1 ";
			// $res['rule'] = $this->fetch($getRule);
			// pr($res);
			// exit;
			if ($res['password'] == $salt){
				// $_SESSION['admin'] = $res;

				$this->session->set_session($res);
				return true;
			}
		}		
		
		return false;
	}
	
}
?>