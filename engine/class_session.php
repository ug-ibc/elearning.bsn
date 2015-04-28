<?php 

/* Hati-hati dengan kelas ini !!!
 * Untuk menjalankan / memanggil fungsi yang ada di kelas ini,
 * pastikan sesi sudah diaktifkan dengan cara sesion_start()
 *
 * class Name : Session
 * Variable Input Type: Array 
 * Return Value : true / false
 * Location : root_path/function/class/class_session.php
 * Created By : Ovan Cop
 * Date : 2012-07-31
 */

 
class Session
{
	protected $session;
	
	public function set_admin_session($name, $data)
	{
		
		$_SESSION['ses_aid'] = session_id();
		
		$count = 0;
		foreach ($name as $value) {
			$_SESSION[$value] = $data[$count];
			
			$count++;
		}
		/*
		$_SESSION['ses_aoperatorid'] = $data['OperatorID'];
		$_SESSION['ses_aname'] = $data['UserNm'];
		$_SESSION['ses_aaksesadmin'] = $data['AksesAdmin'];
		$_SESSION['ses_asatkerid'] = $data['Satker_ID'];
		$_SESSION['ses_anamaoperator'] = $data['NamaOperator'];
		$_SESSION['ses_ajabatan'] = $data['JabatanOperator'];
		$_SESSION['ses_ahakakses'] = $data['Hak_Akses'];
		$_SESSION['ses_ashowmenu'] = $dataGroup['groupShowMenu'];
		$_SESSION['ses_ajabatanaksesmenu'] = $dataGroup['groupAccessMenu'];
		$_SESSION['ses_atoken'] = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');
		*/
		
		return true;
	}
	
	public function set_user_session($data, $dataGroup)
	{
		$_SESSION['ses_uid'] = session_id();
                $_SESSION['ses_uoperatorid'] = $data['OperatorID'];
                $_SESSION['ses_uname'] = $data['UserNm'];
                $_SESSION['ses_uaksesadmin'] = $data['AksesAdmin'];
                $_SESSION['ses_usatkerid'] = $data['Satker_ID'];
                $_SESSION['ses_unamaoperator'] = $data['NamaOperator'];
                $_SESSION['ses_ujabatan'] = $data['JabatanOperator'];
                $_SESSION['ses_uhakakses'] = $data['Hak_Akses'];
                $_SESSION['ses_ushowmenu'] = $dataGroup['groupShowMenu'];
                $_SESSION['ses_ujabatanaksesmenu'] = $dataGroup['groupAccessMenu'];
		$_SESSION['ses_utoken'] = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');
		
		
		return true;
	}
	
	public function set_session($dataSesion=false, $sessName=false)
	{
		global $CONFIG;
		if (array_key_exists('admin', $CONFIG)){
			$configkey = 'admin';
		}
		if (array_key_exists('default', $CONFIG)){
			$configkey = 'default';
		}

		$uniqSess = sha1($CONFIG[$configkey]['root_path'].'codekir-v0.1');

		if ($sessName){
			$_SESSION[$uniqSess][$sessName] = encode($dataSesion);
		}else{
			
			// default session App
			
			$_SESSION[$uniqSess][$configkey] = encode($dataSesion);
		}
		
		
		return true;
	}
	
	public function get_session($sessName=false)
	{
		global $CONFIG;
		
		if (array_key_exists('admin', $CONFIG)){
			$configkey = 'admin';
		}
		if (array_key_exists('default', $CONFIG)){
			$configkey = 'default';
		}
		
		$session = false;
		
		$uniqSess = sha1($CONFIG[$configkey]['root_path'].'codekir-v0.1');

		if ($sessName){
			$session[$sessName] = @$_SESSION[$uniqSess];
		}else{
			
			if (isset($_SESSION[$uniqSess])) $session = $_SESSION[$uniqSess];
		}
		
		
		return decode($session[$configkey]);
	}
    
    public function delete_session($sessName=false)
	{
		global $CONFIG;
		
        if(!$sessName)return false;
        
		if (array_key_exists('admin', $CONFIG)){
			$configkey = 'admin';
		}
		if (array_key_exists('default', $CONFIG)){
			$configkey = 'default';
		}
		
		$session = false;
		
		$uniqSess = sha1($CONFIG[$configkey]['root_path'].'codekir-v0.1');
        
        unset($_SESSION[$uniqSess][$sessName]);
		
		return true;
	}
	
	public function get_session_admin()
	{
		
		$sessionAdmin['ses_aid'] = $_SESSION['ses_aid'];
		$sessionAdmin['ses_aoperatorid'] = $_SESSION['ses_aoperatorid'];
		$sessionAdmin['ses_aname'] = $_SESSION['ses_aname'];
		$sessionAdmin['ses_aaksesadmin'] = $_SESSION['ses_aaksesadmin'];
		$sessionAdmin['ses_asatkerid'] = $_SESSION['ses_asatkerid'];
		$sessionAdmin['ses_anamaoperator'] = $_SESSION['ses_anamaoperator'];
		$sessionAdmin['ses_ajabatan'] = $_SESSION['ses_ajabatan'];
		$sessionAdmin['ses_ahakakses'] = $_SESSION['ses_ahakakses'];
		$sessionAdmin['ses_ashowmenu'] = $_SESSION['ses_ashowmenu'];
		$sessionAdmin['ses_ajabatanaksesmenu'] = $_SESSION['ses_ajabatanaksesmenu'];
		$sessionAdmin['ses_atoken'] = $_SESSION['ses_atoken'];
		
		return $sessionAdmin;
	}
	
	function get_session_user()
	{
		
		$sessionUser['ses_uid'] = '123';
		// $sessionUser['ses_uoperatorid'] = $_SESSION['ses_uoperatorid'];
		// $sessionUser['ses_uname'] = $_SESSION['ses_uname'];
		// $sessionUser['ses_uaksesadmin'] = $_SESSION['ses_uaksesadmin'];
		// $sessionUser['ses_usatkerid'] = $_SESSION['ses_usatkerid'];
		// $sessionUser['ses_unamaoperator'] = $_SESSION['ses_unamaoperator'];
		// $sessionUser['ses_ujabatan'] = $_SESSION['ses_ujabatan'];
		// $sessionUser['ses_uhakakses'] = $_SESSION['ses_uhakakses'];
		// $sessionUser['ses_ushowmenu'] = $_SESSION['ses_ushowmenu'];
		// $sessionUser['ses_ujabatanaksesmenu'] = $_SESSION['ses_ujabatanaksesmenu'];
		
		return $sessionUser;
	}
}


?>
