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
		//memanggil fungsi getwebex pada model
		//pr($this->admin[idUser]);
		$data=$this->models->getwebex();
		if ($data){	
			$this->view->assign('data',$data);
		}
		return $this->loadView('webex/listwebex');
	}

	//fungsi untuk menginput data webex dari view
	public function inputwebex(){
		global $CONFIG;
		//kondisi untuk mengecek validasi form
		if(isset($_POST['topic']) && isset($_POST['speaker']) && isset($_POST['meeting_number']) && isset($_POST['schedule'])){
			$topic = $_POST['topic'];
			$speaker = $_POST['speaker'];
			$upload1 = uploadFile('picture',false,'image');
			// pr($judul);exit;
			$picture=$upload1['full_name'];
			$waktu = $_POST['waktu'];
			$site = $_POST['site'];
			$schedule = $_POST['schedule'];
			//pr($status);exit;
			$meeting_number = $_POST['meeting_number'];
			//pr($meeting_number);exit;
			$data=$this->models->inputwebex($topic,$speaker,$picture,$waktu,$site,$schedule,$meeting_number);
			//kondisi untuk memberi peringatan proses input berhasil atau tidak
			if($data == 1){
				echo "<script>alert('Data Successfully Created');window.location.href='".$CONFIG['admin']['base_url']."webex'</script>";
			}
		}
		//eksekusi jika validasi form tidak sesuai
		else {pr('gagal');}
	}

	//fungsi untuk menampilkan form input webex
	public function addwebex(){
		return $this->loadView('webex/addwebex');	
	}

	//fungsi untuk menghapus data webex
	public function deletewebex(){
		global $CONFIG;
		//mengambil parameter id_webex dari view
		$id_webex = $_GET['id_webex'];
		//melempar id_webex ke fungsi deletwebex yang ada di model
		$data=$this->models->deletewebex($id_webex);
		if($data == 1){
			echo "<script>alert('Data Successfully Delete');window.location.href='".$CONFIG['admin']['base_url']."webex'</script>";
		}
		else {pr('gagal');}
	}

	//fungsi untuk merubah data webex
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
		//eksekusi jika melakukan perubahan terhadap data webex
		else{
			$topic = $_POST['topic'];
			$speaker = $_POST['speaker'];
			$schedule = $_POST['schedule'];
			$waktu = $_POST['waktu'];
			$site = $_POST['site'];
			$meeting_number = $_POST['meeting_number'];

			if($_FILES['picture']['name']){
				deleteFile($_POST['hiddenpicture']);
				$upload1 = uploadFile('picture',false,'image');
				$picture=$upload1['full_name'];
			} else {
				$picture = $_POST['hiddenpicture'];
			}

			$data=$this->models->updatewebex($id_webex,$topic,$speaker,$picture,$waktu,$site,$schedule,$meeting_number);
			if($data == 1){
				echo "<script>alert('Data Successfully Update');window.location.href='".$CONFIG['admin']['base_url']."webex'</script>";
			}
		}
	}

	//fungsi untuk menampilkan form input video 
	public function addvideowebex(){
		return $this->loadView('webex/addvideowebex');	
	}

	public function listvideowebex(){
		//memanggil fungsi getvideo pada model
		//pr($this->admin[idUser]);
		$data=$this->models->getvideowebex();
		if ($data){	
			$this->view->assign('data',$data);
		}
		return $this->loadView('webex/listvideowebex');
	}


	public function inputvideowebex(){
		global $CONFIG;
		if(isset($_POST)){
		 $x = form_validation($_POST);
		 try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						//update or insert
						$x['title'] = $_POST['title'];
						$x['jenisfile'] = $_POST['jenisfile'];
					
						if(!empty($_FILES['file_video']['name'])){
							if($_FILES['file_video']['name'] != ''){
								//if($x['action'] == 'update') deleteFile($x['file_hidden']);
								$video = uploadFile('file_video',null,'video');
								$x['post_video'] = $video['full_name'];
							}
						}else{
							if(empty($_FILES['file_video']['name']) && $x['file_video'] != ""){	
								//get first url
								$split_first = explode('watch',$x['file_video']);
								$hit = count($split_first);
								if($hit != 1){
									$split_second = explode('=',$x['file_video']);
									$x['post_video'] = $split_first[0].'embed/'.$split_second[1];
								}else{
									$x['post_video'] = $x['file_video'];
								}
							}//else{
								//$x['post_image'] = $x['file_hidden'];
							//}
						}
						$data = $this->models->inputvideowebex($x);
					}
				   	
			   }catch (Exception $e){}
			echo "<script>alert('Video Successfully Added');window.location.href='".$CONFIG['admin']['base_url']."webex/listvideowebex'</script>";		

	  }
		return $this->loadView('inputvideowebex');
	}

	//fungsi untuk menghapus data video webex
	public function deletevideowebex(){
		global $CONFIG;
		//mengambil parameter id_video dari view
		$id_video = $_GET['id_video'];
		//melempar id_video ke fungsi deletevideo yang ada di model
		$data=$this->models->deletevideowebex($id_video);
		if($data == 1){
			echo "<script>alert('Video Successfully Delete');window.location.href='".$CONFIG['admin']['base_url']."webex/listvideowebex'</script>";
		}
		else {pr('gagal');}
	}

	//fungsi untuk merubah data webex
	public function editvideowebex(){
		global $CONFIG;
		$id_video = $_GET['id_video'];
		//kondisi apabila tidak melakukan perubahan
		if ($_POST == null){	
			$data=$this->models->selectvideowebex($id_video);
			if ($data){	
				$this->view->assign('data',$data);
			}	
			return $this->loadView('webex/editvideowebex');	
		}
		//eksekusi jika melakukan perubahan terhadap data webex
		else{if(isset($_POST)){
		 $x = form_validation($_POST);
		 try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						//update or insert
						$x['title'] = $_POST['title'];
						$x['jenisfile'] = $_POST['jenisfile'];
						$x['id_video'] = $_GET['id_video'];
						if(!empty($_FILES['file_video']['name'])){
							if($_FILES['file_video']['name'] != ''){
								deleteFile($x['file_hidden']);
								$video = uploadFile('file_video',null,'video');
								$x['post_video'] = $video['full_name'];
							}
						}else{
							if(empty($_FILES['file_video']['name']) && $x['file_video'] != ""){	
								//get first url
								$split_first = explode('watch',$x['file_video']);
								$hit = count($split_first);
								if($hit != 1){
									$split_second = explode('=',$x['file_video']);
									$x['post_video'] = $split_first[0].'embed/'.$split_second[1];
								}else{
									$x['post_video'] = $x['file_video'];
								}
							}else{
								$x['post_video'] = $x['file_hidden'];
							}
						}
						$data = $this->models->updatevideowebex($x);
					}
				   	
			   }catch (Exception $e){}
			echo "<script>alert('Video Successfully Edit');window.location.href='".$CONFIG['admin']['base_url']."webex/listvideowebex'</script>";		

	  }
		return $this->loadView('editvideowebex');
			
		}
	}
}
?>