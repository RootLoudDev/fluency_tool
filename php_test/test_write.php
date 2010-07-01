<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/sdkDoc.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_sdk.css" rel="stylesheet" type="text/css"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Test PHP Write Permission</title>
<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" -->
   
   <meta name="GENERATOR" content="Mozilla/4.79 [en] (Windows NT 5.0; U) [Netscape]">
   <meta name="KeyWords" content="Java, audio, input, output, JavaSonics, recording, plugin, API">
   <meta name="Description" content="Java API for audio I/O.">

<!-- InstanceEndEditable -->
</head>
<body>
<center>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr valign="middle">
      <td width="200" bgcolor="#DCE2E7"><center>
          <font color="#FF9933" size="+2"><strong><em><a href="http://www.javasonics.com/" target="_top"> <font face="Verdana, Arial, Helvetica, sans-serif">JavaSonics</font></a></em> </strong></font>
        </center></td>
      <td width="60" bgcolor="#DCE2E7"><center>
          <h1>SDK</h1>
        </center></td>
      <td bgcolor="#DCE2E7"><center>
          <h1><!-- InstanceBeginEditable name="mainHeading" -->Test Write Permission for PHP<!-- InstanceEndEditable --></h1>
        </center></td>
    </tr>
  </table>
</center>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td valign="top" width="100" bgcolor="#D7E5F2"><br>
      <p><a class="sidenavbar" href="http://www.javasonics.com/" target="_top">Web&nbsp;Home</a></p>
      <p><a class="sidenavbar" href="../index.html" target="_top">SDK&nbsp;Home</a></p>
      <p><a class="sidenavbar" href="../docs/index.html" target="_top">Docs</a></p>
      <p><a class="sidenavbar" href="index.html" target="_top">Test&nbsp;PHP</a></p>
      <p><a class="sidenavbar" href="../asp_test/index.html" target="_top">Test&nbsp;ASP</a></p>
      <p><a class="sidenavbar" href="../asp_net_test/index.html" target="_top">Test&nbsp;ASP.NET</a></p>
      <p><a class="sidenavbar" href="../examples/index.html" target="_top">Examples</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/demos/" target="_top">Demos</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/downloads/" target="_top">Download</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/sales/" target="_top">Purchase</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/support/" target="_top">Support</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/forum/" target="_top">Forum</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/login/" target="_top">Login</a></p>
      <p><a class="sidenavbar" href="http://www.javasonics.com/contacts.php" target="_top">Contact&nbsp;Us</a></p>
      <p><a class="sidenavbar" href="http://www.mobileer.com/" target="_blank">Company</a></p>
      <br>
    </td>
    <td valign="top"><div class="primary"> <!-- InstanceBeginEditable name="primaryContent" -->

<center>
</center>
<p>
PHP will test to see if it can write to the "uploads" directory.</p>
<pre>
<?php


	// NOTE: This uses a relative pathname. You may want to substitute another directory.
	$uploadDir = "../uploads/";
	echo "Upload dir = $uploadDir\n";
	
	// Get client computer's IP address.
	$client_ip_address = $_SERVER["REMOTE_ADDR"];
	echo "client_ip_address = $client_ip_address\n";

	// Generate a unique filename based on the time and IP address.
	$uniq_id = md5(microtime() . $client_ip_address);
	$unique_filename = $uploadDir . "temp_" . $uniq_id . ".txt";
	echo "unique_filename = $unique_filename\n";
	
	if( !file_exists( $uploadDir ) )
	{
		echo "\nTest FAILED! Directory $uploadDir does not exist!\n" ;
		echo "Please modify the PHP code in this script to match your server folders.\n" ;
	}
	else
	{
		$fp = fopen( $unique_filename, "w" );
		if( !fwrite( $fp, "abcd\n") )
		{
			echo "\nWrite permission test FAILED!\n" ;
			echo "Could not write to file in directory:\n";
			echo "    $uploadDir\n" ;
			echo "Please change write permission according to the installation instructions.\n" ;
		}
		else
		{
			echo "\nWrite permission test PASSED!\n" ;
		}
		fclose( $fp );
		unlink( $unique_filename );
	}

?>

</pre>
<p>If the write test failed, see installation <a href="../docs/install.html">step #2</a> related to setting write permission for the &quot;uploads&quot; folder. Otherwise please continue with the <a href="record_upload_wav.php">next</a> test.</p>

<p>[<a href="index.html">Test Home</a>] [<a href="test_post.php">Previous</a>] [<a href="record_upload_wav.php">Next</a>] 
</p>
<p>
<!-- InstanceEndEditable --> </div></td>
  </tr>
</table>
<br>
<div align="left"> &copy; 2001-2006 <a href="http://www.mobileer.com/">Mobileer, Inc.</a> &nbsp;&nbsp;This page is from the ListenUp&nbsp;SDK. You can download the SDK from <a href="http://www.javasonics.com/downloads/">here</a>.</div>
</body>
<!-- InstanceEnd --></html>
