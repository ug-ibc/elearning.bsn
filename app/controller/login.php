<?php

class login extends Controller {
	
	var $models = FALSE;
	var $view;
    var $loadSession = false;
	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
        $this->loadSession = new Session;

    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->loginHelper = $this->loadModel('loginHelper');
        $this->userHelper = $this->loadModel('userHelper');
	}
	
	function index(){

        $getCity = $this->contentHelper->getCity();
        // pr($getCity);

        $this->view->assign('city', $getCity);
    	return $this->loadView('register');
    }
    

    function local()
    {
        // pr($_POST);
        if (isset($_POST['token'])){

            $validateData = $this->loginHelper->local($_POST);
            
            if ($validateData){
                // set session
                $setSession = $this->loadSession->set_session($validateData);
                
                print json_encode(array('status'=>true));
            }else{
                print json_encode(array('status'=>false));
            }

        }

        exit;
    }

    

    function login(){

        global $basedomain;

        

    	return $this->loadView('user/login');
    }
    
    function register(){
    	return $this->loadView('user/register');
    }
    
    

}

?>
