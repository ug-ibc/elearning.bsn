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
		$this->contentHelper = $this->loadModel('contentHelper');
        
	}
	
	
     function index(){
		if(isset($_POST['cari'])){
			$certificate = $_POST['cari'];
			$group_course = $this->models->get_group_by_certificate($certificate);
			$id_group = $group_course['idGrup_kursus'];
			// pr($group_course);
			if($id_group != ''){
				$list_course = $this->models->get_list_course_by_certificate($id_group);
				// pr($list_course);
				$nilai = $this->models->get_value_by_certificate($id_group);
				// pr($nilai);
				$this->view->assign('group_course',$group_course);
				$this->view->assign('list_course',$list_course);
				$this->view->assign('nilai',$nilai);
				$this->view->assign('keyword',$certificate);
				$this->view->assign('user',$this->user);
				return $this->loadView('kursus/page_search');
			}else{
				return $this->loadView('kursus/page_search');
			}
			
		}else{
			// echo "no post";
			// pr($this->user);
			return $this->loadView('kursus/page_search');
		
		}
		

    }
	
	function cetak()
    {
		global $basedomain;
		
		$id_crtfkt = $_GET['id_crtfkt'];
		$id_grp = $_GET['id_grp'];
		$id_usr = $_GET['id_usr'];
		$criteria = $this->contentHelper->get_criteria($id_grp);
		
		$certificate = $this->contentHelper->get_certificate_by_search($id_crtfkt,$id_grp,$id_usr);
		$ex1 = explode('-',$certificate[create_time]);
		$ex2 = explode(' ',$ex1[2]);
		$tanggal = $ex2[0].'/'.$ex1[1].'/'.$ex1[0];
		
		if($certificate[nilai] >= $criteria[kategoriBaik]){
			$kategori = "Baik";
		}elseif($certificate[nilai] >= $criteria[kategoriCukup] && $certificate[nilai] < $criteria[kategoriBaik]){
			$kategori = "Cukup";
		}else{
			$kategori = "Kurang";
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
