<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );
class news extends Controller{
var $models = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		$this->view=$this->setSmarty();
	}

	public function loadmodule()
	{
		$this->models=$this->loadModel('mnews');
	}

	//listnews
	public function index(){
		//memanggil fungsi getnews pada model
		$data=$this->models->getnews();
		if ($data){	
			$this->view->assign('data',$data);
		}
		return $this->loadView('news/listnews');
	}

	//fungsi untuk menginput data news dari view
	public function inputnews(){
		global $CONFIG;
		//kondisi untuk mengecek validasi form
		if(isset($_POST['judul']) && isset($_POST['brief']) && isset($_POST['isi'])){
			
			$judul = $_POST['judul'];
			$brief = $_POST['brief'];
			$publish = $_POST['publish'];
			$upload = uploadFile('gambar',false,'image');
			// pr($judul);exit;
			$namafile=$upload['full_name'];
			$status = $_POST['status'];
			//pr($status);exit;
			//$author = $_POST['author'];
			$isi = $_POST['isi'];
			$data=$this->models->inputnews($judul,$brief,$namafile,$isi,$publish,$status);
			//kondisi untuk memberi peringatan proses input berhasil atau tidak
			if($data == 1){
				echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."news'</script>";
			}
		}
		//eksekusi jika validasi form tidak sesuai
		else {pr('gagal');}
	}

	//fungsi untuk menampilkan form input news
	public function addnews(){
		return $this->loadView('news/addnews');	
	}

	//fungsi untuk menghapus data news
	public function deletenews(){
		global $CONFIG;
		//mengambil parameter id_news dari view
		$id_news = $_GET['id_news'];
		//melempar id_news ke fungsi deletenews yang ada di model
		$data=$this->models->deletenews($id_news);
		if($data == 1){
			echo "<script>alert('Data berhasil di hapus');window.location.href='".$CONFIG['admin']['base_url']."news'</script>";
		}
		else {pr('gagal');}
	}

	//fungsi untuk merubah data news
	public function editnews(){
		global $CONFIG;
		$id_news = $_GET['id_news'];
		//kondisi apabila tidak melakukan perubahan
		if ($_POST == null){	
			$data=$this->models->selectnews($id_news);
			if ($data){	
				$this->view->assign('data',$data);
			}	
			return $this->loadView('news/editnews');	
		}
		//eksekusi jika melakukan perubahan terhadap data news
		else{
			$judul = $_POST['judul'];
			$brief = $_POST['brief'];
			$publish = $_POST['publish'];
			$status = $_POST['status'];
			$upload = uploadFile('gambar',false,'image');
			// pr($judul);exit;
			$namafile=$upload['full_name'];
			//$author = $_POST['author'];
			$isi = $_POST['isi'];
			$data=$this->models->updatenews($id_news,$judul,$brief,$namafile,$isi,$publish,$status);
			if($data == 1){
				echo "<script>alert('Data berhasil di perbarui');window.location.href='".$CONFIG['admin']['base_url']."news'</script>";
			}
		}
	}
}
?>