<?php 
function sammail($to,$subject,$Body,$from='support@yoursite.com'){
	include ("phpmailer/PHPMailerAutoload.php");
	$hostname='ip'; //smtp mail server
$username='username'; //smtp username
$password='password'; //smtp password
$port='587'; //smtp port
$ssl='tls'; //smtp security
			$mail = new PHPMailer();
 $mail->SMTPDebug = 0;
    //Set PHPMailer to use SMTP.
    $mail->isSMTP(true);
    //Set SMTP host name                          
    $mail->Host = $hostname;
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password     
    $mail->Username = $username;
    $mail->Password = $password;
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = $ssl;
	$mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);  
    //Set TCP port to connect to 
    $mail->Port = $port;
    $mail->From = $username;  
    $mail->FromName = 'WapKiz';
	$mail->addReplyTo($from, $from);
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $Body;
    $mail->AltBody = $Body;
    if (!$mail->send()) {
	//	echo 'mail error';
     //return "Mailer Error: " . $mail->ErrorInfo;
	  return false;
	  
    }
    else {
		//echo 'mail sent.';
         return true;
    }
}
