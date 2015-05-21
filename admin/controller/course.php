<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class course extends Controller {
	
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
		
		$this->mcourse = $this->loadModel('mcourse');
	}
	
	public function index(){
		// echo "masukk ajaa";
		$select = $this->mcourse->select_data();
		// pr($select);
		$this->view->assign('data',$select);
		return $this->loadView('course/coursegroup');

	}

	public function addgroup()
	{

		return $this->loadView('course/addgroup');
	}

	public function courselist(){
		return $this->loadView('course/courselist');	
	}

	public function addcourse(){
		return $this->loadView('course/addcourse');	
	}

	public function upload(){
		return $this->loadView('course/uploadfile');	
	}

	public function uploadfile(){
		return $this->loadView('course/uploadform');	
	}
	
	public function ajax_insert(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$namagrup =$_POST['namagrup'];
		$syaratkelulusan =$_POST['syaratkelulusan'];
		$n_status = 1;
		if ($namagrup != '' && $syaratkelulusan != ''){
			$insert = $this->mcourse->insert_data($namagrup,$syaratkelulusan,$n_status);
			// echo json_encode($data);
		}
		exit;
		// echo "<script>window.location.href='".$basedomain."course/index'</script>";	
		// return $this->loadView('course/index');	
	}
	
	
	
}

?>
