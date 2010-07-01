<?php
include_once('userroles.php');
session_start();
checkLogin('admin');

$id = $_POST['id'];
$id = mysql_real_escape_string($id);
$reviewee = $_POST['reviewee'];
$reviewee = mysql_real_escape_string($reviewee);

$testQuery = "SELECT * FROM peerreview WHERE reviewer = '$id' AND reviewee = '$reviewee'";
$testResult = mysql_query($testQuery) or die($result_string = "Query failed:" . mysql_error());

if(mysql_num_rows($testResult) == 1)
{
	$query = "DELETE FROM peerreview  WHERE reviewer = '$id' AND reviewee = '$reviewee' LIMIT 1";
	$result = mysql_query($query);
}
// Could probably use some error handling or response
echo mySql_error();
?>