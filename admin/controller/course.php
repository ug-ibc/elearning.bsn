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
		
		$this->marticle = $this->loadModel('mcourse');
	}
	
	public function index(){
		
		
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
}

?>
