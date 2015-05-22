<?php

class quiz extends Controller {
	
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
        $this->quizHelper = $this->loadModel('quizHelper');
	}
	
	function index(){
		$soal = $this->quizHelper->getQuiz(1,1);
       	// pr($soal);
       	if ($soal){
       		foreach ($soal as $key => $value) {
       			$acakSoal[] = $this->quizHelper->randomJawaban($value);
       		}
       	}
       	
       	pr($acakSoal);
		return $this->loadView('quiz/page_quiz');
    }

}

?>
