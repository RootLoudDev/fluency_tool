<?php
// Show the headers from the HTTP request.
// (C) Phil Burk, http://www.softsynth.com

// These must come before anything else is printed so that they get in the header.
    header("Cache-control: private");
    header("Content-Type: text/plain");
	
	echo "#Headers from the request:\n";
	$headers_sent = getallheaders();
	foreach ($headers_sent as $key =>$value)
	{
    	echo "$key=$value\n";
	}
	
	echo "SUCCESS look in Java Console for headers.\n";
?>
