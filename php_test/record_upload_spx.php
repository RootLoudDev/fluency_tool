<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/sdkDoc.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style_sdk.css" rel="stylesheet" type="text/css"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Test ListenUp - Upload Speex file</title>
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
          <h1><!-- InstanceBeginEditable name="mainHeading" -->Use Speex Voice Compression<!-- InstanceEndEditable --></h1>
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
    <td valign="top"><div class="primary"> <!-- InstanceBeginEditable name="primaryContent" --><p><br>


<ol>
<li>
When you see the Applet appear, click the red circle and speak
into the microphone. Try to say something besides "Hello, Testing, 1,2,3".</li>

<li>
You should see the "LEDs" light up as you speak. Try to keep
the level near the middle.</li>

<li>
Click the blue square to stop recording.</li>

<li>
Click the blue triangle to play back your recording.</li>

<li>
Click the send button upload the message to the server.</li>
</ol>

The message will be compressed approximately 20:1 using Speex.

<p>
<!-- Note that we need to add the JAR file for Speex to the ARCHIVE parameter. -->	
<applet
    CODE="com.softsynth.javasonics.recplay.RecorderUploadApplet"
    CODEBASE="../codebase"
    ARCHIVE="JavaSonicsListenUp.jar,OggXiphSpeexJS.jar"
    NAME="JavaSonicRecorderUploader"
    WIDTH="400" HEIGHT="120">
    
    <!-- Use Speex compression for small files. -->	
    <param name="format" value="speex">
    <!-- Set quality factor. Trade size for fidelity. -->	
    <param name="speexQuality" value="3.0">
    <!-- Use 16000 Hz, which is supported by Speex. -->	
    <param name="frameRate" value="16000.0">
    
    <!-- Most microphones are monophonic so use 1 channel. -->	
    <param name="numChannels" value="1">
    <!-- Set maximum message length to whatever you want. -->	
    <param name="maxRecordTime" value="20.0">

	<!-- Specify URL and file to be played after upload. -->
    <param name="refreshURL" value="play_message.php?sampleName=message_12345.spx">

	<!-- Specify name of file uploaded.
	     There are alternatives that allow dynamic naming. -->
    <param name="uploadFileName" value="message_12345.spx">
    
	<!-- Server script to receive the multi-part form data. -->
    <param name="uploadURL" value="handle_upload_simple.php">

<?php

	// Pass username and password from server to Applet if required.
	if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) )
    {
		$authUserName = $_SERVER['PHP_AUTH_USER'];
		echo "    <param name=\"userName\" value=\"$authUserName\">\n";
	
		$authPassword = $_SERVER['PHP_AUTH_PW'];
		echo "    <param name=\"password\" value=\"$authPassword\">\n";
	}
?>
</applet>
<p>[<a href="index.html">Test Home</a>] [<a href="record_upload_wav.php">Previous</a>] [<a href="index.html">Next</a>] 
<p>
<!-- InstanceEndEditable --> </div></td>
  </tr>
</table>
<br>
<div align="left"> &copy; 2001-2006 <a href="http://www.mobileer.com/">Mobileer, Inc.</a> &nbsp;&nbsp;This page is from the ListenUp&nbsp;SDK. You can download the SDK from <a href="http://www.javasonics.com/downloads/">here</a>.</div>
</body>
<!-- InstanceEnd --></html>
