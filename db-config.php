<?php
	$dbhost= "localhost";	/* Address of 1&1 database server */ 
	$dbuser= "root";		/* Database user name */ 
	$dbpassword= "";		/* Database password */ 
	$database= "fluency";	/* Name of database */ 
	
	function db_open ($db="") {
		global $dbhost, $dbuser, $dbpassword;
		
		$conn = mysql_connect($dbhost, $dbuser, $dbpassword) or die ("The database appears to be down.");
		mysql_select_db('fluency');
	//	if ($db!="" and !mysql_select_db($db))
	//		die ("The database is unavailable.");
			
		return $conn;
	}
?>
