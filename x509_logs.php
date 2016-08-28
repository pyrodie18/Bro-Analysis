#!/usr/bin/php -q
<?php
include_once('functions.php');
include_once('config.php');
//function LoadBroFileLogs(array $fileNames) {
/**
 * This file contains all of the functionality to import bro X509 logs into the database
 * All CONSTANTS are defined within config.php
 */
$insertStatement = ""; //Holds the overall SQL insert statement
$currentRecordVals = ""; //Holds the values for this particular record before adding to $insertStatement
//foreach ($fileNames as $currentFile) {
$currentFile = "../test2/x509.log"; //use only for testing
	$file = fopen($currentFile, "r");
	$i = 1;
	$insertStatement = X509_LOG_INSERT;
	$completeStatement = True;
	while(! feof($file)){
		$tmpRecord = fgetcsv($file, 0, "\t");
		// Check to ensure that the first charachter 
		// isn't '#' and if it is, skip the line
		if ($tmpRecord[0][0] == '#') continue;  //Line is a header
                if ($tmpRecord[0][0] == false) continue; //Line is blank
		
		$fuid = $tmpRecord[X509_FUID];
		$version = ReturnNum($tmpRecord[X509_VERSION]);
		$serial = ReturnString($tmpRecord[X509_SERIAL]);
		$subject = ReturnString($tmpRecord[X509_SUBJECT]);
		$issuer = ReturnString($tmpRecord[X509_ISSUER]);
		$notValidBefore = ReturnString($tmpRecord[X509_NOTVALIDBEFORE]);
		$notValidAfter = ReturnString($tmpRecord[X509_NOTVALIDAFTER]);
		$keyAlg = ReturnString($tmpRecord[X509_KEYALG]);
		$sigAlg = ReturnString($tmpRecord[X509_SIGALG]);
		$keyType = ReturnString($tmpRecord[X509_KEYTYPE]);
		$keyLen = ReturnString($tmpRecord[X509_KEYLENGTH]);
		
		//Build $currentRecordVals
		$currentRecordVals = "('$fuid', $version, '$serial', '$subject', '$issuer', FROM_UNIXTIME($notValidBefore), FROM_UNIXTIME($notValidAfter), '$keyAlg', '$sigAlg', '$keyType', $keyLen)";

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
			$insertStatement = X509_LOG_INSERT;
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

