<?php
require 'getMails.php';
include 'config.php';

/*Save e-mail on FS*/
$message = file_get_contents('php://input');
$data_json = json_decode($message);
$email_json = json_encode(array(
		'subject' => $data_json->{'subject'}, 
		'body' => $data_json->{'body'}
		));
$f = fopen($conf_mail_body, "w");
fwrite($f, $email_json);
fclose($f);

/*Save list of emails*/
$f = fopen($conf_mail_list, "w");
if (property_exists($data_json, 'addressates')){
	fwrite($f, $data_json->{'addressates'});
}
else {
	$dests = fetchMails();
	foreach ($dests as $dest) {
	 	fwrite($f, $dest["mail"].":".$dest["name"]."\n");
	}
}
fclose($f)
?>
