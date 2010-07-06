<?php
/* 
 * FluencyTool Enviroment Configuration File.
 * This sets all the enviroment variables such as which company is current logged in
 * and what their images, colors, titles are.
 *
 * Company: RootLoud <http://www.rootloud.com>
 * Application: FluencyTool <http://www.fluencytool.com>
 * Programmer: David Duggins <david@rootloud.com>
 * Created: 7/1/2010
 * Last Updated: 7/6/2010
 */
require_once('includes/global-inc.php');  //this loads all the required classes..changed from dbconnect.php on 7/6/10 DWD

//TODO: need to load the database here
$myFluencyDB = new DBConnect;
$myFluencyDB->setHost('localhost', 'root', '');
$myFluencyDB->setDatabase('fluency_tool');
$myFluencyDB->connectHost();
$myFluencyDB->connectDB();



//TODO: lookup org based on url (http://my.fluencytool.com/org_name_is_here)

//TODO: load the org config information
//validate the users

//TODO Take the is user validation function and turn it into a User class
function checkLogin($levels)
	{
		if(!$_SESSION['logged_in'])
		{
			$access = FALSE;
		}
		else {
				$userid = $_SESSION['user_id'];
				$userid = mysql_real_escape_string($userid);
				$kt = split(' ', $levels);
				$query = 'SELECT rolename FROM users INNER JOIN roles ON users.role = roles.ID WHERE users.ID = "'.$userid.'"';
				$result = mysql_query($query);
				$row = mysql_fetch_assoc($result);

				$access = FALSE;

				while(list($key,$val)=each($kt))
				{
					if($val==$row['rolename'])
					{//if the user role matches one of the allowed roles
						$access = TRUE;
					}
				}
			}
		if($access==FALSE)
		{

			header("Location: index.php");
		}
		else {
		//do nothing: continue
                    
		}
	}

?>
