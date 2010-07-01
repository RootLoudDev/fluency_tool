<?php
/** 
 file:global-inc.php
  content: This is the global functions include 
  Author: David Duggins
  Created:10/02/2009
  Updated:10/02/2009
 
  function list: (see each function for documentation)
  validEmail()
  send_email()
  upload_file
  get_file_dialog()
  myErrorHandler()
*/

/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/

function validEmail($email)

{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
   //   if ($isValid && !(checkdnsrr($domain,"MX") ||
// ↪checkdnsrr($domain,"A")))
  //    {
         // domain not found in DNS
     //    $isValid = false;
    //  }
   }
   return $isValid;
}


function send_mail($to, $subject, $message, $header){
//$to = "weatheredwatcher@gmail.com";
mail($to, $subject, $message, $header);

}

function upload_file($target_path) {
 /*This function will take a file and upload to the server
  * It passes the path to upload and returns a boolean TRUE or FALSE
  */
       $target_path = $target_path . basename( $_FILES['uploadedfile']['name']);

       $results=move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
       $_SESSION['upload_file']=$_FILES['uploadedfile']['name'];
       echo $_SESSION['upload_file'];
       echo $_FILES['uploadedfile']['name'];
       return $results;
}

function get_file_dialog($referal_page) {
    /*this function shows a get file form. it passes the referal page and returns the file to be processed
     * as a global $_FILES
     */
   echo('
    <form enctype="multipart/form-data" action="?id='.$referal_page.'" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
Choose a file to upload: <input name="uploadedfile" type="file" /><br />
<input type="submit" name="submit" value="Click here to Upload File" />
</form>
');
}

function myErrorHandler($errno, $errstr, $errfile, $errline)
/**
*
* This is a collection of custom error handling procedures for the Leveraged Media System
* It is loaded in the main index file and overrides all error handling with the exception of fatal memory errors
*/
{
	$myLog = new Log;
	$myLog->set_page($_SERVER['PHP_SELF']);
    switch ($errno) {
    case E_USER_ERROR:
        $myLog->set_log("ERROR:[$errno] Fatal error on line $errline ");
	    $myLog->write_log();
    	exit(1);
        break;

    case E_USER_WARNING:
		$myLog->set_log("WARNING:[$errno] $errstr ");
    	$myLog->write_log();
        break;

    case E_USER_NOTICE:
	$myLog->set_log("NOTICE:[$errno] $errstr ");
	$myLog->write_log();
    break;

    default:
        $myLog->set_log("Unknown Error Type:[$errno] $errstr ");
    	$myLog->write_log();
		break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}


?>
