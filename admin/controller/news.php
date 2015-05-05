<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class news extends Controller {
	
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
		
		$this->models = $this->loadModel('mnews');
	}
	
	public function index(){
		

		return $this->loadView('news/newslist');

	}

	public function addnews(){
		

		return $this->loadView('news/addnews');

	}

}

?>
