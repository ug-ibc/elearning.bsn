<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class evaluasi extends Controller {
	
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
		
		$this->contentHelper = $this->loadModel('contentHelper');
	}
	
	public function index(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi');

	}

	function nikotin()
	{

		$usertype = $this->admin['admin']['type'];
		if ($usertype==1) $dataArr['n_status'] = '1,2,3';
		if ($usertype==2) $dataArr['n_status'] = '3';
		if ($usertype==3) $dataArr['n_status'] = '2';

		$data = $this->contentHelper->getLaporanNikotinList($dataArr);
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateDataNikotin($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		$this->view->assign('admin',$this->admin['admin']);
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-nikotin');    
	}

	function label()
	{
		global $basedomain;

		if ($this->admin['admin']['type']==1) $dataArr['n_status'] = '1,2,3';
		if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '3';
		if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '2';
		if ($this->admin['admin']['type']==4) $dataArr['n_status'] = '2';
		$data = $this->contentHelper->getLaporanKemasanList($dataArr);
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi/label'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($this->admin);exit;
		$this->view->assign('admin',$this->admin['admin']);

		return $this->loadView('evaluasi/evaluasi-label');  
	}

	function detillabel()
	{
		global $basedomain;

		$id = _g('id');

		$dataArr['id'] = $id;
		$dataArr['n_status'] = 2;

		$tulisanPeringatan = array(1 => 'Merokok Membunuhmu',
									2 => 'Merokok dekat anak berbahayan bagi mereka',
									3 => 'Merokok sebabkan kanker mulut',
									);
		$bentukKemasan = array(1 => 'Kotak persegi panjang',
								2 => 'Kotak slop',
								3 => 'Slinder'
								);
		$isiKemasan = array(1 => '10 bks/slop',
							2 => '10 btg/bks',
							2 => '10 slider/slop',
							2 => '12 btg/bks',
							2 => '50 btg/slinder',
							);
		$jenisRokok = array(1 => 'SKT',
							2 => 'SKM',
							);
		
		$data = $this->contentHelper->getLaporanKemasan($dataArr);
		$getTUlisan = $this->contentHelper->getTulisanPeringatan(false);
		$this->view->assign('tulisan',$getTUlisan);

		if ($data){
			foreach ($data as $key => $value) {
				$data[$key]['d_tulisanPeringatan'] = $tulisanPeringatan[$value['tulisanPeringatan']];
				$data[$key]['d_bentukKemasan'] = $bentukKemasan[$value['bentuKemasan']];
				$data[$key]['d_isiKemasan'] = $isiKemasan[$value['isi']];
				$data[$key]['d_jenisRokok'] = $jenisRokok[$value['jenis']];

				$data[$key]['dataDisabled'] = 'disabled';
				
			}
			$this->view->assign('data',$data[0]);
		}
		// pr($data);
		$this->view->assign('id',$id);
		

		if (isset($_POST['idPelaporan'])){

			// pr($_POST);
			// exit;
			// $checkBoxCount = count($_POST['pelaporanKemasan']);
			// if ($checkBoxCount == 7){

				$dataArr['id'] = $_POST['idPelaporan'];
				// $dataArr['n_status'] = 2;
				// $update = $this->contentHelper->updateStatusKemasan($dataArr);
				$update = $this->contentHelper->evaluasiKemasan($_POST);
				
				if ($update){
					echo "<script>window.location.href='".$basedomain."pelaporan/kemasan'</script>";
					// redirect($basedomain.'evaluasi');
				}
			// }
		}

		if (isset($_GET['id'])){
			
			if (isset($_GET['act'])){
				$dataArr['id'] = $_GET['id'];
				$dataArr['n_status'] = 0;
				$update = $this->contentHelper->updateStatusKemasan($dataArr);
				if ($update){
					echo "<script>window.location.href='".$basedomain."pelaporan/kemasan'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}

			
		
		}

		
		$slider = $this->loadView('pelaporan/slider');
		$this->view->assign('slider',$slider);

		return $this->loadView('evaluasi/evaluasi-label-detail');
	}
	public function iklanmlr(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-mlr');

	}

	public function iklanmlr_detail(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-mlr-detail');

	}

	public function iklantv(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-iklantv');

	}

	public function iklantv_detail(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-iklantv-detail');

	}

	public function iklanphw(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-phw');

	}

	public function iklanphw_detail(){
		
		$data = $this->contentHelper->getDataEvaluasi();
		// pr($data);
		if ($data){
			
			$this->view->assign('data',$data);
		}
		
		if ($_POST['status']){

			if (count($_POST['ids']>0)){

				$id = implode(',', $_POST['ids']);

				$status = intval($_POST['status']);
				$approve = $this->contentHelper->validateData($id, $status);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		
		// pr($data);exit;
		

		return $this->loadView('evaluasi/evaluasi-phw-detail');

	}
	public function detail(){

		global $basedomain;

		$id = _g('id');


		$getMerek = $this->contentHelper->getMerekProduk();
		$this->view->assign('getMerek',$getMerek);

		
		if (!$id){
			$this->view->assign('addnew',true);
		}else{
			$data = $this->contentHelper->getDataEvaluasi($id);
			// pr($data);
			$this->view->assign('data',$data[0]);
		}
		
		$this->view->assign('id',$id);
		if ($_POST['id']){

			$update = $this->contentHelper->updateDataEvaluasi($_POST);
			if ($update){
				$this->view->assign('status',true);
			}else{
				$this->view->assign('status',false);
			}
		}


		if (isset($_GET['act'])){
			if (intval($_GET['act'])>0){


				$approve = $this->contentHelper->validateData($id,$_GET['act']);
				if ($approve){
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}else{
					$this->view->assign('status',false);
				}
			}
		}

		return $this->loadView('evaluasi/evaluasi-detail');
	}
	
	
	// function ajax()
	// {
		
	// 	$id = _p('id');
	// 	$n_status = _p('n_status');
		
	// 	$data = $this->models->updateStatusFrame($id, $n_status);
	// 	if ($data){
	// 		print json_encode(array('status'=>true));
	// 	}else{
	// 		print json_encode(array('status'=>false));
	// 	}

	// 	exit;
	// }

	function ajax()
	{

	    $id = _p('merek');
	    $getKab = $this->contentHelper->getProdusen($id);
	    if ($getKab){
	      print json_encode(array('status'=>true, 'res'=>$getKab));
	    }else{
	      print json_encode(array('status'=>false));
	    }
	    
	    exit;
	}
}

?>
