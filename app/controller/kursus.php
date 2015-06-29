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
	}
	
	function index(){
		global $basedomain;

		$isCourseReady = $this->quizHelper->isCourseReady();
		// pr($isCourseReady);

		// pr($this->user);
		// echo $this->user[idUser];
		if ($isCourseReady){
			$data = $this->models->getGrupKursus($this->user);
			// pr($data);
			// db($data);
			if ($data){
				foreach ($data as $key => $value) {
					if ($isCourseReady[$value['idGrup_kursus']]['courseready'] == 1){
						$courseReady[] = $value;
					}
				}
			}
			// db($courseReady);
			$this->view->assign('grup',$courseReady);
			$this->view->assign('user',$this->user[idUser]);
		}
		
		return $this->loadView('kursus/grupkursus');

    }

    function kursusDetail()
    {
    	global $basedomain;
    	$id = $_GET['id'];

    	$isQuizRunning = $this->quizHelper->isQuizRunning($id);
    	// pr($isQuizRunning);
    	if ($isQuizRunning){ redirect($basedomain.'quiz/startQuiz/?id='.$id); exit;}
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
     function search(){
		// pr($_GET);

		$this->view->assign('pdf',$_GET['pdf']);
		return $this->loadView('kursus/page_search');

    }

}

?>
