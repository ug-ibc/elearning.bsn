<?php
class mkursus extends Database{

	function getGrupKursus($idUser=false){
		$query = "SELECT * FROM grup_kursus WHERE n_status = '1'";
		$result = $this->fetch($query,1);
		foreach ($result as $key => $value) {
			$query = "SELECT COUNT(*) as total FROM kursus WHERE idGrup_kursus = '{$value['idGrup_kursus']}'";
			$res = $this->fetch($query);
			$result[$key]['total'] = $res['total'];
		}
		foreach ($result as $key => $value) {

			$query = "SELECT n.*,st.kategoriBaik,st.kategoriCukup,st.kategoriKurang FROM nilai as n 
					join tbl_quiz_setting as st on st.idGroupKursus = n.idGroupKursus
					WHERE n.idGroupKursus = '{$value['idGrup_kursus']}' AND n.idUser = '{$idUser['idUser']}' ORDER BY n.idNilai DESC LIMIT 1";
			$res = $this->fetch($query);
			if($res){
				$result[$key]['nilai'] 			= intval($res['nilai']);
				$result[$key]['kodeSertifikat'] = $res['kodeSertifikat'];
				$result[$key]['status_nilai'] 	= intval($res['n_status']);
				$result[$key]['kategoriBaik'] 	= intval($res['kategoriBaik']);
				$result[$key]['kategoriCukup'] 	= intval($res['kategoriCukup']);
				$result[$key]['kategoriKurang'] = intval($res['kategoriKurang']);
				
			}else{
				$result[$key]['nilai'] = 0;
				$result[$key]['status_nilai'] = 0;
			}
		}
		return $result;
	}

	function getCourse($id,$idk)
	{
		$query = "SELECT * FROM grup_kursus WHERE idGrup_kursus = '{$id}' AND n_status = '1'";
		$grup = $this->fetch($query);

		// $query = "SELECT * FROM kursus WHERE idGrup_kursus = '{$id}' AND n_status = '1'";
		$query = "SELECT * FROM kursus WHERE 	idKursus = '{$idk}' AND n_status = '1'";
		$course = $this->fetch($query,1);

		foreach ($course as $key => $value) {
			// $query = "SELECT * FROM materi WHERE idKursus='{$value['idKursus']}' AND idGrup_kursus = '{$id}' AND n_status = '1'";
			$query = "SELECT * FROM materi WHERE idKursus='{$value['idKursus']}'  AND n_status = '1'";
			// echo "query materi =".$query; 
			// echo "<br>";
			$materi = $this->fetch($query,1);
			if($materi){
				foreach ($materi as $key2 => $value) {
					// $query = "SELECT * FROM file WHERE n_status = '1' AND idMateri = '{$value['idMateri']}' AND idKursus='{$value['idKursus']}' AND idGrup_kursus = '{$id}'";
					$query = "SELECT * FROM file WHERE n_status = '1' AND idMateri = '{$value['idMateri']}' AND idKursus='{$value['idKursus']}' ";
					// echo "query file =".$query;
					// echo "<br>";
					$file = $this->fetch($query,1);

					$materi[$key2]['file'] = $file;
					
				}

				$course[$key]['materi'] = $materi;
			}
			
			
		}
		
		$dataArr = array('grup' => $grup , 'course' => $course);
		
		return $dataArr;
	}
	
	function getAllCourse($groupid=false)
	{
		
		$filter = "";
		if ($groupid) $filter .= " AND idGrup_kursus = {$groupid}";
		// $query = "SELECT * FROM kursus WHERE idGrup_kursus = '{$id}' AND n_status = '1'";
		$query = "SELECT * FROM kursus WHERE n_status = '1' {$filter} ORDER BY list_order ASC";
		// pr($query);
		$Allcourse = $this->fetch($query,1);

		return $Allcourse;
	}
	
	function get_group_by_certificate($certificate){
		$query = "SELECT g.idGrup_kursus,g.namagrup FROM grup_kursus as g, nilai as n
					where n.idGroupKursus = g.idGrup_kursus 
					and n.n_status = 1 and g.n_status = 1 and n.kodeSertifikat = '{$certificate}'";	
		$result = $this->fetch($query);
		return $result;
	}
	
	function get_list_course_by_certificate($id_group){
		$query = "SELECT namamateri FROM materi
					where n_status = 1 and idGrup_kursus  ={$id_group}";
		$result = $this->fetch($query,1);
		return $result;
	}
	
	function get_value_by_certificate($id_group,$certificate){
		$query = "SELECT n.nilai,n.idUser,n.kodeSertifikat,n.create_time,
					t.kategoriBaik,t.kategoriCukup,t.kategoriKurang,
					u.name, u.jenispekerjaan
					FROM nilai as n
					join tbl_quiz_setting as t on t.idGroupKursus = n.idGroupKursus
					join user as u on u.idUser = n.idUser
					where n.idGroupKursus  ={$id_group} and n.kodeSertifikat like '$certificate%' order by n.nilai";
		
		$result = $this->fetch($query);
		return $result;
	}
	
	function get_attempt_user($idGroupKursus,$idUser){
		$query = "SELECT count(1) as jml from nilai where idGroupKursus = {$idGroupKursus} and idUser = {$idUser}";
		$result = $this->fetch($query);
		return $result;
	
	
	}
	
}
?>