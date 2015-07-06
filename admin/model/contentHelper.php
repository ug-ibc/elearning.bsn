<?php
class contentHelper extends Database {
	
	var $prefix = "lelang";

	function getData()
	{
		$sql = "SELECT * FROM code_activity";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function getMessage()
	{
		$sql = "SELECT m.*, um.name,um.email FROM my_message m LEFT JOIN user_member um ON m.receive = um.id ";
		$res = $this->fetch($sql,1);
		if ($res) return $res;
		return false;
	}
	
	function saveMessage($data)
	{
		foreach ($data as $key => $val){
			$tmpfield[] = $key;
			$tmpdata[] = "'$val'";
		}
		// from,to,subject,content,createdate,n_status
		$tmpfield[] = 'fromwho';
		$tmpfield[] = 'createdate';
		$tmpfield[] = 'n_status';
		
		$date = date('Y-m-d H:i:s');
		$tmpdata[] = 0;
		$tmpdata[] = "'{$date}'";
		$tmpdata[] = 1;
		
		$field = implode(',',$tmpfield);
		$data = implode(',',$tmpdata);
		
		$sql = "INSERT INTO my_message ({$field}) 
				VALUES ({$data})";
		// pr($sql);
		// exit;
		$res = $this->query($sql);
		if ($res) return true;
		return false;
	}
	
	function get_user($data)
	{
		$query = "SELECT * FROM user_member WHERE email = '{$data}'";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function importData($name=null)
	{
		$query = "INSERT INTO import (name,n_status) VALUES ('{$name}', 1)";
		// pr($query);
		$result = $this->query($query);
		
		return $result;
	}

	function getRegistrant($n_status=1, $debug=0)
	{
		$filter = "";
		$sql = array(
                'table'=>"user",
                'field'=>"COUNT(1) AS total",
                'condition' => "n_status IN ({$n_status}) {$filter}"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
		return false;
	}

	function getCourse($n_status=1, $debug=0)
	{
		$filter = "";
		$sql = array(
                'table'=>"kursus",
                'field'=>"COUNT(1) AS total",
                'condition' => "n_status IN ({$n_status}) {$filter}"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
		return false;
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

	function getDownloadEbook($n_status=1,$debug=0)
	{
		$filter = "";
		$sql = array(
                'table'=>"file",
                'field'=>"SUM(downloadCount) AS total",
                'condition' => "n_status IN ({$n_status}) {$filter}"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
		return false;
	}

	function quizStatistic()
	{
		$sql = array(
                'table'=>"nilai AS n, grup_kursus AS gk",
                'field'=>"COUNT(n.idUser) AS total, gk.namagrup",
                'joinmethod'=>'LEFT JOIN',
                'join'=>'n.idGroupKursus = gk.idGrup_kursus',
                'condition' => "n.n_status = 1 {$filter}"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
	}

	

}
?>