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

		$start = 0;
		$getQuiz = $this->quizHelper->getQuiz(1,1, $start);
       	// pr($soal);

       	$getUserAnswer = $this->quizHelper->getUserAnswer(1,1);
       	// pr($getUserAnswer);
       	if ($getUserAnswer){
       		foreach ($getUserAnswer as $key => $value) {
       			$answerList[$value['idSoal']] = $value['jawabanuser'];
       			$soalList[] = $value['idSoal'];
       		}

       		// pr($answerList);
       	}


       	if ($getQuiz){
       		foreach ($getQuiz as $key => $value) {
       			$dataSoal[] = $this->quizHelper->randomJawaban($value);
       		}

       		
       		
   			foreach ($dataSoal as $key => $value) {
       			$dataSoal[$key]['no'] = ($start+1);
       			

       			if (in_array($value['idSoal'], $soalList)) $dataSoal[$key]['jawabanuser'] = $answerList[$value['idSoal']];
       			$start++;
       		}
       		
       		
       	}
       	
       	// pr($dataSoal);
       	$this->view->assign('soal', $dataSoal);
		return $this->loadView('quiz/page_quiz');
    }

    function ajax()
    {
    	$pilihan = intval(_p('pilihan'));
    	$soal = intval(_p('soal'));
    	$kursus = intval(_p('kursus'));
    	$materi = intval(_p('materi'));
    	// pr($dataid);

    	$updateData = $this->quizHelper->userAnswer($kursus, $materi, $soal, $pilihan);
    	if ($updateData){
    		print json_encode(array('status'=>true));
    	}else{
    		print json_encode(array('status'=>false));
    	}
    	exit;
    }
}

?>
