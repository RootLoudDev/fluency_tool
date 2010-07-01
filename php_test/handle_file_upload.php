<?php
// Print information from HTML upload file form.
// (C) Phil Burk, http://www.softsynth.com

// These must come before anything else is printed so that they get in the header.
    header("Cache-control: private");
    header("Content-Type: text/plain");

// Get posted variables. Assume register_globals is off.
    $userComment = strip_tags($_POST['userComment']);
	
// Extract information provided by PHP POST processor.
    $upfile_size = $_FILES['userfile']['size'];
    $raw_name = $_FILES['userfile']['name'];
    // Strip path info to prevent uploads outside target directory.
    $upfile_name = basename($raw_name);

// Print relevent file information provided by PHP POST processor for debugging.
    echo "name        = $upfile_name\n";
    echo "type        = " . $_FILES['userfile']['type'] . "\n";
    echo "size        = $upfile_size\n";
    echo "userComment = $userComment\n";
    
    echo "\nSUCCESS file was uploaded\n";
    echo "\nHit BACK button in browser to continue testing.\n";
?>
