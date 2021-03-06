<?php
include_once('userroles.php');
session_start();
checkLogin('associate');

$userassociate = $_SESSION['user_name'];
$associateid = $_SESSION['user_id'];

$scenariocount = 7;

// Set up recorder 
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
<title>PULMOZYME: Manager Screen</title>
<link href="styles.css" rel="stylesheet" type="text/css" />

<!-- START SLIDE JAVASCRIPT -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="animatedcollapse.js">

/***********************************************
* Animated Collapsible DIV v2.4- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>


<script type="text/javascript">
animatedcollapse.addDiv('scenario1', 'fade=0,speed=400,group=pets, hide=0')
animatedcollapse.addDiv('scenario2', 'fade=0,speed=400,group=pets, hide=1')
animatedcollapse.addDiv('scenario3', 'fade=0,speed=400,group=pets, hide=1')
animatedcollapse.addDiv('scenario4', 'fade=0,speed=400,group=pets, hide=1')
animatedcollapse.addDiv('scenario5', 'fade=0,speed=400,group=pets, hide=1')
animatedcollapse.addDiv('scenario6', 'fade=0,speed=400,group=pets, hide=1')
animatedcollapse.addDiv('scenario7', 'fade=0,speed=400,group=pets, hide=1')

animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
	//$: Access to jQuery
	//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
	//state: "block" or "none", depending on state
	if (divobj.id=="scenario1") {
		if (state=="block") {
			selectScenario('one');
		}
	}
	if (divobj.id=="scenario2") {
		if (state=="block") {
			selectScenario('two');
		}
	}
	if (divobj.id=="scenario3") {
		if (state=="block") {
			selectScenario('three');
		} 
	}
	if (divobj.id=="scenario4") {
		if (state=="block") {
			selectScenario('four');
		} 
	}
	if (divobj.id=="scenario5") {
		if (state=="block") {
			selectScenario('five');
		} 
	}
	if (divobj.id=="scenario6") {
		if (state=="block") {
			selectScenario('six');
		} 
	}
	if (divobj.id=="scenario7") {
		if (state=="block") {
			selectScenario('seven');
		}
	}
}

animatedcollapse.init()

</script>
<!--END SLIDE JAVASCRIPT-->
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

	function loadPlayer(playFilename)
	{
		var d = new Date();
		var playString = playFilename + "?time=" + d.getTime();
		document.ListenUpPlayer.loadRecording(playString);			
	}
		
	function selectScenario(scenario)
	{
		var playable = document.JavaSonicRecorderUploader.isPlayable();
		
		switch (scenario)
		{
		case 'NONE':
			fileName = "";
			document.getElementById('notes').value = "";
			document.getElementById('loadResponse').disabled = true;
			document.getElementById('loadIdealResponse').disabled = true;
			try 
				{
					document.ListenUpPlayer.erase();
					document.JavaSonicRecorderUploader.erase();
				}
			catch (err)
				{
				}
			break;			
		case 'one':
			if (playable && fileName != "Scenario1.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario1.spx";
			document.getElementById('notes').value = "<?php echo $fbText[1]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[1] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;	
			}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		case 'two':
			if (playable && fileName != "Scenario2.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario2.spx";
			document.getElementById('notes').value = "<?php echo $fbText[2]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[2] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;
			}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		case 'three':
			if (playable && fileName != "Scenario3.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario3.spx";
			document.getElementById('notes').value = "<?php echo $fbText[3]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[3] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;
			}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		case 'four':
			if (playable && fileName != "Scenario4.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario4.spx";
			document.getElementById('notes').value = "<?php echo $fbText[4]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[4] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;
				}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		case 'five':
			if (playable && fileName != "Scenario5.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario5.spx";
			document.getElementById('notes').value = "<?php echo $fbText[5]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[5] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;
			}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		case 'six':
			if (playable && fileName != "Scenario6.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario6.spx";
			document.getElementById('notes').value = "<?php echo $fbText[6]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[6] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;
			}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		case 'seven':
			if (playable && fileName != "Scenario7.spx") 
			{
				document.JavaSonicRecorderUploader.erase();
			}
			fileName = "Scenario7.spx";
			document.getElementById('notes').value = "<?php echo $fbText[7]; ?>";
			document.JavaSonicRecorderUploader.addNameValuePair("scenario", fileName);
			if (scenarioDone[7] == 1) { 
				document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
				document.getElementById('loadIdealResponse').disabled = false;
			}else{
				document.getElementById('loadIdealResponse').disabled = true;	
				document.ListenUpPlayer.erase();
			}
			break;
		}
	}
	
	function scenarioUpload () {
		var scenariofile = fileName;
//		document.ListenUpPlayer.loadRecording(uploadsDir + "/" + fileName);
		var playString = uploadsDir + "/" + fileName
		loadPlayer(playString)
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
	loadPlayer(playString)
}

function loadIdealResponse()
{
	var bestScenarioFileName = "Optimal" + fileName;
	var bestDir = "exampleAudio/"
	var playString = bestDir + bestScenarioFileName;
	loadPlayer(playString);
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
		selectScenario('one_response');
	}
}	
</script>

</head>

<body>
<div id="container">
<div class="blue" id="logout" style="width: 80px; float: right;"><a href="logout.php"> Log Out </a></div>
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
                  
                  <div id="instructions" class="drop"><strong>Instructions</strong>
                    <p>Follow these instructions to get started:</p>
  <ol>
    <li>Read the first scenario presented.</li>
    <li>Record your audio response. </li>
    <li>Listen to your response. </li>
    <li>Listen to an ideal response to the scenario.</li>
    <li>Rerecord until you are satisfied with your response.</li>
    <li>Upload your audio response.</li>
    <li>Continue this process until you have responded to all seven scenarios.</li>
  </ol>
</div>

<a href="#" rel="toggle[scenario1]" data-openimage="images/scenario1-close.jpg" data-closedimage="images/scenario1.jpg"><img src="collapse.jpg" border="0" /></a>

<div id="scenario1" class="drop">
  <p><strong>Description of the Situation</strong></p>
  <p>You are meeting with Dr. Leonard, a pediatric pulmonologist, for the 2nd time. You begin the conversation with some open-ended questions to explore Dr. Leonard‘s thoughts about early disease and clinical findings.&nbsp; Dr. Leonard replies that each patient presents differently and some patients show early symptoms while others do not.&nbsp; He asks if there is any new data to suggest that disease starts early in the course of CF.</p>
  <hr />
  <p>
    <strong>Description of Resources a</strong><strong>nd Response</strong></p>
<p>Response would include a discussion of data suggesting early disease in CF.</p>
  <p><strong><u>Resources</u></strong><br />
    Resources to use during the disease state discussion include:</p>
  <ul>
    <li>Cystic Fibrosis(CF); Early Disease Processes and Their Role in CF Lung Disease: Data supporting the fact that there is lung disease/damage early in the course of disease, even when FEV1 is normal.</li>
    <li>Kirchner PRC-approved article: Shows increased DNA levels in infants with CF – and in some cases this was before there was radiographic evidence of disease.</li>
    <li>Sly PRC-approved article: Radiographic evidence of lung disease/ free neutrophilic elastase activity associated with structural lung disease.</li>
  </ul>
  <p>For your background information only: Reprint Binder</p>
  <ul>
    <li>Paul article: BALF study showing evidence of neutrophilic airway inflammation in patients with normal lung function.</li>
    <li>Brody article: High-Resolution CT in Young Patients showing that bronchiectasis is common in young children with CF with normal PFT’s.</li>
    <li>Tiddens article: Indicating a discrepancy between lung function and structural damage.</li>
    <li>Terrheggen-Lagro article: Study in young children with CF showing that chest radiograph scores worsen significantly over time even while lung function remains stable.</li>
    <li>Muhlebach article: Data showing that the ratio of neutrophils or of IL-8 to bacteria in BALF was significantly greater for CF patients compared to control subjects, regardless of pathogen.</li>
  </ul>
</div>



<a href="#" rel="toggle[scenario2]" data-openimage="images/scenario2-close.jpg" data-closedimage="images/scenario2.jpg"><img src="collapse.jpg" border="0" /></a> 

<div id="scenario2" class="drop">
  <p><strong>Description of the Situation</strong></p>
  <p>You are meeting with Dr. Reynolds, a pediatric pulmonologist, who recently completed her fellowship program and joined the Cystic Fibrosis Care Center. You are meeting with Dr. Reynolds for the first time. You begin the conversation with an open-ended question. Can you tell me about your experience with Pulmozyme? Dr. Reynolds states that she cared for several CF patients on Pulmozyme during her fellowship. She knows that Pulmozyme is a component of standard therapy for the patient with CF, but asks if you would review the mechanism of action. 
  <hr />
    <strong>Description of Resources and Response</strong></p>
  <p>Response would include a discussion of Pulmozyme’s MOA and use in the treatment of cystic fibrosis.</p>
  <p><strong><u>Resources</u></strong><br />
    Resources used during a Pulmozyme discussion:</p>
  <ul>
    <li>Pulmozyme education brochure: Review of abnormal mucus and disease progression, how Pulmozyme addresses abnormal mucus, proposed MOA, improvement in lung function, reduction in risk of exacerbation, thereby delaying disease progression.</li>
    <li>Pulmozyme PI: Review of Pulmozyme’s impact on lung function and respiratory exacerbation rate.</li>
  </ul>
</div>



<a href="#" rel="toggle[scenario3]" data-openimage="images/scenario3-close.jpg" data-closedimage="images/scenario3.jpg"><img src="collapse.jpg" border="0" /></a>
<div id="scenario3" class="drop">
<p><strong>Description of the Situation</strong></p>
<p>You are meeting with Dr. Peters, a pulmonologist who has recently moved to the area. He has just joined a relatively new adult CF program at the CF Center. In your conversation with Dr. Peters you learn that his previous experience has been in a general adult pulmonary clinic, where he saw primarily COPD and lung cancer patients. He is excited about this new opportunity to specialize in CF. He asks you to tell him about the Pulmozyme data for CF, particularly data on BID dosing for adults.</p>
<hr />
<p><strong>Description of Resources and Response</strong></p>
<p>Response would include a discussion of the efficacy and MOA of Pulmozyme.</p>
<p><strong><u>Resources</u></strong><br />
  Resources to use during the discussion:</p>
<ul>
  <li>Fuchs PRC-approved article: discuss the design, methods, &nbsp;and results </li>
  <li>Pulmozyme PI: Clinical data, emphasis on the data with BID dosing in patients&nbsp; ≥21 years of age</li>
  <li>Refer to Medical Communications for further information on BID dosing</li>
</ul>
</div>

<a href="#" rel="toggle[scenario4]" data-openimage="images/scenario4-close.jpg" data-closedimage="images/scenario4.jpg"><img src="collapse.jpg" border="0" /></a> 
<div id="scenario4" class="drop">
  <p><strong>Description of the Situation</strong></p>
  <p>You are meeting with Dr. James, a pediatric pulmonologist at the small rural pulmonary clinic. He manages the care for a small number of CF patients who are unable to travel to the regional CF center. He is familiar with Pulmozyme and states that he generally prescribes Pulmozyme only for his patients with severe disease, who are having frequent exacerbations requiring hospitalization. The patients are already burdened with daily care and this avoids the time and expense of another added daily treatment until it is really needed.</p>
  <p><strong>Description of the Resources and Response</strong></p>
  <p>Response could incorporate disease state education on the first visit, followed by Pulmozyme MOA discussions on subsequent visits. </p>
  <hr />
  <p><strong><u>Resources for Initial Visit</u></strong><br />
    Resources to use during disease state discussion include:</p>
  <ul>
    <li>Pulmozyme education brochure: Section on assessing risk factors for disease progression in cystic fibrosis</li>
    <li>Konstan (2007)PRC-approved article: Identifying risk factors for rate of decline in FEV1</li>
    <li>Konstan (2003)PRC-approved article: Growth and nutritional indexes in early life predict pulmonary function in CF</li>
    <li>Cory PRC-approved article: Normal pulmonary function did not predict a slower rate of decline</li>
  </ul>
  <p>For your background information only: Clinical Reprint Binder</p>
  <ul>
    <li>Flume (2007)article: Practice guidelines recommending chronic use of Pulmozyme in mild, moderate and severe disease</li>
    <li>Tiddens article: CF lung inflammation is early, sustained and severe. The same is true for lung damage</li>
  </ul>
  <p><strong><u>CS Response </u></strong><br />
    Dr. James, I understand your concerns for your patients.&nbsp; Let’s talk about disease severity and risk factors for disease progression for a few moments. I brought 3 articles that I think you might find interesting.&nbsp; This brochure highlights some of the findings in these studies (Section 2 in Pulmozyme education brochure on Risk factors/disease progression).</p>
  <p>As you can see on the first page, here are 3 HRCT scans of a 9 year old, 13 year old, and a 21 year old. Each of these patients has normal PFTs, which reflect normal lung function. But look at the scan itself; there is significant structural damage. This shows that structural lung damage may be well underway prior to abnormal lung function. What are your thoughts about this and do you have any patients that you currently see where this underlying process may be happening?</p>
  <p>When looking at the very young patient, the Konstan et al study identified patients at risk for pulmonary function decline. These data came from a prospective, observational study involving 931 patients from ESCF. He determined that at-risk patients could be identified even before routine pulmonary function tests could be performed. Risk factors present at age 3 could predict lung function at age 6. These included cough, sputum, clubbing, crackles, and a positive <em>Pseudomonas</em> culture. Lower nutritional factors such as weight-for-age and height-for-age were also associated with reduced pulmonary function at age 6 in this study.</p>
  <p>Looking at 4866 patients, again from ESCF, Konstan et al sought to characterize the rate of pulmonary function decline over a period of 4 years in 3 different age groups (6-8, 9-12, and 13-17), and to identify and compare risk factors associated with pulmonary decline. Across the 3 different age groups, high baseline FEV1 and crackles were both significantly associated with a steeper rate of decline. High lung function should not be clinically reassuring.</p>
  <p>In a much earlier study by Cory et al, patients over age 5 with normal early PFT measures showed variable survival curves. Normal pulmonary function did not predict a slower rate of disease progression.</p>
  <p>According to what we have reviewed, it appears that severe disease may be present before you see significant changes in clinical signs and symptoms. What are your thoughts?</p>
  <p><strong><u>Resources for Return (Separate) Visit</u></strong><br />
    Resources to use during a Pulmozyme discussion include:</p>
  <ul>
    <li>Pulmozyme education brochure: Review Section 1 on abnormal mucus and disease progression; Section 3 regarding how Pulmozyme addresses abnormal mucus; Section 4 on prescribing Pulmozyme along with other standard therapies to improve lung function and reduce exacerbation risk, thereby delaying disease progression</li>
    <li>Pulmozyme PI: Clinical trial data, indication for use</li>
  </ul>
</div>



<a href="#" rel="toggle[scenario5]" data-openimage="images/scenario5-close.jpg" data-closedimage="images/scenario5.jpg"><img src="collapse.jpg" border="0" /></a> 

<div id="scenario5" class="drop">
  <p><strong>Description of the Situation</strong></p>
  <p>You are meeting with Dr. Westin, the pulmonologist at a small CF Center. When you are leaving his office you run into the office administrator in the hallway. She stops you and states that she has been really frustrated working with insurance carriers for the last 2 patients that have started on Pulmozyme. </p>
  <hr />
  <p><strong>Description of Resources and Response </strong></p>
  <p>The response would incorporate a discussion of services for uninsured, underinsured, and benefits investigation through Access Solutions and the required forms.</p>
  <p><strong><u>Resources</u></strong><br />
    Response would incorporate:</p>
  <ul>
    <li>Access Solutions brochure </li>
    <li>SMN and PAN forms</li>
  </ul>
</div>



<a href="#" rel="toggle[scenario6]" data-openimage="images/scenario6-close.jpg" data-closedimage="images/scenario6.jpg"><img src="collapse.jpg" border="0" /></a> 

<div id="scenario6" class="drop">
  <p><strong>Description of the Situation</strong></p>
  <p>You are meeting with the nursing staff at the CF Center and you run into Dr. Levine, one of the pediatric pulmonologists. She tells you that she just saw a 4 year-old patient who has progressive lung disease and increasing frequency of infection and pulmonary exacerbations. She says she is thinking about starting him on Pulmozyme and wants to know what data is available for that age group. Do you know if insurance will cover the medication?</p>
  <hr />
  <p><strong>Description of Resources and Response</strong></p>
  <p>The response would incorporate an emphasis that use of Pulmozyme in children under 5 years of age is at the discretion of the pulmonologist.</p>
  <p><strong><u>Resources</u></strong><br />
    Resources to use during the discussion include: </p>
  <ul>
    <li>Pulmozyme PI: With emphasis that use in children under 5 years of age is at the discretion of the pulmonologist</li>
    <li>Access Solutions program brochure</li>
    <li>Referral to Medical Communications Department &nbsp;</li>
  </ul>
  <p>For your background information only: Clinical Reprint Binder</p>
  <ul>
    <li>Wagener article: Aerosol delivery and safety of recombinant human deoxyribonuclease in young children with cystic fibrosis: a bronchoscopic study</li>
  </ul>
</div>



<a href="#" rel="toggle[scenario7]" data-openimage="images/scenario7-close.jpg" data-closedimage="images/scenario7.jpg"><img src="collapse.jpg" border="0" /></a> 

<div id="scenario7" class="drop">
  <p><strong>Description of the Situation</strong></p>
  <p>You have an appointment to meet with Dr. Benjamin, an adult pulmonologist, who started the adult CF program at the CF Center 5 years ago. As she sits down to talk with you, Dr. Benjamin shakes her head and says, “I’ve been in clinic all morning, and I keep hearing the same thing from my patients – <em>why do you keep adding more medications? Can’t I eliminate something for a change? It takes me so much time to neb all these drugs</em>.&nbsp; Some of my patients have been on Pulmozyme for 14 years. The hypertonic saline seems to add some benefit. Do they need to be on both Pulmozyme and hypertonic saline?</p>
  <p><strong>Description of Resources and Response </strong></p>
  <hr />
  <p>The response would incorporate a discussion of the Pulmozyme MOA and efficacy data, as well as Pulmozyme administration.</p>
  <p><strong><u>Resources&nbsp; </u></strong><br />
    Resources to include in the discussion: </p>
  <ul>
    <li>Pulmozyme education brochure: &nbsp;Review of &nbsp;the MOA for Pulmozyme – Section3: Pulmozyme addresses abnormal mucus; Section 4: Prescribe Pulmozyme to improve lung function and reduce exacerbation risk, thereby delaying disease progression</li>
    <li>Fuchs PRC-approved article: Reduction of exacerbations, lung function improvement</li>
    <li>Pulmozyme Patient Education brochure</li>
    <li>Request for the Medical Communications Department to discuss hypertonic saline</li>
  </ul>
  <p>For your background information only: Clinical Reprint Binder</p>
  <ul>
    <li>Flume (2007) article: Guidelines for use of chronic medications</li>
  </ul>
</div>
                  
                  
                  
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
      <div class="contentInterior">
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
                <td width="562" class="blue">Using the controls above, you can record and upload your audio response. First select a scenario from the ones to the left.  Then click the microphone button to begin recording. Click “Upload” when you are ready to submit to your manager. Be sure to upload your recording BEFORE changing scenarios or your work will be lost.  Once you have recorded your response, you will be able to listen to an ideal response in the Listen section below. </td>
              </tr>
            </table>
		</div>
      </div>
      <div id="menu-bar3" style="text-align:center;"> Listen</div>
      <div class="contentInterior">
      
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
              <td width="562" class="blue">Using the controls above, you can listen to your uploaded response and an ideal response.  Your response is automatically loaded for listening immediately after upload or when you select a scenario you have already uploaded a response for.  "Load Ideal Response" will be available for a scenario after you have recorded your response.  Click "Load Ideal Response" to load the ideal response for your review.</td>
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
