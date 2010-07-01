<?php
// Log diagnostic status from Applet
// (C) Phil Burk, http://www.softsynth.com

// Set path to log file. CHANGE THIS FOR YOUR MACHINE!
// Make sure it is writable by Apache.
        $logFilePathName = "/../logs/listenup_diagnostic_log.txt";
        
// The following variables may be sent by the diagnostic reporter:
//    sessionID
//    diagnosis
//    osName
//    osVersion
//    javaVendor
//    javaVersion
//    errorMsg

// Send response as plain text so we can read it easier in the Java Console.
// These must come before anything else is printed so that they get in the header.
	header("Cache-control: private");
	header("Content-Type: text/plain");
        
// Get posted variables. Assume register_globals is off.
	$sessionID = strip_tags($_POST['sessionID']);
	$diagnosis = strip_tags($_POST['diagnosis']);
	$osName = strip_tags($_POST['osName']);
	$osVersion = strip_tags($_POST['osVersion']);
	$javaVendor = strip_tags($_POST['javaVendor']);
	$javaVersion = strip_tags($_POST['javaVersion']);
	$errorMsg = strip_tags($_POST['errorMsg']);

	// Append info to log file.
	$today = date("Ymd,H:i:s");
	$log_msg = "$REMOTE_ADDR,$sessionID,$diagnosis,$osName,$osVersion,$javaVendor,$javaVersion,$errorMsg,$today\n";
	
	// TODO - change this to match the path for your logs directory.
	$fp = fopen( $_SERVER['DOCUMENT_ROOT'] . $logFilePathName , "a" );
	if( fp === false )
	{
	    echo("Could not open ListenUp diagnostic log file.\n");
	}
	else
	{
	    fwrite( $fp, $log_msg );
	    fclose( $fp );
	}
?>
