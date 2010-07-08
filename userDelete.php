<?php
include_once('includes/_bootstrap.php');
session_start();
checkLogin('admin');

$id = $_POST['id'];
$id = mysql_real_escape_string($id);

$testQuery = "SELECT ID FROM users WHERE ID = '$id'";
$testResult = mysql_query($testQuery) or die($result_string = "Query failed:" . mysql_error());

if(mysql_num_rows($testResult) == 1)
{
	$query = "DELETE FROM users  WHERE ID = '$id' LIMIT 1";
	$result = mysql_query($query);
}
// TODO Could probably use some error handling or response
?>