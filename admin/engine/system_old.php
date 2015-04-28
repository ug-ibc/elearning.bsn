<?php

/* hati-hati dengan file ini !!!
 * pemanggilan semua controller dimulai dari file ini 
 * file ini berubah, aplikasi tidak berjalan :-)
 */
 
define ('APPPATH', './');
define ('TATARUANG', true);

require_once (COREPATH.'loader.php');

if (is_array($CONFIG)) {
	
	if ($CONFIG['admin']['app_underdevelopment'] == TRUE) under_development();

}

/* load halaman berdasarkan parameter 
 * yang diminta dari browser dengan method GET
 */


// pr($_SERVER);
$setPage = NULL;
$setFunction = NULL;

$baseURI = strip_tags($_SERVER['QUERY_STRING']);

/* 	Ini untuk membuat path app menjadi dinamic, bukan statis lagi
	jadi app ini bisa ditaroh dimana aja gk harus di document root apache
	yeah.... :-)
*/

// pr($_SERVER);
$getURI = null;
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
// pr($vPage);
if ($vPage){
	
	$validation['pid'] = @$vPage[0];
	$validation['act'] = @$vPage[1];
	$validation['det'] = @$vPage['det'];
	
	
}

// pr($validation);exit;
if (isset($validation)) {
	
	if (isset($validation['pid'])) {
		
		if ($validation['pid'] == ''){
			
			$setPage = $CONFIG['admin']['default_view'];
			
		}else{
			
				$setPage = $validation['pid'];
				
			
		}
		
	}else{
		
		$setPage = $CONFIG['admin']['default_view'];
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
	
	$setPage = $CONFIG['admin']['default_view'];
	$setFunction = 'index';

}

// pr($validation);exit;
$DATA['admin']['page'] = @$setPage ;
$DATA['admin']['function'] = @$setFunction ;
$DATA['admin']['uri'] = @$validation ;

/* proses pemanggilan controller dimulai disini
 * controller akan memanggil file yang direquest oleh
 * user sesuai dengan parameter
 * yang dikirimkan lewat browser
 */
 
// pr($DATA);
// pr($_GET);

$route = $_SERVER['PHP_SELF'];
$route = substr($route, strlen('/index.php'));

$controller = new Controller;
$controller->index();

exit;

?>
