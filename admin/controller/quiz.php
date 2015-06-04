<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );

class quiz extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
	}
	public function loadmodule()
	{
		
		$this->models = $this->loadModel('mquiz');
	}
	
	public function index(){
       
		return $this->loadView('quiz/quiz');

	}

	function listquiz()
	{

		$getQuiz = $this->models->getQuiz(false, '0,1');
		// pr ($getQuiz);
		if ($getQuiz){
			$this->view->assign('getQuiz', $getQuiz);
		}
		return $this->loadView('quiz/quizlist');
	}

	public function inputquiz(){
		global $CONFIG, $basedomain;

		$soal=$_POST['soal'];
		$pilihan1=$_POST['pilihan1'];
		$pilihan2=$_POST['pilihan2'];
		$pilihan3=$_POST['pilihan3'];
		$pilihan4=$_POST['pilihan4'];
		$jenissoal=$_POST['jenissoal'];
		$keterangan=$_POST['keterangan'];
		$jawaban=$_POST['jawaban'];
		$kursus=$_POST['kursus'];
		$materi=$_POST['materi'];
		$groupkursus=$_POST['groupkursus'];
		$quizstatus = $_POST['quizstatus'];
		$data=$this->models->inputquiz($soal,$pilihan1,$pilihan2,$pilihan3,$pilihan4,$jenissoal,$keterangan,$jawaban,$kursus,$materi,$groupkursus,$quizstatus);
		
		if ($data==1){
			echo "<script>alert('Data berhasil disimpan');</script>";
			
		}else{
			echo "<script>alert('Data gagal disimpan');</script>";
			
		}

		redirect($basedomain.'quiz');
		exit;
	}
	
	public function addquiz(){
		
		$this->view->assign('active','active');

		if(isset($_GET['id']))
		{
			$data = $this->models->get_article_id($_GET['id']);	
			// pr($data);
			if ($data){
				// echo 'ada';
				$content = unserialize($data['content']);
				// pr($data['content']);
				$data['data'] = $content;
			}

			// pr($data);
			$this->view->assign('data',$data);
		} 

		$this->view->assign('admin',$this->admin['admin']);
		return $this->loadView('quiz/inputquiz');
	}
    
	public function quizlist(){
		$data = $this->models->get_quizlist();
		if($data){
			$this->view->assign('data',$data);
		}	
		return $this->loadView('quiz/quizlist');
	}

}

?>
