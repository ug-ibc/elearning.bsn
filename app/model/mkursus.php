<?php
class mkursus extends Database{

	function getGrupKursus(){
		$query = "SELECT * FROM grup_kursus WHERE n_status = '1'";
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			$query = "SELECT COUNT(*) as total FROM kursus WHERE idGrup_kursus = '{$value['idGrup_kursus']}'";
			$res = $this->fetch($query);
			$result[$key]['total'] = $res['total'];
		}

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
}
?>