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
		
		$this->marticle = $this->loadModel('marticle');
	}
	
	public function index(){
		
		// uploadFile($data,$path=null,$ext){
		


		
		$data1 = 1;
		$vardata = array("coba data","array 2");
		// pr($vardata);
		$this->view->assign('data',$vardata);

		return $this->loadView('home/home');

	}

}

?>
