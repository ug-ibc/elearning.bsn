<?php

class Application {
	
	var $page;
	var $func;
	var $configkey = 'default';
	var $view = false;
	
	protected $php_ext = "";
	protected $html_ext = "";
	protected $sessi = "";
	protected $user = "";
	
	
	public function __construct(){
		global $CONFIG, $DATA, $LOCALE;
		
		if (array_key_exists('admin', $CONFIG)){
			$this->configkey = 'admin';
			
		}
		if (array_key_exists('dashboard', $CONFIG)){
			$this->configkey = 'dashboard';
		}
		if (array_key_exists('services', $CONFIG)){
			$this->configkey = 'services';
		}

		// pr($DATA);exit;
		$this->php_ext = $CONFIG[$this->configkey]['php_ext'];
		$this->html_ext = $CONFIG[$this->configkey]['html_ext'];
		$this->page = $DATA[$this->configkey]['page'];
		$this->func = $DATA[$this->configkey]['function'];
		
		$this->loadLibrary();
		
	}
	/* load every library */
	function loadLibrary()
	{
		
		$GLOBALS['CODEKIR']['smarty'] = $this->setSmarty();
		$GLOBALS['CODEKIR']['purifier'] = $this->setPurifier();
		
	}
	
	function setSmarty()
	{
		global $SMARTY;
		
		$view = new Smarty();
		$view->setTemplateDir($SMARTY[0]['template']);
		$view->setCompileDir($SMARTY[0]['logs']);
		$view->setCacheDir($SMARTY[0]['cache']);
		$view->setConfigDir($SMARTY[0]['config']);
		
		return $view;
	}
	
	function setPurifier()
	{
		
		$filePath = LIBS.'purifier/library/HTMLPurifier.auto.php';
		
		if (is_file($filePath)){
			
			require_once $filePath;
		
			$puri_config = HTMLPurifier_Config::createDefault();
			$puri_config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
			// $puri_config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
			
			$purifier = new HTMLPurifier($puri_config);
			
			return $purifier;
		}
		
		return false;
		
	}
	
	function excel($file=false)
	{
		error_reporting(E_ALL ^ E_NOTICE);
		
		global $CONFIG, $EXCEL;
		if (!$file) return false;
		if (!in_array($_FILES[$file]['type'], $EXCEL[0]['filetype'])) return false;
		
		$excel = "";
		$filename = ($_FILES[$file]['tmp_name']);
		$excelEngine = LIBS . 'excel/excel_reader' . $CONFIG[$this->configkey]['php_ext'];
		if (is_file($excelEngine)){
			
			require_once ($excelEngine);
			
			$excel = new Spreadsheet_Excel_Reader($filename);
			
		}
		
		return $excel;
	}
	
	function loadView($fileName='home', $data="")
	{
		
		global $CONFIG, $basedomain, $rootpath, $app_domain;
		
		if ($fileName == "") return false;
		if (array_key_exists('admin', $CONFIG)){
			$this->configkey = 'admin';
		}
		if (array_key_exists('dashboard', $CONFIG)){
			$this->configkey = 'dashboard';
		}
		if (array_key_exists('services', $CONFIG)){
			$this->configkey = 'services';
		}
		$getFileView = null;
		// $php_ext = $CONFIG[$this->configkey]['php_ext'];
		$html_ext = $CONFIG[$this->configkey]['html_ext'];
		
		if ($data !=''){
			/* Ubah subkey menjadi key utama */
			foreach ($data as $key => $value){
				$$key = $value;
			}
		}
		
		if (!$this->view) $this->view = $this->setSmarty();
		
		$this->view->assign('basedomain',$basedomain);
        $this->view->assign('rootpath',$rootpath);
		
		/* include file view */
		if (is_file(APP_VIEW.$fileName.$html_ext)) {
			if ($fileName !='') $fileName = $fileName.$html_ext;
			
			if (file_exists(APP_VIEW.$fileName)){
			
				ob_start();
				// include APP_VIEW.$fileName;
				$this->view->display(APP_VIEW.$fileName);
				$getFileView = ob_get_contents();
				ob_end_clean();
				
				return $getFileView;
			}else{ 
				show_error_page('File not exist');
				die();
			}
			
		}else{
		
			show_error_page('File not exist');
			die();
		}
		
		//return TRUE;
	}
	
	
	
	function load($param=false, $debug=false)
	{
		
		if (!$param) return false;
		
		if ($param['file'] !='') $fileName = $param['file'].'.php';
		
		if ($debug){ pr($param['path'].$fileName); exit; }
		if (is_file($param['path'].$fileName)){
		
			include_once $param['path'].$fileName;
			
			$$param['file'] = new $param['file']();
			
			ob_get_clean();
			return $$param['file'];
		}
		
		return false;
	}
	
	function loadSessi($param=null)
	{
		global $CONFIG;
		
		if ($param =="") return false;
		
		$filename = COREPATH.$param.$CONFIG[$this->configkey]['php_ext'];
		if (file_exists($filename)){
			
			$include = include $filename;
			$object = new Session();
			
			ob_get_clean();
			
			return $object;
			
		}
		
		return false;
		
	}
	
	function loadModel($fileName=false)
	{
		global $CONFIG;
		
		if (!$fileName) return false;
		$dataArr = array();
		
		if (array_key_exists('admin', $CONFIG)){
			$this->configkey = 'admin';
		}
		if (array_key_exists('services', $CONFIG)){
			$this->configkey = 'services';
		}
		
		$php_ext = $CONFIG[$this->configkey]['php_ext'];
		if (is_file(APP_MODELS.$fileName.$php_ext)) {
			
			$dataArr['file'] = $fileName;
			$dataArr['path'] = APP_MODELS;
			return $this->load($dataArr);
			
		}
		
		return false;
		
	}
	
	/* under develope */
	// function assign($key, $data)
	// {
		// return array($key => $data);
	// }
	
	
	function validatePage()
	{
		global $basedomain, $CONFIG, $DATA;
		if (!$this->isUserOnline()){
			
			redirect($basedomain.$CONFIG[$this->configkey]['login']);
			exit;
		}else{
		
			if ($DATA[$this->configkey]['page'] == $CONFIG[$this->configkey]['login']){
				
				redirect($basedomain.$CONFIG[$this->configkey]['default_view']);
				exit;
			}
		}
		
	}
	
	
}

?>
