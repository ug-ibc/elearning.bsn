<?php
class userHelper extends Database {
	
    function __construct()
    {   
        global $CONFIG;
        $session = new Session;
        $getSessi = $session->get_session();
        // pr($getSessi);
        $this->user = $getSessi[0];
        $this->salt = $CONFIG['default']['salt'];
        $this->prefix = "lelang";
    }
    
    
    

    /**
     * @todo edit user profile, update user data from inputed data
     */
    function editProfile($data=false){
        if($data==false) return false;
        
        if (empty($data['twitter'])){
            $dataTwitter = 'NULL';
        }else{
            $dataTwitter = "'".$data['twitter']."'";
        }
        
        if (empty($data['website'])){
            $dataWeb = 'NULL';
        }else{
            $dataWeb = "'".$data['website']."'";
        }
        
        if (empty($data['phone'])){
            $dataPhone = 'NULL';
        }else{
            $dataPhone = "'".$data['phone']."'";
        }
        
        $session = new Session;
        $ses_user = $session->get_session();
        $user = $ses_user;                
             
        $sql = "UPDATE `person` SET `name` = '".$data['name']."', `email` = '".$data['email']."', `project` = '".$data['project']."', `institutions` = '".$data['institutions']."', `twitter` = $dataTwitter, `website` = $dataWeb, `phone` = $dataPhone WHERE `id` = '".$user['login']['id']."' ";
        $res = $this->query($sql,0);
        //$sql2 = "UPDATE `florakb_person` SET `username` = '".$data['username']."' WHERE `id` = '".$user['login']['id']."' ";
        //$res2 = $this->query($sql2,1);
        //if($res && $res2){return true;}
        if($res){return true;}
    }
    
    /**
     * @todo edit user password
     */
    function editPassword($data=false){
        if($data==false) return false;
        
        global $CONFIG;
		$salt = $CONFIG['default']['salt'];
		$password = sha1($data['newPassword'].$salt);
        
        $session = new Session;
        $ses_user = $session->get_session();
        $user = $ses_user;
        
        $sql = "UPDATE `florakb_person` SET `password` = '".$password."', `salt` = '".$salt."' WHERE `id` = '".$user['login']['id']."' ";
        $res = $this->query($sql,1);
        if($res){return true;}
    }
    
    /**
     * @todo get data user/person
     * 
     * @param $data = 
     * @param $field =  field name
     */
    function getUserData($field,$data){
        if($data==false) return false;
        $sql = "SELECT * FROM `person` WHERE `$field` = '".$data."' ";
        $res = $this->fetch($sql,0);  
        if(empty($res)){return false;}
        return $res; 
    }
    
    /**
     * @todo get data user/person app
     * 
     * @param $data = 
     * @param $field =  field name
     */
    function getUserappData($field,$data,$n_status=0){
        if($data==false) return false;
        $filter = "";
        if ($n_status) $filter = " AND n_status = {$n_status}";

        $sql = "SELECT * FROM `florakb_person` WHERE `$field` = '".$data."' {$filter}";
        $res = $this->fetch($sql,0,1);  
        if(empty($res)){return false;}
        return $res; 
    }

    function validateEmail($email, $debug=false)
    {

        $sql = array(
                'table'=>'social_member',
                'field'=>"COUNT(email) AS total",
                'condition' => "email = '{$email}'",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res[0]['total']>0) return true;
        return false;

    } 
}
?>