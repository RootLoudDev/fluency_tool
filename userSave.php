<?php
include_once('userroles.php');
session_start();
checkLogin('admin');

/* Gathering Data Variables*/
//	print_r($_POST);
	$id = mysql_real_escape_string($_POST['id']);
	$username = mysql_real_escape_string($_POST['username']);
	$firstname = mysql_real_escape_string($_POST['firstname']);
	$lastname = mysql_real_escape_string($_POST['lastname']);
	$email = mysql_real_escape_string($_POST['email']);
	$role = mysql_real_escape_string($_POST['roleselect']);
	$location = mysql_real_escape_string($_POST['locationselect']);
	$password = mysql_real_escape_string($_POST['password']);
	$entryType = mysql_real_escape_string($_POST['entryType']);

// For now, username isn't changable.  Once it is, there will need to be validation
// that the username isn't already in use.	

// Entering values
// this could be simplified, but I'm doing it the long way
if ($entryType = "Edit")
{
	$query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', role = '$role', location = '$location' WHERE ID = '$id'";
	MYSQL_QUERY($query) or die( "<H3>Update query failed</H3>:" . mysql_error());

} else if ($entryType = "New")
{
	$query = "INSERT INTO users (ID, username, password, firstname, lastname, email, role, location, scenario1, scenario2, scenario3, scenario4, scenario5, scenario6, scenario7)
				VALUES('', '$username', '$password', '$firstname', '$lastname', '$email', '$role', '$location', '0', '0', '0', '0', '0', '0', '0')";
	MYSQL_QUERY($query) or die( "<H3>Insert query failed</H3>");

	}         
// return to calling page
header("Location: ./admin.php");

?>