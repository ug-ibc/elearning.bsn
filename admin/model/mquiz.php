<?php
class mquiz extends Database {
	
	//var $prefix = "lelang";
	
	function inputquiz($soal,$pilihan1,$pilihan2,$pilihan3,$pilihan4,$jenissoal,$keterangan,$jawaban,$kursus,$materi,$groupkursus)
	{
		$query = "INSERT INTO banksoal (soal,pilihan1,pilihan2,pilihan3,pilihan4,jenissoal,keterangan,jawaban,idKursus,idMateri,idGrup_kursus)
					VALUES
						('".$soal."','".$pilihan1."','".$pilihan2."','".$pilihan3."'
							,'".$pilihan4."','".$jenissoal."','".$keterangan."','".$jawaban."'
							,'".$kursus."','".$materi."','".$groupkursus."')";

	$exec=$this->query($query,0);
	if($exec) return 1;
		else pr('query gagal');
	}
	
	function get_quizlist()
	{
		$query = "SELECT * FROM banksoal;";
		//pr($query);
		$result = $this->fetch($query,1,0);
		return $result;
		}
		
}
?>