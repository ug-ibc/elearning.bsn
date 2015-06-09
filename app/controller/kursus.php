<?php

class kursus extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->models = $this->loadModel('mkursus');
	}
	
	function index(){
		
		$data = $this->models->getGrupKursus();
		$this->view->assign('grup',$data);

		return $this->loadView('kursus/grupkursus');

    }

    function kursusDetail()
    {
    	return $this->loadView('kursus/page_kursus');
    }

}

?>
