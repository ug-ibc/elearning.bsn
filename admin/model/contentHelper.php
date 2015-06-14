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

	function getLaporanKemasan($data, $debug=false)
	{
		$id = $data['id'];
		$n_status = $data['n_status'];

		$filter = "";
		
		if ($id) $filter = " AND k.id = {$id}";

		$sql = array(
                'table'=>"{$this->prefix}_pelaporan_kemasan AS k, {$this->prefix}_industri AS i , {$this->prefix}_product AS p, {$this->prefix}_industri_pabrik AS ip",
                'field'=>"k.*, i.namaIndustri, i.noTelepon, i.noFax, i.namaPimpinan, p.merek, ip.noNPPBKC, ip.namaJalan",
                'condition' => "k.pabrikID != 0 AND k.n_status IN ({$n_status}) {$filter}",
                'limit' => '100',
                'joinmethod' => 'LEFT JOIN',
                'join' => 'k.industriID = i.id, k.merek = p.id, k.pabrikID = ip.id'
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
		return false;

	}

	

}
?>