<?php
/* contoh models */

class helper_model extends Database {
	
	var $user;
	function __construct()
	{
		$sessi = new Session;
		$getUserSes = $sessi->get_session('login');
		$this->user = $getUserSes['login']['login'];
		$this->prefix = "lelang"; 
	}

	public function getData_sel($parameter){
			
			if($parameter['status'] == "true"){
				if($parameter['condition'] != ""){
					$bindCur = ",:friend_cv";
				}else{
					$bindCur = ":friend_cv";
				}
			} else {
				$bindCur = "";
			}
            
			$data['sql'] = "begin ".$parameter['package']."(".$parameter['condition']." ".$bindCur."); end;";
			$data['condition'] = $parameter['condition'];
			$data['value'] = $parameter['value'];
			
			$hasil = $this->fecthData($data,true);
			
			return $hasil;
			
    }

    function logActivity($action='surf', $comment=null)
    {
    	$sql = "SELECT id FROM code_activity WHERE activityValue = '{$action}' LIMIT 1 ";
    	$res = $this->fetch($sql,0,1);
    	if ($res){

    		$date = date('Y-m-d H:i:s'); 
    		$source = $_SERVER['REMOTE_ADDR'];
    		$comment = htmlentities($comment, ENT_QUOTES);
    		
    		$ins = "INSERT INTO code_activity_log (userid, activityId, activityDesc, source, datetimes, n_status)
    				VALUES ({$this->user['id']}, {$res['id']}, '{$comment}', '{$source}', '{$date}',1)";
    		$result = $this->query($ins,1);

    		if ($result) return true;
    		return false;
    	}

    	return false;
    }

    function getMenu($data=false, $debug=false)
    {

    	$sql = array(
                'table'=>"tbl_user_menu_parent AS p",
                'field'=>"p.*",
                'condition' => "1 ORDER BY menuOrder",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res){

        	foreach ($res as $key => $value) {
        		$sql = array(
	                'table'=>"tbl_user_menu AS m",
	                'field'=>"m.*",
	                'condition' => "menuStatus = 1 AND menuParent = {$value['menuParentID']}",
	                );

	        	$result[$value['menuParentDesc']] = $this->lazyQuery($sql,$debug);
        	}
        	// pr($result);

        }

        
        $sql = array(
                'table'=>"admin_member AS a",
                'field'=>"a.menu_akses",
                'condition' => "1 AND id = {$data['userid']}",
                );

        $menuuser = $this->lazyQuery($sql,$debug);

        $datamenu['menu'] = $result;
        $datamenu['akses_user'] = $menuuser;
        // pr($datamenu);
        if ($datamenu) return $datamenu;
		return false;
    }
}
?>
