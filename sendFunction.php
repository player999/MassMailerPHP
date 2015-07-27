<?php
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';

/*
destination:
	"name": Name in the e-mail message
	"mail": Destination e-mail address

message:
	"subject": Subject of e-mail message
	"text": Plain text e-mail body
	"attachments": array of file named
*/
function sendMail($destination, $message)
{
	include 'config.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';

	$mail->Host = $conf_host;
	$mail->Port = $conf_port;
	$mail->SMTPSecure = $conf_smtpsecure;
	$mail->SMTPAuth = $conf_auth;
	$mail->Username = $conf_uname;
	$mail->Password = $conf_passw;
	$mail->setFrom($conf_from_mail, $conf_from_name);
	$mail->addReplyTo($conf_reply_mail, $conf_reply_name);
	$mail->addAddress($destination["mail"], $destination["name"]);
	$mail->Subject = $message["subject"];

	if ($message["html"]) {
		$mail->msgHTML = $message["html"];
	}
	else if($message["text"]) {
		$mail->Body = $message["text"];
	}

	foreach ($message["attachments"] as $attachment) {
		$mail->addAttachment($attachment);
	}

	if (!$mail->send()) {
		file_put_contents('php://stderr', "Mailer error: ".$mail->ErrorInfo."\n");
		return false;
	} else {
		return true;
	}
}
?>