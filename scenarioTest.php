<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'includes/_bootstrap.php';




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PULMOZYME: Associate Screen</title>
<link href="css/start/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script/jquery-min.js"></script>
<script type="text/javascript" src="script/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript">
	$(function() {
		$("#accordion").accordion();
	});
	</script>

</head>
    <body>
        <html>
            
            
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




        </html>
    </body>