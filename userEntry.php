<?php
include_once('userroles.php');
session_start();
checkLogin('admin');

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
	$id = (int) $_GET['id'];
} else {
	$id = "";
} 

if($id != null)
{
	$sql = "SELECT id, username, firstname, lastname, email, role, location FROM users WHERE ID='$id' LIMIT 1";
	$result = mysql_query($sql) or die( "<H3>Read query failed</H3>" . mysql_error());
	if(mysql_num_rows($result)==1)
	{
		$row = mysql_fetch_assoc($result);
		$id = $row["id"];
		$username = $row["username"];
		$firstname =  $row["firstname"];
		$lastname = $row["lastname"];
		$email = $row["email"];
		$role = $row["role"];
		$location = $row["location"];
		$entryType = "Edit";
		
		$peersQuery = "SELECT peerreview.reviewee, firstname, lastname, username FROM peerreview INNER JOIN users ON peerreview.reviewee = users.ID WHERE reviewer='$id'";
		$peersResult = mysql_query($peersQuery) or die("<H3>Read query failed</H3>" . mysql_error());
		$peerRows = mysql_num_rows($peersResult);
		if ($peerRows > 0) {
			$rownum = 0;
			$peerId = "";
			$peerInfo = "";
			while ($list = mysql_fetch_assoc($peersResult)) {
				$rownum ++;
				$peerInfo[$rownum] = $list['firstname'] . " " . $list['lastname'] . "(" . $list['username'] . ")";
				$peerId[$rownum] = $list['reviewee'];
			}
		}
	}
} else {
	$id = "";
	$username =  "";
	$firstname = "";
	$lastname = "";
	$email = "";
	$role = "";
	$location = "";
	$entryType = "New";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>User Entry</title>
<!-- Handles both new and edit -->
<script type="text/javascript" src="request.js"></script>
<script type="text/javascript">
var entryType = "<?php echo $entryType ?>";
var peerRows = "<?php echo $peerRows ?>";
var peerStr = "";
var peerInfo = "";
var peerIdStr = "";
var peerId = "";

if	(peerRows != "0")
{
	peerStr = "<?php if ($peerRows != 0 ) echo implode(',', $peerInfo); ?>";
	peerInfo = peerStr.split(",");
	peerIdStr = "<?php if ($peerRows != 0 ) echo implode(',', $peerId); ?>";
	peerId = peerIdStr.split(",");
}

function deletePeer(reviewee)
{
	var ajaxRequest= createRequest();
	
	ajaxRequest.onreadystatechange = function() {
		if(ajaxRequest.readyState == 4){
			window.location.reload();
		}
	}

	var queryString = "id=" + <?php echo $id ?> + "&reviewee=" + reviewee;
	ajaxRequest.open("POST", "peerDelete.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}
</script>
</head>
<body>
<script type="text/javascript">
function addNewPeer(){
	window.location.href='./addPeer.php?id=' + "<?php echo $id ?>";
}

function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } 
	if (entryType == "New" && document.getElementById('password').value != document.getElementById('confirmpassword').value) errors += '- Passwords must match.\n';
	if (entryType == "New" && document.getElementById('password').value == "") errors += '- Password is required.\n';
	if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
    <form action="userSave.php" method="post" name="userForm" id="userForm" onsubmit="MM_validateForm('username','','R','firstname','','R','lastname','','R','email','','R','role','','R','location');return document.MM_returnValue">
	
		<table>
			<tr><td>Username</td><td><input name="username" type="text" id="username" size="35" disabled=true value="<?php echo $username ?>" /></td></tr>
			<tr><td>First Name</td><td><input name="firstname" type="text" id="firstname" size="35" value="<?php echo $firstname ?>" /></td></tr>
			<tr><td>Last Name</td><td><input name="lastname" type="text" id="lastname" size="35" value="<?php echo $lastname ?>" /></td></tr>
			<tr><td>Email</td><td><input name="email" type="text" id="email" size="35" value="<?php echo $email ?>" /></td></tr>
			<tr><td>Role</td><td><select name="roleselect" id="roleselect">
				<option	value="2">Associate</option>
				<option value="1">Manager</option>
				<option value="3">Admin</option></select>
			</td></tr>
			<tr><td>Location</td><td><select name="locationselect" id="locationselect">
				<option value="East">East</option>
				<option value="West">West</option></select>
			</td></tr>
			<tr id="pwd" style="display:table-row;"><td>Password</td><td><input type="password" name="password" type="text" id="password" size="35" value="" /></td></tr>
			<tr id="cfmpwd" style="display:table-row;"><td>Confirm Password</td><td><input type="password" name="confirmpassword" type="text" id="confirmpassword" size="35" value="" /></td></tr>
		</table>
		<br/><br/>
		<input type="hidden" name="entryType" value="<?php echo $entryType ?>" />
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<input type="submit" name="userSave" id="userSave" value="Save User" />
		<input type="button" name="cancel" onclick="window.location.href='./admin.php'"  value="Cancel" />

    </form>
<script type="text/javascript">
if (entryType=="New") {
	document.getElementById('pwd').style.display = "table-row";
	document.getElementById('cfmpwd').style.display = "table-row";
	document.getElementById('username').disabled = false;
} else {
	document.getElementById('pwd').style.display = "none";
	document.getElementById('cfmpwd').style.display = "none";
	document.getElementById('username').disabled = true;
}

var role = "<?php echo $role ?>";
if (role=="2") {document.getElementById('roleselect').options[0].selected="yes"}
	else if (role=="1") {document.getElementById('roleselect').options[1].selected="yes"}
	else if (role=="3") {document.getElementById('roleselect').options[2].selected="yes"};
	
var userlocation = "<?php echo $location ?>";
if (userlocation=="East") {document.getElementById('locationselect').options[0].selected="yes"}
	else if (userlocation=="West") {document.getElementById('locationselect').options[1].selected="yes"};
</script>
<div id="peerlist">
<H3><u>Peers</u></H3><input type="button" name="addPeer" id="addPeer" value="Add" onclick="addNewPeer()"/>
<table>
</div>
<script type="text/javascript">
if (role != "2") {
	document.getElementById('peerlist').style.visibility = 'hidden';
} else {
	document.getElementById('peerlist').style.visibility = 'visible';
	for (i=0; i<=peerRows-1; i++) {
		document.write("<tr><td>" + peerInfo[i] + "</td><td><a href='javascript:deletePeer(" + peerId[i] + ");'>delete</a></td></tr>");
	}
}
</script>
</table>
</body>
</html>