<?php
function uploadScenario($scenarioname, $associatenum)
{
	$scenarioarray = array("scenario1", "scenario2", "scenario3", "scenario4", "scenario5", "scenario6","scenario7");
// Only update  on valid values
	if (in_array($scenarioname, $scenarioarray, true) && ($associatenum == $_SESSION['user_id']))
	{
		$queryscenario = "UPDATE users SET $scenarioname=1 WHERE ID='$associatenum' LIMIT 1";
		$resultscenario = mysql_query($queryscenario);
	}
}
?>