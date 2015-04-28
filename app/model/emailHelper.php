<?php

class emailHelper {

	function sendGlobalMail($name,$to,$from,$sbj,$msg){
		GLOBAL $CONFIG, $LOCALE;

		require_once LIBS."Utility/PHPMailer/class.phpmailer.php";
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP();                                      // set mailer to use SMTP
		$mail->Host = $CONFIG['EMAIL_SMTP_HOST'];  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = $CONFIG['EMAIL_SMTP_USER'];  // SMTP username
		$mail->Password = $CONFIG['EMAIL_SMTP_PASSWORD']; // SMTP password

		$mail->From = $from;
		$mail->FromName = $from;
		$mail->AddAddress($to);

		$mail->WordWrap = 50;                                 // set word wrap to 50 characters
		$mail->IsHTML(true);                                  // set email format to HTML

		$mail->Subject = $sbj;
		
		$mail->Body    = $msg;
		
		$mail->AltBody = $msg;
		$result = $mail->Send();
	
		if($result) return array('message'=>'success send mail','result'=>true,'res'=>$result);
		else return array('message'=>'error mail setting','result'=>false,'res'=>$result);
	}

}
?>