<?php
session_start();
require_once('db-config.php');
db_open ("pulmofluency");

$assocSelected = $_GET['assocSelected'];
// Escape User Input to help prevent SQL Injection
$assocSelected = mysql_real_escape_string($assocSelected);

// Get scenario data
$queryuser = "SELECT username, email, scenario1, scenario2, scenario3, scenario4, scenario5, scenario6, scenario7
			FROM users WHERE ID='$assocSelected'";
$resultuser = mysql_query($queryuser);

if (mysql_num_rows($resultuser) != 1)
{
	$result_string = "Unexpected result in user query";
}

$row = mysql_fetch_row($resultuser);
	$result_string .= "$row[0]~$row[1]~$row[2]~$row[3]~$row[4]~$row[5]~$row[6]~$row[7]~$row[8]|";

// Get Feedback data
$managerId = $_SESSION['user_id'];	
	if ($assocSelected != "" && $_SESSION['user_id'] !="")
	{
		$queryfeedback = "SELECT fbscenario, fbtext FROM feedback 
							WHERE associateid='$assocSelected' AND 
								managerid='$managerId'";
		$resultfeedback = mysql_query($queryfeedback);
				
		if (mysql_num_rows($resultfeedback) >= 1)
		{
			while ( $rowfeedback = mysql_fetch_array($resultfeedback))
			{
				$result_string .= "$rowfeedback[fbscenario]~$rowfeedback[fbtext]|";
			}
		}
	}
echo $result_string;
?>