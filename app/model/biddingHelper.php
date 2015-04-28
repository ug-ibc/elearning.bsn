<?php
class biddingHelper extends Database {
	
	var $prefix = "lelang";
	var $salt = "";
	
    function __construct()
	{
		// $this->db = new Database;
		$this->salt = "ovancop1234";
		$this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
		$this->date = date('Y-m-d H:i:s');

        $sessionUser = new Session;
	    // $this->user = $sessionUser->getUser();
    }

    function isMemberAllowToBidding($userid=false,$debug=false)
    {

        $filter = "";
        if ($userid) $filter .= " AND id = {$userid}";

        $sql = array(
                'table'=>'social_member',
                'field'=>"*",
                'condition' => "verified = 1 AND n_status = 1 {$filter}",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res){
            return $res;
        }

        return false;
    }

    function bidding()
    {
        
    }
}
?>