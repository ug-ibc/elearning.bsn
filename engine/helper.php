<?php

/* helper sistem */

function show_error_page($param){
	if (!empty($param)) echo $param; else echo 'Halaman tidak ditemukan';
}

function pr($data)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function vd($data)
{
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

function _p($data)
{
	return clean($_POST[$data]);
}

function _g($data)
{
	return clean($_GET[$data]);
}

function _r($data)
{
	return clean($_REQUEST[$data]);
}

function clean($data)
{
	return trim(strip_tags($data));
}

function error_code($code=000)
{
	global $CONFIG;
	if ($CONFIG['default']['app_status']=='Development'){
		$msgcode = $code;
	}else{
		$getLength = strlen($code);
		$msgcode = substr($code,$getLength-3, $getLength);
	}
	$msg = "<fieldset style='color:red'>Error code {$msgcode}</fieldset>";
	pr($msg);
}



?>
