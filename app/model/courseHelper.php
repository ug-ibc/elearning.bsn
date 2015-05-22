<?php

class courseHelper extends Database {
	
	var $prefix = "";
	var $salt = "";
	function __construct()
	{
		// $this->db = new Database;
		$this->salt = "ovancop1234";
		$this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
		$this->date = date('Y-m-d H:i:s');

	}

    function getCourse($idKursus, $idMateri)
    {

        $n_status = 1;

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

    function randomJawaban($data)
    {
        /*
            array(
                id = 1,
                soal = test,
                jawaban = a,
                pilihan = pilihan a,
                pilihan = pilihan b,
                pilihan = pilihan c,
                pilihan = pilihan d
            )
        */

        foreach ($data as $key => $value) {
            
            
        }
    }
}
?>