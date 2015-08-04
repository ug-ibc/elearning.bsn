<?php
/* contoh models */

class helper_model extends Database {
	
	var $user = null;
    var $prefix = "";
	function __construct()
	{
		$session = new Session;
		$getSessi = $session->get_session();
		$this->user = $getSessi[0];

	}
    function getOnlineUser($n_status=1, $debug=0)
    {
        $filter = "";
        $sql = array(
                'table'=>"user",
                'field'=>"COUNT(1) AS total",
                'condition' => "n_status IN ({$n_status}) AND is_online = 1 {$filter}"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }
    
    function getNews($id=false, $categoryid=1, $type=1, $start=0, $limit=5)
    {
        
        $filter = "";
        if ($id) $filter = " AND id = {$id} ";

        $sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
                AND articleType = {$type} {$filter} LIMIT {$start},{$limit}";
        // pr($sql);
        $res = $this->fetch($sql,1);
        if ($res){

            foreach ($res as $key => $value) {
                
                $newData[$key]['title'] = $value['title'];
                $newData[$key]['start'] = date('Y-m-d', strtotime($value['posted_date']));
                $newData[$key]['end'] = date('Y-m-d', strtotime($value['expired_date']));
            }

            // pr($newData);
            return $newData;  
        } 
        return false;
    }

    /*
	function generateEmail($email=false, $username=false,$regfrom=1)
    {
        global $CONFIG, $basedomain;

        if (!$email && !$username) return false;

        $dataArr['email'] = $email;
        $dataArr['username'] = $username;
        $dataArr['token'] = sha1('register'.$email);
        $dataArr['validby'] = sha1(CODEKIR);
        $dataArr['regfrom'] = $regfrom;

        $inflatData = encode(serialize($dataArr));
        logFile($inflatData);


        $return['to'] = $email;
        $return['from'] = $CONFIG['email']['EMAIL_FROM_DEFAULT'];
        $return['subject'] = "[NOTIFICATION]";
        $return['msg'] = "To activate your account please <a href='{$basedomain}login/validate/?ref={$inflatData}'>click here</a>";
        $return['encode'] = $inflatData;

        return $return;
    }

    function emailLog($email=false, $subject='account')
    {
        if (!$email) return false;

        $sql = "SELECT COUNT(1) AS total FROM florakb_mail_log WHERE receipt = '{$email}' 
                AND subject = '{$subject}' AND n_status = 1";
        // pr($sql);
        $res = $this->fetch($sql,1);
        if ($res['total']>0) return true; // true if exist
        return false;
    }

    function getEmailLog($email=false, $subject='account')
    {
        if ($email) $filter = " AND receipt = '{$email}'";
        if ($subject) $filter = " AND subject = '{$subject}'";

        $sql = "SELECT * FROM florakb_mail_log WHERE n_status = 0 {$filter}";
        // pr($sql);
        $res = $this->fetch($sql,1,1);
        if ($res) return $res; // true if exist
        return false;
    }

    function updateEmailLog($update=true, $receipt=false, $subject='account', $n_status=0)
    {
        
        // echo 'masuk';
        $date = date('Y-m-d H:i:s');

        if ($update){
            
            $sql = "UPDATE `florakb_mail_log` SET  n_status = {$n_status} WHERE receipt = '{$receipt}' AND subject = '{$subject}' AND n_status = 0 LIMIT 1";
            // pr($sql);
            logFile($sql);
            
            $res = $this->query($sql,1);  
            logFile($res);
            if ($res) return true;
            return false;

        }else{
            $sql = "INSERT IGNORE INTO `florakb_mail_log` (receipt, subject, send_date, n_status) 
                    VALUES ('{$receipt}', '{$subject}', '{$date}', {$n_status})";
            // pr($sql);
            // logFile($sql);exit;
            $res = $this->query($sql,1);  
            if ($res) return true;
            return false;
        }
        
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
    */
    
    function logActivity($action='surf', $comment=null)
    {
        // $sql = "SELECT id FROM code_activity WHERE activityValue = '{$action}' LIMIT 1 ";
        // $res = $this->fetch($sql,0,1);
        // if ($res){

            $date = date('Y-m-d H:i:s'); 
            $source = $_SERVER['REMOTE_ADDR'];
            $comment = htmlentities($comment, ENT_QUOTES);
            if ($this->user['id']) $userid = $this->user['id'];
            else $userid = 0;
            $ins = "INSERT INTO tbl_activity_log (userID, activity, description, source, datetimes)
                    VALUES ({$userid}, '{$action}', '{$comment}', '{$source}', '{$date}')";
            $result = $this->query($ins);
            // db();
            if ($result) return true;
            return false;
        // }

        // return false;
    }
}
?>
