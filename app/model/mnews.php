<?php
class mnews extends Database{

	//fungsi untuk menampilkan dafar news di halaman berita
	function getnews2()
	{
		//query memanggil home
		$query = "SELECT news.id_news, news.judul, news.author, news.posted, news.gambar, news.brief, user.username from news, user where news.author = user.idUser && news.status = 1 limit 3";
		// pr($query);
		//memanggil semua data. Jika hanya memanggil 1 data ->fetch($query,0,0)
		$result = $this->fetch($query,1,0);
		return $result;
	}

	//fungsi untuk menampilkan dafar news di halaman berita
	function getnews()
	{
		//query memanggil data
		$query = "SELECT news.id_news, news.judul, news.author, news.posted, news.gambar, news.brief, user.username from news, user where news.author = user.idUser && news.status = 1 limit 5";
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
}
?>