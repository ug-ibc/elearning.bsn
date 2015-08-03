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
        $this->quizHelper = $this->loadModel('quizHelper');
		$this->contentHelper = $this->loadModel('contentHelper');
	}
	
	function index(){
		global $basedomain;
		$kursus = $this->contentHelper->getKursus();
		// pr($kursus);
		// $this->view->assign('kursus',$kursus);
		$isCourseReady = $this->quizHelper->isCourseReady();
		// pr($isCourseReady);

		// pr($this->user);
		// echo $this->user[idUser];
		if ($isCourseReady){
			
			/*$data = $this->models->getGrupKursus($this->user);
			if ($data){
				foreach ($data as $key => $value) {
					if ($isCourseReady[$value['idGrup_kursus']]['courseready'] == 1){
						$courseReady[] = $value;
					}
				}
			}*/

			$dataKursus = array();
			foreach ($isCourseReady as $key => $value) {

				if ($value['soalkursus']){
					foreach ($value['soalkursus'] as $key => $val) {
						$dataKursus[] = $val;
					}
					
				}
				
			}
			// pr($dataKursus);
			$this->view->assign('kursus',$dataKursus);
			$this->view->assign('user',$this->user[idUser]);
		}
		return $this->loadView('kursus/grupkursus');

    }

    function kursusDetail()
    {
    	global $basedomain;
    	$id = $_GET['id'];
		$idk = $_GET['idk'];
		$isQuizRunning = $this->quizHelper->isQuizRunning($id);
    	// pr($isQuizRunning);
		if ($isQuizRunning){ redirect($basedomain.'quiz/startQuiz/?id='.$id); exit;}
    	$data = $this->models->getCourse($id,$idk);
		// pr($data);
    	$Alldata = $this->models->getAllCourse($id);
    	// pr($Alldata);
    	
    	if ($this->user){
    		$getHasRead = $this->quizHelper->getHasRead($id);
	    	if ($getHasRead){
	    		foreach ($getHasRead as $key => $value) {
	    			$hasRead[] = $value['kursusid'];
	    		}
	    	}
    	}else{
    		$hasRead = false;
    	}
    	
    	// pr($hasRead);
    	$this->view->assign('hasRead',$hasRead);
    	$this->view->assign('allcourse',$Alldata);
		$this->view->assign('course',$data);
		$this->view->assign('user', $this->user);
		$this->view->assign('kursusid', $id);
		$this->view->assign('havequiz', count($data['course']));
    	return $this->loadView('kursus/page_kursus');
    }
	
	function subkursusDetail()
    {
    	global $basedomain;
    	$id = $_GET['id'];
		$idk = $_GET['idk'];
		$isQuizRunning = $this->quizHelper->isQuizRunning($id);
    	// pr($isQuizRunning);
		if ($isQuizRunning){ redirect($basedomain.'quiz/startQuiz/?id='.$id); exit;}
    	$data = $this->models->getCourse($id,$idk);
		// pr($data);
    	$Alldata = $this->models->getAllCourse($id);
    	// pr($Alldata);
    	if ($this->user){
    		$getHasRead = $this->quizHelper->getHasRead($id);
	    	if ($getHasRead){
	    		foreach ($getHasRead as $key => $value) {
	    			$hasRead[] = $value['kursusid'];
	    		}
	    	}
    	}else{
    		$hasRead = false;
    	}
    	$this->view->assign('hasRead',$hasRead);
		$this->view->assign('allcourse',$Alldata);
		$this->view->assign('course',$data);
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
     function search(){
		// pr($_GET);

		$this->view->assign('pdf',$_GET['pdf']);
		return $this->loadView('kursus/page_search');

    }

    
    function ajax_marked(){

    	$kursusid = _p('kursusid'); 
    	$groupid = _p('groupid'); 

    	$marked = $this->quizHelper->hasRead($kursusid, $groupid);
    	if ($marked){
    		print json_encode(array('status'=>true));
    	}else{
    		print json_encode(array('status'=>false));
    	}

    	exit;
    }
}

?>
