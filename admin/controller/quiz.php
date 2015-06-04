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
    
	public function articleinp(){
		global $CONFIG;
		
		if(isset($_POST['n_status'])){
			if($_POST['n_status']=='on') $_POST['n_status']=1;
		} else {
			$_POST['n_status']=0;
		}

		if(isset($_POST['topcontent'])){
			if($_POST['topcontent']=='on') $_POST['topcontent']=1;
		} else {
			$_POST['topcontent']=0;
		}

		if(isset($_POST['slider_image'])){
			if($_POST['slider_image']=='on') $_POST['slider_image']=1;
		} else {
			$_POST['slider_image']=0;
		}
		
		if(isset($_POST['articletype'])){
			if($_POST['articletype']=='on') {
				if($_POST['articleid_old']!=0){
					$_POST['articletype'] = $_POST['articleid_old'];
				} else {
					$_POST['articletype']=1; 
				}
			}
		} else {
			$_POST['articletype']=0;
		}
 		

 		// pr($_POST);exit;	
		if(isset($_POST)){
                // validasi value yang masuk
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."home'</script>";
            }
	}
	
	public function articledel(){

		global $CONFIG;
		// pr($_POST);exit;
		$data = $this->models->article_del($_POST['ids']);
		
		echo "<script>alert('Data has been moved to trash');window.location.href='".$CONFIG['admin']['base_url']."home'</script>";
		
	}
	
	public function trash(){
       
		$data = $this->models->get_article_trash();
		if ($data){
			foreach ($data as $key => $val){
				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

				if($val['n_status'] == '2') {
					$data[$key]['n_status'] = 'Deleted';
					$data[$key]['status_color'] = 'red';
				} 
			}
		}

		$this->view->assign('active','active');
		$this->view->assign('data',$data);

		return $this->loadView('viewtrash');

	}
	
	
	public function articlerest(){

		global $CONFIG;
		
		$data = $this->models->article_restore($_POST['ids']);
		
		echo "<script>alert('Your data has been restore');window.location.href='".$CONFIG['admin']['base_url']."article/trash'</script>";
		
	}
	
	public function articledelp(){

		global $CONFIG;
		
		$id = $_GET['id'];

		$data = $this->models->article_delpermanent($id);
		
		echo "<script>alert('Data berhasil di hapus secara permanen');window.location.href='".$CONFIG['admin']['base_url']."article/trash'</script>";
		
	}

	public function upload(){

		return $this->loadView('uploadFrame');

	}

	public function uploadtwt(){

		return $this->loadView('uploadFrameTwt');

	}

	public function uplFrame(){
		global $CONFIG;

		//upload file
		if(!empty($_FILES)){
			if($_FILES['file_frame']['name'] != ''){
				$image = uploadFile('file_frame','frame','image');

				$data[0]['title'] = $_POST['title'];
				$data[0]['typealbum'] = $_POST['typealbum'];
				$data[0]['gallerytype'] = 1;
				$data[0]['content'] = $image['full_name'];
				$data[0]['files'] = $image['full_name'];
				$data[0]['created_date'] = date("Y-m-d H:i:s");
				$data[0]['n_status'] = 1;

			} else {
				echo "<script>alert('You have to choose frame file');window.location.href='".$CONFIG['admin']['base_url']."article/upload'</script>";
			}

			if($_FILES['file_cover']['name'] != ''){
				$image = uploadFile('file_cover','cover','image');

				$data[1]['title'] = $_POST['title'];
				$data[1]['typealbum'] = $_POST['typealbum'];
				$data[1]['gallerytype'] = 2;
				$data[1]['content'] = $image['full_name'];
				$data[1]['files'] = $image['full_name'];
				$data[1]['created_date'] = date("Y-m-d H:i:s");
				$data[1]['n_status'] = 1;

			} else {
				echo "<script>alert('You have to choose cover file');window.location.href='".$CONFIG['admin']['base_url']."article/upload'</script>";
			}

				$data = $this->models->frame_inp($data);

				echo "<script>alert('Files has been uploaded');window.location.href='".$CONFIG['admin']['base_url']."home/frame'</script>";
		} else {

			echo "<script>alert('No file has been selected');window.location.href='".$CONFIG['admin']['base_url']."article/upload'</script>";

		}
	}

	function profil()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(1);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=1;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function visimisi()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(3);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=3;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function tupoksi()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(4);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=4;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function peraturan()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(5);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=5;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function penelitian()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(6);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=6;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function faq()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(7);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=7;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function saran()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(8);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=8;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function alurprosedur()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(9);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=9;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}

	function petunjuk()
	{

		global $CONFIG;
		$getProfil = $this->models->getContent(10);
		$this->view->assign('data',$getProfil[0]);

		if ($_POST['title']){
			$_POST['articletype']=10;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/profil'</script>";
            
		}

		return $this->loadView('profil');
	}


	function kontak()
	{
		global $CONFIG;
		$getKontak = $this->models->getContent(2);
		$this->view->assign('data',$getKontak[0]);

		if ($_POST['title']){
			$_POST['articletype']=2;
			$_POST['n_status']=1;
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
						
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',null,'image');
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
			   
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$CONFIG['admin']['base_url']."article/kontak'</script>";
            
		}

		return $this->loadView('kontak');
	}

}

?>
