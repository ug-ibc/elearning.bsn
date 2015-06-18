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
		// pr($query);
	$exec=$this->query($query,0);
	if($exec) return 1;
		else return false;
	}
	

	
	function getQuiz($id=false, $n_status=1, $start=0, $limit=10, $debug=0)
	{
		$sql = array(
                'table'=>"banksoal AS b, kursus AS k, materi AS m, grup_kursus AS gk",
                'field'=>"b.*, k.namakursus, m.namamateri, gk.namagrup",
                'condition' => " b.n_status IN ({$n_status}) ",
                'limit' => "LIMIT {$start},{$limit}",
                'joinmethod' => 'LEFT JOIN',
                'join' => "b.idKursus = k.idKursus, b.idMateri = m.idMateri, b.idGrup_kursus = gk.idGrup_kursus"
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
        return false;
	}

	function get_grupkursus()

	{
		$query = "SELECT * FROM grup_kursus";
		//pr($query);
		$result = $this->fetch($query,1,0);
		return $result;
		}

	function get_kursus($grupid)

	{
		$query = "SELECT * FROM kursus WHERE idKursus = $grupid";
		//pr($query);
		$result = $this->fetch($query,1,0);
		return $result;
		}

	function selectquiz($idSoal)
	{
		//pr($id);
		// SELECT column_name(s)
		// FROM table1
		// JOIN table2
		// ON table1.column_name=table2.column_name;
		$query = "SELECT b.*, gk.namagrup, gk.syaratkelulusan, gk.create_time, k.namakursus FROM banksoal AS b LEFT JOIN grup_kursus AS gk ON b.idGrup_kursus=gk.idGrup_kursus 
				 LEFT JOIN kursus AS k ON b.idKursus = k.idKursus WHERE b.idSoal ='".$idSoal."'";

		$result = $this->fetch($query,0);
		return $result;
	}

	function deletequiz($idSoal)
	{
		//query delete data
		$query = "UPDATE banksoal SET n_status='2' WHERE idSoal = '".$idSoal."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	function updatequiz($idSoal, $soal,$pilihan1,$pilihan2,$pilihan3,$pilihan4,$jenissoal,$keterangan,$jawaban,$kursus,$materi,$groupkursus,$n_status)
	{
		//query insert data
		$query = "UPDATE banksoal SET soal='".$soal."', pilihan1='".$pilihan1."', pilihan2='".$pilihan2."', pilihan3='".$pilihan3."', pilihan4='".$pilihan4."',jenissoal='".$jenissoal."',keterangan='".$keterangan."', jawaban='".$jawaban."',idKursus='".$kursus."',idMateri='".$materi."',idGrup_kursus='".$groupkursus."', n_status = {$n_status} WHERE idSoal = '".$idSoal."'";
		//eksekusi query
		// pr($query);
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}
		
	function getDatakursus($id=false, $tabel=0, $cond=false, $n_status= 1, $debug=0)
	{

		if (!$tabel) return false;

		$arrayTabel = array(0=>'grup_kursus', 1=>'kursus', 2=>'materi');
		$arrayFieldTabel = array(0=>'idGrup_kursus', 1=>'idKursus', 2=>'idMateri');

		$filter = "";
		if ($id) $filter .= " AND {$arrayFieldTabel[$tabel]} = $id ";
		if ($cond) $filter .= " AND {$cond}";

		$sql = array(
                'table'=>"{$arrayTabel[$tabel]}",
                'field'=>"*",
                'condition' => " n_status = {$n_status} {$filter} ",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res) return $res;
	}
}
?>