<?php
class importHelper extends Database {
	
	var $prefix = "bpom";
	var $user = "";
	function __construct()
	{
		$usersess = new Session();
		$userArr = $usersess->get_session();
		$this->user = $userArr['admin'];
	}

	function insertTmpData($data=array())
	{
		
		$index = 1;
		foreach ($data as $val) {
			$tmpField = array();
			$tmpData = array();
			foreach ($val as $key => $value) {
				if ($index<=27){
					$tmpField[] = "`".$key."`";
					$tmpData[] = "'".$value."'";	
				}
				$index++;
			}	
			
			$index = 1;
			$tmpField[] = "`session`";
			$tmpData[] = "'".session_id()."'";

			$field = implode(',', $tmpField);
			$value = implode(',', $tmpData);

			$sql[] = "INSERT INTO tmp_import ({$field}) VALUES ({$value})";

		}

		$success = true;
		if ($sql){
			foreach ($sql as $value) {
				// pr($value);
				$res = $this->query($value);
				if (!$res) $success = false;
			}
		}
		// pr($sql);

		if ($success) return true;
		return false;

		exit;

	}

	function getTmpData()
	{
		$sesID = session_id();
		$sql = "SELECT * FROM tmp_import WHERE session = '{$sesID}'";
		$res = $this->fetch($sql,1);

		if ($res) return $res;
		return false;
	}

	function saveData($data=array())
	{

		
		$arrayField = array(5=>'tanggalBeli',
							6=>'lokasiBeli',
							7=>'jenisGambar',
							9=>'luasPeringatan_depan',
							10=>'luasPeringatan_belakang',
							11=>'warnaGambar',
							12=>'evaluasiPeringatan',
							13=>'kadarNikotin',
							14=>'kadarTar',
							15=>'kadarPenulisan_sisi',
							16=>'kadarTulisan',
							17=>'pernyataanUtama',
							18=>'kodeProduksi',
							19=>'tanggalProduksi',
							21=>'pernyataanBatas_aman',
							22=>'pernyataanZat_kimia',
							23=>'kataPromotif',
							24=>'evaluasiInformasi',
							25=>'kesimpulan',
							26=>'tahun',
							27=>'harga');
		foreach ($data['ids'] as $value) {
			$id[] = $value;
		}
		$sesID = session_id();
		$impID = implode(',', $id);
		$sql = "SELECT * FROM tmp_import WHERE session = '{$sesID}' AND id IN ({$impID})";
		// pr($sql);
		$res = $this->fetch($sql,1);
		if ($res){
			
			$impField = array();
			$impData = array();
			
			// pr($res);exit;
			$indexArr = array_keys($arrayField);
			foreach ($res as $value) {
				
				

				$tmpField = array();
				$tmpData = array();

				foreach ($value as $key => $value) {

					if ($key==2){
						$produsen = $this->checkData('bpom_product','merek',$value);
						if ($produsen){
							$tmpField[] = "produkID";
							$tmpData[] = $produsen['id'];
						}
						
					}
					
					
					if (in_array($key, $indexArr)){

						$tmpField[] = $arrayField[$key];

						if ($key==5){
							$expl = explode('-', $value);
							$impl = $expl[0].'-'.$expl[1].'-'.'20'.$expl[2];
							$tmpData[] = "'".date('Y-m-d',strtotime($impl))."'";
						}else{

							if ($key==18){

								$tmpData[] = "'".substr($value,3) ."'";
							}else{

								if ($key==19){
									if ($value=='Tidak Ada'){
										$tmpData[] = "'".$value."'";
									}else{
										
										$tmp = substr($value,5,10);
										$tmpData[] = "'".date('Y-m-d', strtotime($tmp))."'";
									}
									
								}else{
									$tmpData[] = "'".$value."'";
								}
								
							}
						}	
					}
					
				}

				$tmpField[] = "tanggalEvaluasi";
				$tmpField[] = "userid";
				$tmpField[] = "balaiID";
				$tmpField[] = "provinsi";
				$tmpField[] = "n_status";

				$tmpData[] = "'".date('Y-m-d H:i:s')."'";
				$tmpData[] = $this->user['id'];
				$tmpData[] = intval($data['balai']);
				$tmpData[] = "'".$data['provinsi']."'";
				$tmpData[] = 1;

				// pr($tmpField);
				$impField = implode(',', $tmpField);
				$impData = implode(',', $tmpData);

				$query[] = "INSERT INTO {$this->prefix}_evaluasi ({$impField}) VALUES ({$impData})";
				

			}

			// pr($query);
			// exit;
			
			sleep(1);

			if ($query){
				$success = true;
				foreach ($query as  $value) {
					logFile($value);
					$run = $this->query($value);
					if (!$run) $success = false;
				}

				if ($success){

					$del = "DELETE FROM tmp_import WHERE id IN ($impID)";
					$exec = $this->query($del);
					return true;
				}else return false;
			}
		}
		
		return false;
	}

	function checkData($tabel="bpom_product", $field="merek", $data="")
	{


		$sql = "SELECT * FROM {$tabel} WHERE {$field} = '{$data}'";
		// pr($sql);
		$res = $this->fetch($sql);
		if ($res) return $res;
		return false;
	}
	
}
?>