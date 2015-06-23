<?php

class search extends Controller {
	
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
        $this->quizHelper = $this->loadModel('quizHelper');
	}
	
	
     function index(){
		// pr($_GET);

		$this->view->assign('pdf',$_GET['pdf']);
		return $this->loadView('kursus/page_search');

    }

}

?>
