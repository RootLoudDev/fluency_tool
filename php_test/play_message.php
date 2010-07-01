<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/sdkDoc.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_sdk.css" rel="stylesheet" type="text/css"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Play a Voice Message</title>
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
          <h1><!-- InstanceBeginEditable name="mainHeading" -->Test ListenUp <!-- InstanceEndEditable --></h1>
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


<p>
This page will play a voice message whose name is passed in the HTTP query.
The filename is specified using the "sampleName" parameter.
See the URL for this page in your browser address bar as an example.
</p>

<applet
    CODE="com.softsynth.javasonics.recplay.PlayerApplet"
    CODEBASE="../codebase"
    ARCHIVE="JavaSonicsListenUp.jar,OggXiphSpeexJS.jar"
    NAME="JavaSonicRecorderUploader"
    WIDTH="220" HEIGHT="70">
	
	<param name="autoPlay" value="yes">
    <param name="showWaveform" value="yes">
<?php

// The name of the sample to be played is passed using an HTML query parameter.
// The variable is $sampleName.
    $sampleName = strip_tags($_GET['sampleName']);
// The path is relative to $uploads_dir
    $uploads_dir = "../uploads";
// Add a timestamp to the URL to defeat any caches.
	$sampleURL = $uploads_dir . "/". $sampleName . "?time=" . time();

	echo "<param name=\"sampleURL\" ";
	echo "   value=\"$sampleURL\">\n";
?>
</applet>
<p>
If the recorded message is a WAV file recorded using either "adpcm" or "s16" format
then it can also be played directly by the browser.
<p>
<blockquote>
<h3>
<?php
	
	// Does the filename end with ".wav"?
	// If so then play it using a link.
	$suffix = substr( $sampleName, -4 );
	if( strcasecmp( $suffix, ".wav" ) == 0 )
	{
		echo "<a href=\"$sampleURL\">Click here to play the message using your browser's WAV player.</a>\n";
	}
	else
	{
		echo "Message is not a WAV file and can only be played using the Applet.\n";
	}

	$msgSize = filesize( "$uploads_dir/$sampleName" );
	echo "<p>Uploaded file size is $msgSize bytes.\n";
	
?>
</h3>
</blockquote>
<h3>Use your browser's BACK button to return to the test sequence. </h3>
<p>[<a href="index.html">Test Home</a>]
        
</p>
        <!-- InstanceEndEditable --> </div></td>
  </tr>
</table>
<br>
<div align="left"> &copy; 2001-2006 <a href="http://www.mobileer.com/">Mobileer, Inc.</a> &nbsp;&nbsp;This page is from the ListenUp&nbsp;SDK. You can download the SDK from <a href="http://www.javasonics.com/downloads/">here</a>.</div>
</body>
<!-- InstanceEnd --></html>
