<?php

/* Kumpulan fungsi umum yang sering digunakan */

function base_url() {
	global $config;
	
	$base_url = $config['base_url'];
	
	return $base_url;
}

function changeDate($date=false)
{
	if (!$date) return false;
	$changeFormat = date("j F Y",strtotime($date));
	
	return $changeFormat;
}

function change_date_simple($date_data, $type, $order_by)
{
	/* ex : change_date_to_slash('2012-01-01', 'slash', 'by_date') */
	
	($date_data !='') ? $status = 1 : exit ('Date not complete');
	
	if ($type == 'slash')
	{
		list ($tahun, $bulan, $tanggal) = explode ('-',$date_data);
	
		if ($order_by == 'by_year') $new_date = "$tahun/$bulan/$tanggal";
		if ($order_by == 'by_month') $new_date = "$bulan/$tanggal/$tahun";
		if ($order_by == 'by_date') $new_date = "$tanggal/$bulan/$tahun";
	}
	else if ($type == 'strip')
	{
		list ($tahun, $bulan, $tanggal) = explode ('/',$date_data);
	
		if ($order_by == 'by_year') $new_date = "$tahun-$bulan-$tanggal";
		if ($order_by == 'by_month') $new_date = "$bulan-$tanggal-$tahun";
		if ($order_by == 'by_date') $new_date = "$tanggal-$bulan-$tahun";
	}
	
}
	
function simple_paging($paging_data, $limit)
{
	if ($paging_data==0)
	{
		echo '<script type=text/javascript>alert("Page Not Found"); window.location.href="?pid=1";</script>';
	}
	if ($paging_data== 1)
	{
		$paging = ((($paging_data - 1) * $limit));
	}else
	{
		$paging = ((($paging_data - 1) * $limit) + 1);
	}
	
	return $paging;
}
	
function form_validation($data)
{
	if (!$data) return false;
	$valid_post_vars = $data;
						
	$dataArr = array ();			
	foreach ($valid_post_vars as $key => $value) {
		//echo $key;
		//echo $value;
		//$prefix_post_vars = "p_";
		//$valid_post_var_name = $prefix_post_vars . $i_vpv;
		
		$valid_post_var_value = trim(htmlspecialchars($value));
		
		//$$valid_post_var_name = $valid_post_var_value;

		$dataArr[$key] = $valid_post_var_value;
		
	}
	
	return $dataArr;
	//print_r($dataArr);
}
	
function clear_var($data)
{
	return $$data = '';
}

function under_development() {

	echo 'Maaf, Situs ini sedang dalam perbaikan';
	
	exit;
}

function redirect($data) {
	
	echo "<meta http-equiv=\"refresh\" content=\"0; url={$data}\">";

}


function imageFrame($filename=false, $framefile=false)
{

	global $IMAGE, $CONFIG;

	if (array_key_exists('mobile',$CONFIG)) include(APP.LIBS.'class_image_upload/class.upload.php');
	else include(LIBS.'class_image_upload/class.upload.php');

	deleteFile($filename,'imageFramed');
	// pr($IMAGE[0]['pathfile'].$filename);
	$handle = new Upload($IMAGE[0]['pathfile'].$filename);
	// pr($handle);
	if ($handle->uploaded) {
		$handle->image_resize = true;
		$handle->image_x = 180;
		$handle->image_y = 181;
		$handle->image_ratio_crop = false;
		$handle->jpeg_quality = 100;
		$handle->image_watermark = $IMAGE[0]['pathframe'].$framefile;

		$handle->Process($IMAGE[0]['imageframed']);
		if ($handle->processed) {
			$filename = $handle->file_dst_name;
		}else{
			echo 'Error: ' . $handle->error . '';
		}
		$handle-> Clean();
		return true;
	}else{
		echo 'Error: ' . $handle->error . '';
	}
	
	return false;
}

/**
 * @todo upload file function
 * @param String $data = name attribut of file to be upload
 * @param String $path = string path to upload file
 * 
 * @return Array $result = array('status' => '', 'message' => '', 'full_path' => '', 'full_name' => '', 'raw_name' => '');
 * @return int status = 0/1
 * @return String message = message to print at view
 * @return String full_path = to process the uploaded file
 * @return String full_name = full name of uploaded file, include extension
 * @return String raw_name = raw name of uploaded file
 * */
function uploadFile($data,$path=null,$ext){
	global $CONFIG;
	
	if (array_key_exists('admin',$CONFIG)) $key = 'admin';
	if (array_key_exists('default',$CONFIG)) $key = 'default';
    if (array_key_exists('mobile',$CONFIG)) $key = 'mobile';
    /* result template
    $result = array(
        'status' => '',
        'message' => '',
        'full_path' => '',
        'full_name' => '',
        'raw_name' => '',
        'real_name' => ''
    );
    */
    if($ext){
        if (!in_array($_FILES[$data]['type'], $CONFIG[$key][$ext])){
            $result = array(
                'status' => '0',
                'message' => 'File type is not allowed.',
                'full_path' => '',
                'full_name' => '',
                'raw_name' => '',
                'real_name' => ''
            );
            return $result;
        }
	}
	logFile(serialize($_FILES[$data]));

	if ($path!='') $path = $path.'/';
	$pathFile = $CONFIG[$key]['upload_path'].$path;
	$ext = explode ('.',$_FILES[$data]["name"]);
	$countExt = count($ext);
	$getExt = $ext[$countExt-1];
	$shufflefilename = md5(str_shuffle('codekir-v0.3'.$CONFIG[$key]['max_filesize']));
	$filename = $shufflefilename.'.'.$getExt;
	
	/* Host Folder path */
	list($root_path, $dummy) = explode('admin',$CONFIG[$key]['root_path']);
	list($dummy, $pathFolder) = explode($root_path,$pathFile);

	if ($_FILES[$data]["error"] > 0){
	
		echo "Return Code: " . $_FILES[$data]["error"] . "<br>";
	
	}else{
	
		$_FILES[$data]["name"];
		($_FILES[$data]["size"] / $CONFIG[$key]['max_filesize']);
		$_FILES[$data]["tmp_name"];

		// if (file_exists($pathFile. $_FILES[$data]["name"])){
		// 	$result = array(
		// 		'status' => '0',
		// 		'message' => 'File exist.',
		// 		'full_path' => $pathFile,
		// 		'full_name' => $filename,
		// 		'raw_name' => $shufflefilename,
  //               'real_name' => $_FILES[$data]["name"],
  //               'folder_name' => $pathFolder
		// 	);
		// 	return $result;
		// }else{
		
			$moved = move_uploaded_file($_FILES[$data]["tmp_name"],$pathFile . $filename);
    		if($moved){
            	$result = array(
    				'status' => '1',
    				'message' => 'Upload Succeed.',
    				'full_path' => $pathFile,
    				'full_name' => $filename,
    				'raw_name' => $shufflefilename,
                    'real_name' => $_FILES[$data]["name"],
                    'folder_name' => $pathFolder
    			);
            }else{
                $result[] = array(
    				'status' => '0',
    				'message' => 'Move Uploaded File Failed.',
    				'full_path' => $pathFile,
    				'full_name' => $filename,
    				'raw_name' => $shufflefilename,
                    'real_name' => $_FILES[$data]["name"][$filekey],
                    'folder_name' => $pathFolder
    			);
            }

			// pr($result);exit;
			return $result;
		// }
	}
	
	return $filename;
}

/**
 * @todo upload file function
 * @param String $data = name attribut of file to be upload
 * @param String $path = string path to upload file
 * 
 * @return Array $result = array('status' => '', 'message' => '', 'full_path' => '', 'full_name' => '', 'raw_name' => '');
 * @return int status = 0/1
 * @return String message = message to print at view
 * @return String full_path = to process the uploaded file
 * @return String full_name = full name of uploaded file, include extension
 * @return String raw_name = raw name of uploaded file
 * */
function uploadFileMultiple($data,$path=null,$ext){
	global $CONFIG;
	
	if (array_key_exists('admin',$CONFIG)) $key = 'admin';
	if (array_key_exists('default',$CONFIG)) $key = 'default';
    if (array_key_exists('mobile',$CONFIG)) $key = 'mobile';
    /* result template
    $result = array(
        'status' => '',
        'message' => '',
        'full_path' => '',
        'full_name' => '',
        'raw_name' => '',
        'real_name' => ''
    );
    */
	logFile(serialize($_FILES[$data]));
    $result = array();
	foreach($_FILES[$data]['type'] as $filekey => $filevalue){
	
	    if (!in_array($_FILES[$data]['type'][$filekey], $CONFIG[$key][$ext])){
	        $result[] = array(
	            'status' => '0',
	            'message' => 'File type is not allowed.',
	            'full_path' => '',
	            'full_name' => '',
	            'raw_name' => '',
	            'real_name' => ''
	        );
	        
	    }

		if ($path!='') $pathslash = $path.'/';
		$pathFile = $CONFIG[$key]['upload_path'].$pathslash;
		$extfile = explode ('.',$_FILES[$data]["name"][$filekey]);
		$countExt = count($extfile);
		$getExt = $extfile[$countExt-1];
		$shufflefilename = md5(str_shuffle('codekir-v0.3'.$CONFIG[$key]['max_filesize']));
		$filename = $shufflefilename.'.'.$getExt;
		
		/* Host Folder path */
		list($root_path, $dummy) = explode('admin',$CONFIG[$key]['root_path']);
		list($dummy, $pathFolder) = explode($root_path,$pathFile);

		if ($_FILES[$data]["error"][$filekey] > 0){
		
			echo "Return Code: " . $_FILES[$data]["error"][$filekey] . "<br>";
		
		}else{
		
			$_FILES[$data]["name"][$filekey];
			($_FILES[$data]["size"][$filekey] / $CONFIG[$key]['max_filesize']);
			$_FILES[$data]["tmp_name"][$filekey];
			
			$moved = move_uploaded_file($_FILES[$data]["tmp_name"][$filekey],$pathFile . $filename);
			if($moved){
            
                $result[] = array(
    				'status' => '1',
    				'message' => 'Upload Succeed.',
    				'full_path' => $pathFile,
    				'full_name' => $filename,
    				'raw_name' => $shufflefilename,
                    'real_name' => $_FILES[$data]["name"][$filekey],
                    'folder_name' => $pathFolder
    			);
            }else{
                $result[] = array(
    				'status' => '0',
    				'message' => 'Move Uploaded File Failed.',
    				'full_path' => $pathFile,
    				'full_name' => $filename,
    				'raw_name' => $shufflefilename,
                    'real_name' => $_FILES[$data]["name"][$filekey],
                    'folder_name' => $pathFolder
    			);
            }
			
		}
		
	}
	
	return $result;
}

function deleteFile($data=null, $path=null)
{	
	global $CONFIG;
	
	if (array_key_exists('admin',$CONFIG)) $key = 'admin';
	if (array_key_exists('default',$CONFIG)) $key = 'default';
	if (array_key_exists('mobile',$CONFIG)) $key = 'mobile';
	
	if ($data == null) return false;
	if ($path!='') $data = $path.'/'.$data;	
	
	$fileName = $CONFIG[$key]['upload_path'].$data;
	
	if (is_file($fileName)){
		unlink($fileName);
	}else{
		return false;
	}
	
}

function encode($data=false)
{
	if ($data){
		$hasil = base64_encode(serialize($data));
		return $hasil;
	}
	
}

function decode($data=false)
{
	
	if ($data){
		$hasil = unserialize(base64_decode($data));
		return $hasil;
	}
	
}

function getindexzip($name=null)
{
	
	if ($name==null) return false;
	
	$zip = new ZipArchive;

	if ($zip->open($name) == TRUE) {
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$filename[] = $zip->getNameIndex($i);
		 
		}
	}
	
	if (is_array($filename)) return $filename;
	return false;
}

function unzip($file=null, $path=null)
{
	global $CONFIG;

	if ($file==null) return false;
	
	$zip = new ZipArchive;
	if ($zip->open($file) === TRUE) {
		$zip->extractTo($path);
		$zip->close();
        unlink($file);
		return true;
	}else{
        unlink($file);
        return false;
	}
}

/**
 * @todo unzip file
 * @param String $file = full path to file that will be extract, including extension
 * @param String $path_extract = path to folder where $file will be extract
 * 
 * @return true
 * */
function s_linux_unzip($file, $path_extract){
    mkdir($path_extract, 0755);

    //extract and delete zip file             
    shell_exec("unzip -jo $file  -d $path_extract");
    //unlink($file);
    return true;
}

/**
 * @todo create folder
 * @param array $path_array = array contain folder that will be created array($path_1, $path_2)
 * @param int $permission = value of permission access to folder
 * */
function createFolder($path_array, $permissions){
    foreach ($path_array as $dir) {
        if (!is_dir($dir)){
            mkdir($dir, $permissions, TRUE);
        }
    }
}

/**
 * @todo calculate excecution time
 * @param int $timeStart = start time in microtime
 * @param int $timeEnd = end time in microtime
 * @return int/float
 * */
function execTime($timeStart, $timeEnd)
{
	$time = $timeEnd  - $timeStart ;
	
	$runTime = number_format($time,3) . ' Seconds';
	return $runTime;
}

/**
* @todo Delete a file, or a folder and its contents
* @param string $dirPath Directory to delete
* @return bool Returns TRUE on success, FALSE on failure
*/
function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    return rmdir($dirPath);
}

/**
 * @todo create log file
 * @param string $comment = comment log
 * */
function logFile($comment, $fileName=false, $method=false)
{
	
	/*
		method false = "a"
		method (true)1 = w
	*/
	$path = LOGS;
	
	if (!$fileName) $fileName = 'Log-'.date('d-m-Y').'.txt';
	
	if ($method){
		$handle = fopen($path.$fileName, "w");
	}else{
		$handle = fopen($path.$fileName, "a");
	}
	
	fwrite($handle, "{$comment}"."\n");
	fclose($handle);
}

function sftpServices($host="localhost", $user=false, $pass=false, $filename=false, $singleAccount=false)
{

	global $CONFIG, $sftpConfig;

	logFile('host ='.$host.'user='.$user.'pass='.$pass.'filename='.$filename.'single='.$singleAccount);

	if (!$user && !$pass && !$filename) return false;
	$folderTmp = $user."/".$CONFIG['default']['zip_foldername']."/";
	$pathFile = $CONFIG['default']['upload_path_temporary'].$folderTmp.$filename;

	if ($singleAccount){

		$user = $sftpConfig['user'];
		$pass = $sftpConfig['pass'];
		$host = $sftpConfig['host'];

		$folderTmp = $user."/".$CONFIG['default']['zip_foldername']."/";
		$pathFile = $CONFIG['default']['upload_path_temporary'].$folderTmp.$filename;
		
	}

	logFile(serialize($sftpConfig));

	if ($sftpConfig['mode']=='1'){

		$shellExec = "cd ".$CONFIG['default']['upload_path']." && sftp ".$user."@".$host.":".$pathFile;
		logFile($shellExec);
		exec($shellExec);

		return true;
		exit;
	}

	// if using single account to upload zip file 
	

	$portDefine = $sftpConfig['port'];

	
	logFile("begin connection ssh2");
	$connection = ssh2_connect($host, $portDefine);


	logFile("connect=".$connection." user=".$user." pass=".$pass);
	
	if (ssh2_auth_password($connection, $user, $pass)){
		logFile('sftp connected'); 
	}else{
		logFile('sftp failed connected');
		return false; 
	}

	$sftp = ssh2_sftp($connection);

	
	if (ssh2_scp_recv($connection, $pathFile, $CONFIG['default']['upload_path'].$filename)){

		logFile('sftp move file to tmp');
	}else{
		logFile('sftp failed move file to tmp');
		return false;
	}

	// ssh2_scp_recv($connection, $pathFile, $CONFIG['default']['upload_path'].$filename);
	logFile('source='.$pathFile.' target='.$CONFIG['default']['upload_path'].$filename);
	// unlink($pathFile);
	logFile('delete current file');

	return true;

}

function createAccount($data=array())
{
	global $CONFIG;
	
	$host = $CONFIG['default']['hostname'];
	$port = "12345";
	
	logFile(serialize($data));
	exec("echo '".$data['username']. " ".$data['password']."' | nc ".$host." ".$port);

}

function dateFormat($date,$type=false,$locale='id_ID.utf8'){
		
		/* ex : dateFormat(<any type of date>, 'dd-mm-yyyy') */

		if($date =='') exit('Date not complete');

		setlocale (LC_TIME, 'id_ID.utf8');
		
		if($type == 'dd-mm-yyyy'){
			return strftime( "%d-%m-%Y", strtotime($date));
		} 
		if($type == 'dd/mm/yyyy'){
			return strftime( "%d/%m/%Y", strtotime($date));
		} 
		elseif ($type == 'article-day') {
			return strftime( "%A, %d %B %Y", strtotime($date));
		}
		elseif ($type == 'article') {
			return strftime( "%d %B %Y", strtotime($date));
		}
	}

function sendGlobalMail($to,$from,$msg,$config=true){


	GLOBAL $CONFIG, $LOCALE;
	
	if (!$config){

		@mail($to,"[ NOTIFICATION ] Flora Kalbar",$msg,"From: $from\n");

		return array('message'=>'success send mail','result'=>true);

	}

	require_once LIBS."PHPMailer/class.phpmailer.php";
	
	if ($from !='') $from = $from;
	else $from = $CONFIG['EMAIL_FROM_DEFAULT'];
	
	$mail = new PHPMailer(true);
	$mail->IsSMTP(); // telling the class to use SMTP

	try {
		logFile('ready to send mail');
		$mail->Host       = $CONFIG['email']['EMAIL_SMTP_HOST']; // SMTP server
		$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		$mail->Username   = $CONFIG['email']['EMAIL_FROM_DEFAULT'];  // GMAIL username
		$mail->Password   = $CONFIG['email']['EMAIL_SMTP_PASSWORD'];            // GMAIL password
		$mail->AddAddress($to);
		$mail->SetFrom($CONFIG['email']['EMAIL_FROM_DEFAULT'], 'No Reply Account');
		$mail->Subject = "[ NOTIFICATION ] Flora Kalbar";
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML($msg);
		$result = $mail->Send();
		
		logFile('status send = '.$result);

		if($result) return array('message'=>'success send mail','result'=>true,'res'=>$result);
		else return array('message'=>'error mail setting','result'=>false,'res'=>$mail->ErrorInfo);
	
	}catch (phpmailerException $e) {
	  // echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  // echo $e->getMessage(); //Boring error messages from anything else!
	}

	
}

function smart_resize_image($file,
                              $width = 0,
                              $height = 0,
                              $proportional = false,
                              $output = 'file',
                              $delete_original = true,
                              $use_linux_commands = false,
   $quality = 100
   ) {
      
    if ( $height <= 0 && $width <= 0 ) return false;

    # Setting defaults and meta
    $info = getimagesize($file);
    $image = '';
    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;
$cropHeight = $cropWidth = 0;

    # Calculating proportionality
    if ($proportional) {
      if ($width == 0) $factor = $height/$height_old;
      elseif ($height == 0) $factor = $width/$width_old;
      else $factor = min( $width / $width_old, $height / $height_old );

      $final_width = round( $width_old * $factor );
      $final_height = round( $height_old * $factor );
    }
    else {
		$final_width = ( $width <= 0 ) ? $width_old : $width;
		$final_height = ( $height <= 0 ) ? $height_old : $height;
		$widthX = $width_old / $width;
		$heightX = $height_old / $height;

		$x = min($widthX, $heightX);
		$cropWidth = ($width_old - $width * $x) / 2;
		$cropHeight = ($height_old - $height * $x) / 2;
    }
	
    # Loading image to memory according to type
    switch ( $info[2] ) {
      case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($file); break;
      case IMAGETYPE_GIF: $image = imagecreatefromgif($file); break;
      case IMAGETYPE_PNG: $image = imagecreatefrompng($file); break;
      default: return false;
    }
    
    
    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $transparency = imagecolortransparent($image);
      $palletsize = imagecolorstotal($image);

      if ($transparency >= 0 && $transparency < $palletsize) {
        $transparent_color = imagecolorsforindex($image, $transparency);
        $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
        imagefill($image_resized, 0, 0, $transparency);
        imagecolortransparent($image_resized, $transparency);
      }
      elseif ($info[2] == IMAGETYPE_PNG) {
        imagealphablending($image_resized, false);
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
        imagefill($image_resized, 0, 0, $color);
        imagesavealpha($image_resized, true);
      }
    }
    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);


    # Taking care of original, if needed
    if ( $delete_original ) {
      if ( $use_linux_commands ) exec('rm '.$file);
      else @unlink($file);
    }

    # Preparing a method of providing result
    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }
    
    # Writing image according to type to the output destination and image quality
    switch ( $info[2] ) {
      case IMAGETYPE_GIF: imagegif($image_resized, $output); break;
      case IMAGETYPE_JPEG: imagejpeg($image_resized, $output, $quality); break;
      case IMAGETYPE_PNG:
        $quality = 9 - (int)((0.9*$quality)/10.0);
        imagepng($image_resized, $output, $quality);
        break;
      default: return false;
    }

    return true;
}

function ImageCreateFromBMP($filename)
{
//Ouverture du fichier en mode binaire
   if (! $f1 = fopen($filename,"rb")) return FALSE;

//1 : Chargement des ent�tes FICHIER
   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
   if ($FILE['file_type'] != 19778) return FALSE;

//2 : Chargement des ent�tes BMP
   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                 '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                 '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] = 4-(4*$BMP['decal']);
   if ($BMP['decal'] == 4) $BMP['decal'] = 0;

//3 : Chargement des couleurs de la palette
   $PALETTE = array();
   if ($BMP['colors'] < 16777216)
   {
    $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
   }

//4 : Cr�ation de l'image
   $IMG = fread($f1,$BMP['size_bitmap']);
   $VIDE = chr(0);

   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
   $P = 0;
   $Y = $BMP['height']-1;
   while ($Y >= 0)
   {
    $X=0;
    while ($X < $BMP['width'])
    {
     if ($BMP['bits_per_pixel'] == 24)
        $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
     elseif ($BMP['bits_per_pixel'] == 16)
     {  
        $COLOR = unpack("n",substr($IMG,$P,2));
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 8)
     {  
        $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 4)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
        if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 1)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
        if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
        elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
        elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
        elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
        elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
        elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
        elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
        elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     else
        return FALSE;
     imagesetpixel($res,$X,$Y,$COLOR[1]);
     $X++;
     $P += $BMP['bytes_per_pixel'];
    }
    $Y--;
    $P+=$BMP['decal'];
   }

	//Fermeture du fichier
   	fclose($f1);

	return $res;
}


?>
