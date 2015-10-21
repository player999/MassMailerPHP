<?php
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';
require 'getMails.php';

/*
destination:
	"name": Name in the e-mail message
	"mail": Destination e-mail address

message:
	"subject": Subject of e-mail message
	"text": Plain text e-mail body
	"html": HTML Code of your e-mail
	"html_root": root of html page
	"attachments": array of file named
*/

function emptyMail($mail) {
	if ($mail["name"] == "" && $mail["mail"] == "") return true;
	else return false;
}

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
	$mail->CharSet = 'UTF-8';

	if ($message["html"]) {
		if ($message["html_root"]) $html_root = $message["html_root"];
		else $html_root = "";
		$mail->msgHTML($message["html"], $html_root);
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

function sendMultipleMail($message, $interval)
{
	include 'config.php';
	while(1) {
		$mail = popMail($conf_mail_list);
		if(emptyMail($mail)) break;
		sendMail($mail, $message);;
		sleep($interval);
	}
	
}

?>
