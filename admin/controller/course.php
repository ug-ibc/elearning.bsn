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
	
	public function ajax_delete_course_list(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id =$_POST['id'];
		$n_status = 2;
		if ($id != ''){
			$insert = $this->mcourse->delete_data_course_list($id,$n_status);
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
		if(isset($_GET['id']))
		{
			
			$id = form_validation($_GET);
			$id_course = $id['id'];
			if(isset($id['id']) && count($id)!=0)
			{	
				//for edit data
				$select_list = $this->mcourse->select_data_list_course_condition($id_course);
				// pr($select_list);
				$this->view->assign('data_list',$select_list);
				
				//for dropdown group course
				$select = $this->mcourse->select_data_course();
				// pr($select);
				$this->view->assign('data',$select);
				// exit;

				$grup = $this->mcourse->getGrup($select_list[0]['idGrup_kursus']);
				$this->view->assign('grup',$grup);

				return $this->loadView('course/addcourse');
			}else{	
				$select = $this->mcourse->select_data_course();
				// pr($select);
				$this->view->assign('data',$select);
				return $this->loadView('course/addcourse');
			}	
		} else {
			$select = $this->mcourse->select_data_course();
			// pr($select);
			$this->view->assign('data',$select);
			return $this->loadView('course/addcourse');
		}

	}
	
	public function insert_course(){
		global $CONFIG;
		if(isset($_POST)){
		 $x = form_validation($_POST);
		 // pr($_POST);
		 // exit;
		 // pr($_FILES);exit;
		 try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						//update or insert
						$x['action'] = 'insert';
						if($x['id'] != ''){
							$x['action'] = 'update';
						}
						
						if($_FILES['gambar']['name']){
							deleteFile($_POST['hiddenFile']);
							$upload = uploadFile('gambar',false,'image');
							$x['image']=$upload['full_name'];
						} else {
							$x['image'] = $_POST['hiddenFile'];
						}

						$data = $this->mcourse->course_insert($x);
			   		}
				   	
			   }catch (Exception $e){}
		if($x['id'] == ''){
			echo "<script>alert('Course Successfully Created');window.location.href='".$CONFIG['admin']['base_url']."course/courselist'</script>";		
		}else{
			echo "<script>alert('Course Successfully Update');window.location.href='".$CONFIG['admin']['base_url']."course/courselist'</script>";		
		}
	  }
		return $this->loadView('insert_course');
	}
	
	//update status course
	
	public function ajax_update_status_course(){
	
		//add code here
		// pr($_POST);
		$id = $_POST['id'];
		$status =$_POST['status'];
		if($status == 1){
			$n_status = 0;
		}else{
			$n_status = 1;
		}
		if ($id != '' && $status != ''){
			$update_status = $this->mcourse->update_status_course($id,$n_status);
		}
		exit;
	}
	
	public function addgroup()
	{

		return $this->loadView('course/addgroup');
	}

	//module upload video/ebook
	public function upload(){
		global $basedomain;
		// pr($basedomain);
		global $CONFIG;
		// pr($CONFIG);
		if(isset($_GET['id']))
		{
			
			$id = form_validation($_GET);
			$id_upload = $id['id'];
			if(isset($id['id']) && count($id)!=0)
			{	
				//select data upload
				$select_list_data_upload= $this->mcourse->select_data_list_upload_condt($id_upload);
				$this->view->assign('data_list_upload',$select_list_data_upload);

				//for dropdown list course
				$select_list_course = $this->mcourse->select_data_list_course($select_list_data_upload[0]["idGrup_kursus"]);
				$this->view->assign('data_list_course',$select_list_course);
				
				//for dropdown group course
				$select_list_group = $this->mcourse->select_data_list_group();
				$this->view->assign('data_group_course',$select_list_group);

				//for dropdown material course
				$select_list_material = $this->mcourse->select_data_list_material($select_list_data_upload[0]["idKursus"]);
				$this->view->assign('data_material_course',$select_list_material);
				
				return $this->loadView('course/uploadform');
				
			}else{	
				//for dropdown list course
				$select_list_course = $this->mcourse->select_data_list_course();
				$this->view->assign('data_list_course',$select_list_course);
				
				//for dropdown group course
				$select_list_group = $this->mcourse->select_data_list_group();
				$this->view->assign('data_group_course',$select_list_group);
				
				return $this->loadView('course/uploadform');
			}	
		} else {
			
			$select_list_group = $this->mcourse->select_data_list_group();
			$this->view->assign('data_group_course',$select_list_group);

			return $this->loadView('course/uploadform');
		}
	
			
	}
	
	public function insert_upload(){
		global $CONFIG;
		if(isset($_POST)){
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
						// upload file
						// pr($_FILES);
						if(!empty($_FILES['file_image']['name'])){
							// echo "masuk files";exit;
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['file_hidden']);
								$image = uploadFile('file_image',null,'image');
								$x['post_image'] = $image['full_name'];
							}
						}else{
							if(empty($_FILES['file_image']['name']) && $x['file_image'] != ""){	
								$x['post_image'] = $x['file_image'];
							}else{
								echo "file isi";
								$x['post_image'] = $x['file_hidden'];
							}
						}
						$data = $this->mcourse->upload_insert($x);
					}
				   	
			   }catch (Exception $e){}
		if($x['id'] == ''){
			echo "<script>alert('Upload Ebook & Video Successfully Created');window.location.href='".$CONFIG['admin']['base_url']."course/uploadfile'</script>";		
		}else{
			echo "<script>alert('Upload Ebook & Video Successfully Update');window.location.href='".$CONFIG['admin']['base_url']."course/uploadfile'</script>";		
		}
	  }
		return $this->loadView('insert_upload');
	}
	
	public function uploadfile(){
		//select data upload
		$select_list_data_upload= $this->mcourse->select_data_list_upload();
		$this->view->assign('data_list_upload',$select_list_data_upload);
		
		//for dropdown list course
		$select_list_course = $this->mcourse->select_data_list_course();
		$this->view->assign('data_list_course',$select_list_course);
		
		//for dropdown group course
		$select_list_group = $this->mcourse->select_data_list_group();
		$this->view->assign('data_group_course',$select_list_group);

		//for dropdown material course
		$select_list_material = $this->mcourse->select_data_list_material();
		$this->view->assign('data_material_course',$select_list_material);
		
		
		return $this->loadView('course/uploadfile');
	}
	
	public function ajax_update_status_upload(){
	
		//add code here
		// pr($_POST);
		$id = $_POST['id'];
		$status =$_POST['status'];
		if($status == 1){
			$n_status = 0;
		}else{
			$n_status = 1;
		}
		if ($id != '' && $status != ''){
			$update_status = $this->mcourse->update_status_upload($id,$n_status);
		}
		exit;
	}
	
	public function ajax_delete_course_upload(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id =$_POST['id'];
		$n_status = 2;
		if ($id != ''){
			$insert = $this->mcourse->delete_data_course_upload($id,$n_status);
			// echo json_encode($data);
		}
		exit;
		
	}
	
	public function viewmaterial(){
		$id = form_validation($_GET);
		$id_course = $id['id'];
		// pr($id);
		// echo "id course".$id_course;
		$this->view->assign('data',$id_course);
		
		//select header
		$select_header_material= $this->mcourse->select_data_header_material($id_course);
		// pr($select_header_material);
		$this->view->assign('data_header_material',$select_header_material);
		
		//select data upload
		$select_list_data_material= $this->mcourse->select_data_list_material($id_course);
		$this->view->assign('data_list_material',$select_list_data_material);
		
		return $this->loadView('course/material');
	}
	
	public function ajax_update_material(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$idMateri = $_POST['idMateri'];
		$namamateri =$_POST['namamateri'];
		$idKursus =$_POST['idKursus'];
		$jenismateri =$_POST['jenismateri'];
		$idGrup_kursus =$_POST['idGrup_kursus'];
		$urutan =$_POST['urutan'];
		$keterangan =$_POST['keterangan'];
		
		$syaratkelulusan =$_POST['syaratkelulusan'];
		if ($namamateri != '' && $urutan != ''){
			$update = $this->mcourse->update_data_material($idMateri,$namamateri,$idKursus,
															$jenismateri,$idGrup_kursus,$urutan,$keterangan);
		}
		exit;
		
	}
	
	public function ajax_get_data_material(){
	
	// pr($_POST);
	// echo masuk;
	// exit;
	global $basedomain;
	$idkursus =$_POST['idkursus'];
	
	if ($idkursus != ''){
		$edit = $this->mcourse->get_data($idkursus);
		echo json_encode($edit);
	}
	exit;
	}
	
	public function ajax_get_data_material_edit(){
	
	// pr($_POST);
	// echo masuk;
	// exit;
	global $basedomain;
	$idmateri =$_POST['idmateri'];
	
	if ($idmateri != ''){
		$edit = $this->mcourse->get_data_edit($idmateri);
		echo json_encode($edit);
	}
	exit;
	}
	
	public function ajax_insert_material(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		global $basedomain;
		$namamateri =$_POST['namamateri'];
		$idKursus =$_POST['idKursus'];
		$jenismateri =$_POST['jenismateri'];
		$idGrup_kursus =$_POST['idGrup_kursus'];
		$urutan =$_POST['urutan'];
		$keterangan =$_POST['keterangan'];
		$n_status = 1;
		if ($namamateri != '' && $urutan != ''){
			$insert = $this->mcourse->insert_data_material($namamateri,$idKursus,$jenismateri,$idGrup_kursus,$urutan,$keterangan,$n_status);
			// echo json_encode($data);
		}
		exit;
	}
	
	public function ajax_update_status_material(){
		
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
			$update_status = $this->mcourse->update_status_material($id,$n_status);
		}
		exit;
		
	}
	
	public function ajax_delete_course_material(){
		
		// pr($_POST);
		// echo masuk;
		// exit;
		$id =$_POST['id'];
		$n_status = 2;
		if ($id != ''){
			$insert = $this->mcourse->delete_data_course_material($id,$n_status);
			// echo json_encode($data);
		}
		exit;
		
	}

	public function ajaxchange(){

		$grupid = $_POST['grupid'];
		$kursusid = $_POST['kursusid'];
		$data = $this->mcourse->getGrup($grupid,$kursusid);

		print json_encode($data);

		exit;
	}
	
	public function ajaxmateri(){

		$kursusid = $_POST['kursusid'];
		$data = $this->mcourse->getMateri($kursusid);

		print json_encode($data);

		exit;

	}

	public function viewvisitor(){
		
		//register user
		$register_user= $this->mcourse->select_data_register_user();
		$this->view->assign('register_user',$register_user);
		//register  get sertificate
		$sertificate_user= $this->mcourse->select_data_sertificate_user();
		$this->view->assign('sertificate_user',$sertificate_user);
		
		//visitor
		$visitor_user= $this->mcourse->select_data_visitor_user();
		$this->view->assign('visitor_user',$visitor_user);
		
		return $this->loadView('course/statistic');
	}
	
	function cetak()
    {
		global $basedomain;
		//register user
		$register_user= $this->mcourse->select_data_register_user();
		$user_register = $register_user[0]['total'];
		
		//register  get sertificate
		$sertificate_user= $this->mcourse->select_data_sertificate_user();
		$user_sertificate = $sertificate_user[0]['total'];
		
		//visitor
		$visitor_user= $this->mcourse->select_data_visitor_user();
		$user_visitor = $visitor_user[0]['total'];
		
		// exit;
		$this->reportHelper =$this->loadModel('reportHelper');
		$html = "<div style=\"width: ; text-align: center;\">
					<h4>List User : </h4>
					 <table style=\"text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
						<thead>
							<tr class=\"\" >
								<td>registered users</td>
								<td>users who already <br>received a certificate</td>
								<td>users who just browse the web <br>without login</td>
							</tr>
							</thead>
							<tbody>
								<tr>
									<td align=\"center\">$user_register</td>
									<td align=\"center\">$user_sertificate</td>
									<td align=\"center\">$user_visitor</td>	
								</tr>
							</tbody>
						</table>
					</div>";

		$generate = $this->reportHelper->loadMpdf($html, 'visitor');
    }
		
}

?>
