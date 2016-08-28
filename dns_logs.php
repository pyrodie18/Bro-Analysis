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
		
		$uid = $tmpRecord[DNS_UID];
		$transID = ReturnString($tmpRecord[DNS_TRANSID]);
		$query = ReturnString($tmpRecord[DNS_QUERY]);
		$className = ReturnString($tmpRecord[DNS_CLASSNAME]);
		$typeName = ReturnString($tmpRecord[DNS_TYPENAME]);
		$answers = ReturnString($tmpRecord[DNS_ANSWERS]);
		
		//Build $currentRecordVals
		$currentRecordVals = "('$uid', '$transID', '$query', '$className', '$typeName', '$answers')";

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
