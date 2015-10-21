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


/* Now it is mock */
/*
function fetchMails() {
	$mails = array(
		array(
			"name" => 'Taras Zakharchenko',
			"mail" => 'player999@ukr.net'
		),
		array(
			"name" => 'Taras Ivanov',
			"mail" => 'taras.zakharchenko@gmail.com'
		)
	);
	return $mails;
}
*/

function fetchMails() {
	include 'config.php';
	$conn = mysql_connect($conf_dbhost, $conf_dbuser, $conf_dbpass);
	if(!$conn)
	{
		return "Connection failed";
	}
	mysql_select_db($conf_dbname);
	$sql = "SELECT distinct `customers_email_address`, `customers_name` 
	FROM `orders` WHERE customers_email_address != '' and 
	`orders_id` > 2350 order by `customers_email_address`";
	$retval = mysql_query($sql, $conn); 
	if(!$retval)
	{
		return "Failed to execute ".$sql;
	}

	$resulting_array = array();
	while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
	{
		if (strstr($row["customers_email_address"], "@")) {
			array_push($resulting_array, array(
				"name" => iconv('windows-1251', 'utf-8', $row["customers_name"]),
				"mail" => iconv('windows-1251', 'utf-8', $row["customers_email_address"])
			));
		}
	}
	mysql_close($conn);
	return $resulting_array;
}

?>