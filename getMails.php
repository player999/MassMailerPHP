<?php
/*
Get List of e-mails from text file
*/

function popMail($file) {
	$emptyrecord = array(
			"name" => "",
			"mail" => ""
			);

	if(!file_exists($file)) return $emptyrecord;
	$handle = fopen($file, "r");
	if(!$handle) return $emptyrecord;
	fseek($handle, 0, SEEK_END);
	$size = ftell($handle);
	if ($size < 1) {
		fclose($handle);
		unlink($file);
		return $emptyrecord;
	}
	fseek($handle, 0, SEEK_SET);
	$data = fread($handle, $size);
	fclose($handle);
	$records = split("\n", $data);
	if (count($records) < 1) {
		unlink($file);
		return $emptyrecord;
	}
	//Now analyse e-mail records
	$line = $records[0];
	unset($records[0]);
	$new_data = join("\n", $records);
	$handle = fopen($file, "w");
	fwrite($handle, $new_data);

	$sp = split(":", $line);
	if (count($sp) == 2) {
		$returnrecord = array(
			"name" => $sp[1],
			"mail" => $sp[0]
			);
	}
	else {
		$returnrecord = popMail($file);
	}
	return $returnrecord;
}

?>