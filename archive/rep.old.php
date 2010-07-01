<?php
include_once('userroles.php');
session_start();
checkLogin('associate');

$userassociate = $_SESSION['user_name'];
$associateid = $_SESSION['user_id'];

$scenariocount = 7;

// Set up recorder  <<<<<<<<<<<<<<<<<<<<< CHECK THIS SECTION
$userDir=$userassociate;
$uploadsDir = "./uploads/" . $userDir;

// Get user data
$queryuser = "SELECT firstname, lastname, scenario1, scenario2, scenario3, scenario4, scenario5, scenario6, scenario7
			FROM users WHERE ID='$associateid'";
$resultuser = mysql_query($queryuser);

if (mysql_num_rows($resultuser) != 1)
{
	echo ("unexpected result in user query");
}

$rowuser = mysql_fetch_row($resultuser);
$fullname = "$rowuser[0] $rowuser[1]";	
//// Update scenario results 
for ($i=1; $i<=7; $i++)
{
	$scenario[$i] = $rowuser[($i+1)];
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PULMOZYME: Rep Screen</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="showFeedback.js"></script>
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
	var uploadsDir = "<?php echo $uploadsDir?>"

	
	function selectScenario(scenario)
	{
		showFeedback(scenario);
		switch (scenario)
		{
		case 'one_response':
			fileName = "Scenario1.wav";
			document.getElementById('notes').value = "<?php echo $fbText[1]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[1] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		case 'two_response':
			fileName = "Scenario2.wav";
			document.getElementById('notes').value = "<?php echo $fbText[2]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[2] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		case 'three_response':
			fileName = "Scenario3.wav";
			document.getElementById('notes').value = "<?php echo $fbText[3]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[3] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		case 'four_response':
			fileName = "Scenario4.wav";
			document.getElementById('notes').value = "<?php echo $fbText[4]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[4] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		case 'five_response':
			fileName = "Scenario5.wav";
			document.getElementById('notes').value = "<?php echo $fbText[5]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[5] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		case 'six_response':
			fileName = "Scenario6.wav";
			document.getElementById('notes').value = "<?php echo $fbText[6]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[6] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		case 'seven_response':
			fileName = "Scenario7.wav";
			document.getElementById('notes').value = "<?php echo $fbText[7]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[7] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
			}else{
				document.ListenUpPlayer.erase();
			}
			break;
		}
	}
	
	function scenarioUpload () {
		var scenariofile = fileName;
		document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
		switch (scenariofile)
		{
		case 'Scenario1.wav':
		scenarioDone[1]="1";
		break;
		case 'Scenario2.wav':
		scenarioDone[2]="1";
		break;
		case 'Scenario3.wav':
		scenarioDone[3]="1";
		break;
		case 'Scenario4.wav':
		scenarioDone[4]="1";
		break;
		case 'Scenario5.wav':
		scenarioDone[5]="1";
		break;
		case 'Scenario6.wav':
		scenarioDone[6]="1";
		break;
		case 'Scenario7.wav':
		scenarioDone[7]="1";
		break;		}
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
		selectScenario('one_response');
	}
}	
</script>
</head>

<body >
<div id="container">

<img src="images/logo.gif" width="303" height="98" alt="Xolair" />

<div id="content">
 <table width="873" border="0">
  <tr>
    <td width="420" rowspan="3" valign="top">
      <div id="column-wide">
        <div id="menu-bar3" style="text-align:center;"> Scenarios</div>
        <div class="contentInterior">
          <div class="scenario">
            <form action="" method="" name="territoryForm" id="territoryForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="20"><input type="radio" name="scenario" onClick="javascript:selectScenario('one_response')" checked /></td>
                  <td width="562" class="blue"><strong>Scenario 1</strong><div  id="one_response" style="display:block">
                    <p>You are meeting with Dr. Leonard, a pediatric pulmonologist, for the 2nd time. You begin the conversation with some open-ended questions to explore how Dr. Leonard considers Pulmozyme in his treatment decisions, and how it is incorporated in into his overall management of CF patients. He shares with you that he generally waits until he begins to see decline in FEV1 before he initiates Pulmozyme therapy.  I know the HCRT data showing early structural damage, but is there any evidence to suggest that Pulmozyme will make a difference?</p>
                    </div></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onClick="javascript:selectScenario('two_response')"/></td>
                  <td class="grey"><strong>Scenario 2</strong>
                  <div  id="two_response" style="display:none">
                    <p>You are meeting with Dr. Peters, a pulmonologist who has recently moved to the area. He has just joined a relatively new adult CF program at the CF Center. In your conversation with Dr. Peters you learn that his previous experience has been in a general adult pulmonary clinic where he saw primarily COPD and lung cancer patients. He is excited about this new opportunity to specialize in CF. He asks you to tell him about the Pulmozyme data for CF, particularly data on BID dosing for adults.</p>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario"onClick="javascript:selectScenario('three_response')"/></td>
                  <td class="blue"><strong>Scenario 3</strong>
                  <div  id="three_response" style="display:none">
                    <p>You are meeting with Dr. James, a pediatric pulmonologist at the small rural pulmonary clinic. He manages the care for a small number of CF patients who are unable to travel to the regional CF center. He is familiar with Pulmozyme and states that he generally prescribes Pulmozyme only for his patients with severe disease, who are having frequent exacerbations requiring hospitalization. The patients are already burdened with daily care and this avoids the time and expense of another added daily treatment until it is really needed.</p>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onClick="javascript:selectScenario('four_response')"/></td>
                  <td class="grey"><strong>Scenario 4</strong>
                  <div  id="four_response" style="display:none">
                    <p>You are meeting with Dr. Westin, the pulmonologist at a small CF Center. When you are leaving his office you run into the office administrator in the hallway. She stops you and states that she has been really frustrated working with insurance carriers for the last two patients that have started on Pulmozyme. </p>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onClick="javascript:selectScenario('five_response')"/></td>
                  <td class="blue"><strong>Scenario 5</strong>
                  <div  id="five_response" style="display:none">
                    <p>You are meeting with the nursing staff at the CF Center and you run into Dr. Levine, one of the pediatric pulmonologists. She tells you that she just saw a 4 year old patient who has progressive lung disease and increasing frequency of infection and pulmonary exacerbations. She says she is thinking about starting him on Pulmozyme and wants to know what data is available for that age group. Do you know if insurance will cover the medication?</p>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onClick="javascript:selectScenario('six_response')"/></td>
                  <td class="blue"><span class="grey"><strong>Scenario 6</strong>
                  </span>
                    <div  id="six_response" style="display:none">
                      <p class="grey">You are meeting with a Dr. Casey, a pediatric pulmonologist who is new to the CF Center. You chat about where he used to live and his professional experience. The conversation then turns to how he approaches care of CF. He comments that he likes to keep the treatment plan as simple as possible for the parents and patient, so he tends to initiate Pulmozyme when lung progression is evident. </p>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onClick="javascript:selectScenario('seven_response')"/></td>
                  <td class="grey"><span class="blue"><strong>Scenario 7</strong>
                  </span>
                    <div  id="seven_response" style="display:none">
                      <p class="blue">You have an appointment to meet with Dr. Benjamin, an adult pulmonologist, who started the adult CF program at the CF Center 5 years ago. As she sits down to talk with you, Dr. Benjamin shakes her head and says, “I’ve been in clinic all morning, and I keep hearing the same thing from my patients – why do you keep adding more medications? Can’t I eliminate something for a change? It takes me so much time to neb all these drugs.  Some of my patients have been on Pulmozyme for 14 years. The hypertonic saline seems to add some benefit. Do they need to be on both Pulmozyme and hypertonic saline?</p>
                    </div>
                  </td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
      </div></td>
    <td height="113" valign="bottom">
<!-- Recorder Applet -->
<applet 
    CODE="com.softsynth.javasonics.recplay.RecorderUploadApplet"
	mayscript = "true"
    CODEBASE="./codebase"
    ARCHIVE="JavaSonicsListenUp.jar"
    NAME="JavaSonicRecorderUploader"
    WIDTH="420" HEIGHT="110">
	<param name="bevelSize" value="2">
    <param name="uploadURL" value="handle_upload_simple.php">
    <param name="uploadFileName" value="upload.wav">
	<param name="showLogo" value="no">
	<param name="stashBeforeSend" value="yes">
	<param name="useFileCache" = "yes">
	
	<param name="fieldName_1" value="userDir">
	<param name="fieldRows_1" value="0">
	<param name="fieldDefault_1" value="<?php echo $userDir ?>">

	<param name="fieldName_2" value="scenario"> -->
	<param name="fieldRows_2" value="0"> -->
	<param name="fieldDefault_2" value="Scenario1.wav"> -->
	
	<param name="fieldName_3" value="userId">
	<param name="fieldRows_3" value="0">
	<param name="fieldDefault_3" value="<?php echo $associateid ?>">	
	
</applet>
<!-- Player Applet -->
<applet 
    CODE="com.softsynth.javasonics.recplay.PlayerApplet"
	mayscript = "true"
    CODEBASE="./codebase"
    ARCHIVE="JavaSonicsListenUp.jar"
    NAME="ListenUpPlayer"
    WIDTH="250"
    HEIGHT="70">
	<param name="bevelSize" value="2">
	<param name="showTimeText" value="yes">
	<param name="showLogo" value="no">

    <!-- Play the file at this URL. - set by javascript -->
<!--    <param name="sampleURL" value="Scenario1.wav"> -->
</applet>
<!-- End Applet -->

	</td>
  </tr>
  <tr>
    <td height="244" valign="bottom">
	  <label>
        <textarea name="notes" id="notes" cols="50" rows="13" disabled=true></textarea>
      </label>
	</td>
  </tr>
  <tr>
    <td width="443" height="2" valign="bottom"></td>
    </tr>
  </table>
</div>
</div>
<script language="javascript">
	setTimeout('appletLoaded()', 10);
</script>

<div id="footer1">
  <p>THIS INFORMATION IS CONFIDENTIAL AND FOR INTERNAL EDUCATIONAL PURPOSES ONLY. 
    <br />
    SOME OF THE CONTENT WITHIN THIS CASE STUDY MAY NOT BE CONDSISTENT WITH THE U.S. PRESCRIBING INFORMATION. </p>
</div>
</body>
</html>
