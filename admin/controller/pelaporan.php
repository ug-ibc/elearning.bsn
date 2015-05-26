<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class pelaporan extends Controller {
	
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
		

		return $this->loadView('pelaporan');

	}

	function ajaxGetLokasiPabrik()
  	{

	    $getIndustri = _p('idIndustri');
	    $getPabrik = $this->contentHelper->getPabrik(false,$getIndustri);
	    if ($getPabrik){

	        foreach ($getPabrik as $key => $value) {
	          $tmp = $this->contentHelper->getKab($value['provinsi']);
	          $getPabrik[$key]['alamatPabrik'] = $tmp[0];
	          $tmpKab = $this->contentHelper->getKab($value['provinsi']);
	          $getPabrik[$key]['getCurrentKab'] = $tmpKab[0];
	          $tmpProv = $this->contentHelper->getLokasi($tmpKab[0]['parent']);
	          $getPabrik[$key]['getCurrentProv'] = $tmpProv[0];
	        }

	        // pr($getPabrik);
	        if ($getPabrik){
	          print json_encode(array('status'=>true, 'res'=>$getPabrik));
	        }else{
	          print json_encode(array('status'=>false));
	        }
	        
	        exit;
	        // $this->view->assign('listpabrik',$getPabrik);  
	    }
	 }

	function addKemasan()
	{

		$getIndustri = $this->contentHelper->getIndustri(false);
		// pr($getIndustri);
	    $this->view->assign('listindustri',$getIndustri); 
		return $this->loadView('pelaporan/pelaporan-kemasan-add');
	}

	function ajaxIndustri()
	{
		if (isset($_POST['get_pabrik'])){

			$id = _p('kode_wilayah');
		    if ($id){
		      $getPabrik = $this->contentHelper->getPabrik($id);
		      // pr($getPabrik);
		      if ($getPabrik){
		        $getIndustri = $this->contentHelper->getIndustri($getPabrik[0]['indusrtiID']);
		        
		        // pr($getIndustri);
		        $data['ind'] = $getIndustri[0];
		        $data['pabrik'] = $getPabrik[0];
		        // pr($data);
		        print json_encode(array('status'=>true, 'res'=>$data));
		      }else{
		        print json_encode(array('status'=>false));
		      }
		    }else{
		      print json_encode(array('status'=>false));
		    }
		}

		exit;
	}

	function buatlaporan()
	{

		if ($this->admin['admin']['type']==4){
			if ($this->admin['admin']['type']==4) $dataArr['n_status'] = '7';

			//get produsen
			$getIndustri = $this->contentHelper->getIndustri();
			$getProduk = $this->contentHelper->getProduk();
			$getTUlisan = $this->contentHelper->getTulisanPeringatan(false);
    		
			$this->view->assign('listindustri',$getIndustri); 
			$this->view->assign('produk',$getProduk);  
			$this->view->assign('tulisan',$getTUlisan);
			if ($_POST['addLaporan']){

				

		     	// echo 'masuk';
		      	pr($_POST);
		      	// pr($_FILES);

			    $saveData = $this->contentHelper->saveDataKemasan($_POST);
			    if ($saveData){

			        // pr($_FILES);
			        if(!empty($_FILES)){
			          

			            $foto = array('fotoDepan','fotoBelakang','fotoKanan','fotoKiri','fotoAtas','fotoBawah','suratPengantar');
			            foreach ($foto as $key => $value) {

			              if($_FILES[$value]['name'] != ''){
			                $image = uploadFile($value,null,'image');
			                // pr($image);
			                // exit;
			                if ($image){
			                  $dataImage[$value] =  $image;
			                }
			              }
			            }
			          // pr($dataImage);
			          
			          $dataImage['pabrikID'] = $_POST['pabrikID'];
			          $updateData = $this->contentHelper->updateDataKemasan($dataImage);
			          if ($updateData) reload($basedomain.'account/pelaporan');


			        }
			        reload($basedomain.'pelaporan/kemasan');
		      	}
			   
			}

			return $this->loadView('pelaporan/pelaporan-kemasan-add');
			exit;
		}
	}

	function kemasan()
	{


		// pelaporan balai 
		


		// pr($this->admin);
		if ($this->admin['admin']['type']==1) $dataArr['n_status'] = '1,2,3';
		if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '2';
		if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '1';
		if ($this->admin['admin']['type']==4) $dataArr['n_status'] = '7';

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
					echo "<script>window.location.href='".$basedomain."evaluasi'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}
			
		}
		

		// pr($data);exit;
		
		$this->view->assign('admin',$this->admin['admin']);

		return $this->loadView('pelaporan/pelaporan-kemasan');    
	}

	function nikotin()
	{

		if ($this->admin['admin']['type']==1) $dataArr['n_status'] = '1,2,3';
		if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '2';
		if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '1';
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
		
		// pr($data);exit;
		$this->view->assign('admin',$this->admin['admin']);

		return $this->loadView('pelaporan/pelaporan-nikotin');    
	}


	function detailkemasan()
	{
		global $basedomain;

		$id = _g('id');

		$dataArr['id'] = $id;
		if ($this->admin['admin']['type']==1) $dataArr['n_status'] = '1,2,3';
		if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '2';
		if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '1';
		if ($this->admin['admin']['type']==4) $dataArr['n_status'] = '7';

		if (isset($_GET['view'])){
			if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '3';
			if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '2';
			if ($this->admin['admin']['type']==4) $dataArr['n_status'] = '2';

			$this->view->assign('disableData',true);
		}

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
							3 => '10 slider/slop',
							4 => '12 btg/bks',
							5 => '50 btg/slinder',
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

				if ($this->admin['admin']['type']==2){
					$data[$key]['dataDisabled'] = 'disabled';
				}else{
					if (isset($_GET['view'])){
						$data[$key]['dataDisabled'] = 'disabled';
					}else{
						$data[$key]['dataDisabled'] = '';
					}

				}
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

				if (isset($_POST['reject'])){
					if ($this->admin['admin']['type']==2) $_POST['n_status'] = '1';
				}else{
					if ($this->admin['admin']['type']==2) $_POST['n_status'] = '3';
					if ($this->admin['admin']['type']==3) $_POST['n_status'] = '2';
					if ($this->admin['admin']['type']==4) $_POST['n_status'] = '2';
				}
				

				// $dataArr['n_status'] = 2;
				// $update = $this->contentHelper->updateStatusKemasan($dataArr);

				// pr($_POST);
				
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

		$this->view->assign('admin',$this->admin['admin']);

		return $this->loadView('pelaporan/pelaporan-kemasan-detail');
	}

	function detailnikotin()
	{
		global $basedomain;

		$id = _g('id');

		$dataArr['id'] = $id;
		if ($this->admin['admin']['type']==1) $dataArr['n_status'] = '1,2,3';
		if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '2';
		if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '1';

		if (isset($_GET['view'])){
			if ($this->admin['admin']['type']==2) $dataArr['n_status'] = '3';
			if ($this->admin['admin']['type']==3) $dataArr['n_status'] = '2';

			$this->view->assign('disableData',true);
		}

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
							3 => '10 slider/slop',
							4 => '12 btg/bks',
							5 => '50 btg/slinder',
							);
		$jenisRokok = array(1 => 'SKT',
							2 => 'SKM',
							);
		
		$data = $this->contentHelper->getLaporanNikotin($dataArr);
		

		if ($data){
			foreach ($data as $key => $value) {

				$data[$key]['namaProvinsi'] = $this->contentHelper->getLokasi($value['provinsi']);
				$data[$key]['d_tulisanPeringatan'] = $tulisanPeringatan[$value['tulisanPeringatan']];
				$data[$key]['d_bentukKemasan'] = $bentukKemasan[$value['bentuKemasan']];
				$data[$key]['d_isiKemasan'] = $isiKemasan[$value['isiKemasan']];
				$data[$key]['d_jenisRokok'] = $jenisRokok[$value['jenis']];

				if ($this->admin['admin']['type']==2){
					$data[$key]['dataDisabled'] = 'disabled';
				}else{
					if (isset($_GET['view'])){
						$data[$key]['dataDisabled'] = 'disabled';
					}else{
						$data[$key]['dataDisabled'] = '';
					}
					
				}

			}
			// pr($data);
			$this->view->assign('data',$data[0]);
		}
		
		$this->view->assign('id',$id);
		

		if (isset($_POST['idPelaporan'])){

			// pr($_POST);
			$checkBoxCount = count($_POST['pelaporanKemasan']);
			// if ($checkBoxCount == 14){

				$dataArr = array();
				$dataArr['id'] = $_POST['idPelaporan'];
				if (isset($_POST['reject'])){
					if ($this->admin['admin']['type']==2) $_POST['n_status'] = '1';
				}else{
					if ($this->admin['admin']['type']==2) $_POST['n_status'] = '3';
					if ($this->admin['admin']['type']==3) $_POST['n_status'] = '2';
				}

				if ($_POST['jenis']) $_POST['jenis'] = array_search($_POST['jenis'], $jenisRokok) ;
				if ($_POST['isiKemasan']) $_POST['isiKemasan'] = array_search($_POST['isiKemasan'], $isiKemasan) ;

				// pr($dataArr);
				// $update = $this->contentHelper->updateStatusNikotin($_POST,1);

				$update = $this->contentHelper->evaluasiNikotin($_POST);
				
				if ($update){
					echo "<script>window.location.href='".$basedomain."pelaporan/nikotin'</script>";
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
					echo "<script>window.location.href='".$basedomain."pelaporan/nikotin'</script>";
					// redirect($basedomain.'evaluasi');
				}
			}

			
		
		}

		$this->view->assign('admin',$this->admin['admin']);

		return $this->loadView('pelaporan/pelaporan-nikotin-detail');
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
		

		return $this->loadView('evaluasi');

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
		

		return $this->loadView('evaluasi');

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
		

		return $this->loadView('evaluasi');

	}

	public function detail(){

		global $basedomain;

		$id = _g('id');
		$data = $this->contentHelper->getDataEvaluasi($id);
		// pr($data);
		// $this->view->assign('data',$data[0]);
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

		return $this->loadView('pelaporan-detail');
	}
	
	
	function ajax()
	{
		
		$id = _p('id');
		$n_status = _p('n_status');
		
		$data = $this->models->updateStatusFrame($id, $n_status);
		if ($data){
			print json_encode(array('status'=>true));
		}else{
			print json_encode(array('status'=>false));
		}

		exit;
	}
}

?>
