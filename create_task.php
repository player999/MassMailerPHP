<?php
require 'getMails.php';
include 'config.php';

/*Save e-mail on FS*/
$message = file_get_contents('php://input');
$f = fopen($conf_mail_body, "w");
fwrite($f, $message);
fclose($f);

/*Save list of emails*/
$dests = fetchMails();
$f = fopen($conf_mail_list, "w");
foreach ($dests as $dest) {
 	fwrite($f, $dest["mail"].":".$dest["name"]."\n");
}
fclose($f)
?>
