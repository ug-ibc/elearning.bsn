<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );
class gallery extends Controller{
var $models = FALSE;

public function __construct()
{
	parent::__construct();
	$this->loadmodule();
	$this->view=$this->setSmarty();
}

public function loadmodule()
{
	$this->models=$this->loadModel('mgallery');
}

//Menampilkan halaman data album 
public function index(){

	//memanggil fungsi getalbum pada model
	$data=$this->models->getalbum();
	if ($data){	
		$this->view->assign('data',$data);
	}
	return $this->loadView('gallery/listalbum');
}

//Menampilkan halaman form tambah album
public function addalbum(){
	global $CONFIG;
	//pr('masuk');
	return $this->loadView('gallery/addalbum');
}

//Fungsi untuk melempar data dari form tambah album ke model
public function inputalbum(){
	global $CONFIG;
	$nm_album = $_POST['nm_album'];
	$upload = uploadFile('cover_album',false,'image');
	$namafile=$upload['full_name'];
	$data=$this->models->inputalbum($nm_album,$namafile);		
	if($data == 1){
		echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
	}
	
}

//Menampilkan halaman galeri foto sesuai dengan album yang dipilih
public function getgallery(){
	//menangkap parameter id_album dari halaman album
	$id_album=$_GET['id_album'];
	$data=$this->models->getgallery($id_album);
	if ($data){	
		// $vardata=array("$id_album","$data");
		$vardata['id'] = $id_album;
		$vardata['data'] = $data;
		// pr($vardata);exit;
		$this->view->assign('data',$vardata);
	}
	return $this->loadView('gallery/listgallery');
}

//Menampilkan halaman form tambah galeri foto
public function addgallery(){
	global $CONFIG;
	//pr('masuk');
	$id_album=$_GET['id_album'];
	$this->view->assign('data',$id_album);
	return $this->loadView('gallery/addgallery');
}

//Fungsi untuk melempar data dari form tambah galeri foto ke model
public function inputgallery(){
	global $CONFIG;
	$jns_file=$_POST['jns_file'];

	// pr($_POST);exit;
	if ($jns_file == "Foto") {
		$id_album=$_GET['id_album'];
		$judul = $_POST['judul'];
		$deskripsi = $_POST['deskripsi'];
		$upload = uploadFile('gambar',false,'image');
		// pr($judul);exit;
		$namafile=$upload['full_name'];
		$data=$this->models->inputgallery($judul,$deskripsi,$namafile,$id_album,$jns_file);
		// exit;
		if($data == 1){
			//pr('Sukses masuk');
			echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."gallery/getgallery/?id_album=".$id_album."'</script>";
			exit;
		}	
	}
	elseif ($jns_file == "Video") {
		$id_album=$_GET['id_album'];
		$judul = $_POST['judul'];
		$deskripsi = $_POST['deskripsi'];
		$upload = uploadFile('gambar',false,'video');
		pr($upload);
		// pr($_FILES);exit;
		$namafile=$upload['full_name'];
		$data=$this->models->inputgallery($judul,$deskripsi,$namafile,$id_album,$jns_file);
		//exit;
		if($data == 1){
			//pr('Sukses masuk');
			echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."gallery/getgallery/?id_album=".$id_album."'</script>";
			exit;
		}	
	}
}

}
?>