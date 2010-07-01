<?php
	session_start();
	$_SESSION['user_id'] = "";
	$_SESSION['logged_in'] = FALSE;
	$_SESSION['user_name'] = "";
	header("Location: index.php");
?>