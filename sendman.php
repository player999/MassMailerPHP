<?php
require 'sendFunction.php';

$dst = array(
	"name" => 'Taras Zakharchenko',
	"mail" => 'player999@ukr.net'
);

$mes = array(
	"subject" => 'Test Message',
	"text" => "Message body",
	"attachments" => array()
);


sendMail($dst, $mes);
?>