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
$currentFile = "../test2/files.log"; //use only for testing
	$file = fopen($currentFile, "r");
	$i = 1;
	$insertStatement = FILE_LOG_INSERT;
	$completeStatement = True;
	while(! feof($file)){
		$tmpRecord = fgetcsv($file, 0, "\t");
		// Check to ensure that the first charachter 
		// isn't '#' and if it is, skip the line
		if ($tmpRecord[0][0] == '#') continue;  //Line is a header
                if ($tmpRecord[0][0] == false) continue; //Line is blank

		$fuid = $tmpRecord[FILE_FUID];
		$cuid = ReturnString($tmpRecord[FILE_UID]);
		$source = ReturnString($tmpRecord[FILE_SOURCE]);
		$analyzers = ReturnString($tmpRecord[FILE_ANALYZERS]);
		$mime = ReturnString($tmpRecord[FILE_MIME]);
		$fileName = ReturnString($tmpRecord[FILE_FILENAME]);
		$md5 = ReturnString($tmpRecord[FILE_MD5]);
		$sha1 = ReturnString($tmpRecord[FILE_SHA1]);
		$sha256 = ReturnString($tmpRecord[FILE_SHA256]);
		$extractedName = ReturnString($tmpRecord[FILE_EXTRACTED]);
	   
	   //Build $currentRecordVals
		$currentRecordVals = "('$fuid', '$cuid', '$source', '$analyzers', '$mime', '$fileName', '$md5', '$sha1', '$sha256', '$extractedName')";
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
			$insertStatement = FILE_LOG_INSERT;
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
