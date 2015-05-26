<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );

class profile extends Controller {
	
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
		
		$this->models = $this->loadModel('mprofile');

	}
	
	public function index(){
		    
		$this->view->assign('admin',$this->admin['admin']);
		return $this->loadView('inputuser');

	}
    
	public function setting(){
		global $CONFIG,$basedomain;
		
		$id = $this->admin['admin']['id'];
		$x = form_validation($_POST);
		unset($x['token']);
		if(isset($_POST['old_password'])){
			
			$old_password = sha1($x['old_password'].$this->admin['admin']['salt']);

			if($old_password == $this->admin['admin']['password']){
				
				unset($x['old_password']);
				unset($x['repassword']);
				

				$x['password'] = sha1($x['password'].$this->admin['admin']['salt']);

			} else {
				echo "<script>alert('Denied. Wrong password');window.location.href='".$CONFIG['admin']['base_url']."profile'</script>";
			}
		} else {
			$x['password'] = $this->admin['admin']['password'];
		}
		
		$data = $this->models->updSettings($x,$id);


		if (_p('token')){

			$getUser = $this->models->updSess($x);

			if ($getUser){
				echo "<script>alert('Settings has been saved.');window.location.href='".$CONFIG['admin']['base_url']."profile'</script>";
			}else{
				redirect($basedomain.$CONFIG['admin']['login']);
			}
			
			exit;
		}

	}

}

?>
