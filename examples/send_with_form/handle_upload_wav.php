<?php
// HTML File Upload processor
// (C) Phil Burk, http://www.softsynth.com
// This version handles file upload in a simple way.
//
// IMPORTANT - MAKE THESE CHANGES to fit your application.
//  1) Change check for the file name to match your naming system.
//  2) Change or remove the upfile_size_limit code.
//  3) Change the uploads_dir to match your desired directory.
//  4) Get your own variables from the POST like userName or whatever.

// Define directory to put file in.
// It must have read/write permissions accessable your web server.
	$uploads_dir = "../../uploads";

// Set maximum file size that your script will allow.
    $upfile_size_limit = 500000;

// These must come before anything else is printed so that they get in the header.
    header("Cache-control: private");
    header("Content-Type: text/plain");

// Get posted variables. Assume register_globals is off.
    $duration = strip_tags($_POST['duration']);

// Extract information provided by PHP POST processor.
    $upfile_size = $_FILES['userfile']['size'];
	

    // NOTE: you can change $upfile_name to anything you want. You can build names
    // based on a database ID or hash index, etc.
	$recording_id = "xyz123";
	$upfile_name = "rec_" . $recording_id . ".wav";
    
	// Print relevent file information provided by PHP POST processor for debugging.
    echo "raw_name     = $raw_name\n";
    echo "name         = $upfile_name\n";
    echo "type         = " . $_FILES['userfile']['type'] . "\n";
    echo "size         = $upfile_size\n";
    echo "Upload dir   = $uploads_dir\n";
	
// Applet always sends duration in seconds along with file.
    echo "duration     = " . $duration . "\n";

	if( $upfile_size > $upfile_size_limit)
    {
        echo "ERROR - PHP script says file too large, $upfile_size > $upfile_size_limit\n";
    }
    else
    {
    // Move file from temporary server directory to public local directory.
        $moveResult = move_uploaded_file($_FILES['userfile']['tmp_name'],
            $uploads_dir . "/" . $upfile_name );
        if( $moveResult )
        {
            echo 'CALLJS setRecordingID( "' . $recording_id . "\")\n";
            echo "SUCCESS - $upfile_name uploaded.\n";
        }
        else
        {
            echo "ERROR - move_uploaded_file() failed! See Java Console.\n"; 
        }
    }

?>
