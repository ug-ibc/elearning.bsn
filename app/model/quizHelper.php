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

    function getQuiz($idKursus, $idMateri, $n_status=1)
    {

        if (!$idKursus) return false;
        if (!$idMateri) return false;

        $sql = array(
                'table'=>"banksoal ",
                'field'=>"*",
                'condition' => " idKursus = {$idKursus} AND idMateri = {$idMateri} AND n_status = {$n_status} ORDER BY RAND()",
                'limit' => '100',
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
    }

    function randomJawaban($soal=array())
    {

        if (!is_array($soal)) return false;

        $listIndex = array('pilihan1','pilihan2','pilihan3','pilihan4');
        
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

}
?>