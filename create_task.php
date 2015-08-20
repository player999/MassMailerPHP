<?php
require 'getMails.php';

/*Save e-mail on FS*/
$message = file_get_contents('php://input');
$f = fopen("email.txt", "w");
fwrite($f, $message);
fclose($f);

/*Save list of emails*/

?>
