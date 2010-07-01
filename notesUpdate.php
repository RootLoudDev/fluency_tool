<?php
session_start();
require_once('db-config.php');
db_open ("pulmofluency");

$assocSelected = $_POST['assocSelected'];
$assocSelected = mysql_real_escape_string($assocSelected);
$scenSelected = $_POST['scenSelected'];
$scenSelected = mysql_real_escape_string($scenSelected);
$notesText = $_POST['notesText'];
$notesText = mysql_real_escape_string($notesText);
$feedbackType = "feedback";
$managerId = $_SESSION['user_id'];	

if ($assocSelected != "" && $managerId !="" && $feedbackType !="" && $scenSelected !="") {
	// Post note
	$queryfb = "REPLACE INTO feedback (associateid, managerid, fbtype, fbscenario, fbtext) 
				VALUES ('$assocSelected', '$managerId', '$feedbackType', '$scenSelected', '$notesText')";
	$resultfb = mysql_query($queryfb);
}
// Could probably use some error handling or response
?>