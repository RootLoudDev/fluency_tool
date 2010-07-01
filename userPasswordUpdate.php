<?php
include_once('userroles.php');
session_start();
checkLogin('admin');

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
	$id = (int) $_GET['id'];
} else {
	header("Location: ./admin.php");
}
	
$userquery = "SELECT ID, username, firstname, lastname FROM users WHERE ID='$id';";
$userresults = mysql_query($userquery);

if (mysql_num_rows($userresults) == 0)
{
	header("Location: ./admin.php");
} else {
		$row = mysql_fetch_assoc($userresults);
		$id = $row["ID"];
		$username = $row["username"];
		$firstname =  $row["firstname"];
		$lastname = $row["lastname"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Update Password</title>
</head>
<body>
<script type="text/javascript">
function validateForm() {
    var errors=''
	if (document.getElementById('password').value != document.getElementById('confirmpassword').value) errors += '- Passwords must match.\n';
	if (document.getElementById('password').value == "") errors += '- Password is required.\n';
	if (errors) alert('The following error(s) occurred:\n'+errors);
    document.returnValue = (errors == '');
}
</script>
    <form action="userPasswordSave.php" method="post" name="userForm" id="userForm" onsubmit="validateForm();return document.returnValue">
		<table>
			<tr>Change password for <?php echo $firstname . " " . $lastname . "(" . $username . ")" ?></tr>
			<tr><td>Password</td><td><input type="password" name="password" id="password" size="35" value="" /></td></tr>
			<tr><td>Confirm Password</td><td><input type="password" name="confirmpassword" id="confirmpassword" size="35" value="" /></td></tr>
		</table>
		<br/><br/>
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<input type="submit" name="userSave" id="userSave" value="Save User" />
		<input type="button" name="cancel" onclick="window.location.href='./admin.php'"  value="Cancel" />
    </form>
</body>
</html>