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
}
?>