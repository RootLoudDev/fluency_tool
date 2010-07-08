<?php
include_once('includes/_bootstrap.php');
session_start();
checkLogin('admin');

/* Gathering Data Variables*/
//	print_r($_POST);
	$id = mysql_real_escape_string($_POST['id']);
	$password = mysql_real_escape_string($_POST['password']);

// Entering values
// this could be simplified, but I'm doing it the long way
$query = "UPDATE users SET password = '$password' WHERE ID = '$id'";
MYSQL_QUERY($query) or die( "<H3>Update query failed</H3>:" . mysql_error());

// return to main page
header("Location: ./admin.php");

?>