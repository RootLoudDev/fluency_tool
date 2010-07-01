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

// find out how many rows are in the table 
$sql = "SELECT COUNT(*) FROM users WHERE role = '2'";
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
<title>Add Peer</title>
<script type="text/javascript" src="request.js"></script>
<script language="javascript" type="text/javascript">
function callAddPeer(value, mode){
	var ajaxRequest= createRequest();
	ajaxRequest.onreadystatechange = function() {
		if(ajaxRequest.readyState == 4){
			window.location.reload();
		}
	}

	var queryString = "reviewee=" + value + "&reviewer=" + "<?php echo $id ?>" + "&mode=" + mode;
	ajaxRequest.open("POST", "updatePeer.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}

function addPeers(mode){
	var rowsPerPage = "<?php echo $rowsperpage ?>";
	for (i=1; i<=rowsPerPage;i++)
	{
		checkbox = document.getElementById('chkbx['+i+']');
		if ((checkbox) && (checkbox.checked)) {
				checkbox.checked = false;
				callAddPeer(checkbox.value, mode);
		}
	}
}
</script>
</head>
<body>
Add peers for <?php echo $firstname . " " . $lastname . "(" . $username . ")" ?>
	<form action="" method="" name="peerForm" id="peerForm" onsubmit="">
		<input type="button" name="addPeer" onclick="addPeers('0')"  value="Add" />
		<input type="button" name="addPeerRecip" onclick="addPeers('1')"  value="Add Reciprocal" />
		<input type="button" name="cancel" onclick="window.location.href='./userEntry.php?id=' + '<?php echo $id ?>';"  value="Cancel" />
		<br>
		<table width="500" border="0">
			<tr>
				<td width="20"></td>
				<td width="100"><u>Username</u></td>
				<td width="100"><u>First Name</u></td>
				<td width="100"><u>Last Name</u></td>
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
$currentPeersSql = "SELECT reviewee FROM peerreview WHERE reviewer = '$id'";
$currentPeersResult = mysql_query($currentPeersSql);
if ($peerResult = mysql_fetch_array($currentPeersResult)) {$peerArray = $peerResult["reviewee"];} else {$peerArray="0";}
while ($peerResult = mysql_fetch_array($currentPeersResult)) {
$peerArray = $peerArray . "," . $peerResult["reviewee"];
}

$sql = "SELECT users.id, username, firstname, lastname, location FROM users 
		WHERE role = '2' AND users.id <> '$id' AND users.id NOT IN (" . $peerArray . ") ORDER BY lastname LIMIT $offset, $rowsperpage";
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
</body>
</html>
</body>
</html>