<?php
class mcourse extends Database {
	
	function asd()
	{

	}
	
	//insert course with ajax
	function insert_data($namagrup,$syaratkelulusan,$n_status)
	{
		$query = "INSERT INTO grup_kursus (namagrup,syaratkelulusan,n_status)
				  VALUES ('$namagrup','$syaratkelulusan','$n_status')";
		// echo $query;
		$result = $this->query($query);
		// return $result;
	}
	
	//select course with ajax
	function edit_data($idGrup_kursus){
		$query = "SELECT namagrup,syaratkelulusan FROM grup_kursus WHERE idGrup_kursus = '$idGrup_kursus' ";
		// $query = "SELECT namagrup FROM grup_kursus WHERE idGrup_kursus = '$idGrup_kursus' ";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	
	}
	
	//update course with ajax with id
	function update_data($id,$namagrup,$syaratkelulusan){
		$query = "UPDATE grup_kursus
						SET 
							namagrup = '{$namagrup}',
							syaratkelulusan = '{$syaratkelulusan}'
						WHERE
							idGrup_kursus = '{$id}'";
		$result = $this->query($query);					
	}
	
	//update course with ajax with id
	function update_status($id,$n_status){
		$query = "UPDATE grup_kursus
						SET 
							n_status = '{$n_status}'
						WHERE
							idGrup_kursus = '{$id}'";
		$result = $this->query($query);					
	}
	
	//delete course with ajax with id
	function delete_data($id,$n_status){
		$query = "UPDATE grup_kursus
						SET 
							n_status = '{$n_status}'
						WHERE
							idGrup_kursus in ({$id})";
		echo $query;					
		$result = $this->query($query);					
	}
	
	
	//select group course
	function select_data(){
		$query = "SELECT idGrup_kursus,namagrup,syaratkelulusan,n_status,create_time FROM grup_kursus WHERE n_status != '2'";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	
	}
	
	//select course
	function select_data_course(){
		$query = "SELECT idGrup_kursus,namagrup FROM grup_kursus WHERE n_status != '2'";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function course_insert($x){
		if($x['action'] == 'insert'){
			$n_status = '1';
			$query = "INSERT INTO kursus (namakursus,keterangan,jeniskursus,start_date,end_date,quota,idGrup_kursus,n_status)
				  VALUES ('$x[namakursus]','$x[keterangan]','$x[jeniskursus]','$x[start_date]','$x[end_date]',
				  '$x[quota]','$x[idGrup_kursus]',$n_status)";
			// echo $query;
			// exit;
			$result = $this->query($query);	
		}else{
			//update here
		}
	}
	
	function select_data_list_course(){
		$query = "SELECT idKursus,namakursus,keterangan,jeniskursus,start_date,end_date,quota,idGrup_kursus,n_status FROM kursus WHERE n_status != '2'";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	function select_data_list_group(){
		$query = "SELECT idGrup_kursus,namagrup FROM grup_kursus WHERE n_status != '2'";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
	
	
}
?>