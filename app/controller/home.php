<?php

class home extends Controller {
	
	var $models = FALSE;
	var $view;
	var $reportHelper;
	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
		$getUserLogin = $this->isUserOnline();
		$this->user = $getUserLogin[0];
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->userHelper = $this->loadModel('userHelper');
        $this->userGallery=$this->loadModel('mgallery');
        $this->userNews=$this->loadModel('mnews');
        $this->quizHelper = $this->loadModel('quizHelper');
	}
	
	function index(){

		$this->log($aksi='surf', $activity='landing home bsn');
		$vardata['data'] = $this->userNews->getnews2();
		$vardata['data2'] = $this->userGallery->getgallery();
		$vardata['quotes'] = $this->contentHelper->getCatatan(2);
		$vardata['glosarium'] = $this->contentHelper->getCatatan(1);
		$online = $this->contentHelper->getOnlineUser();

		$datawebex=$this->contentHelper->getwebex();
		if ($datawebex){	
			$this->view->assign('datawebex',$datawebex);
		}
		$datavidwebex=$this->contentHelper->getvideowebex();
		if ($datavidwebex){	
			$this->view->assign('datavidwebex',$datavidwebex);
		}
		
		// pr($datavidwebex);
		// $totalvidwebex=count($datavidwebex);

		// $datatot=$totalvidwebex%4;


		$getTestimoni = $this->quizHelper->getTestimoni();
		
		$isCourseReady = $this->quizHelper->isCourseReady();
		
		if ($isCourseReady){
			
			$dataKursus = array();
			foreach ($isCourseReady as $key => $value) {

				if ($value['soalkursus']){
					foreach ($value['soalkursus'] as $key => $val) {
						$dataKursus[] = $val;
					}
					
				}
				
			}
			$this->view->assign('kursus',$dataKursus);
			$this->view->assign('user',$this->user[idUser]);
		}
		
		$this->view->assign('testimoni',$getTestimoni);
		$this->view->assign('online',$online[0]['total']);
		$kursus = $this->contentHelper->getKursus(true);
		// $this->view->assign('kursus',$kursus);
		$this->view->assign('data',$vardata);			

		return $this->loadView('home');
    }

    function logout()
    {
    	global $basedomain;

    	// $updateStatusNilai = $this->quizHelper->updateStatusNilai();
    	
    	$doLogout = $this->userHelper->logoutUser();
    	if ($doLogout){
    		redirect($basedomain.'logout.php');exit;
    	}else{
    		redirect($basedomain);
    		logFile('can not logout user');exit;
    	}
    }

    function cetak()
    {
		global $basedomain;
		
		$id_usr = $_GET['id_usr'];
		$id_grp = $_GET['id_grp'];
		
		$criteria = $this->contentHelper->get_criteria($id_grp);
		
		$certificate = $this->contentHelper->get_certificate($id_usr,$id_grp);
		$ex1 = explode('-',$certificate[create_time]);
		$ex2 = explode(' ',$ex1[2]);
		$tanggal = $ex2[0].'/'.$ex1[1].'/'.$ex1[0];
		
		if($certificate[nilai] >= $criteria[kategoriBaik]){
			// $kategori = "Baik";
			$kategori = "Sangat Baik";
		}elseif($certificate[nilai] >= $criteria[kategoriCukup] && $certificate[nilai] < $criteria[kategoriBaik]){
			// $kategori = "Cukup";
			$kategori = "Baik";
		}else{
			// $kategori = "Kurang";
			$kategori = "";
		}
		
		$background_certificate =  $basedomain."assets/img/certificate/bg.jpg";
		$this->reportHelper =$this->loadModel('reportHelper');
		$html = "<style>
					body {
					  background: rgb(204,204,204);
					  background-image:  url(\"$background_certificate\");
					  width: 21cm;
					  height: 29.7cm;
					  display: block;
					  margin: 0 auto;
					  margin-bottom: 0.5cm;
					  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);  
					}
					#spacePage{
						height:8cm;
					}
					</style>
					<page >
						
						<div id=\"spacePage\">&nbsp;</div>
						<div style=\"width: ; text-align: center;\">
							<div>No : $certificate[kodeSertifikat]</div>
							<h5>diberikan kepada</h5>

							<h1 style=\"font-family: Monotype Corsiva; font-style: italic\">$certificate[name]</h1>

							<h5>telah mengikuti</h5>

							<h1>Grup Kursus : $certificate[namagrup]</h1>

							<h5>Tanggal $tanggal di website http://elearning.bsn.go.id</h5>

							<h5>sebagai</h5>

							<h1 style=\"font-family: Monotype Corsiva; font-style: italic\">Peserta</h1>

							<h5>dengan Predikat </h5>

							<h1 style=\"font-family: Monotype Corsiva; font-style: italic\">$kategori</h1>

							Kepala Pusat Pendidikan dan <br/>
							Pemasyarakatan Standardisasi

							<h5>Metrawinda Tunus</h5>
						</div>
					</page>";

		// echo $html;
		// exit;
    	$generate = $this->reportHelper->loadMpdf($html, 'certificate');
    }

}

?>
