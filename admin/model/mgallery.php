<?php
class mgallery extends Database{
	
//Fungsi untuk menampilkan data album dari database
	function getalbum()
	{
		//query memanggil data
		$query = "SELECT * FROM album";
		//memanggil semua data. Jika hanya memanggil 1 data ->fetch($query,0,0)
		$result = $this->fetch($query,1,0);
		return $result;
	}

//Fungsi untuk menginput data album ke database
	function inputalbum($nm_album,$namafile)
	{
		$query = "INSERT INTO album(nm_album,cover_album)
					VALUES('".$nm_album."','".$namafile."')";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

//Fungsi untuk menampilkan data galeri dari database
	function getgallery($id_album)
	{
		//query memanggil data
		$query = "SELECT * FROM gallery where id_album='".$id_album."'";
		//memanggil semua data. Jika hanya memanggil 1 data ->fetch($query,0,0)
		$result = $this->fetch($query,1,0);
		return $result;
	}

//Fungsi untuk menginput data album ke database
	function inputgallery($judul,$deskripsi,$namafile,$id_album,$jns_file)
	{

		$query = "INSERT INTO gallery(id_album,nm_gallery,jns_file,path_lokasi,deskripsi)
					VALUES('".$id_album."','".$judul."','".$jns_file."','".$namafile."','".$deskripsi."')";
		//eksekusi query
		logFile($query);
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}
}
?>