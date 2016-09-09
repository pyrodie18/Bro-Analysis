#!/usr/bin/php -q
<?php
include_once('conn_logs.php');
include_once('dns_logs.php');
include_once('file_logs.php');
include_once('http_logs.php');
include_once('ssl_logs.php');
include_once('x509_logs.php');


// ** Get current directory and then all files within it. ** //
$currentDir = '/home/troy/Documents/test2/';
$files = glob($currentDir.'*.log');

foreach ($files as $file) {
	if (strpos($file, "conn.log")) {
		LoadBroConnLogs($file);	
	} else if (strpos($file, "dns.log")) {
		LoadBroDNSLogs($file);
	} else if (strpos($file, "files.log")) {
		LoadBroFilesLogs($file);
	} else if (strpos($file, "http.log")) {
		LoadBroHTTPLogs($file);
	} else if (strpos($file, "ssl.log")) {
		LoadBroSSLLogs($file);
	} else if (strpos($file, "x509.log")) {
		LoadBroX509Logs($file);
	}
}
?>
