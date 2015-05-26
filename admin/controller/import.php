<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class import extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();

		global $app_domain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
		$this->view->assign('app_domain',$app_domain);
	}
	public function loadmodule()
	{
		
		$this->models = $this->loadModel('marticle');
		$this->excelHelper = $this->loadModel('excelHelper');
		$this->importHelper = $this->loadModel('importHelper');
		$this->contentHelper = $this->loadModel('contentHelper');
	}
	
	public function index(){
		


		return $this->loadView('importxls');

	}

	function simpanData()
	{

		$countID = count($_POST['ids']);
		if ($countID>0){
			$save = $this->importHelper->saveData($_POST);
			// $save = true;
			if ($save){
				$this->view->assign('totalinsert',$countID);
			}
		}else{
			$this->view->assign('error',true);
		}
		

		return $this->loadView('importxls_success');
	}

	function previewData()
	{

		$getData = $this->importHelper->getTmpData();
		$getWilayah = $this->contentHelper->getWilayah();
		$getBalai = $this->contentHelper->getBalai();

		// pr($getData);
		$this->view->assign('data',$getData);
		$this->view->assign('wilayah',$getWilayah);
		$this->view->assign('balai',$getBalai);
		$this->view->assign('preview',true);

		return $this->loadView('importxls');
	}

	function parseExcel()
	{
		/*
		New scenario !
		1. Parse data xls 
		2. Validate data before upload
		3. Store data to tmp table
		3. Try to move data from tmp table to real table
		4. Done
		
		*/
		
		global $EXCEL, $basedomain;
		
		// $username = $this->user['login']['username'];
		

		// pr($_FILES);exit;
		logFile(serialize($_FILES));

		if ($_FILES){
			
			$numberOfSheet = 1;
			$startRowData = 12;
			$startColData = 2;
			$formNametmp = array_keys($_FILES);
			$formName = $formNametmp[0];
			
			if (empty($formName)) die;
			
			$startTime = microtime(true);
			/* parse data excel */
			
			logFile('load excel begin');

			// empty log file
			

			$parseExcel = $this->excelHelper->fetchExcel($formName, $numberOfSheet,$startRowData,$startColData);
			// pr($parseExcel);exit;
			
			if ($parseExcel){
				// logFile('Extract File ', $username);
				foreach ($parseExcel as $key => $val){
					
					$field = implode(',',$val['field_name']);
					
					$data = array();

					if ($val['data']){

						foreach ($val['data'] as $keys => $value){
						
							foreach ($value as $k => $v){
								$data[$val['field_name'][$k]] = $v;
							}
							
							$newData[$val['sheet']]['data'][] = $data; 
							
						}
					}else{
						print json_encode(array('status'=>false, 'msg'=>'Data tidak tersedia'));
						exit;
					}
					
					
				}
				
				
				/* here begin process */
				if ($newData){
					
					$emptyTmptable = $this->importHelper->insertTmpData($newData[0]['data']);
					
					if ($emptyTmptable) redirect($basedomain.'import/previewData');
					exit;
					
					

				}else{
					print json_encode(array('status'=>false, 'msg'=>'Tidak ada data yang tersedia'));
					exit;
				}
			}else{
				print json_encode(array('status'=>false, 'msg'=>'Ekstrak gagal'));
				exit;
			}
		}else{
			logFile('File xls empty');
			// echo "File is empty";
			print json_encode(array('status'=>true, 'msg'=>'File kosong'));
		}
		
		
		exit;
	}
	
}

?>
