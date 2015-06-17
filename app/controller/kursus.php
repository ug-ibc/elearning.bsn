<?php

class kursus extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$getUserLogin = $this->isUserOnline();
		$this->user = $getUserLogin[0];
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->models = $this->loadModel('mkursus');
	}
	
	function index(){
		global $basedomain;
		$data = $this->models->getGrupKursus($this->user);
		$this->view->assign('grup',$data);
		return $this->loadView('kursus/grupkursus');

    }

    function kursusDetail()
    {
    	$id = $_GET['id'];

    	$data = $this->models->getAllCourse($id);
    	// pr($data);
		$this->view->assign('allcourse',$data);
		$this->view->assign('user', $this->user);
		$this->view->assign('kursusid', $id);
		$this->view->assign('havequiz', count($data['course']));
    	return $this->loadView('kursus/page_kursus');
    }
    function listGroup(){
		
		return $this->loadView('kursus/page_listGroup');

    }
    function viewPdf(){
		// pr($_GET);

		$this->view->assign('pdf',$_GET['pdf']);
		return $this->loadView('kursus/viewpdf');

    }


}

?>
