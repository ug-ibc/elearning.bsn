<?php

class user extends Controller {
	
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
		
		$this->userHelper = $this->loadModel('userHelper');
		$this->contentHelper = $this->loadModel('contentHelper');
	}
	
	public function index(){
       
		
		$dataUser = $this->userHelper->getUserData();

		// pr($_POST);

		if ($_POST['status']){
			
			$iduser = implode(',', $_POST['ids']);
			$updateUser = $this->userHelper->updateUser($iduser, $_POST['status']);
			if ($updateUser){
				$this->view->assign('status',true);
			}else{
				$this->view->assign('status',false);
			}
		}

		$this->view->assign('data',$dataUser);
		return $this->loadView('user');

	}
    
	
	function show(){
       
		// $data = $this->contentHelper->getData();
		// pr($data);
		return $this->loadView('home');

	}
	
	function add(){
       
		global $basedomain;
		
		// if (_p('token')){
			
			
		// 	$uploadImage['status'] = false;
		// 	if ($_FILES['image']['name']!="")$uploadImage = uploadFile('image','user');
			
		if ($_POST['name']){

			$addUser = $this->userHelper->addUser($_POST);
			if ($addUser){
				$this->view->assign('status',true);
			}else{
				$this->view->assign('status',false);
			}
		}
		// 	$addUser = $this->userHelper->addUser();
		// 	if ($uploadImage['status']){
				
		// 		$updateUser = $this->userHelper->updateUserImage($uploadImage['filename'],$addUser);
		// 	}
			
		// 	if ($addUser) redirect($basedomain.'user');
		// 	exit;
		// }
		// pr($_POST);
		
		return $this->loadView('user-detail');

	}
	
	
	function edit()
	{
		global $basedomain, $app_domain;;
		$userid['id'] = intval(_g('id'));

		$dataUser = $this->userHelper->getListUser($userid);
		if ($dataUser){
			$getIndustri = $this->contentHelper->getIndustri($dataUser[0]['industri_id']);

			foreach ($dataUser as $key => $value) {
				$dataUser[$key]['perusahaan'] = $getIndustri[0];
			}
		}
		

		
		if (_p('token')){
			
			// upload image 
			
			$uploadImage['status'] = false;
			if ($_FILES['image']['name']!="")$uploadImage = uploadFile('image','user');
			
			
			$dataarr = array();
			$userid = intval(_p('id'));
			$addUser = $this->userHelper->updateUserProfile($dataarr,$userid);
			if ($uploadImage['status']){
				
				$updateUser = $this->userHelper->updateUserImage($uploadImage['filename'],$addUser);
			}
			
			if ($addUser) redirect($basedomain.'user');
			exit;
		}

		// pr($dataUser);
		$this->view->assign('data',$dataUser[0]);
		return $this->loadView('user-detail');
	}
	
	function delete()
	{
		$id = intval(_p('id'));
		if ($id>0){
			$del = $this->userHelper->deleteUser($id);
			if ($del){
				print json_encode(array('status'=>true));
			}else{
				print json_encode(array('status'=>false));
			}
		}
		
		exit;
	}
	
	function register_admin()
	{
		global $CONFIG;
		pr($_POST);exit;
		if(!empty($_POST)){
			$x = form_validation($_POST);

			   try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						pr($_POST);exit;
						$data = $this->models->upd_pass($pass);
			   		}
			}catch (Exception $e){}
			
		}
			echo "<script>window.location.href='".$CONFIG['admin']['base_url']."'</script>";
		
	}
}

?>
