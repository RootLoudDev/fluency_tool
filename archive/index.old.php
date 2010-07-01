<?php
require_once('db-config.php');
db_open ("fluency");

	if($_POST['user']!='' && $_POST['pass']!='')
	{
		/* We'll need to use the md5 on the live database, but for now, we're not scrambling the password 	
		 *$query = mysql_query('SELECT ID, username FROM users WHERE username = "'.mysql_real_escape_string($_POST['user']).'" AND password = "'.mysql_real_escape_string(md5($_POST['pass'])).'"'); */
		$query = mysql_query('SELECT ID, username, role FROM users WHERE username = "'.mysql_real_escape_string($_POST['user']).'" AND password = "'.mysql_real_escape_string($_POST['pass']).'"');

		if(mysql_num_rows($query) == 1)
		{
			session_start();
			$row = mysql_fetch_assoc($query);
			$_SESSION['user_id'] = $row['ID'];
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['user_name'] = $row['username'];
			
			if($row['role'] == "manager")
			{
				header("Location: manager.php");
			}
			elseif($row['role'] == "associate")
			{
//				header("Location: associate.php");
				header("Location: rep.php");
			}
			else
			{
				$error = 'User has no rights on this system.';
			}
		}
		else 
		{
				$error = 'Login failed.';
		}
	}
	else {
		//	$error = 'Please log in to access your account.';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PULMOZYME: Patient Case Study</title>
<link href="styles.css" rel="stylesheet" type="text/css" /></head>

<body>
<div id="container">
<img src="images/logo.gif" width="303" height="98" alt="Xolair" />
<div id="content">
 <h6>&nbsp;</h6>
 
<p>&nbsp;</p>

<div id="menu-bar" style="text-align:center;"> Account Access</div>
  <div id="login"> <br />
    <br />
    <table width="266" height="71" border="0" align="center">
      <form id="form1" name="form1" method="post" action="<?php echo($_SERVER['PHP_SELF']);?>">
        <tr>
          <td width="79" height="38" align="right" class="black">User</td>
          <td width="177"><label>
            <input type="text" name="user" id="user" />
          </label></td>
        </tr>
        <tr>
          <td align="right" class="black">Pass</td>
          <td><input type="password" name="pass" id="pass" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" class="black"><label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="submit" id="submit" value="Submit" />
          </label></td>
        </tr>
      </form>
    </table>
<?php if(isset($error)) {echo "<font color=red><center>$error</center>";}?>
    <p align="center"> <span class="tiny-link"><br />
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</div>
<div id="footer1">
  <p>THIS INFORMATION IS CONFIDENTIAL AND FOR INTERNAL EDUCATIONAL PURPOSES ONLY. 
    <br />
    SOME OF THE CONTENT WITHIN THIS CASE STUDY MAY NOT BE CONDSISTENT WITH THE U.S. PRESCRIBING INFORMATION. </p>
</div>
</body>
</html>
