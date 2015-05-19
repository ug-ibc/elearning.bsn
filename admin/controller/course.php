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

}

?>
