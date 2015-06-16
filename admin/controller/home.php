<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class home extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();

		global $app_domain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
		$this->view->assign('app_domain',$app_domain);
	}
	public function loadmodule()
	{
		
		$this->contentHelper = $this->loadModel('contentHelper');
		$this->marticle = $this->loadModel('marticle');
	}
	
	public function index(){
		
		// uploadFile($data,$path=null,$ext){
		

		$register = $this->contentHelper->getRegistrant();
		$course = $this->contentHelper->getCourse();
		$online = $this->contentHelper->getOnlineUser();
		$download = $this->contentHelper->getDownloadEbook();
		// pr($download);
		$this->view->assign('register',$register[0]['total']);
		$this->view->assign('course',$course[0]['total']);
		$this->view->assign('online',$online[0]['total']);
		$this->view->assign('download',intval($download[0]['total']));

		return $this->loadView('home/home');

	}
	
	//view glosarium
	public function glosariumlist(){
		// echo "masukk ajaa";
		$select = $this->marticle->select_data();
		// pr($select);
		$this->view->assign('data',$select);
		
		return $this->loadView('home/glosarium');

	}
	
	public function ajax_insert(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$judul =$_POST['judul'];
		$keterangan =$_POST['keterangan'];
		$n_status = 1;
		$tipe = 1;
		if ($judul != '' && $keterangan != ''){
			$insert = $this->marticle->insert_data($judul,$keterangan,$n_status,$tipe);
			// echo json_encode($data);
		}
		exit;
		
	}
	
	public function ajax_edit(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$idCatatan =$_POST['idCatatan'];
		
		if ($idCatatan != ''){
			$edit = $this->marticle->edit_data($idCatatan);
			echo json_encode($edit);
		}
		exit;
	}
	
	public function ajax_update(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id = $_POST['id'];
		$judul =$_POST['judul'];
		$keterangan =$_POST['keterangan'];
		if ($judul != '' && $keterangan != ''){
			$update = $this->marticle->update_data($id,$judul,$keterangan);
		}
		exit;
		
	}

	public function ajax_update_status(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id = $_POST['id'];
		$status =$_POST['status'];
		if($status == 1){
			$n_status = 0;
		}else{
			$n_status = 1;
		}
		if ($id != '' && $status != ''){
			$update_status = $this->marticle->update_status($id,$n_status);
		}
		exit;
		
	}
	
	public function ajax_delete(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id =$_POST['id'];
		$n_status = 2;
		if ($id != ''){
			$insert = $this->marticle->delete_data($id,$n_status);
			// echo json_encode($data);
		}
		exit;
		
	}

	public function quoteslist(){
		// echo "masukk ajaa";
		$select = $this->marticle->select_data_quotes();
		// pr($select);
		$this->view->assign('data',$select);
		
		return $this->loadView('home/quotes');

	}
	
	public function ajax_insert_quotes(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$judul =$_POST['judul'];
		$keterangan =$_POST['keterangan'];
		$n_status = 1;
		$tipe = 2;
		if ($judul != '' && $keterangan != ''){
			$insert = $this->marticle->insert_data($judul,$keterangan,$n_status,$tipe);
			// echo json_encode($data);
		}
		exit;
		
	}
	
}

?>
