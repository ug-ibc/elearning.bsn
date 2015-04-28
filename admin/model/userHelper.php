<?php
class userHelper extends Database {
	
    function __construct()
    {
        $session = new Session;
        $getSessi = $session->get_session();
        $this->user = $getSessi['ses_user']['login'];
    }


    function getListUser($data=false, $debug=false)
    {

        $id = $data['id'];

        $sql = array(
                    'table' =>'social_member',
                    'field' => "*",
                    'condition' => "id = {$id}",
                    'limit' => 1
                );
        // $sqlu = "UPDATE social_member SET last_login = '{$lastLogin}' ,login_count = {$loginCount} WHERE id = {$res['id']} LIMIT 1";
        $result = $this->lazyQuery($sql);
        if ($result) return $result;
        return false;

    }


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
        $user = $ses_user['ses_user'];                
             
        $sql = "UPDATE `person` SET `name` = '".$data['name']."', `email` = '".$data['email']."', `project` = '".$data['project']."', `institutions` = '".$data['institutions']."', `twitter` = $dataTwitter, `website` = $dataWeb, `phone` = $dataPhone WHERE `id` = '".$user['login']['id']."' ";
        $res = $this->query($sql,0);
        $sql2 = "UPDATE `florakb_person` SET `username` = '".$data['username']."' WHERE `id` = '".$user['login']['id']."' ";
        $res2 = $this->query($sql2,1);
        if($res && $res2){return true;}
    }
    
    function editPassword($data=false){
        if($data==false) return false;
        
        global $CONFIG;
		$salt = $CONFIG['default']['salt'];
		$password = sha1($data['newPassword'].$salt);
        
        $session = new Session;
        $ses_user = $session->get_session();
        $user = $ses_user['ses_user'];
        
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
    function getUserData($id=false,$data=false){

        $filter = "";
        if(!$id==false) $filter = " AND id = {$id}";
        $sql = "SELECT * FROM `social_member` WHERE 1";
        $res = $this->fetch($sql,1);  
        if(empty($res)){return false;}
        return $res; 
    }
    
    /**
     * @todo get data user/person app
     * 
     * @param $data = 
     * @param $field =  field name
     */
    function getUserappData($field,$data){
        if($data==false) return false;
        $sql = "SELECT * FROM `florakb_person` WHERE `$field` = '".$data."' ";
        $res = $this->fetch($sql,0,1);  
        if(empty($res)){return false;}
        return $res; 
    }

    function storeUserUploadLog($data=null, $filename=null)
    {

        $userid = $this->user['id'];
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `florakb_upload_log` (userid, filename, `desc`, upload_date) 
                VALUES ({$userid}, '{$filename}', '{$data}', '{$date}')";
        // pr($sql);
        $res = $this->query($sql,1);  
        if ($res) return true;
        return false;
    }

    function addUser($data=array())
    {

        if($data==false) return false;

        foreach ($data as $key => $value) {
            
            $tmpfield[] = "`$key`";
            $tmpdata[]= "'".$value."'";
            
        }

        $field = implode(',',$tmpfield);
        $data = implode(',',$tmpdata);
        
        $sql = "INSERT INTO social_member ({$field}) 
                VALUES ({$data})";
        // pr($sql);
        // exit;
        $res = $this->query($sql);
        if ($res) return true;
        return false;
    }

    function updateUser($data=false,$n_status=0)
    {

        if (empty($data)) return false;

        
        
        $sql = "UPDATE social_member SET n_status = {$n_status} WHERE id IN ({$data}) LIMIT 1";
        pr($sql);
        $res = $this->query($sql);
        if ($res) return true;
        return false;
    }
}
?>