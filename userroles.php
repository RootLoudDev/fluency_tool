<?php
include 'includes/dbconnect.php';

session_start();

	function checkLogin($levels)
	{
		if(!$_SESSION['logged_in'])
		{
			$access = FALSE;
		}
		else {
				$userid = $_SESSION['user_id'];
				$userid = mysql_real_escape_string($userid);
				$kt = split(' ', $levels);
				$query = 'SELECT rolename FROM users INNER JOIN roles ON users.role = roles.ID WHERE users.ID = "'.$userid.'"';
				$result = mysql_query($query);
				$row = mysql_fetch_assoc($result);
			
				$access = FALSE;
			
				while(list($key,$val)=each($kt))
				{
					if($val==$row['rolename'])
					{//if the user role matches one of the allowed roles
						$access = TRUE;
					}
				}
			}
		if($access==FALSE)
		{
			header("Location: index.php");
		}
		else {
		//do nothing: continue
		}
	}
?>