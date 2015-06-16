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
		$tgl=date('Y-m-d');
		$query = "INSERT INTO album(nm_album,create_date,cover_album)
					VALUES('".$nm_album."','".$tgl."','".$namafile."')";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

	function selectalbum($id_album)
	{
		//pr($id);
		$query = "SELECT *,DATE_FORMAT(create_date,'%Y-%m-%d') as create_date FROM album WHERE id_album ='".$id_album."'";

		$result = $this->fetch($query,0,0);
		return $result;

	}

	function updatealbum($id_album,$judul,$namafile)
	{
		//query insert data
		$query = "UPDATE album SET nm_album='".$judul."', cover_album='".$namafile."' WHERE id_album = '".$id_album."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		//pr ($query);exit;
		if($exec) return 1; else pr('query gagal');
	}

	function updatealbum2($id_album,$judul)
	{
		//query insert data
		$query = "UPDATE album SET nm_album='".$judul."' WHERE id_album = '".$id_album."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		//pr ($query);exit;
		if($exec) return 1; else pr('query gagal');
	}

		function deletealbum($id_album)
	{
		//query insert data
		$query = "Delete FROM album WHERE id_album = '".$id_album."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

		function deletefoto($id_album)
	{
		//query insert data
		$query = "Delete FROM gallery WHERE id_album = '".$id_album."'";
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
		$tgl=date('Y-m-d');
		$query = "INSERT INTO gallery(id_album,nm_gallery,create_date,jns_file,path_lokasi,deskripsi)
					VALUES('".$id_album."','".$judul."','".$tgl."','".$jns_file."','".$namafile."','".$deskripsi."')";
		//eksekusi query
		logFile($query);
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}

		function selectgallery($id_gallery)
	{
		//pr($id);
		$query = "SELECT *,DATE_FORMAT(create_date,'%Y-%m-%d') as create_date FROM gallery WHERE id_gallery ='".$id_gallery."'";

		$result = $this->fetch($query,0,0);
		return $result;

	}

	function updategallery($id_gallery,$judul,$deskripsi,$namafile)
	{
		//query insert data
		$query = "UPDATE gallery SET nm_gallery='".$judul."', deskripsi='".$deskripsi."', path_lokasi='".$namafile."' WHERE id_gallery = '".$id_gallery."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		//pr ($query);exit;
		if($exec) return 1; else pr('query gagal');
	}

	function updategallery2($id_gallery,$judul,$deskripsi)
	{
		//query insert data
		$query = "UPDATE gallery SET nm_gallery='".$judul."', deskripsi='".$deskripsi."' WHERE id_gallery = '".$id_gallery."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		//pr ($query);exit;
		if($exec) return 1; else pr('query gagal');
	}

		function deletegallery($id_gallery)
	{
		//query insert data
		$query = "Delete FROM gallery WHERE id_gallery = '".$id_gallery."'";
		//eksekusi query
		$exec = $this->query($query,0);	
		//kondisi apabila eksekusi berhasil mengembalikan notif 1, jika gagal mencetak query gagal 
		if($exec) return 1; else pr('query gagal');
	}
}
?>