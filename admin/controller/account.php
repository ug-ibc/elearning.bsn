<?php
defined ('TATARUANG') or exit ( 'Forbidden Access' );

class account extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		
		// $this->validatePage();
	}
	public function loadmodule()
	{
		
		// $this->contentHelper = $this->loadModel('contentHelper');
	}
	
	public function index(){
       
		// echo 'ada';
		// pr($_GET);
		return $this->loadView('account');
	}
    
	public function ada(){
       
		// echo 'ada1';
		pr($_GET);
		return $this->loadView('account');
	}
}

?>
