<?php
class msetting extends Database {
	
	function get_user($data)
	{
		$query = "SELECT * FROM user_member WHERE id = {$data}";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	function upd_profile($x){
		
		
		$x['description'] = cleanText($x['description']);
		
		$query = "UPDATE user_member SET nickname='{$x['nickname']}', email='{$x['email']}', description='{$x['description']}', image_profile='{$x['image']}' WHERE id = {$_SESSION['admin']['id']}";
		// pr($query);
		$result = $this->query($query);
	}
	
	function upd_pass($pass){
		
		$query = "UPDATE user_member SET password='{$pass}' WHERE id = {$_SESSION['admin']['id']}";
		
		$result = $this->query($query);
	}
	
	function get_user_list($type=2){
		$query = "SELECT * FROM user_member WHERE usertype IN ({$type})";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function user_check($user){
		$query = "SELECT count(username) as count FROM user_member WHERE username LIKE '{$user}'";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function input_usr($data){

		if($data['action'] == 'insert'){
			$query = "INSERT INTO  
						user_member (username,password,usertype,image_profile,nickname,name,email,description,n_status)
					VALUES
						('".$data['username']."','".$data['password']."','".$data['usertype']."','".$data['image']."','".$data['nickname']."','".$data['nickname']."','".
							$data['email']."','".$data['description']."','".$data['n_status']."')";

		} else {
			$query = "UPDATE user_member
						SET 
							password = '{$data['password']}',
							usertype = '{$data['usertype']}',
							image_profile = '{$data['image']}',
							nickname = '{$data['nickname']}',
							name = '{$data['nickname']}',
							email = '{$data['email']}',
							description = '{$data['description']}',
							n_status = '{$data['n_status']}'
						WHERE
							id = '{$data['id']}'";
		}
		
		$result = $this->query($query);
		
		return $result;
	}
	
	function usrmember_del($id){
		$query = "DELETE FROM user_member WHERE id = {$id}";
		
		$result = $this->query($query);
	}
	
	function get_usr_id($id){
		$query = "SELECT * FROM user_member WHERE id = {$id}";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
}
?>