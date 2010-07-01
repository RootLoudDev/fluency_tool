<?php
require_once('db-config.php');
db_open ("pulmofluency");
session_start();

$userid = $_SESSION['user_id'];
$locSelected = $_GET['locSelected'];
$userIsReviewer = $_GET['userIsReviewer'];

// Escape User Input to help prevent SQL Injection
$locSelected = mysql_real_escape_string($locSelected);
$userIsReviewer = mysql_real_escape_string($userIsReviewer);

$location = explode("~", $locSelected);

// Build SQL
// Build SELECT statement	
	$sqlselect = 'SELECT users.firstname, users.lastname, users.ID';
// Build FROM statement
	if ($userIsReviewer <> "1") {
		$sqlfrom = ' FROM users';
	} else {
		$sqlfrom = ' FROM peerreview, users';
	}
// Build WHERE statement
	if ($userIsReviewer <> "1") {
		$sqlwhere = ' WHERE role="2"';
	} else {
		$sqlwhere = ' WHERE role="2" AND (peerreview.reviewer = "'.$userid.'") AND (users.ID = peerreview.reviewee)';
	}
	$sqlwhere2 = "";
	if ($location) 
	{
		$kv = array();
		foreach ($location as $key => $value) 
		{
			if ($value)
			{
				$kv[] = "\"$value\"";
			}
		}
		$sqlwhere2 = join(", ", $kv);
	}
	else 
	{
		$sqlwhere2 = "";
	}
	if ($sqlwhere2!="")
	{
		$sqlwhere = $sqlwhere . " AND location IN (" . $sqlwhere2 . ")";
	}

// Build SORT	
	$sqlsort = ' ORDER BY lastname';
	
// Build Query
	$query = "$sqlselect $sqlfrom $sqlwhere $sqlsort";
	$qry_result = mysql_query($query) or die(mysql_error());	
	
	//Build Result String
	$result_string = mysql_num_rows($qry_result) . "|";
	
	while($row = mysql_fetch_array($qry_result))
	{
	$result_string .= "$row[ID]~$row[firstname]~$row[lastname]|";
	}

echo $result_string;
?>