<?php

class login extends Controller {
	
	var $models = FALSE;
	var $sessi = null;
	
	public function __construct()
	{
		$this->loadmodule();
		$this->setSmarty();
	}
	public function loadmodule()
	{
		$this->loginHelper = $this->loadModel('loginHelper');
		$this->userHelper = $this->loadModel('userHelper');
		
	}
	
	
	
	public function index()
	{
		global $CONFIG;
		// pr($_SESSION);
		return $this->loadView('login');
	}
	
	function local()
	{
		global $CONFIG,$basedomain;
		
		
		if (_p('token')){
			
			// echo $this->loadView('login-loader');
			
			
			$getUser = $this->loginHelper->goLogin();
			// pr($getUser);
			// pr($CONFIG);
			// pr($basedomain);
			// exit;
			if ($getUser){
				redirect($basedomain.$CONFIG['admin']['default_view']);
			}else{
				redirect($basedomain.$CONFIG['admin']['login']);
			}
			
			exit;
		}
		
		return $this->loadView('login');
	}
	
	function register()
	{
		global $CONFIG;
		$data['username'] = _p('email');
		$data['name'] = _p('name');
		$data['email'] = _p('email');
		$data['salt'] = 1234567890;

		if($_POST['password']!=''){
			$data['password'] = sha1(_P('password').$data['salt']);;
		}
		$getUser = $this->loginHelper->createUser($data);
		if ($getUser){
			echo "<script>alert('Data anda akan segera di proses oleh admin');window.location.href='".$CONFIG['admin']['base_url']."'</script>";
		}
		return false;
	}
	
	public function checkuser(){
		$new_user = $_POST['new_user'];

		$result = $this->loginHelper->user_check($new_user);

		if($result[0]['count'] > 0){
			$getData = array('status'=>"1");
		} else {
			$getData = array('status'=>"0");
		}
		
		echo json_encode($getData);
		
		exit;
	}
  
}

?>
