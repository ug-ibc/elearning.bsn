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


//fungsi untuk merubah data news
	public function editalbum(){
		global $CONFIG;
		$id_album = $_GET['id_album'];
		//kondisi apabila tidak melakukan perubahan
		if ($_POST == null){	
			$data=$this->models->selectalbum($id_album);
			if ($data){	
				$this->view->assign('data',$data);
			}	
			return $this->loadView('gallery/editalbum');	
		}
		//eksekusi jika melakukan perubahan terhadap data news
		else{
			//pr ($_FILES['cover_album']);exit;

				if (empty($_FILES['cover_album']['name'])){
					$id_album=$_GET['id_album'];
					$judul = $_POST['nm_album'];
					$data=$this->models->updatealbum2($id_album,$judul);
					if($data == 1){
						echo "<script>alert('Data berhasil di perbarui');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
					}
				}		
				elseif (!empty($_FILES['cover_album']['name'])){
					$id_album=$_GET['id_album'];
					$judul = $_POST['nm_album'];
					$upload = uploadFile('cover_album',false,'image');
					// pr($_POST['hiddenFile'];);exit;
					$namafile=$upload['full_name'];
					//pr($namafile);exit;
					//$author = $_POST['author'];
					//$foto = $_POST['hiddenFile'];
					//unlink('localhost/elearning.bsn/public_assets/'.$foto);
					//pr($foto); exit;
					$data=$this->models->updatealbum($id_album,$judul,$namafile);
					if($data == 1){
						echo "<script>alert('Data berhasil di perbarui');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
					}
					
				}
			
			}
	}

		//fungsi untuk menghapus data news
	public function deletealbum(){
		global $CONFIG;
		//mengambil parameter id_news dari view
		$id_album = $_GET['id_album'];
		//melempar id_news ke fungsi deletenews yang ada di model
		$data=$this->models->deletealbum($id_album);
		$data2=$this->models->deletefoto($id_album);
		if($data == 1 && $data2 == 1){
			echo "<script>alert('Data berhasil di hapus');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
		}
		else {pr('gagal');}
	}



//Menampilkan halaman galeri foto sesuai dengan album yang dipilih
public function getgallery(){
	//menangkap parameter id_album dari halaman album
	$id_album=$_GET['id_album'];
	$data=$this->models->getgallery($id_album);
	// if ($data){	
		// $vardata=array("$id_album","$data");
		$vardata['id'] = $id_album;
		$vardata['data'] = $data;
		// pr($vardata);exit;
		$this->view->assign('data',$vardata);
	// }
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

//fungsi untuk merubah data news
	public function editgallery(){
		global $CONFIG;
		$id_gallery = $_GET['id_gallery'];
		//kondisi apabila tidak melakukan perubahan
		if ($_POST == null){	
			$data=$this->models->selectgallery($id_gallery);
			if ($data){	
				$this->view->assign('data',$data);
			}	
			return $this->loadView('gallery/editgallery');	
		}
		//eksekusi jika melakukan perubahan terhadap data news
		else{
			//pr ($_FILES['gambar']);exit;

				if (empty($_FILES['gambar']['name'])){
					$id_gallery=$_GET['id_gallery'];
					$judul = $_POST['judul'];
					$deskripsi = $_POST['deskripsi'];
					$data=$this->models->updategallery2($id_gallery,$judul,$deskripsi);
					if($data == 1){
						echo "<script>alert('Data berhasil di perbarui');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
					}
				}		
				elseif (!empty($_FILES['gambar']['name'])){
					$id_gallery=$_GET['id_gallery'];
					$judul = $_POST['judul'];
					$deskripsi = $_POST['deskripsi'];
					$upload = uploadFile('gambar',false,'image');
					// pr($_POST['hiddenFile'];);exit;
					$namafile=$upload['full_name'];
					//pr($namafile);exit;
					//$author = $_POST['author'];
					//$foto = $_POST['hiddenFile'];
					//unlink('localhost/elearning.bsn/public_assets/'.$foto);
					//pr($foto); exit;
					$data=$this->models->updategallery($id_gallery,$judul,$deskripsi,$namafile);
					if($data == 1){
						echo "<script>alert('Data berhasil di perbarui');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
					}
					
				}
			
			}
	}

		//fungsi untuk menghapus data news
	public function deletegallery(){
		global $CONFIG;
		//mengambil parameter id_news dari view
		$id_gallery = $_GET['id_gallery'];
		//melempar id_news ke fungsi deletenews yang ada di model
		$data=$this->models->deletegallery($id_gallery);
		if($data == 1){
			echo "<script>alert('Data berhasil di hapus');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
		}
		else {pr('gagal');}
	}


}
?>