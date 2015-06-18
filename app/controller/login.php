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

        
    	return $this->loadView('register');
    }
    

    function local()
    {
        // pr($_POST);
        global $basedomain;
        if (isset($_POST['token'])){

            $validateData = $this->loginHelper->local($_POST);
            
            if ($validateData){
                // set session
                $setSession = $this->loadSession->set_session($validateData);
                
                if ($_POST['is_applykursus']){
                    $id = $_POST['is_applykursus'];
                    redirect($basedomain."quiz/startQuiz/?id={$id}");
                }else{
                    redirect($basedomain.'home');
                }
                exit;
            }else{
                redirect($basedomain);exit;
            }

        }

        
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
