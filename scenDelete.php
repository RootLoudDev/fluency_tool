<?php
include_once('userroles.php');
session_start();
checkLogin('admin');

$id = $_POST['id'];
$id = mysql_real_escape_string($id);

$testQuery = "SELECT id FROM scenarios WHERE id = '$id'";
$testResult = mysql_query($testQuery) or die($result_string = "Query failed:" . mysql_error());

if(mysql_num_rows($testResult) == 1)
{
	$query = "DELETE FROM scenarios  WHERE id = '$id' LIMIT 1";
	$result = mysql_query($query);
	mysql_query("DELETE FROM resources WHERE scenarioID ='$id'");
echo "<script>alert('Scenario Deleted')</script>";
}
else
echo "<script>alert('$result_string')</script>";

?>