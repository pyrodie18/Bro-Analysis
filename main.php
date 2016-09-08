#!/usr/bin/php -q
<?php
include_once('conn_logs.php');

// ** Get current directory and then all files within it. ** //
$currentDir = '/home/troy/Documents/test2/';
$files = glob($currentDir.'*.log');

print_r($files);

foreach ($files as $file) {
	if (strpos($file, "conn.log")) {
		LoadBroConnLogsTest($file);	
	} else {
		print("not $file");
	}
}
?>
