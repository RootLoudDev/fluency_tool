<?php
include_once('userroles.php');
session_start();
checkLogin('admin');

$reviewee = $_POST['reviewee'];
$reviewee = mysql_real_escape_string($reviewee);
$reviewer = $_POST['reviewer'];
$reviewer = mysql_real_escape_string($reviewer);
$mode = $_POST['mode'];
$mode= mysql_real_escape_string($mode);
// Mode 0 - Add Peer (reviewee for reviewer)
// Mode 1 - Add Reciprocal Peer (reviewee for reviewer AND reviewer as reviewee for reviewee)
if ($reviewee != "" && $reviewer !="")
{
	$query = "INSERT INTO peerreview (reviewer, reviewee)  VALUES('$reviewer', '$reviewee')";
	MYSQL_QUERY($query) or die( "<H3>Update query failed</H3>:" . mysql_error());
	
	if ($mode == "1")
	{
		$query = "INSERT INTO peerreview (reviewer, reviewee)  VALUES('$reviewee', '$reviewer')";
		MYSQL_QUERY($query) or die( "<H3>Update query failed</H3>:" . mysql_error());
	}
}

// Could probably use some error handling or response
?>