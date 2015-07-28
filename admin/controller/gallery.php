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
			echo "<script>alert('Album Successfully Created');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
		}
	}

	//Fungsi untuk update gallery
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
		//eksekusi jika melakukan perubahan terhadap album
		else{
				$id_album=$_GET['id_album'];
				$judul = $_POST['nm_album'];
				//upload gambar baru	
				if($_FILES['cover_album']['name']){
					deleteFile($_POST['hiddenFile']);
					$upload = uploadFile('cover_album',false,'image');
					$namafile=$upload['full_name'];
				} else {
					$namafile = $_POST['hiddenFile'];
				}
			$data=$this->models->updatealbum($id_album,$judul,$namafile);
			if($data == 1){
				echo "<script>alert('Album Successfully Update');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
			}
		}
	}

	//fungsi untuk menghapus album
	public function deletealbum(){
		global $CONFIG;
		//mengambil parameter id_news dari view
		$id_album = $_GET['id_album'];
		//melempar id_news ke fungsi deletenews yang ada di model
		$data=$this->models->deletealbum($id_album);
		$data2=$this->models->deletefoto($id_album);
		if($data == 1 && $data2 == 1){
			echo "<script>alert('Album Successfully Delete');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
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
				echo "<script>alert('Picture Successfully Added');window.location.href='".$CONFIG['admin']['base_url']."gallery/getgallery/?id_album=".$id_album."'</script>";
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
				echo "<script>alert('Picture Successfully Added');window.location.href='".$CONFIG['admin']['base_url']."gallery/getgallery/?id_album=".$id_album."'</script>";
				exit;
			}	
		}
	}

	//Fungsi untuk update gallery
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
				$id_album=$_POST['id_album'];
				$id_gallery=$_GET['id_gallery'];
				$judul = $_POST['judul'];
				$deskripsi = $_POST['deskripsi'];
				
			if($_FILES['gambar']['name']){
				deleteFile($_POST['hiddenFile']);
				$upload = uploadFile('gambar',false,'image');
				$namafile=$upload['full_name'];
			} else {
				$namafile = $_POST['hiddenFile'];
			}
			
			$data=$this->models->updategallery($id_gallery,$judul,$deskripsi,$namafile);
			if($data == 1){
				echo "<script>alert('Picture Successfully Update');window.location.href='".$CONFIG['admin']['base_url']."gallery/getgallery/?id_album=".$id_album."'</script>";
			}
		}
	}

	//fungsi untuk menghapus gallery foto
	public function deletegallery(){
		global $CONFIG;
		//mengambil parameter id_news dari view
		$id_gallery = $_GET['id_gallery'];
		//melempar id_news ke fungsi deletenews yang ada di model
		$data=$this->models->deletegallery($id_gallery);
		if($data == 1){
			echo "<script>alert('Picture Successfully Delete');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
		}
		else {pr('gagal');}
	}


}
?>