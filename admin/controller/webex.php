<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );
class webex extends Controller{
var $models = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		$this->view=$this->setSmarty();
		$sessionAdmin=New Session();
		$this->admin=$sessionAdmin->get_session();
	}

	public function loadmodule()
	{
		$this->models=$this->loadModel('mwebex');
	}

	//listnews
	public function index(){
		//memanggil fungsi getnews pada model
		//pr($this->admin[idUser]);
		$data=$this->models->getwebex();
		if ($data){	
			$this->view->assign('data',$data);
		}
		return $this->loadView('webex/listwebex');
	}

	//fungsi untuk menginput data news dari view
	public function inputwebex(){
		global $CONFIG;
		//kondisi untuk mengecek validasi form
		if(isset($_POST['topic']) && isset($_POST['speaker']) && isset($_POST['meeting_number']) && isset($_POST['schedule'])){
			$topic = $_POST['topic'];
			$speaker = $_POST['speaker'];
			$upload1 = uploadFile('picture',false,'image');
			// pr($judul);exit;
			$picture=$upload1['full_name'];
			$upload2 = uploadFile('cover',false,'image');
			// pr($judul);exit;
			$cover=$upload2['full_name'];
			$schedule = $_POST['schedule'];
			//pr($status);exit;
			$meeting_number = $_POST['meeting_number'];
			//pr($meeting_number);exit;
			$data=$this->models->inputwebex($topic,$speaker,$picture,$cover,$schedule,$meeting_number);
			//kondisi untuk memberi peringatan proses input berhasil atau tidak
			if($data == 1){
				echo "<script>alert('Data Successfully Created');window.location.href='".$CONFIG['admin']['base_url']."webex'</script>";
			}
		}
		//eksekusi jika validasi form tidak sesuai
		else {pr('gagal');}
	}

	//fungsi untuk menampilkan form input news
	public function addwebex(){
		return $this->loadView('webex/addwebex');	
	}

	//fungsi untuk menghapus data news
	public function deletewebex(){
		global $CONFIG;
		//mengambil parameter id_news dari view
		$id_webex = $_GET['id_webex'];
		//melempar id_news ke fungsi deletenews yang ada di model
		$data=$this->models->deletewebex($id_webex);
		if($data == 1){
			echo "<script>alert('Data Successfully Delete');window.location.href='".$CONFIG['admin']['base_url']."webex'</script>";
		}
		else {pr('gagal');}
	}

	//fungsi untuk merubah data news
	public function editwebex(){
		global $CONFIG;
		$id_webex = $_GET['id_webex'];
		//kondisi apabila tidak melakukan perubahan
		if ($_POST == null){	
			$data=$this->models->selectwebex($id_webex);
			if ($data){	
				$this->view->assign('data',$data);
			}	
			return $this->loadView('webex/editwebex');	
		}
		//eksekusi jika melakukan perubahan terhadap data news
		else{
			$topic = $_POST['topic'];
			$speaker = $_POST['speaker'];
			$schedule = $_POST['schedule'];
			$meeting_number = $_POST['meeting_number'];

			if($_FILES['picture']['name']){
				deleteFile($_POST['hiddenpicture']);
				$upload1 = uploadFile('picture',false,'image');
				$picture=$upload1['full_name'];
			} else {
				$picture = $_POST['hiddenpicture'];
			}

			if($_FILES['cover']['name']){
				deleteFile($_POST['hiddencover']);
				$upload2 = uploadFile('cover',false,'image');
				$cover=$upload2['full_name'];
			} else {
				$cover = $_POST['hiddencover'];
			}

			$data=$this->models->updatewebex($id_webex,$topic,$speaker,$picture,$cover,$schedule,$meeting_number);
			if($data == 1){
				echo "<script>alert('Data Successfully Update');window.location.href='".$CONFIG['admin']['base_url']."webex'</script>";
			}
		}
	}
}
?>