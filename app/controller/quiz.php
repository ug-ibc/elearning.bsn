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
		$getUserLogin = $this->isUserOnline();
		// pr($getUserLogin);
		$this->user = $getUserLogin[0];
    }
	
	function loadmodule()
	{
        $this->quizHelper = $this->loadModel('quizHelper');
	}
	
	function index(){

		$start = 0;
		// pr($_SESSION);
		if ($this->user){

			// get Kursus 
			$getKursus = $this->quizHelper->getKursus();

	       	$generateSoal = $this->quizHelper->isUserStartQuiz();

	       	$startQuiz = false;
	    	if ($generateSoal)$startQuiz = true;

	       	$this->view->assign('kursus', $getKursus);
	       	$this->view->assign('user', $this->user);
	       	$this->view->assign('startQuiz', $startQuiz);
	       	
       	}
		return $this->loadView('quiz/page_quiz');
    }


    function getMateri()
    {
    	$idKursus = intval(_p('idKursus'));

    	$getMateri = $this->quizHelper->getMateri(false, $idKursus);
    	if ($getMateri){
    		print json_encode(array('status'=>true, 'res'=>$getMateri));
    	}else{
    		print json_encode(array('status'=>false));
    	}
    	exit;
    }

    function ajax()
    {
    	$pilihan = intval(_p('pilihan'));
    	$soal = intval(_p('soal'));
    	$kursus = intval(_p('kursus'));
    	$materi = intval(_p('materi'));
      $idGrup_kursus = intval(_p('idGrup_kursus'));
    	// pr($dataid);

      $getGenerateSoal = $this->quizHelper->getGenerateSoal();
      $idsoalGen = $getGenerateSoal[0]['id'];
    	$updateData = $this->quizHelper->userAnswer($kursus, $materi, $soal, $pilihan, $idsoalGen, $idGrup_kursus);
    	if ($updateData){
    		print json_encode(array('status'=>true));
    	}else{
    		print json_encode(array('status'=>false));
    	}
    	exit;
    }

    function startQuiz()
    {
      $start = 0;
    	$param = intval(_p('param'));

    	$startQuiz = false;

    	// generate soal cukup 1 kali ketika klik tombol mulai

      $groupKursus = _g('id');
    	$generateSoal = $this->quizHelper->generateSoal($groupKursus);
      
      $alreadySubmit = false;

    	if ($generateSoal){
			$startQuiz = true;
			$_SESSION['idcount'] = $generateSoal[0]['id'];
			$_SESSION['end_date'] = $generateSoal[0]['end_date'];
		}else{

      $alreadySubmit = true;
			unset($_SESSION['idcount']);
			unset($_SESSION['end_date']);
		}
			
		$soalList = array();
    $getKursus = array();
		$getQuiz = $this->quizHelper->getQuiz($groupKursus);
       	
       	$getUserAnswer = $this->quizHelper->getUserAnswer($groupKursus);
       	if ($getUserAnswer){
       		foreach ($getUserAnswer as $key => $value) {
       			$answerList[$value['idSoal']] = $value['jawabanuser'];
       			$soalList[] = $value['idSoal'];
       		}

       		
       	}


       	if ($getQuiz){
       		foreach ($getQuiz as $key => $value) {
       			$dataSoal[] = $this->quizHelper->randomJawaban($value, false);
       		}

       		
       	// pr($dataSoal);
   			foreach ($dataSoal as $key => $value) {
       			$dataSoal[$key]['no'] = ($start+1);
       			
       			if ($soalList){
       				if (in_array($value['idSoal'], $soalList)) $dataSoal[$key]['jawabanuser'] = $answerList[$value['idSoal']];
       				
       			}
       			$start++;
       		}
       		
       		
       	}
       	
       	$this->view->assign('kursus', $getKursus);
       	$this->view->assign('user', $this->user);
       	$this->view->assign('startQuiz', $startQuiz);
       	$this->view->assign('hiddenStatus', true);
        $this->view->assign('alreadySubmit', $alreadySubmit);
        $this->view->assign('dataQuiz', $generateSoal[0]);

        $this->view->assign('soal', false);

       	if (isset($_SESSION['end_date'])){

       		$this->view->assign('soal', $dataSoal);
       	}

       	return $this->loadView('quiz/page_quiz');
    }
    
    function countDown()
    {

    	$end_date = $_SESSION['end_date'];
    	
		$countDown = strtotime($end_date);
		$diffTime =  ($countDown) - time();
		// pr($diffTime);
		if($diffTime >= 1) {
		    $countMin = floor($diffTime/60);
		    $countSec = ($diffTime-($countMin*60));
		    // echo 'Time remaining until next run is in ',$countMin,' minute(s) ',$countSec,' seconds';
			
		    $date['minute'] = $countMin;
		    $date['second'] = $countSec;
			
			print json_encode(array('status'=>true, 'end_date'=>$date));
		} else {
			
			$idcount = $_SESSION['idcount'];
			$finish = $this->quizHelper->updateCountDown($idcount);
			if ($finish)print json_encode(array('status'=>false));
		}

		exit;
    }

    function finishQuiz()
    {
        global $basedomain;
        $userid = _p('userid');

        $userSess = $this->user['idUser'];
        $quizId = _p('quizId');

        if ($userid == $userSess){

          $finishQuiz = $this->quizHelper->finishQuiz($quizId);
          if ($finishQuiz){
            print json_encode(array('status'=>true));
          }else{
            print json_encode(array('status'=>false));
          }
        }

        exit;
    }

    function hasil()
    {

      $correctionAnswer = $this->quizHelper->correctionAnswer();
      // pr($correctionAnswer);

      if ($correctionAnswer){
        $this->view->assign('correct', $correctionAnswer['correct']);
        $this->view->assign('wrong', $correctionAnswer['wrong']);

        
      }
      return $this->loadView('quiz/page_hasil');
    }
}

?>
