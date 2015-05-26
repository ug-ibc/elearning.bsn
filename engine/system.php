<?php

/* hati-hati dengan file ini !!!
 * pemanggilan semua controller dimulai dari file ini 
 * file ini berubah, aplikasi tidak berjalan :-)
 */
 
define ('APPPATH', 'app/');
// define ('CODEKIR', true);
define ('LIBS', 'libs/');
define ('LOGS', 'logs/');
define ('CACHE', 'cache/');
define ('TMP', 'tmp/');

require_once (COREPATH.'loader.php');

if (is_array($CONFIG)) {
	
	if ($CONFIG['default']['app_underdevelopment'] == TRUE) under_development();

}

/* load halaman berdasarkan parameter 
 * yang diminta dari browser dengan method GET
 */


$setPage = NULL;
$setFunction = NULL;
$getURI = array();

/* Get page berdasarkan method GET 
$baseURI = ($_GET);
*/

// $baseURI = strip_tags($_SERVER['SCRIPT_NAME'].$_SERVER['REDIRECT_QUERY_STRING']);
$baseURI = strip_tags($_SERVER['QUERY_STRING']);

/* 	Ini untuk membuat path app menjadi dinamic, bukan statis lagi
	jadi app ini bisa ditaroh dimana aja gk harus di document root apache
	yeah.... :-)
*/


if ($baseURI){

	$explURI = explode('/', $baseURI);
	
	if ($explURI){
		
		foreach ($explURI as $key => $URI){
			if ($URI !=""){
				$getURI[] = $URI;
				
			}
		}
		
	}else{
		// URI tidak didefinisi
		
		show_error_page('URI not defined');
		exit;
	}
}


$vPage = form_validation($getURI);
// pr($vPage);exit;
if ($vPage){
	
	$validation['pid'] = @$vPage[0];
	if ($validation['pid']=='admin') exit;
	if ($validation['pid']=='services') exit;
	$validation['act'] = @$vPage[1];
	$validation['det'] = @$vPage['det'];
	
	
}


if (isset($validation)) {
	
	if (isset($validation['pid'])) {
		
		if ($validation['pid'] == ''){
			
			$setPage = $CONFIG['default']['default_view'];
			
		}else{
			if (in_array($validation['pid'], $ROUTES)){
				$setPage = $validation['pid'];
				
			}else{
				// redirect('./');
				
			}
			
		}
		
	}else{
		
		$setPage = $CONFIG['default']['default_view'];
		$setFunction = 'index';
		
	}
	
	if (isset($validation['act'])){
		
		
		($validation['act'] == '') ? $setFunction = 'index' : $setFunction = $validation['act'];
	} else {
		$setFunction = 'index';
	}
	
} else {
	
	/* jika halaman yang diminta tidak sesuai dengan
	 * konfigurasi maupun file yang dipanggil tidak ada
	 * maka gunakan halaman standar index
	 */
	
	$setPage = $CONFIG['default']['default_view'];
	$setFunction = 'index';

}

// pr($validation);exit;
$DATA['default']['page'] = @$setPage ;
$DATA['default']['function'] = @$setFunction ;
$DATA['default']['uri'] = @$validation ;

/* proses pemanggilan controller dimulai disini
 * controller akan memanggil file yang direquest oleh
 * user sesuai dengan parameter
 * yang dikirimkan lewat browser
 */
 

// pr($DATA);

$route = $_SERVER['PHP_SELF'];
$route = substr($route, strlen('/index.php'));

// exit;
$controller = new Controller;
$controller->index();

exit;

?>
