<?php
require 'sendFunction.php';
include 'config.php';

if(!file_exists($conf_mail_body)) return;
$handle = fopen($conf_mail_body, "r");
if(!$handle) return;
fseek($handle, 0, SEEK_END);
$size = ftell($handle);
if ($size < 1) {
	fclose($handle);
	unlink($conf_mail_body);
	return;
}
fseek($handle, 0, SEEK_SET);
$data = fread($handle, $size);
fclose($handle);
$m = json_decode($data);
$mes = array(
	"subject" => $m->{"subject"},
	"html" => $m->{"body"},
	"html_root" => ".",
	"attachments" => array()
);
sendMultipleMail($mes, 1);

?>