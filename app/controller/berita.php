<?php

class berita extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	public function loadmodule()
	{
		$this->models=$this->loadModel('mnews');
	}
	

	public function index(){

	global $CONFIG;
	$data=$this->models->getnews();
	//pr($data);EXIT;
	if ($data){
			
		$this->view->assign('data',$data);
		

	return $this->loadView('berita/page_berita');
}

}
}

?>
