<?php
class mnews extends Database{

	//fungsi untuk eksekusi penyimpanan data news ke database
	function inputnews($judul,$brief,$author,$isi,$publish,$status)
	{
		//query insert data
		$query = "INSERT INTO news (judul,brief,author,isi,status,posted)
					VALUES('".$judul."','".$brief."','".$author."','".$isi."','".$status."','".$publish."')";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	//fungsi unt
	function getnews()
	{
		//query memanggil data
		$query = "SELECT * FROM news WHERE status in ('0','1','2') ";
		//pr($query);
		//memanggil semua data. Jika hanya memanggil 1 data ->fetch($query,0,0)
		$result = $this->fetch($query,1,0);
		return $result;
	}
	
	function selectnews($id_news)
	{
		//pr($id);
		$query = "SELECT * FROM news WHERE id_news ='".$id_news."'";

		$result = $this->fetch($query,0,0);
		return $result;

	}

	function deletenews($id_news)
	{
		//query insert data
		$query = "UPDATE news SET status='4' WHERE id_news = '".$id_news."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	function updatenews($id_news, $judul,$brief,$author,$isi,$publish,$status)
	{
		//query insert data
		$query = "UPDATE news SET judul='".$judul."', brief='".$brief."', author='".$author."', isi='".$isi."', posted='".$publish."',status='".$status."' WHERE id_news = '".$id_news."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}
}
?>