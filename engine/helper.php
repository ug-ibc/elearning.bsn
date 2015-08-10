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

	if (isset($_POST[$data]))return clean($_POST[$data]);
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

function debug($var=false)
{
	if ($var) pr($var);
	else pr('masuk');
	exit;
}

function db($var=false)
{
	debug($var);
}

function limit_words ($text, $max_words) {
    $split = preg_split('/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
    $truncated = '';
    for ($i = 0; $i < min(count($split), $max_words*2); $i += 2) {
        $truncated .= $split[$i].$split[$i+1];
    }
    return trim($truncated);
}

function limit_char ($text,$char)
{
	if ( mb_strlen( $text, 'utf8' ) > $char ) {
	   $last_space = strrpos( substr( $text, 0, $char ), ' ' ); // find the last space within 35 characters
	   $text = substr( $text, 0, $last_space );
	}

	return $text;
}	

?>
