<?php
include_once 'includes/dbconnect.php';
$scenario_title = $_GET['scenario_title'];
$scenario_description = $_GET['scenario_description'];
$scenario_resource = $_GET['scenario_resources'];

mysql_query("INSERT INTO scenarios (scenarioTitle, scenarioDescription, scenarioResource) VALUES('$scenario_title','$scenario_description', '$scenario_resource')")or die(mysql_error());
$id = mysql_insert_id();

$tracker = count($_GET) - 3;
$tracker = $tracker / 2;

for($i=1; $i <= $tracker; $i++){
    

	$res_text = "res_text".$i;
	$res_type = "res_type".$i;
	$resource = $_GET[$res_text];
	$type = $_GET[$res_type];
	//echo $type;
mysql_query("INSERT INTO resources (scenarioID, resource, resourceType) VALUES('$id','$resource', '$type')")or die(mysql_error());
	
	

}	

return $msg;
?>
