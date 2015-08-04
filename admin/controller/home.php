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
		$this->mquiz = $this->loadModel('mquiz');
		$this->mcourse = $this->loadModel('mcourse');
	}
	
	public function index(){
		
		// uploadFile($data,$path=null,$ext){
		
		// $quizStatistic = $this->contentHelper->quizStatistic();
		// db($quizStatistic);
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
	
	public function chart(){
		
		$monthArray =array('1','2','3','4','5','6','7','8','9','10','11','12');
		
		$year = date('Y');
		
		$register_user= $this->mcourse->select_data_register_user_condt_home($monthArray,$year);
		$visitor_user= $this->mcourse->select_data_visitor_user_condt_home($monthArray,$year);
		
		$newformat = array('register'=>$register_user,'visitor'=>$visitor_user);
		print json_encode($newformat);
		exit;
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
		$wilayah = $_POST['wilayah'];
		
		if ($idCatatan != ''){
			$edit = $this->marticle->edit_data($idCatatan, $wilayah);
			echo json_encode($edit);
		}
		exit;
	}
	
	public function ajax_edit_wilayah(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$idCatatan =$_POST['kode_wilayah'];
		
		if ($idCatatan != ''){
			$edit = $this->marticle->edit_data($idCatatan, 1);
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
		$wilayah = $_POST['wilayah'];
		if ($judul != '' && $keterangan != ''){
			$update = $this->marticle->update_data($id,$judul,$keterangan,$wilayah);
		}
		exit;
		
	}

	public function ajax_update_status(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id = $_POST['id'];
		$status =$_POST['status'];
		$wilayah = $_POST['wilayah'];
		if($status == 1){
			$n_status = 0;
		}else{
			$n_status = 1;
		}
		if ($id != '' && $status != ''){
			$update_status = $this->marticle->update_status($id,$n_status,$wilayah);
		}
		exit;
		
	}

	function ajax_update_status_testimoni()
	{
		$id = $_POST['id'];
		$status =$_POST['status'];

		
		if($status == 1){
			$n_status = 0;
		}else{
			$n_status = 1;
		}
		if ($id != '' && $status != ''){

			$update_status = $this->mquiz->update_status_testimoni($id,$n_status);
		}
		exit;
	}
	
	public function ajax_delete(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$kode_wilayah = $_POST['kode_wilayah'];
		$id =$_POST['id'];
		$n_status = 2;
		if ($id != ''){
			$insert = $this->marticle->delete_data($id,$n_status, $kode_wilayah);
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

	public function testimoni(){
		// echo "masukk ajaa";
		$select = $this->mquiz->getNilai();
		// pr($select);
		if ($select){
			$i = 0;
			$data = array();
			foreach ($select as $key => $value) {
				if ($value['data']){
					$unserial = unserialize($value['data']);
					// $select[$key]['idNilai'] = $value['idNilai'];
					$select[$key]['testimoni'] = $unserial['testimoni'];
					$select[$key]['status_testimoni'] = intval($unserial['status_testimoni']);
				}
			}
		}
		// pr($select);
		$this->view->assign('data',$select);
		
		return $this->loadView('home/testimoni');

	}

	public function externalLink(){
		// echo "masukk ajaa";
		$select = $this->marticle->select_data_link();
		// pr($select);
		$this->view->assign('data',$select);
		
		return $this->loadView('home/link');

	}
	
	public function ajax_insert_quotes(){
		
		global $basedomain;
		$judul =$_POST['judul'];
		$keterangan =$_POST['keterangan'];
		$wilayah = $_POST['wilayah'];
		$n_status = 1;
		$typedata = _p('type');
		if ($typedata) $tipe = 3;
		else $tipe = 2;
		if ($judul != '' && $keterangan != ''){
			$insert = $this->marticle->insert_data($judul,$keterangan,$n_status,$tipe, $wilayah);
			// echo json_encode($data);
		}
		exit;
		
	}

	function cetak()
	{
		
		global $basedomain;
		$background_certificate =  $basedomain."assets/img/certificate/bg.jpg";
		$this->reportHelper =$this->loadModel('reportHelper');
		$html = "<h1>hello world</h1>";

		// echo $html;
		// exit;
    	$generate = $this->reportHelper->loadMpdf($html, 'certificate');
    
	}

	function wilayah()
	{

		$select = $this->marticle->getWilayah($id, $all);
		// pr($select);
		$this->view->assign('data',$select);
		return $this->loadView('home/wilayah');
	}


	
}

?>
