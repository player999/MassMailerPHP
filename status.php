<?php
if(!file_exists("mails.txt")) {
	echo "{\"status\": \"ready\"}";
}
else {
	$handle = fopen("mails.txt", "r");
	$linecount = 1;
	while(!feof($handle)){
		$linecount += substr_count(fread($handle, 8192), "\n");
	}
	fclose($handle);
	$respones = array('status' => 'sending', 'left' => $linecount);
	echo json_encode($respones);
}
?>