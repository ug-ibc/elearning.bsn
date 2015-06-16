<?php

class home extends Controller {
	
	var $models = FALSE;
	var $view;
	var $reportHelper;
	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->userHelper = $this->loadModel('userHelper');
        $this->userGallery=$this->loadModel('mgallery');
        $this->userNews=$this->loadModel('mnews');
	}
	
	function index(){

		$this->log($aksi='surf', $activity='landing home bsn');
		//$data=$this->userGallery->getgallery();
		//if ($data){	
		$vardata['data'] = $this->userNews->getnews2();
		$vardata['data2'] = $this->userGallery->getgallery();

		$kursus = $this->contentHelper->getKursus();
		$this->view->assign('kursus',$kursus);

		// pr($vardata);exit;
		$this->view->assign('data',$vardata);			

		//$this->view->assign('data',$data);
		//}
		return $this->loadView('home');
    }

    function logout()
    {
    	global $basedomain;
    	$doLogout = $this->userHelper->logoutUser();
    	if ($doLogout){
    		redirect($basedomain.'logout.php');exit;
    	}else{
    		redirect($basedomain);
    		logFile('can not logout user');exit;
    	}
    }

    function cetak()
    {

    	$this->reportHelper =$this->loadModel('reportHelper');

    	$html = "<h1>Its works</h1>";

    	$generate = $this->reportHelper->loadMpdf($html, 'namafileotput');
    }

}

?>
