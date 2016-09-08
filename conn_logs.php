#!/usr/bin/php -q
<?php
include_once('functions.php');
include_once('config.php');
function LoadBroConnLogs(array $fileName) {
/**
 * This file contains all of the functionality to import bro conn logs into the database
 * All CONSTANTS are defined within config.php
 */
print("Importing conn log file $fileName \n");
$insertStatement = ""; //Holds the overall SQL insert statement
$currentRecordVals = ""; //Holds the values for this particular record before adding to $insertStatement
//foreach ($fileNames as $currentFile) {
//$currentFile = "../test2/conn.log"; //use only for testing
	$file = fopen($fileName, "r");
	$i = 1;
	$insertStatement = CONN_LOG_INSERT;
	$completeStatement = True;
	while(! feof($file)){
		$tmpRecord = fgetcsv($file, 0, "\t");
		// Check to ensure that the first charachter 
		// isn't '#' and if it is, skip the line
		if ($tmpRecord[0][0] == '#') continue;  //Line is a header
		if ($tmpRecord[0][0] == false) continue; //Line is blank
			
		$ts = $tmpRecord[CONN_TS];
		$uid = $tmpRecord[CONN_UID];
		$origH = $tmpRecord[CONN_ORIGH];
		$origP = $tmpRecord[CONN_ORIGP];
		$respH = $tmpRecord[CONN_RESPH];
		$respP = $tmpRecord[CONN_RESPP];
		$proto = ReturnString($tmpRecord[CONN_PROTO]);
		$service = ReturnString($tmpRecord[CONN_SERVICE]);
		$duration = ReturnNum($tmpRecord[CONN_DURATION]);
		$origBytes = ReturnNum($tmpRecord[CONN_ORIGBYTES]);
		$respBytes = ReturnNum($tmpRecord[CONN_RESPBYTES]);
		$connState = ReturnString($tmpRecord[CONN_CONNSTATE]);
		$history = ReturnString($tmpRecord[CONN_HISTORY]);
		$origPkts = ReturnNum($tmpRecord[CONN_ORIGPKTS]);
		$origIPBytes = ReturnNum($tmpRecord[CONN_ORIGIPBYTES]);
		$respPkts = ReturnNum($tmpRecord[CONN_RESPPKTS]);
		$respIPBytes = ReturnNum($tmpRecord[CONN_RESPIPBYTES]);
		
		//Build $currentRecordVals
		$currentRecordVals = "(FROM_UNIXTIME($ts), '$uid', INET6_ATON('$origH'), $origP, INET6_ATON('$respH'), $respP, '$proto', '$service', $duration, $origBytes, $respBytes, '$connState', '$history', $origPkts, $origIPBytes, $respPkts, $respIPBytes)";
	
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
			$insertStatement = CONN_LOG_INSERT;
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
}

function LoadBroConnLogsTest($fileName) {
print("Importing conn log file $fileName \n");
}
?>

