<?php
class mkursus extends Database{

	function getGrupKursus($idUser=false){
		$query = "SELECT * FROM grup_kursus WHERE n_status = '1'";
		$result = $this->fetch($query,1);
// pr($result);
		// pr($idUser);
		foreach ($result as $key => $value) {
			$query = "SELECT COUNT(*) as total FROM kursus WHERE idGrup_kursus = '{$value['idGrup_kursus']}'";
			$res = $this->fetch($query);
			$result[$key]['total'] = $res['total'];
		}
		
		foreach ($result as $key => $value) {
			$query = "SELECT * FROM nilai WHERE idGroupKursus = '{$value['idGrup_kursus']}' AND idUser = '{$idUser['idUser']}' ";
			// pr($query);
			$res = $this->fetch($query);
			if($res){
			// pr($res['nilai']);

			$result[$key]['nilai'] = intval($res['nilai']);
			}
		}
// pr($result);
		return $result;
	}

	function getAllCourse($id)
	{
		$query = "SELECT * FROM grup_kursus WHERE idGrup_kursus = '{$id}' AND n_status = '1'";
		$grup = $this->fetch($query);

		$query = "SELECT * FROM kursus WHERE idGrup_kursus = '{$id}' AND n_status = '1'";
		$course = $this->fetch($query,1);

		foreach ($course as $key => $value) {
			$query = "SELECT * FROM materi WHERE idKursus='{$value['idKursus']}' AND idGrup_kursus = '{$id}' AND n_status = '1'";
			$materi = $this->fetch($query,1);
			if($materi){
				foreach ($materi as $key2 => $value) {
					$query = "SELECT * FROM file WHERE n_status = '1' AND idMateri = '{$value['idMateri']}' AND idKursus='{$value['idKursus']}' AND idGrup_kursus = '{$id}'";
					$file = $this->fetch($query,1);

					$materi[$key2]['file'] = $file;
					
				}

				$course[$key]['materi'] = $materi;
			}
			
			
		}
		
		$dataArr = array('grup' => $grup , 'course' => $course);
		
		return $dataArr;
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
	
	function get_value_by_certificate($id_group){
		$query = "SELECT n.nilai,n.idUser,n.kodeSertifikat,n.create_time,
					t.kategoriBaik,t.kategoriCukup,t.kategoriKurang,
					u.name
					FROM nilai as n
					join tbl_quiz_setting as t on t.idGroupKursus = n.idGroupKursus
					join user as u on u.idUser = n.idUser
					where n.idGroupKursus  ={$id_group}";
		$result = $this->fetch($query);
		return $result;
	}
}
?>