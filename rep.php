<?php
include_once('includes/_bootstrap.php');
session_start();
checkLogin('associate');

$userassociate = $_SESSION['user_name'];
$associateid = $_SESSION['user_id'];

// Set up recorder 
$userDir=$userassociate;
$uploadsDir = "./uploads/" . $userDir;

// Get user data
$currentUser = new User;
$currentUser->setUserFromID($_SESSION['user_id']);
$currentUser->getScenarios();

//// Update scenario results
for ($i=1; $i<=7; $i++)
{
	$scenario[$i] = $currentUser->scenarios[($i-1)];
}

	
// Get feedback data
$queryfeedback = "SELECT fbscenario, fbtext, fbtype, firstname, lastname FROM feedback, users
						WHERE associateid='$associateid' AND 
								(feedback.managerid = users.ID)";
$resultfeedback = mysql_query($queryfeedback);
if (mysql_num_rows($resultfeedback) >= 1)
{
	while ($rowfeedback = mysql_fetch_array($resultfeedback))
	{
		$scn = $rowfeedback['fbscenario'];
		$txt = $rowfeedback['fbtext'];
		$type = $rowfeedback['fbtype'];
		$fname = $rowfeedback['firstname'];
		$lname = $rowfeedback['lastname'];
		$fbText[$scn] .= $fname." ".$lname." - ".$txt.'\n';
	}
}

// Get peerreview status
$querypeer = "SELECT * FROM peerreview WHERE reviewer='$associateid'";
$resultpeer = mysql_query($querypeer);
if (mysql_num_rows($resultpeer) >= 1)
{
	$userIsReviewer = 1;
} else {
	$userIsReviewer = 0;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PULMOZYME: Associate Screen</title>
<link href="styles.css" rel="stylesheet" type="text/css" />

<link href="css/start/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script/jquery-min.js"></script>
<script type="text/javascript" src="script/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript">
	$(function() {
		$("#accordion").accordion();
	});
	</script>

<script language="javascript">
	var scenarioDone=new Array(7);
		scenarioDone[1] = "<?php echo $scenario[1] ?>"
		scenarioDone[2] = "<?php echo $scenario[2] ?>"
		scenarioDone[3] = "<?php echo $scenario[3] ?>"
		scenarioDone[4] = "<?php echo $scenario[4] ?>"
		scenarioDone[5] = "<?php echo $scenario[5] ?>"
		scenarioDone[6] = "<?php echo $scenario[6] ?>"
		scenarioDone[7] = "<?php echo $scenario[7] ?>"
	var fileName = "";
	var uploadsDir = "<?php echo $uploadsDir?>";
	var fileExtension = ".spx";
	var userIsReviewer = "<?php echo $userIsReviewer?>";
	
	function scenarioNameDisplay()
	{
		var fileNameDisplay = fileName.replace(fileExtension, "");
		fileNameDisplay = fileNameDisplay.substring(0,8) + " " + fileNameDisplay.substring(8);	
		return fileNameDisplay;
	}
	
	function loadPlayer(playFilename, displayName)
	{
		var d = new Date();
		var playString = playFilename + "?time=" + d.getTime();
		var display = displayName
		document.ListenUpPlayer.loadRecording(playString);	
		document.getElementById("nowplaying").innerHTML = display;		
	}

	function selectScenarioPlayable ()
	{
		var playString = uploadsDir + "/" + fileName
//		var fileNameDisplay = fileName.replace(fileExtension, "");
//		fileNameDisplay = fileNameDisplay.substring(0,8) + " " + fileNameDisplay.substring(8);
		var fileNameDisplay = scenarioNameDisplay();
		loadPlayer(playString, fileNameDisplay);
		document.getElementById('loadIdealResponse').disabled = false;	
	}
	
	function selectScenarioUnplayable (scenarioChanged)
	{
		var scenarioChanged = scenarioChanged;
		document.getElementById('loadIdealResponse').disabled = true;
		if (scenarioChanged == true)
		{
			document.ListenUpPlayer.erase();
			document.getElementById("nowplaying").innerHTML = "Scenario not uploaded.";		
		}
	}
	
	function selectScenario(scenario)
	{
		var playable = document.JavaSonicRecorderUploader.isPlayable();
		var scenarioChanged = false;
		switch (scenario)
		{
		case 'one':
			if (fileName != "Scenario1" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario1.spx";
			document.getElementById('notes').value = "<?php echo $fbText[1]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[1] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		case 'two':
			if (fileName != "Scenario2" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario2.spx";
			document.getElementById('notes').value = "<?php echo $fbText[2]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[2] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		case 'three':
			if (fileName != "Scenario3" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario3.spx";
			document.getElementById('notes').value = "<?php echo $fbText[3]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[3] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		case 'four':
			if (fileName != "Scenario4" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario4.spx";
			document.getElementById('notes').value = "<?php echo $fbText[4]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[4] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		case 'five':
			if (fileName != "Scenario5" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario5.spx";
			document.getElementById('notes').value = "<?php echo $fbText[5]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[5] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		case 'six':
			if (fileName != "Scenario6" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario6.spx";
			document.getElementById('notes').value = "<?php echo $fbText[6]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[6] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		case 'seven':
			if (fileName != "Scenario7" + fileExtension)
			{
				scenarioChanged = true;
			}
			if (playable && scenarioChanged == true) 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario7.spx";
			document.getElementById('notes').value = "<?php echo $fbText[7]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			document.getElementById("nowrecording").innerHTML = scenarioNameDisplay();		
			if (scenarioDone[7] == 1) { 
				selectScenarioPlayable();	
			}else{
				selectScenarioUnplayable(scenarioChanged);
			}
			break;
		}
	}
	
	function scenarioUpload () {
		var scenariofile = fileName;
		selectScenarioPlayable();
		document.JavaSonicRecorderUploader.addNameValuePair("scenario", scenariofile);
		switch (scenariofile)
		{
		case 'Scenario1.spx':
		scenarioDone[1]="1";
		break;
		case 'Scenario2.spx':
		scenarioDone[2]="1";
		break;
		case 'Scenario3.spx':
		scenarioDone[3]="1";
		break;
		case 'Scenario4.spx':
		scenarioDone[4]="1";
		break;
		case 'Scenario5.spx':
		scenarioDone[5]="1";
		break;
		case 'Scenario6.spx':
		scenarioDone[6]="1";
		break;
		case 'Scenario7.spx':
		scenarioDone[7]="1";
		break;		}
	}

function loadYourResponse()
{
	document.getElementById('loadIdealResponse').disabled = false;
	document.getElementById('loadResponse').disabled = true;
	var playString = uploadsDir + "/" + fileName
	var fileNameDisplay = scenarioNameDisplay();
	loadPlayer(playString, fileNameDisplay);
}

function loadIdealResponse()
{
	var bestScenarioFileName = "Optimal" + fileName;
	var bestDir = "exampleAudio/"
	var playString = bestDir + bestScenarioFileName;
	var fileNameDisplay = "Ideal " + scenarioNameDisplay();
	loadPlayer(playString, fileNameDisplay);
	document.getElementById('loadIdealResponse').disabled = true;
// Only allow load your response if you've actually uploaded a response
	var num = fileName.substring(8,9);
	if (scenarioDone[num] == "1") {
		document.getElementById('loadResponse').disabled = false;
	}
}

function recorderStateChange( previousState, newState)
{
	if (newState == "recording" && fileName == "")
	{
		document.JavaSonicRecorderUploader.erase();
		alert("Please select a scenario before recording");
	}
	if (previousState == "recording" && fileName != "")
	{
		document.getElementById('loadIdealResponse').disabled = false;
	}
	
}
	
function appletLoaded()
{
	if( !document.ListenUpPlayer.isActive() )
	{
		// Wait 100 milliseconds and try again.
		setTimeout('appletLoaded()', 100 );
	} else if ( !document.JavaSonicRecorderUploader.isActive()) 
	{
		setTimeout('appletLoaded()', 100 );
	} else {
		document.JavaSonicRecorderUploader.setUploadCompletionScript("scenarioUpload();");
		animatedcollapse.init();
		selectScenario('one_response');
	}
}	
</script>
</head>

<body onLoad="appletLoaded();" rel="toggle[scen1]">
<div id="container">
<div class="blue" name="navmenu" id="navmenu" style="width: 100px; float: right;"><a href="logout.php"> Log Out </a>
</div>
<img src="images/logo.gif" width="303" height="98" alt="Pulmozyme" />
<div id="content" align="center">
 <table width="839" border="0">
  <tr>
    <td width="420" rowspan="3" valign="top">
      <div id="column-wide">
        <div id="menu-bar3" style="text-align:center;"> Scenarios</div>
        <div class="contentInterior">
          <div class="scenario">
            <form action="" method="" name="territoryForm" id="territoryForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="562" class="blue">

                  <div id="instructions" class="drop" style="text-align:left"><strong>Instructions</strong>
                    <p>Follow these instructions to get started:</p>
  <ol>
    <li>Read the first scenario presented.</li>
    <li>Record your audio response. </li>
    <li>Listen to your response. </li>
    <li>Listen to an ideal response to the scenario.</li>
    <li>Re-record until you are satisfied with your response.</li>
    <li>Upload your audio response.</li>
    <li>Continue this process until you have responded to all seven scenarios.</li>
  </ol>
</div>

<!-- Begin Scenarios -->

<div id="accordion">
<?php
  $results = mysql_query("SELECT * FROM scenarios");
while($row = mysql_fetch_row($results)){

    $id = $row[0];
    $scenarioTitle = $row[1];
    $scenarioDescription = $row[2];
    $scenarioResource = $row[3];
    ?>
<h3><a href="#"><?=$scenarioTitle?></a></h3>
    <div>
        <p><strong>Description of the Situation</strong></p>
        <?=$scenarioDescription?>
        <p>
        <strong>Description of Resources and Response</strong></p>
        <p><?=$scenarioResource?></p>
        <p><strong><u>Resources</u></strong></p>
            <ul>
            <?php $resource1Results = mysql_query("SELECT resource from resources WHERE scenarioID = '$id' AND resourceType = 1");
                while ($row1 = mysql_fetch_array($resource1Results)) {
                    $resource1 = $row1[0];
                    ?>
                    <li><?=$resource1?></li>
                    <?php
                }
            ?>

            </ul>
        <p>For your background information only: Reprint Binder</p>
            <ul>
            <?php $resource2Results = mysql_query("SELECT resource from resources WHERE scenarioID = '$id' AND resourceType = 2");
                while ($row2 = mysql_fetch_array($resource2Results)) {
                    $resource2 = $row2[0];
                    ?>
                    <li><?=$resource2?></li>
                    <?php
                }
            ?>

            </ul>
    </div>

<?php
}

?>


</div>


<!--  End Scenarios -->
                  </td>
                </tr>
                </table>
              </form>
            </div>
          </div>
      </div></td>
    <td height="113" valign="top">
    
    <div id="column-wide">
      <div id="menu-bar3" style="text-align:center;"> Record</div>
      <div class="contentInterior" >
	    <div id="nowrecording" style="text-align:center;" class="blue">Loading, please wait...</div>      
      <!-- Recorder Applet -->
<applet 
    CODE="com.softsynth.javasonics.recplay.RecorderUploadApplet"
	mayscript = "true"
    CODEBASE="./codebase"
    ARCHIVE="JavaSonicsListenUp.jar,OggXiphSpeexJS.jar"
    NAME="JavaSonicRecorderUploader"
    WIDTH="386" HEIGHT="130">
	<param name="background" value="ffffff">
	<param name="foreground" value="000000">
	<param name="waveBackground" value="DCDCF6">
	<param name="waveForeground" value="03175C">
	<param name="skin" value="./images/DiddlySkin1.jpg">
	<param name="bevelSize" value="0">
    <param name="uploadURL" value="handle_upload_simple.php">
    <param name="uploadFileName" value="upload.spx">
	<param name="showLogo" value="no">
	<param name="sendButtonText" value="Upload">
	<param name="requestStateChanges" value="yes">
	<param name="stateChangeCallback" value="recorderStateChange">
	<param name="format" value="speex">
	<param name="frameRate" value="8000">
	
	<param name="fieldName_1" value="userDir">
	<param name="fieldRows_1" value="0">
	<param name="fieldDefault_1" value="<?php echo $userDir ?>">

	<param name="fieldName_2" value="scenario"> -->
	<param name="fieldRows_2" value="0"> -->
	<param name="fieldDefault_2" value="Scenario1.spx"> -->
	
	<param name="fieldName_3" value="userId">
	<param name="fieldRows_3" value="0">
	<param name="fieldDefault_3" value="<?php echo $associateid ?>">	
	
</applet>
<!-- End Recorder Applet -->
        <div id="scenario2" class="drop">
            <table border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="562" class="blue" style="text-align:left">Using the controls above, you can record and upload your audio response. First, select a scenario from the ones to the left.  Then click the microphone button to begin recording. Click “Upload” when you are done recording. Be sure to upload your recording BEFORE changing scenarios or your work will be lost.  Once you have recorded your response, you will be able to listen to an ideal response in the Listen section below. </td>
              </tr>
            </table>
		</div>
      </div>
      <div id="menu-bar3" style="text-align:center;"> Listen</div>
        <div class="contentInterior">
          <div id="nowplaying" style="text-align:center;" class="blue">Scenario not uploaded.</div>      
<!-- Player Applet -->
<applet 
    CODE="com.softsynth.javasonics.recplay.PlayerApplet"
	mayscript = "true"
    CODEBASE="./codebase"
    ARCHIVE="JavaSonicsListenUp.jar,OggXiphSpeexJS.jar"
    NAME="ListenUpPlayer"
    WIDTH="386"
    HEIGHT="90">
	<param name="background" value="ffffff">
	<param name="foreground" value="000000">
	<param name="waveBackground" value="DCDCF6">
	<param name="waveForeground" value="03175C">
	<param name="skin" value="./images/DiddlySkin1.jpg">
	<param name="bevelSize" value="0">
	<param name="showTimeText" value="yes">
	<param name="showLogo" value="no">
</applet>
<!-- End Applet -->	

<input type="button" id="loadResponse" value="Load Your Response" disabled=true onclick="loadYourResponse()">
<input type="button" id="loadIdealResponse" value="Load Ideal Response" disabled=true onclick="loadIdealResponse()">
<p>
        <div id="scenario2" class="drop">
          <table border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td width="562" class="blue" style="text-align:left">Using the controls above, you can listen to your uploaded response and an ideal response.  Your response is automatically loaded for listening immediately after upload or when you select a scenario you have already uploaded a response for.  "Load Ideal Response" will be available for a scenario after you have recorded your response.  Click "Load Ideal Response" to load the ideal response for your review. Once you listen to the ideal response, you may choose to re-record your response to the scenario by going back to the Record section (above). Remember to upload your response each time you re-record.  Only the last response recorded will be available for evaluation.</td>
            </tr>
          </table>
        </div>
      </div>
        <div id="menu-bar3" style="text-align:center;"> Feedback</div>
      <div class="contentInterior">
        <div id="scenario2" class="drop">
          <table border="0" cellspacing="1" cellpadding="0" >
            <tr>
              <td width="562" align="center" class="blue" ><form id="form1" name="form1" method="post" action="">
                <label>
                  <textarea name="notes" cols="40" rows="9" id="notes" disabled=true></textarea>
                </label>
              </form></td>
            </tr>
          </table>
        </div>
      </div>
    </div></td>
  </tr>
  <tr>
    <td height="200" valign="bottom">
  
</td>
  </tr>
  <tr>
    <td width="409" height="2" valign="bottom"></td>
    </tr>
  </table>
</div>
</div>

<script>
if (userIsReviewer == "1")
{	
	document.getElementById("navmenu").innerHTML = '<?=$currentUser->username?> <a href="logout.php">Log Out </a><br/><br/><a href="manager.php"> Peer Review </a>';
} else {
document.getElementById("navmenu").innerHTML = '<?=$currentUser->username?> <a href="logout.php"> Log Out </a>';
} 
</script>

<div id="footer1">
  <p>THIS INFORMATION IS CONFIDENTIAL AND FOR INTERNAL EDUCATIONAL PURPOSES ONLY. 
    <br />
    SOME OF THE CONTENT WITHIN THIS CASE STUDY MAY NOT BE CONSISTENT WITH THE U.S. PRESCRIBING INFORMATION. </p>
</div>
</body>
</html>
