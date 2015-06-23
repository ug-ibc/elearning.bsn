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
        $this->prefix = "";
        $this->date = date('Y-m-d H:i:s');
        $this->token = str_shuffle('1q2w3e4r5t6y7u8i9o0pazsxdcfvgbhnjmkl');
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

    function createAccount($data,$debug=false)
    {

        if ($data['password'] !== $data['repassword']) return false;
        
        $field = array('name','email','username','tempatlahir','tanggallahir','pendidikan','institusi','jenispekerjaan','hp'); 

        foreach ($data as $key => $value) {
            
            if (in_array($key, $field)){
                $tmpF[] = $key;
                $tmpV[] = "'".$value."'";
            }
        }

        $tmpF[] = "register_date";
        $tmpF[] = "type";
        $tmpF[] = "email_token";
        $tmpF[] = "salt";
        $tmpF[] = "password";


        $pass = sha1($this->salt.$data['password'].$this->salt);
        $tmpV[] = "'".$this->date."'";
        $tmpV[] = 2;
        $tmpV[] = "'".$this->token."'";
        $tmpV[] = "'".$this->salt."'";
        $tmpV[] = "'{$pass}'";


        // pr($tmpV);
        $impField = implode(',', $tmpF);
        $impData = implode(',', $tmpV);

        $sql = "INSERT IGNORE INTO user ({$impField}) VALUES ({$impData})";
        // pr($sql);
        // exit;
        /*
        $sql = array(
                'table'=>'user',
                'field'=>"{$impField}",
                'value' => "{$impData}",
                );

        $res = $this->lazyQuery($sql,$debug,1);*/
        $res = $this->query($sql);

        if ($res){

            // echo 'ada';exit;
            // $data = array('email'=>$data['email'], 'token'=>$this->token);
            // $msg = encode(serialize($data));
            // logFile($msg);
            // $html = "klik link berikut ini {$basedomain}register/validate/?ref={$msg}";
            // $send = sendGlobalMail($email,'noreply@pindai.co.id',$html);
            return true;
        } 

        
        return false;

    }

    function logoutUser()
    {


        $sql = array(
                'table'=>"user",
                'field'=>"is_online = 0",
                'condition'=>"idUser = '{$this->user['idUser']}'",
                );

        $result = $this->lazyQuery($sql,$debug,2);
        if ($result) return true;
        return false;
    }
}
?>