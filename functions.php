<?php
include_once('config.php');
function ReturnNum ($value){
// Evaluates the value to ensure it is numeric and if not returns a 0

	if (! is_numeric($value)) {
		$value = 0;
	}
	return $value;
}

function ReturnString ($value){
// Evaluates the value to ensure it is not a few values and if it is returns a blank string

	if (!strcmp($value,"-")){
		$value = "";
	} elseif (!strcmp($value, "(empty)")){
		$value = "";
	} elseif (strpos($value, "'") !== false) {
		$value = addslashes($value);
	}
	return $value;
}

function db_connect() {
// Define connection as a static variable, to avoid connecting more than once 
	static $connection;

	// Try and connect to the database, if a connection has not been established yet
	if(!isset($connection)) {
		 // Load configuration as an array. Use the actual location of your configuration file
		$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	}

	// If connection was not successful, handle the error
	if($connection === false) {
		// Handle error - notify administrator, log to a file, show an error screen, etc.
		return mysqli_connect_error(); 
	}
	return $connection;
}

function db_query($query) {
	// Connect to the database
	$connection = db_connect();

	// Query the database
	$result = mysqli_query($connection,$query);

	return $result;
}

function num_rows($query) {
	// Connect to the database
	$connection = db_connect();

	/* check connection */
	if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
	}

	if ($result = mysqli_query($connection, $query)) {

		/* determine number of rows result set */
		$row_cnt = mysqli_num_rows($result);

		/* close result set */
		mysqli_free_result($result);
	}
	
	return $row_cnt;
}

function is_ip($str) {
	$ret = filter_var($str, FILTER_VALIDATE_IP);
	return $ret;
}

function is_ipv4($str) {
	$ret = filter_var($str, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	return $ret;
}

function is_ipv6($str) {
	$ret = filter_var($str, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
	return $ret;
}
?>
