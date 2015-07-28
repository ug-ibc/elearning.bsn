<?php
class mwebex extends Database{

	//fungsi untuk eksekusi penyimpanan data news ke database
	function inputwebex($topic,$speaker,$picture,$cover,$schedule,$meeting_number)
	{
		//query insert data
		$query = "INSERT INTO webex (topic,speaker,picture,cover,schedule,meeting_number,status)
					VALUES('".$topic."','".$speaker."','".$picture."','".$cover."','".$schedule."','".$meeting_number."','1')";
		//pr($query); exit;
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	//fungsi unt
	function getwebex()
	{
		//query memanggil data

		$query = "SELECT id_webex, topic, speaker, DATE_FORMAT(schedule,'%d %b %y') as schedule, picture, cover, meeting_number from webex where status= '1'";
		//pr($query);
		//$query = "SELECT * FROM news WHERE status in ('0','1') ";
		//pr($query);
		//memanggil semua data. Jika hanya memanggil 1 data ->fetch($query,0,0)
		$result = $this->fetch($query,1,0);
		return $result;
	}
	
	function selectwebex($id_webex)
	{
		//pr($id);
		$query = "SELECT *,DATE_FORMAT(schedule,'%Y-%m-%d') as schedule FROM webex WHERE id_webex ='".$id_webex."'";

		$result = $this->fetch($query,0,0);
		return $result;

	}

	function deletewebex($id_webex)
	{
		//query insert data
		$query = "UPDATE webex SET status='2' WHERE id_webex = '".$id_webex."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	function updatewebex($id_webex,$topic,$speaker,$picture,$cover,$schedule,$meeting_number)
	{
		//query insert data
		$query = "UPDATE webex SET topic='".$topic."', speaker='".$speaker."', picture='".$picture."', cover='".$cover."', schedule='".$schedule."',meeting_number='".$meeting_number."' WHERE id_webex = '".$id_webex."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}
}
?>