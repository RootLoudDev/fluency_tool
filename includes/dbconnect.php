<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'fluency_tool';


mysql_connect($host, $username, $password) or die(mysql_error());
//echo "Connected to MySQL<br />";
mysql_select_db($database) or die(mysql_error());
//echo "Connected to Database";
?>
