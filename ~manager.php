<?php
include_once('userroles.php');
session_start();
checkLogin('manager associate');  /* Associates can access this screen if they are peer reviewers */
$userid = $_SESSION['user_id'];

// Get peerreview status
$queryuser = "SELECT role
			FROM users WHERE ID='$userid'";
$resultuser = mysql_query($queryuser);

if (mysql_num_rows($resultuser) != 1)
{
	echo ("unexpected result in user query");
}

$rowuser = mysql_fetch_row($resultuser);

if ($rowuser[0] <> "2")
{
	$userIsReviewer = 0;
} else {
	// Get peerreview status
	$querypeer = "SELECT * FROM peerreview WHERE reviewer='$userid'";
	$resultpeer = mysql_query($querypeer);
	if (mysql_num_rows($resultpeer) >= 1)
	{
		$userIsReviewer = 1;
	} else {
			header("Location: index.php");  /* Kick out associates who are not peer reviewers */
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PULMOZYME: Manager Screen</title>
<link href="styles.css" rel="stylesheet" type="text/css" /></head>
<body onLoad="terrSelect()">
<SCRIPT type="text/javascript" src="request.js"></SCRIPT>
<script language="javascript" type="text/javascript">
var rowCount = 12;  // Number of "Name" Rows available - deprecated since Name table is dynamically generated now
var assocFeedback = [];
var assocScenarioFlag = [];
var associateUserName = "";
var associateEmail = "";
var scenarioFileName = "";
var notesDefaultText = "";
var fileExtension = ".spx";
var userIsReviewer = "<?=$userIsReviewer?>";

function scenarioDescriptionDisplay(num)
{
	var scenario = num;
		if (scenario == '1') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You are meeting with Dr. Leonard, a pediatric pulmonologist, for the second time. You begin the conversation with some open-ended questions to explore Dr. Leonard's thoughts about early disease and clinical findings.&nbsp; Dr. Leonard replies that each patient presents differently, and some patients show early symptoms while others do not.&nbsp; He asks if there is any new data to suggest that disease starts early in the course of CF.</p>";
		}
		if (scenario == '2') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You are meeting with Dr. Reynolds, a pediatric pulmonologist who recently completed her fellowship program and joined the Cystic Fibrosis Care Center. This is your first meeting with Dr. Reynolds. You begin the conversation with an open-ended question: Can you tell me about your experience with Pulmozyme? Dr. Reynolds states that she cared for several CF patients on Pulmozyme during her fellowship. She knows that Pulmozyme is a component of standard therapy for the patient with CF, but asks if you would review the proposed mechanism of action. ";
		}
		if (scenario == '3') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You are meeting with Dr. Peters, a pulmonologist who has recently moved to the area. He has just joined a relatively new adult CF program at the CF Center. In your conversation with Dr. Peters, you learn that his previous experience has been in a general adult pulmonary clinic, where he saw primarily COPD and lung cancer patients. He is excited about this new opportunity to specialize in CF. He asks you to tell him about the Pulmozyme data for CF, particularly data on BID dosing for adults.</p>";
		}
		if (scenario == '4') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You are meeting with Dr. James, a pediatric pulmonologist at a small rural pulmonary clinic. He manages the care for a small number of CF patients who are unable to travel to the regional CF center. He is familiar with Pulmozyme and states that he generally prescribes Pulmozyme only for his patients with severe disease who are having frequent exacerbations requiring hospitalization. The patients are already burdened with daily care, and this avoids the time and expense of another added daily treatment until it is really needed.</p>";
		}
		if (scenario == '5') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You are meeting with Dr. Westin, the pulmonologist at a small CF Center. As you are leaving his office you run into the office administrator in the hallway. She stops you and states that she has been really frustrated working with insurance carriers for the last 2 patients that have started on Pulmozyme. </p>";
		}
		if (scenario == '6') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You are meeting with the nursing staff at the CF Center and you run into Dr. Levine, one of the pediatric pulmonologists. She tells you that she just saw a 4 year-old patient who has progressive lung disease and increasing frequency of infection and pulmonary exacerbations. She says she is thinking about starting him on Pulmozyme and wants to know what data is available for that age group. She asks if insurance will cover the medication.</p>";
		}
		if (scenario == '7') 
		{ 
			return "<p><strong>Description of the Situation</strong></p>" +
					"<p>You have an appointment to meet with Dr. Benjamin, an adult pulmonologist, who started the adult CF program at the CF Center 5 years ago. As she sits down to talk with you, Dr. Benjamin shakes her head and says, \"I've been in clinic all morning, and I keep hearing the same thing from my patients: <em>'Why do you keep adding more medications? Can't I eliminate something for a change? It takes me so much time to neb all these drugs</em>.'&nbsp; Some of my patients have been on Pulmozyme for 14 years. The hypertonic saline seems to add some benefit. Do they need to be on both Pulmozyme and hypertonic saline?\"</p>";
		}
}

function scenarioNameDisplay()
{
	var fileNameDisplay = scenarioFileName.replace(fileExtension, "");
	fileNameDisplay = fileNameDisplay.substring(0,8) + " " + fileNameDisplay.substring(8);	
	return fileNameDisplay;
}

function associateSelected(){
	assocSelected="";
	var	table = document.getElementById('repTable');
	var tableLength = table.rows.length;
	
	if (tableLength == 1)
	{
		if (document.repForm.rep.checked == true) {
			assocSelected = document.repForm.rep.value;
		}
	} else {
		for(i = 0; i < tableLength; i++){
			if (document.repForm.rep[i].checked == true) {
				assocSelected = document.repForm.rep[i].value;
			}
		}
	}
	return assocSelected;
}

function scenarioSelected(){
	scenSelected="";
	for(i = 0; i <= 6; i++){
		if (document.scenarioForm.scenario[i].checked == true) {
			scenSelected = i+1;
		}
	}
	return scenSelected;
}

function repTableClear(){
	var	table = document.getElementById('repTable');
	var lastRow = table.rows.length;
	for(i = 0; i < lastRow; i++){
		table.deleteRow(0);
	}
}

function terrSelect(){
	var ajaxRequest = createRequest();

	// Function that receives data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var terrSelectResults = ajaxRequest.responseText.split("|");
			var terrSelectResultsCount = terrSelectResults[0];
			var	table = document.getElementById('repTable');
			
			repTableClear();

			for(i = 0; i < terrSelectResultsCount; i++){

				if (i < terrSelectResultsCount) {
					var associateResults = terrSelectResults[i+1].split("~");
					var associateId = associateResults[0];
					var associateName = associateResults[1] + " " + associateResults[2];
					var lastRow = table.rows.length;
					var row = table.insertRow(lastRow)
					
					// radio button
					var cellRadio = row.insertCell(0);
					var el = document.createElement('input');
					el.type = 'radio';
					el.name = 'rep';
					el.value = associateId;
					el.setAttribute('onClick', 'assocSelect()');
					cellRadio.appendChild(el);
					
					// rep name
					var cellRepName = row.insertCell(1);
					cellRepName.width = '150';
					if (i%2==0) {
					cellRepName.style.fontWeight = "bold";
					cellRepName.style.color = "#03175C";
					}
					var textNode = document.createTextNode(associateName);
					cellRepName.appendChild(textNode);
				}			
			}
		// Reset Scenario buttons	
			for(i = 0; i <= 6; i++){
				document.scenarioForm.scenario[i].style.display = 'none';
				document.scenarioForm.scenario[i].checked=false;
			}
		// Reset Notes
			document.getElementById("notes").value = notesDefaultText;
			document.notesForm.notesSave.disabled = true;
			scenarioFileName = "";
			document.ListenUpPlayer.erase();
			document.getElementById("nowplaying").innerHTML = "Scenario not selected.";				
		// Reset Names
			associateUserName = "";
		}
	}
	
	// Determine Locations checked
	var locSelected = "";
		if	(document.territoryForm.one.checked == true) {
			locSelected = locSelected + document.territoryForm.one.value + "~"; }
		if	(document.territoryForm.two.checked == true) {
			locSelected = locSelected + document.territoryForm.two.value + "~"; }

	var queryString = "?locSelected=" + locSelected + "&userIsReviewer=" + userIsReviewer;
	ajaxRequest.open("GET", "managerData.php" + queryString, true);
	ajaxRequest.send(null); 
}

function assocSelect(){
	var ajaxRequest = createRequest();

	// Function that receives data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		// Record 0 - username, email, and 7 scenario flags; Records 1+ - feedback
			var assocSelectResults = ajaxRequest.responseText.split("|");
			assocInfoWork = assocSelectResults[0].split("~");
			associateUserName = assocInfoWork[0];
			associateEmail = assocInfoWork[1];

// Enable/disable 'send email' checkbox
			if (associateEmail == "")
			{
				document.getElementById('sendEmail').disabled = true;
			} else {
				document.getElementById('sendEmail').disabled = false;
			}
			
			for(i = 0; i <=6; i++){
				assocScenarioFlag[i] = assocInfoWork[i+2];
			}
// Init feedback array
			for(i = 1; i <= 7; i++){
				assocFeedback[i] = notesDefaultText;
			}
// Populate feedback array
			var assocFeedbackWork = [];
			var scenarioNumber = "";
			for(i = 1; i < assocSelectResults.length; i++) {
				assocFeedbackWork = assocSelectResults[i].split("~"); // scenario~text   type removed for now
				scenarioNumber = assocFeedbackWork[0];
				
				if(assocFeedback[scenarioNumber] == notesDefaultText) {
					assocFeedback[scenarioNumber] = assocFeedbackWork[1];
				} else {
					assocFeedback[scenarioNumber] = assocFeedback[scenarioNumber] + " " + assocFeedbackWork[1];
				}
			}
			
// Set Scenario button visibility			
			for(i = 0; i <= 6; i++){
				if(assocScenarioFlag[i] == 1) {
					document.scenarioForm.scenario[i].style.display = 'block';

				} else {
					document.scenarioForm.scenario[i].style.display = 'none';
				}
				
				if(document.scenarioForm.scenario[i].checked) {
					scenarioClicked(i+1);  //Scenarios are numbered 1-7 so i must be adjusted
					if(assocScenarioFlag[i] == 1) {
						document.notesForm.notesSave.disabled = false;
					}
				}
			}
		}
	}
	
	var assocSelected = associateSelected();
	var queryString = "?assocSelected=" + assocSelected;
	ajaxRequest.open("GET", "managerNameSelect.php" + queryString, true);
	ajaxRequest.send(null); 
}

function notesUpdate() {
	var ajaxRequest = createRequest();

	// Function that receives data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			assocFeedback[scenSelected]=notesText;
			alert("Feedback saved.");
			if (document.getElementById('sendEmail').checked == true && !associateEmail == "")
			{
				// alert("E-mail here." + associateEmail + "|" + associateUserName);
				var email = associateEmail;
				var subject = "Pulmozyme Fluency Tool Feedback for Scenario " + scenSelected;
				var body_message = "I've given you some feedback for Scenario " + scenSelected + ".";
				var mailto_link = 'mailto:'+email+'?subject='+subject+'&body='+body_message;

				win = window.open(mailto_link,'emailWindow');
				if (win && win.open &&!win.closed) win.close(); 
				
			}
		}
	}
	
	var assocSelected = associateSelected();
	var scenSelected = scenarioSelected();
	var notesText = document.notesForm.notes.value;
// Strip | and ~ from notesText.
	s = notesText;
	filteredValues = "~|\"";     // Characters stripped out
	var i;
	var returnString = "";
	for (i = 0; i < s.length; i++) {  // Search through string and append unfiltered values to returnString.
		var c = s.charAt(i);
		if (filteredValues.indexOf(c) == -1) returnString += c;
	}
	notesText = returnString;

	var queryString = "assocSelected=" + assocSelected + "&scenSelected=" + scenSelected + "&notesText=" + notesText;
	ajaxRequest.open("POST", "notesUpdate.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}

function loadPlayer(playFilename, displayName)
{
	var d = new Date();
	var playString = playFilename + "?time=" + d.getTime();
	var display = displayName
	document.ListenUpPlayer.loadRecording(playString);	
	document.getElementById("nowplaying").innerHTML = display;		
}

function scenarioClicked(num){
	var feedback = assocFeedback[num];
	document.notesForm.notes.value = feedback;
	if(assocScenarioFlag[num-1] == 1) {
		document.notesForm.notesSave.disabled = false;
		scenarioFileName = "Scenario" + num + fileExtension;
		uploadsDir = "uploads/" + associateUserName;
		playString = uploadsDir + "/" + scenarioFileName;
		
		var fileNameDisplay = scenarioNameDisplay();
		loadPlayer(playString, fileNameDisplay);
		document.getElementById("description").innerHTML = scenarioDescriptionDisplay(num);
		document.getElementById('response').disabled = true;
		document.getElementById('idealResponse').disabled = false;
	} else {
		document.notesForm.notesSave.disabled = true;
		scenarioFileName = "";
		document.ListenUpPlayer.erase();
		document.getElementById("nowplaying").innerHTML = "Scenario not selected.";	
		document.getElementById("description").innerHTML = "Scenario not selected.";
		document.getElementById('response').disabled = true;
		document.getElementById('idealResponse').disabled = true;
	}
}

function loadYourResponse()
{
	document.getElementById('idealResponse').disabled = false;
	document.getElementById('response').disabled = true;
	var playString = uploadsDir + "/" + scenarioFileName
	var fileNameDisplay = scenarioNameDisplay();
	loadPlayer(playString, fileNameDisplay);
	document.getElementById('idealResponse').disabled = false;
	document.getElementById('response').disabled = true;
}

function loadIdealResponse()
{
	var bestScenarioFileName = "Optimal" + scenarioFileName;
	var bestDir = "exampleAudio/"
	var playString = bestDir + bestScenarioFileName;
	var fileNameDisplay = "Ideal " + scenarioNameDisplay();
	loadPlayer(playString, fileNameDisplay)	;
	document.getElementById('idealResponse').disabled = true;
	document.getElementById('response').disabled = false;
}
</script>
<div id="container">
<div class="blue" name="navmenu" id="navmenu" style="width: 100px; float: right;"><a href="logout.php"> Log Out </a></div>
<img src="images/logo.gif" width="303" height="98" alt="Pulmozyme" />
<div id="content">

 
 <table width="873" border="0">
   <div id="managerInst" class="blue">
	<strong>Overview and Instructions</strong>
<ol>
  <li>Select a sales rep from the Name column by clicking the button next to their name.  Territories can be selected to filter the list of names.  </li>
  <li>Select a scenario to review.  If a scenario does not have a button next to it, then the selected sales rep has not submitted a response for that scenario.</li>
  <li>Listen to the sales rep's response to a scenario by clicking the 'Play' icon in the 'Response' section.</li>
  <li>To provide context, you may listen to an ideal scenario response by selecting the 'Play' icon in the 'Ideal Response' section.</li>
  <li>Type your feedback on the rep's response in the text box under 'Feedback'. Please focus on the accuracy of the clinical information provided by the rep and the effectiveness of the overall positioning of the call. Click 'Save Feedback' to provide feedback to the rep.</li>
</ol>
	  </div>
 </table>
 
 
 <table width="873" border="0">
  <tr>
    <td width="187" valign="top">
      <div id="column">
        <div id="menu-bar2" style="text-align:center;"> Territory</div>
        <div class="contentInterior">
          <div class="scenario">
            <form action="" method="" name="territoryForm" id="territoryForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="20"><input type="checkbox" name="one" value="East" onclick="terrSelect()"/></td>
                  <td width="562" class="blue"><strong>East</strong></td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="two" value="West" onclick="terrSelect()"/></td>
                  <td class="grey">West</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="blue"></td>
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
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="grey"></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div></td>
    <td width="187" valign="top">
      <div id="column">
        <div id="menu-bar2" style="text-align:center;"> Name</div>
        <div class="contentInterior">
          <div class="scenario">
            <form action="" method="" name="repForm" id="repForm" onsubmit="">
              <table id="repTable" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="20"><input type="radio" name="rep" value="1" onclick="assocSelect()"/></td>
                  <td width="150" class="blue">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="2" onclick="assocSelect()"/></td>
                  <td class="grey">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="3" onclick="assocSelect()"/></td>
                  <td class="blue">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="4" onclick="assocSelect()"/></td>
                  <td class="grey">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="5" onclick="assocSelect()"/></td>
                  <td class="blue">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="6" onclick="assocSelect()"/></td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="7" onclick="assocSelect()"/></td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="8" onclick="assocSelect()"/></td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="9" onclick="assocSelect()"/></td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="10" onclick="assocSelect()"/></td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="11" onclick="assocSelect()"/></td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="rep" value="12" onclick="assocSelect()"/></td>
                  <td class="grey"></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      
      </td>
    <td width="187" valign="top">
      <div id="column">
        <div id="menu-bar2" style="text-align:center;"> Scenario</div>
        <div class="contentInterior">
          <div class="scenario">
            <form action="" method="" name="scenarioForm" id="scenarioForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="20"><input type="radio" name="scenario" onclick="scenarioClicked('1')"/></td>
                  <td width="562" class="blue"><strong>Scenario 1</strong></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onclick="scenarioClicked('2')"/></td>
                  <td class="grey">Scenario 2</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onclick="scenarioClicked('3')"/></td>
                  <td class="blue"><strong>Scenario 3</strong></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onclick="scenarioClicked('4')"/></td>
                  <td class="grey">Scenario 4</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onclick="scenarioClicked('5')"/></td>
                  <td class="blue"><strong>Scenario 5</strong></td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onclick="scenarioClicked('6')"/></td>
                  <td class="grey">Scenario 6</td>
                  </tr>
                <tr>
                  <td><input type="radio" name="scenario" onclick="scenarioClicked('7')"/></td>
                  <td class="blue"><strong>Scenario 7</strong></td>
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
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="grey"></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td class="grey"></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>      
      </td>
       <td width="289" valign="top" >
      <div id="column-manager">
        <div id="menu-bar2-manager" style="text-align:center;"> Response</div>
        <div class="contentInterior">
	      <div id="nowplaying" style="text-align:center;" class="blue">Scenario not selected.</div>      
          <div class="scenario-manager-right">
            <form action="" method="" name="responseForm" id="responseForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
<!-- Player Applet for Rep Audio -->
<applet 
    code="com.softsynth.javasonics.recplay.PlayerApplet"
	mayscript = "true"
    codebase="./codebase"
    archive="JavaSonicsListenUp.jar,OggXiphSpeexJS.jar"
    name="ListenUpPlayer"
    width="265"
    height="90">
	<param name="background" value="ffffff">
	<param name="foreground" value="000000">
	<param name="waveBackground" value="DCDCF6">
	<param name="waveForeground" value="03175C">
	<param name="skin" value="./images/DiddlySkin1.jpg">
	<param name="bevelSize" value="0">
	<param name="showTimeText" value="yes">
	<param name="showLogo" value="no">
</applet>
<input type="button" id="response" value="Rep Response" disabled=true onclick="loadYourResponse()">
<input type="button" id="idealResponse" value="Ideal Response" disabled=true onclick="loadIdealResponse()">			  

                </table>
              </form>
            </div>
          </div>
          <div id="menu-bar2-manager" style="text-align:center;">Scenario Description</div>
        <div class="contentInterior">
          <div class="scenario-manager-right">
            <form action="" method="" name="scenarioDescription" id="scenarioDescription" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
               <label>
			   	      <div id="description" style="text-align:left;" class="blue">Scenario not selected.</div>      
                </label>             
                </table>
              </form>
            </div>
          </div>
          <div id="menu-bar2-manager" style="text-align:center;"> Feedback</div>
        <div class="contentInterior">
          <div class="scenario-manager-right">
          <div align="center">
            <form action="" method="" name="notesForm" id="notesForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
             <label>
                 <textarea name="notes" cols="28" rows="6" id="notes"></textarea>
                 </label>           
				<input type='button' name='notesSave' onclick='notesUpdate()' disabled=true value='Save Feedback' /><br>
	            <input type='checkbox' name='sendEmail' id='sendEmail' checked=true/>Send Email on feedback.
                </table>
              </form>
              </div>
            </div>
          </div>
        </div>
     
      </td>
    <td width="10" valign="top"><br /><br /></td>
  </tr>
  </table>
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