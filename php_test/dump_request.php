<?php
// Show the variables from the HTTP request.
// (C) Phil Burk, http://www.softsynth.com

// These must come before anything else is printed so that they get in the header.
    header("Cache-control: private");
    header("Content-Type: text/plain");
	
	echo "#Variables in the request:\n";
	foreach ($_REQUEST as $key => $value)
	{
    	echo "$key=$value\n";
	}
	
	echo "SUCCESS look in Java Console for variables.\n";
?>
