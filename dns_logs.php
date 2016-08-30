#!/usr/bin/php -q
<?php
include_once('functions.php');
include_once('config.php');
//function LoadBroFileLogs(array $fileNames) {
/**
 * This file contains all of the functionality to import bro conn logs into the database
 * All CONSTANTS are defined within config.php
 */
$insertStatement = ""; //Holds the overall SQL insert statement
$currentRecordVals = ""; //Holds the values for this particular record before adding to $insertStatement
//foreach ($fileNames as $currentFile) {
$currentFile = "../test2/dns.log"; //use only for testing
	$file = fopen($currentFile, "r");
	$i = 1;
	$insertStatement = DNS_LOG_INSERT;
	$completeStatement = True;
	while(! feof($file)){
		$tmpRecord = fgetcsv($file, 0, "\t");
		// Check to ensure that the first charachter 
		// isn't '#' and if it is, skip the line
		if ($tmpRecord[0][0] == '#') continue;  //Line is a header
        if ($tmpRecord[0][0] == false) continue; //Line is blank
		
		$ts = $tmpRecord[DNS_TS];
		$uid = $tmpRecord[DNS_UID];
		$transID = ReturnString($tmpRecord[DNS_TRANSID]);
		$query = ReturnString($tmpRecord[DNS_QUERY]);
		$className = ReturnString($tmpRecord[DNS_CLASSNAME]);
		$typeName = ReturnString($tmpRecord[DNS_TYPENAME]);
		$responseName = ReturnString($tmpRecord[DNS_RESPONSECODENAME]);
		$answers = ReturnString($tmpRecord[DNS_ANSWERS]);
		
		//Build $currentRecordVals
		$currentRecordVals = "('$uid', '$transID', '$query', '$className', '$typeName', '$responseName', '$answers')";

		if ($i == 1) { //First record, no need to add the comma
			$insertStatement = $insertStatement . $currentRecordVals;
			$i++;
			$completeStatement = False;
		} elseif ($i == 10) { //Final record in the current set, close out the sql statement and insert
			$insertStatement = $insertStatement . ", " . $currentRecordVals . ";";
			//ADD CODE TO INSERT RECORDS INTO DATABASE
			if (! db_query($insertStatement)){
					echo "ERROR...... $insertStatement \n";
			}
			$i = 1; //Reset the counter
			$completeStatement = True;
			$insertStatement = DNS_LOG_INSERT;
		} else { //add a comma and the the next set of values
			$insertStatement = $insertStatement . ", " . $currentRecordVals;
			$i++;
			$completeStatement = False;
		}
	
		//PASSIVE DNS STUFF
		//Check to see if this is an A or AAAA record
		if ((($typeName == "A") || ($typeName == "AAAA")) && $responseName == "NOERROR") {
			$domainAnswers = str_getcsv($answers);
			foreach ($domainAnswers as $value){
				//Ensure that the current $value is actually an IP address
				if (is_ip($value)) {
					//$sql = "SELECT * from passive_dns;";
					$sql = "SELECT * from passive_dns WHERE PASSIVE_QUERY = '$query' and PASSIVE_ANSWER = INET6_ATON('$value');";
					//Make sure that the query/answer combo doesn't already exist
					printf ("%s \n", $sql);
					$numRows = num_rows($sql);
					if ($numRows > 0) {
						$sql = "UPDATE passive_dns SET passive_lastfound = FROM_UNIXTIME($ts), passive_count = passive_count + 1 WHERE PASSIVE_QUERY = '$query' and PASSIVE_ANSWER = INET6_ATON('$value');";
						//Update the current count and last found values
						db_query($sql);
					} else {
						$sql = "INSERT INTO passive_dns (PASSIVE_QUERY, PASSIVE_ANSWER, PASSIVE_FIRSTFOUND, PASSIVE_LASTFOUND, PASSIVE_COUNT) VALUES ('$query', INET6_ATON('$value'), FROM_UNIXTIME($ts), FROM_UNIXTIME($ts), 1)";
						//Insert the values into the table
						db_query($sql);
					}
				}
			}
		}
	}
	
	//If we reach end of file without properly finishing and inserting the sql statement, do it now
	if (! $completeStatement){
		$insertStatement = $insertStatement . ";";
		//ADD CODE TO INSERT RECORDS INTO DATABASE
		if (! db_query($insertStatement)){
				echo "ERROR...... $insertStatement \n";
		}
		$completeStatement = True;
	}
//}
//}
?>

