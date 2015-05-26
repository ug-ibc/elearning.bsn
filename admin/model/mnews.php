<?php
class mnews extends Database{

	//fungsi untuk eksekusi penyimpanan data news ke database
	function inputnews($judul,$brief,$namafile,$isi,$author,$publish,$status)
	{
		//query insert data
		$query = "INSERT INTO news (judul,brief,gambar,author,isi,status,posted)
					VALUES('".$judul."','".$brief."','".$namafile."','".$author."','".$isi."','".$status."','".$publish."')";
		//pr($author); exit;
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	//fungsi unt
	function getnews()
	{
		//query memanggil data

		$query = "SELECT news.id_news, news.judul, news.author, news.posted, news.gambar, news.brief, news.status, user.username from news, user where news.author = user.idUser && news.status in ('0','1')";
		//pr($query);
		//$query = "SELECT * FROM news WHERE status in ('0','1') ";
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
		$query = "UPDATE news SET status='2' WHERE id_news = '".$id_news."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	function updatenews($id_news, $judul,$brief,$namafile,$isi,$publish,$status)
	{
		//query insert data
		$query = "UPDATE news SET judul='".$judul."', brief='".$brief."', gambar='".$namafile."', isi='".$isi."', posted='".$publish."',status='".$status."' WHERE id_news = '".$id_news."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}
}
?>