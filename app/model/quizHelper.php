<?php

class quizHelper extends Database {
	
	var $prefix = "";
	var $salt = "";
	function __construct()
	{
		// $this->db = new Database;
		$this->salt = "ovancop1234";
		$this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
		$this->date = date('Y-m-d H:i:s');

	}

    function getQuiz($idKursus, $idMateri, $start=0, $limit=5, $n_status=1)
    {

        if (!$idKursus) return false;
        if (!$idMateri) return false;

        $sql = array(
                'table'=>"banksoal ",
                'field'=>"*",
                'condition' => " idKursus = {$idKursus} AND idMateri = {$idMateri} AND n_status = {$n_status} ORDER BY RAND()",
                'limit' => "LIMIT {$start},{$limit}",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function randomJawaban($soal=array())
    {

        if (!is_array($soal)) return false;

        $listNo = "1234";
        $listArray = array();
        
        do {
            $leter = substr(str_shuffle($listNo), 0, 1);
            if (!in_array($leter, $listArray)) $listArray[] = $leter;
            $countArray = count($listArray);
            
        } while ($countArray <= 3);

        $dataArrSoal = array();

        if ($listArray){
            foreach ($listArray as $key => $value) {
                
                $soal['acakpilihan'][$value] = $soal['pilihan'.$value]; 
            }
        }

        return $soal;
    }

    function userAnswer($idKursus, $idMateri, $idSoal, $jawabanuser)
    {
        
        if (!$idKursus or !$idMateri or !$idSoal or !$jawabanuser) return false;

        $goodAnswer = $this->getGoodAnswer($idSoal);
        $jawaban = $goodAnswer[0]['jawaban'];
        $date = date('Y-m-d H:i:s');
        $idUser = 1;

        $sql = "INSERT INTO soal (idSoal, idKursus, idMateri, idUser, jawaban, jawabanuser, attempt_date, n_status) 
                VALUES ({$idSoal}, {$idKursus}, {$idMateri}, {$idUser}, {$jawaban}, {$jawabanuser}, '{$date}', 1)
                ON DUPLICATE KEY UPDATE jawabanuser = {$jawabanuser}";
        /*
        $sql = array(
                'table'=>"soal ",
                'field'=>"idSoal, idKursus, idMateri, idUser, jawaban, jawabanuser, attempt_date, n_status",
                'value' => "{$idSoal}, {$idKursus}, {$idMateri}, {$idUser}, {$jawaban}, {$jawabanuser}, '{$date}', 1",
                );

        $res = $this->lazyQuery($sql,$debug,1);*/
        $res = $this->query($sql);
        if ($res) return $res;
        return false;
    }

    function getGoodAnswer($idSoal, $n_status=1)
    {
        $sql = array(
                'table'=>"banksoal",
                'field'=>"*",
                'condition' => " idSoal = {$idSoal} AND n_status = {$n_status}",
                'limit' => "LIMIT 1",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function getUserAnswer($idKursus, $idMateri, $n_status=1)
    {

        $idUser = 1;
        $sql = array(
                'table'=>"soal",
                'field'=>"idSoal, jawabanuser",
                'condition' => " idUser = {$idUser} AND idKursus = {$idKursus} AND idMateri = {$idMateri} AND n_status = {$n_status}",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }
}
?>