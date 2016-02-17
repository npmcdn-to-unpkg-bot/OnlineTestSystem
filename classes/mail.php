<?php 
class Mail{
	public static function sendMail($to,$sub,$msg,$from=null,$reply_to=null){
		$header="";
		if ($from!=null)
			$header.='From: '. $from . "\r\n";
		if ($reply_to!=null)
			$header.='Reply-To: '. $reply_to . "\r\n";
		$header.='X-Mailer: PHP/' . phpversion();
		return mail($to, $sub, $msg, $header);
	}
}
?>