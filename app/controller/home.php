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
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->userHelper = $this->loadModel('userHelper');
        $this->userGallery=$this->loadModel('mgallery');
        $this->userNews=$this->loadModel('mnews');
	}
	
	function index(){

		$this->log($aksi='surf', $activity='landing home bsn');
		//$data=$this->userGallery->getgallery();
		//if ($data){	
		$vardata['data'] = $this->userNews->getnews2();
		$vardata['data2'] = $this->userGallery->getgallery();
		$vardata['quotes'] = $this->contentHelper->getCatatan(2);
		$vardata['glosarium'] = $this->contentHelper->getCatatan(1);

		$kursus = $this->contentHelper->getKursus();
		$this->view->assign('kursus',$kursus);

		// pr($vardata);exit;
		$this->view->assign('data',$vardata);			

		//$this->view->assign('data',$data);
		//}
		return $this->loadView('home');
    }

    function logout()
    {
    	global $basedomain;

    	$updateStatusNilai = $this->quizHelper->updateStatusNilai();
    	
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
						height:10cm;
					}
					.bpmTopnTailC td, .bpmTopnTailC th  {	border-top: 1px solid #FFFFFF; text-align : center}
					.headerrow td, .headerrow th { background-gradient: linear #b7cebd #f5f8f5 0 1 0 0.2;  }
					.evenrow td, .evenrow th { background-color: #f5f8f5; } 
					.oddrow td, .oddrow th { background-color: #e3ece4; } 

							
					</style>
					<page >
						<div id=\"spacePage\">&nbsp;</div>
						<div style=\"width: ; text-align: center;\">
							<h5>diberikan kepada</h5>

							<h1 style=\"font-family: Monotype Corsiva; font-style: italic\">Eddy S. Siradj</h1>

							<h5>telah mengikuti</h5>

							<h1>Grup Kursus : Standardisasi</h1>

							<h5>Tanggal ................ di website http://elearning.bsn.go.id</h5>

							<h5>sebagai</h5>

							<h1 style=\"font-family: Monotype Corsiva; font-style: italic\">Peserta</h1>

							<h5>dengan Predikat </h5>

							<h1 style=\"font-family: Monotype Corsiva; font-style: italic\">Baik / Sangat Baik</h1>

							Kepala Pusat Pendidikan dan <br/>
							Pemasyarakatan Standardisasi

							<h5>Metrawinda Tunus</h5>
						</div>
						<div id=\"spacePage\">&nbsp;</div>
						<div style=\"width: ; text-align: center;\">
						<h4>Daftar Kursus : </h4>
								<table align=\"center\" class=\"bpmTopnTailC\"><thead>
									<tr class=\"headerrow\" ><th>No.</th>
										<td>
											<p>Judul</p>
										</td>
										<td>Durasi</td>
									</tr>
								</thead><tbody>
									<tr class=\"oddrow\"><th>1</th>
										<td>Pengantar (sejarah, filosofi, jenis dan cakupan standar)</td>
										<td>45 menit</td>
									</tr>
									<tr class=\"evenrow\"><th>2</th>
										<td>
										<p>Infrastruktur Mutu</p>
										</td>
										<td>
										<p>45 menit</p>
										</td>
									</tr>
									<tr class=\"oddrow\"><th>3</th>
										<td>Pengantar (sejarah, filosofi, jenis dan cakupan standar)</td>
										<td>45 menit</td>
									</tr>
									<tr class=\"evenrow\"><th>4</th>
										<td>
										<p>Infrastruktur Mutu</p>
										</td>
										<td>
										<p>45 menit</p>
										</td>
									</tr>
								</tbody></table>
						</div>
					</page>";

		// echo $html;
		// exit;
    	$generate = $this->reportHelper->loadMpdf($html, 'certificate');
    }

}

?>
