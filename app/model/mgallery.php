<?php
class mgallery extends Database{
	
//Fungsi untuk menampilkan data galeri dari database
	function getgallery()
	{
		//query memanggil data
		$query = "SELECT * FROM gallery where jns_file ='Foto' order by id_gallery desc limit 3";
		//memanggil semua data. Jika hanya memanggil 1 data ->fetch($query,0,0)
		$result = $this->fetch($query,1,0);
		return $result;
	}


}
?>