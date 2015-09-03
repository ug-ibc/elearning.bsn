<?php

class register extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->loginHelper = $this->loadModel('loginHelper');
        $this->userHelper = $this->loadModel('userHelper');
	}
	
	function index(){

        $getCity = $this->contentHelper->getCity();
        // db($getCity);

        $this->view->assign('city', $getCity);
    	return $this->loadView('akun/page_register');
    }
    

    function local()
    {
        if (isset($_POST['token'])){

            $validateData = $this->loginHelper->local($_POST);
            if ($validateData){
                $_SESSION['user'] = $validateData;
                print json_encode(array('status'=>true));
            }else{
                print json_encode(array('status'=>false));
            }

        }

        exit;
    }

    function signup()
    {
        global $basedomain;
        // pr($_POST);
        if($_POST['g-recaptcha-response']){
            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcrRQwTAAAAACtWyyx6tUJO_TWg8l7ddhrriCDI&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
            // pr($response);
            if($response['success'] == false)
            {
              echo '<h2>You are spammer ! Get the @$%K out</h2>';
              exit;
            }
            else
            {
            
                if ($_POST['token']){

                    $is_email_valid = false;
                    $email_validate = $_POST['email'];

                    if (filter_var($email_validate, FILTER_VALIDATE_EMAIL)) {
                        $is_email_valid = true;
                    }

                    if (!$is_email_valid){
                        logFile('email not valid = '. $email_validate);
                        redirect($basedomain.'register');
                        exit;
                    } 

                    $register = $this->userHelper->createAccount($_POST);
                    if ($register){

                        $this->view->assign('email', $register['email']);
                        $this->view->assign('name', $register['name']);
                        $this->view->assign('encode', $register['encode']);
                        
                        $html = $this->loadView('akun/emailTemplate');
                        // db($register);
                        // logFile($msg);
                        // $html = "klik link berikut ini {$basedomain}register/validate/?ref={$msg}";
                        $send = sendGlobalMail($register['email'],false,$html);

                        redirect($basedomain.'register/status');
                    } 
                    else redirect($basedomain.'register');

                    exit;
                }
            }
        } else {
            echo "<script>alert('Silahkan Cek Captcha terlebih dahulu')</script>";
            redirect($basedomain."register");
        }
    }

    function status()
    {

        $getToken = _g('token');

        $this->view->assign('msg', 'Silahkan verifikasi email anda');
        return $this->loadView('akun/register_status');
    }

    function login(){

        global $basedomain;

        

    	return $this->loadView('user/login');
    }
    
    function register(){
    	return $this->loadView('user/register');
    }
    
    function validate()
    {

        $data = _g('ref');
        
        // db('ada');
        logFile($data);
        if ($data){

            $decode = unserialize(decode($data));
            // pr($decode);
            // check if token is valid
           
            $salt = "register";
            $userMail = $decode['email'];
            $origToken = sha1($salt.$userMail);

            // pr($decode);
            $getToken = $this->userHelper->getEmailToken($decode['email'], true);

            
            // db($getToken);
            if ($getToken['email_token']==$decode['token']){

                $updateStatusUser = $this->userHelper->updateStatusUser($decode['email']);

                // is valid, then create account and set status to validate
                $this->view->assign('validate','Validate account Success');
                $this->view->assign('status',true);
                $this->view->assign('email',$userMail);

            }else{

                // invalid token
                $this->view->assign('validate','Validate account error');
                $this->view->assign('status',false);
                logFile('token mismatch');
            }

            

        }
        

        return $this->loadView('akun/activate-account');
        
    }

    function ajax()
    {
        $email = @_p('email');

        if ($email){

            $validate = $this->userHelper->validateEmail($email);
            if ($validate){

                print json_encode(array('status'=>true));
            }else{
                print json_encode(array('status'=>false));
            }
        }
        

        $idprovinsi = @_p('idprovinsi');
        if ($idprovinsi){
            $getCity = $this->contentHelper->getCity($idprovinsi);
            // pr($getCity);
            if ($getCity){

                print json_encode(array('status'=>true, 'res'=>$getCity));
            }else{
                print json_encode(array('status'=>false));
            }
        }
        exit;
    }

    function setting(){

        return $this->loadView('user/setting');
    }

}

?>
