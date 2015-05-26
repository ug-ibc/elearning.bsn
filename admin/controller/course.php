<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class course extends Controller {
	
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
		
		$this->mcourse = $this->loadModel('mcourse');
	}
	
	//module course group
	public function index(){
		// echo "masukk ajaa";
		$select = $this->mcourse->select_data();
		// pr($select);
		$this->view->assign('data',$select);
		return $this->loadView('course/coursegroup');

	}
	
	public function ajax_insert(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$namagrup =$_POST['namagrup'];
		$syaratkelulusan =$_POST['syaratkelulusan'];
		$n_status = 1;
		if ($namagrup != '' && $syaratkelulusan != ''){
			$insert = $this->mcourse->insert_data($namagrup,$syaratkelulusan,$n_status);
			// echo json_encode($data);
		}
		exit;
		
	}
	
	public function ajax_edit(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$idGrup_kursus =$_POST['idGrup_kursus'];
		
		if ($idGrup_kursus != ''){
			$edit = $this->mcourse->edit_data($idGrup_kursus);
			echo json_encode($edit);
		}
		exit;
	}
	
	public function ajax_update(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id = $_POST['id'];
		$namagrup =$_POST['namagrup'];
		$syaratkelulusan =$_POST['syaratkelulusan'];
		if ($namagrup != '' && $syaratkelulusan != ''){
			$update = $this->mcourse->update_data($id,$namagrup,$syaratkelulusan);
		}
		exit;
		
	}
	
	public function ajax_update_status(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id = $_POST['id'];
		$status =$_POST['status'];
		if($status == 1){
			$n_status = 0;
		}else{
			$n_status = 1;
		}
		if ($id != '' && $status != ''){
			$update_status = $this->mcourse->update_status($id,$n_status);
		}
		exit;
		
	}
	
	public function ajax_delete(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id =$_POST['id'];
		$n_status = 2;
		if ($id != ''){
			$insert = $this->mcourse->delete_data($id,$n_status);
			// echo json_encode($data);
		}
		exit;
		
	}
	
	//module course
	public function courselist(){
		$select_list_course = $this->mcourse->select_data_list_course();
		$this->view->assign('data',$select_list_course);
		
		$select_list_group = $this->mcourse->select_data_list_group();
		$this->view->assign('data_listgroup',$select_list_group);
		return $this->loadView('course/courselist');	
	}

	
	public function addcourse(){
		global $basedomain;
		$select = $this->mcourse->select_data_course();
		// pr($select);
		$this->view->assign('data',$select);
		return $this->loadView('course/addcourse');	
	}
	
	public function insert_course(){
		global $CONFIG;
		if(isset($_POST)){
		 // pr($_POST);
		 // exit;		
		 $x = form_validation($_POST);
		 try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						//update or insert
						$x['action'] = 'insert';
						if($x['id'] != ''){
							$x['action'] = 'update';
						}
						
						$data = $this->mcourse->course_insert($x);
			   		}
				   	
			   }catch (Exception $e){}
		echo "<script>alert('Course Successfully Created');window.location.href='".$CONFIG['admin']['base_url']."course/courselist'</script>";		
		}
		return $this->loadView('insert_course');
	}
	
	public function addgroup()
	{

		return $this->loadView('course/addgroup');
	}

	

	public function upload(){
		return $this->loadView('course/uploadfile');	
	}

	public function uploadfile(){
		return $this->loadView('course/uploadform');	
	}
	
	
	
}

?>
