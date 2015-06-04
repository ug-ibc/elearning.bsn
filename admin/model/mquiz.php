<?php
class mquiz extends Database {
	
	//var $prefix = "lelang";
	
	function inputquiz($soal,$pilihan1,$pilihan2,$pilihan3,$pilihan4,$jenissoal,$keterangan,$jawaban,$kursus,$materi,$groupkursus, $quizstatus)
	{
		$query = "INSERT INTO banksoal (soal,pilihan1,pilihan2,pilihan3,pilihan4,jenissoal,keterangan,jawaban,idKursus,idMateri,idGrup_kursus, n_status)
					VALUES
						('".$soal."','".$pilihan1."','".$pilihan2."','".$pilihan3."'
							,'".$pilihan4."','".$jenissoal."','".$keterangan."','".$jawaban."'
							,'".$kursus."','".$materi."','".$groupkursus."', {$quizstatus})";

	$exec=$this->query($query,0);
	if($exec) return 1;
		else return false;
	}
	
	function get_quizlist()
	function getQuiz($id=false, $n_status=1, $start=0, $limit=10, $debug=0)
	{
		$sql = array(
                'table'=>"banksoal AS b, kursus AS k, materi AS m",
                'field'=>"b.*, k.namakursus, m.namamateri",
                'condition' => " b.n_status IN ({$n_status}) ",
                'limit' => "LIMIT {$start},{$limit}",
                'joinmethod' => 'LEFT JOIN',
                'join' => "b.idKursus = k.idKursus, b.idMateri = m.idMateri"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
	}

	function get_article($type=1)
	{
		$query = "SELECT * FROM banksoal;";
		//pr($query);
		$result = $this->fetch($query,1,0);
		return $result;
		}
		
}
?>