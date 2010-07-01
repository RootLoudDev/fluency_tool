<?php
include_once('userroles.php');
session_start();
checkLogin('manager');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PULMOZYME: Manager Screen</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body onLoad="terrSelect()">
<script language="javascript" type="text/javascript">
<!-- 

var rowCount = 12;  // Number of "Name" Rows available
var assocFeedback = [];
var assocScenarioFlag = [];
var associateUserName = "";
var scenarioFileName = "";
var notesDefaultText = "Feedback";

function associateSelected(){
	assocSelected="";
	for(i = 0; i < rowCount; i++){
		if (document.repForm.rep[i].checked == true) {
			assocSelected = document.repForm.rep[i].value;
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

//Browser Support Code
function terrSelect(){
	var ajaxRequest; 
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("You must update your browser to use this application");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var terrSelectResults = ajaxRequest.responseText.split("|");
			var terrSelectResultsCount = terrSelectResults[0];
			
			for(i = 0; i < rowCount; i++){
				var x = document.getElementById('repTable').rows[i].cells;

				if (i < terrSelectResultsCount) {
					var associateResults = terrSelectResults[i+1].split("~");
					var associateId = associateResults[0];
					if (i%2 == 0) {
						var associateName = "<strong>" + associateResults[1] + " " + associateResults[2] + "</strong>";
					} else {
						var associateName = associateResults[1] + " " + associateResults[2];
					}
					x[0,1].innerHTML=associateName;
					document.repForm.rep[i].value = associateId;
					document.repForm.rep[i].checked = false;
					document.repForm.rep[i].style.display = 'block';


				} else {
					x[0,1].innerHTML = "&nbsp";
					document.repForm.rep[i].value = "";
					document.repForm.rep[i].checked = false;
					document.repForm.rep[i].style.display = 'none';
				}				
			}
		// Reset Scenario buttons	
			for(i = 0; i <= 6; i++){
				document.scenarioForm.scenario[i].style.display = 'none';
				document.scenarioForm.scenario[i].checked=false;
			}
		// Reset Notes
			document.notesForm.notes.value = notesDefaultText;
			document.notesForm.notesSave.disabled = true;
			scenarioFileName = "";
		
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
		if	(document.territoryForm.three.checked == true) {
			locSelected = locSelected + document.territoryForm.three.value + "~"; }
		if	(document.territoryForm.four.checked == true) {
			locSelected = locSelected + document.territoryForm.four.value + "~"; }	
		if	(document.territoryForm.five.checked == true) {
			locSelected = locSelected + document.territoryForm.five.value + "~"; }
		if	(document.territoryForm.six.checked == true) {
			locSelected = locSelected + document.territoryForm.six.value + "~"; }
		if	(document.territoryForm.seven.checked == true) {
			locSelected = locSelected + document.territoryForm.seven.value + "~"; }

	var queryString = "?locSelected=" + locSelected;
	ajaxRequest.open("GET", "managerData.php" + queryString, true);
	ajaxRequest.send(null); 
}

function assocSelect(){
	var ajaxRequest; 
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("You must update your browser to use this application");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		// Record 0 - username and 7 scenario flags; Records 1+ - feedback
			var assocSelectResults = ajaxRequest.responseText.split("|");
			assocInfoWork = assocSelectResults[0].split("~");
			associateUserName = assocInfoWork[0];
			
			for(i = 0; i <=6; i++){
				assocScenarioFlag[i] = assocInfoWork[i+1];
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
	var ajaxRequest; 
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("You must update your browser to use this application");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			assocFeedback[scenSelected]=notesText;
			alert("Feedback saved.");
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
	for (i = 0; i < s.length; i++) {  // Search through string and append to unfiltered values to returnString.
		var c = s.charAt(i);
		if (filteredValues.indexOf(c) == -1) returnString += c;
	}
	notesText = returnString;

	var queryString = "assocSelected=" + assocSelected + "&scenSelected=" + scenSelected + "&notesText=" + notesText;
	ajaxRequest.open("POST", "notesUpdate.php", true);
	ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxRequest.send(queryString); 
}

function scenarioClicked(num){
	var feedback = assocFeedback[num];
	document.notesForm.notes.value = feedback;
	if(assocScenarioFlag[num-1] == 1) {
		document.notesForm.notesSave.disabled = false;
		scenarioFileName = "Scenario" + num + ".wav";
		uploadsDir = "uploads/" + associateUserName;
		playString = uploadsDir + "/" + scenarioFileName;
		document.ListenUpPlayer.loadRecording(playString);
	} else {
		document.notesForm.notesSave.disabled = true;
		scenarioFileName = "";
		document.ListenUpPlayer.erase();
	}
}

//-->
</script>
<div id="container">

<img src="images/logo.gif" width="303" height="98" alt="Xolair" />
<div id="content">
 <table width="873" border="0">
  <tr>
    <td width="187">
      <div id="column">
        <div id="menu-bar2" style="text-align:center;"> Territory</div>
        <div class="contentInterior">
          <div class="scenario">
            <form action="" method="" name="territoryForm" id="territoryForm" onsubmit="">
              <table border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="20"><input type="checkbox" name="one" value="Northwest" onclick="terrSelect()"/></td>
                  <td width="562" class="blue"><strong>Northwest</strong></td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="two" value="Southeast" onclick="terrSelect()"/></td>
                  <td class="grey">Southeast</td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="three" value="Northeast" onclick="terrSelect()"/></td>
                  <td class="blue"><strong>Northeast</strong></td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="four" value="" onclick="terrSelect()"/></td>
                  <td class="grey">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="five" value="" onclick="terrSelect()"/></td>
                  <td class="blue">&nbsp;</td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="six" value="" onclick="terrSelect()"/></td>
                  <td class="blue"></td>
                  </tr>
                <tr>
                  <td><input type="checkbox" name="seven" value="" onclick="terrSelect()"/></td>
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
    <td width="187">
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
    <td width="187">
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
	  
<!-- Player Applet -->
<td width="294" valign="bottom" COLSPAN=4>
<applet 
    code="com.softsynth.javasonics.recplay.PlayerApplet"
	mayscript = "true"
    codebase="./codebase"
    archive="JavaSonicsListenUp.jar"
    name="ListenUpPlayer"
    width="294"
    height="70">
	<param name="bevelSize" value="2">
	<param name="showTimeText" value="yes">
	<param name="showLogo" value="no">

    <!-- Play the file at this URL. - set by javascript -->
 <!--   <param name="sampleURL" value="Scenario1.wav"> -->

</applet>
<!-- End Applet -->
	  
 <!--   <td width="294" valign="bottom" COLSPAN=4> --><br /><br />
      <form id="notesForm" name="notesForm" method="" action="">
        <label>
			<textarea name="notes" id="notes" cols="34" rows="13">Feedback</textarea>
        </label>
			  <input type='button' name='notesSave' onclick='notesUpdate()' disabled=true value='Save Feedback' />
      </form> 
	</td>
	</tr>
  </tr>
  </table>
</div>
</div>


<div id="footer1">
  <p>THIS INFORMATION IS CONFIDENTIAL AND FOR INTERNAL EDUCATIONAL PURPOSES ONLY. 
    <br />
    SOME OF THE CONTENT WITHIN THIS CASE STUDY MAY NOT BE CONDSISTENT WITH THE U.S. PRESCRIBING INFORMATION. </p>
</div>
</body>
</html>
