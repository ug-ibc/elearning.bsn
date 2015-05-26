<?php
class mcourse extends Database {
	
	function asd()
	{

	}
	
	//insert course
	function insert_data($namagrup,$syaratkelulusan,$n_status)
	{
		$query = "INSERT INTO grup_kursus (namagrup,syaratkelulusan,n_status)
				  VALUES ('$namagrup','$syaratkelulusan','$n_status')";
		// echo $query;
		$result = $this->query($query);
		// return $result;
	}
	
	//select course
	function select_data(){
		$query = "SELECT namagrup,syaratkelulusan,n_status,create_time FROM grup_kursus WHERE n_status is not null";
		// pr($query);
		$result = $this->fetch($query,1);
		
		return $result;
	
	}
}
?>