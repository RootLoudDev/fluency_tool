<?php
// Pagination script cribbed from http://www.phpfreaks.com/tutorial/basic-pagination
include_once('includes/_bootstrap.php');
session_start();
checkLogin('admin');

// find out how many rows are in the table 
$sql = "SELECT COUNT(*) FROM users";  // Need to exclude sysadmins once they exist
$result = mysql_query($sql) or die( "<H3>Read query failed</H3>");
$r = mysql_fetch_row($result);
$numrows = $r[0];

// number of rows to show per page
$rowsperpage = 20;

// find out total pages
$totalpages = ceil($numrows / $rowsperpage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Administration</title>
<link href="styles.css" rel="stylesheet" type="text/css" /></head>
<script type="text/javascript" src="request.js"></script>
<script language="javascript" type="text/javascript">
function callUserEdit(value){
	window.location.href='./userEntry.php?id=' + value;
}

function editUsers() {
	var rowsPerPage = "<?php echo $rowsperpage ?>";

	for (i=1; i<=rowsPerPage;i++)
	{
		checkbox = document.getElementById('chkbx['+i+']');
		if ((checkbox) && (checkbox.checked)) {
				checkbox.checked = false;
				callUserEdit(checkbox.value);
		}
	}
}

function callUserDelete(value){
	var ajaxRequest= createRequest();
	
	ajaxRequest.onreadystatechange = function() {
		if(ajaxRequest.readyState == 4){
			window.location.reload();
		}
	}

	var queryString = "id=" + value;
	ajaxRequest.open("POST", "userDelete.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}

function deleteUsers(){
	var rowsPerPage = "<?php echo $rowsperpage ?>";
	var deleteCount = 0;
	for (i=1; i<=rowsPerPage;i++)
	{
		checkbox = document.getElementById('chkbx['+i+']');
		if ((checkbox) && (checkbox.checked)) {
				checkbox.checked = false;
				callUserDelete(checkbox.value);
		}
	}
}

function callUpdatePassword(value) {
	window.location.href='./userPasswordUpdate.php?id=' + value;
}

function updatePasswords() {
	var rowsPerPage = "<?php echo $rowsperpage ?>";

	for (i=1; i<=rowsPerPage;i++)
	{
		checkbox = document.getElementById('chkbx['+i+']');
		if ((checkbox) && (checkbox.checked)) {
				checkbox.checked = false;
				callUpdatePassword(checkbox.value);
		}
	}
}

function toggleRow(row){
	checkbox = document.getElementById('chkbx['+row+']');

if(checkbox.checked) {
		checkbox.checked = false;
	} else {
		checkbox.checked = true;
	}
}
</script>
</head>

<div id="container">

<div class="blue" name="navmenu" id="navmenu" style="width: 100px; float: right;"><a href="logout.php"> Log Out </a></div>
<img src="images/logo.gif" width="303" height="98" alt="Pulmozyme" />
<div id="content">
<div id="managerInst" class="blue">
Edit Users &nbsp; | &nbsp; <a href="scenario.php">Edit Scenarios</a>
<br/><br/>

	<form action="" method="" name="adminForm" id="adminForm" onsubmit="">
		<input type="button" name="newUser" onclick="window.location.href='./userEntry.php'"  value="New User" />
		<input type="button" name="editUser" onclick="editUsers()"  value="Edit User" />
		<input type="button" name="updatePassword" onclick="updatePasswords()"  value="Update Password" />
		<input type="button" name="deleteUser" onclick="deleteUsers()"  value="Delete User" />
		<br>
		<table width="750" border="0">
			<tr>
				<td width="20"></td>
				<td width="100"><u>Username</u></td>
				<td width="100"><u>First Name</u></td>
				<td width="100"><u>Last Name</u></td>
				<td width="130"><u>Email</u></td>
				<td width="75"><u>Role</u></td>
				<td width="50"><u>Location</u></td>
			</tr>
<?php
// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {

  // cast var as int
   $currentpage = (int) $_GET['currentpage'];
} else {
   // default page num
   $currentpage = 1;
} // end if

// if current page is greater than total pages...
if ($currentpage > $totalpages) {
   // set current page to last page
   $currentpage = $totalpages;
} // end if
// if current page is less than first page...
if ($currentpage < 1) {
   // set current page to first page
   $currentpage = 1;
} // end if

// the offset of the list, based on current page 
$offset = ($currentpage - 1) * $rowsperpage;

// get the info from the db 
// Will need to skip sysadmin role users once they exist
$sql = "SELECT users.id, username, firstname, lastname, email, rolename, location FROM users INNER JOIN roles ON users.role = roles.ID ORDER BY lastname LIMIT $offset, $rowsperpage";
$result = mysql_query($sql) or die( "<H3>Read query failed</H3>" . mysql_error());

// Rows are numbered separately so a loop can be run on checkbox values on Edit or Delete
$rownum = 0;
// while there are rows to be fetched...
while ($list = mysql_fetch_assoc($result)) {
	$rownum ++;
	// echo data
	echo "<tr><td><input type='checkbox' name='chkbx[" . $rownum . "]' id='chkbx[" . $rownum . "]' value=" . $list['id'] . "></td>";
	echo "<td onclick='toggleRow(" . $rownum . ");'>" . $list['username'] . "</td>";
	echo "<td onclick='toggleRow(" . $rownum . ");'>" . $list['firstname'] . "</td>";
	echo "<td onclick='toggleRow(" . $rownum . ");'>" . $list['lastname'] . "</td>";
	echo "<td onclick='toggleRow(" . $rownum . ");'>" . $list['email'] . "</td>";
	echo "<td onclick='toggleRow(" . $rownum . ");'>" . $list['rolename'] . "</td>";
	echo "<td onclick='toggleRow(" . $rownum . ");'>" . $list['location'] . "</td></tr>";
} // end while

/******  build the pagination links ******/
// range of num links to show
$range = 3;

// if not on page 1, don't show back links
if ($currentpage > 1) {
   // show << link to go back to page 1
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
   // get previous page num
   $prevpage = $currentpage - 1;
   // show < link to go back to 1 page
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
} // end if 

// loop to show links to range of pages around current page
for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
   // if it's a valid page number...
   if (($x > 0) && ($x <= $totalpages)) {
      // if we're on current page...
      if ($x == $currentpage) {
         // 'highlight' it but don't make a link
         echo " [<b>$x</b>] ";
      // if not current page...
      } else {
         // make it a link
         echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
      } // end else
   } // end if 
} // end for

// if not on last page, show forward and last page links        
if ($currentpage != $totalpages) {
   // get next page
   $nextpage = $currentpage + 1;
    // echo forward link for next page 
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
   // echo forward link for lastpage
   echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
} // end if
/****** end build pagination links ******/
?>
		</table>
	</form>
</div>
</div>
<script language="javascript">
if (userIsReviewer == "1")
{	
	document.getElementById("navmenu").innerHTML = '<a href="logout.php"> Log Out </a><br/><br/><br/><br/><a href="rep.php"> My Scenarios </a>';
} else {
document.getElementById("navmenu").innerHTML = '<a href="logout.php"> Log Out </a>';
} 
</script>

<div id="footer1">
  <p>THIS INFORMATION IS CONFIDENTIAL AND FOR INTERNAL EDUCATIONAL PURPOSES ONLY. 
    <br />
    SOME OF THE CONTENT WITHIN THIS CASE STUDY MAY NOT BE CONSISTENT WITH THE U.S. PRESCRIBING INFORMATION. </p>
 
</div>
</body>
</html>