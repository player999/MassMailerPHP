<?php
require 'sendFunction.php';

$dst = array(
	"name" => 'Taras Zakharchenko',
	"mail" => 'player999@ukr.net'
);

$mes = array(
	"subject" => 'Test Message',
	"text" => 'Body',
	"attachments" => array()
);


sendMail($dst, $mes);
?>