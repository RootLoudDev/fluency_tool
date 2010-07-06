<?php
/** 
  file:global-inc.php
  content: This is the global classes include
  Author: David Duggins
  Created:07/02/2010
  Updated:07/06/2010
 
  */

class DBConnect{

    var $host;
    var $login;
    var $password;
    var $database;

    function setHost($host, $login, $password){

        $this->host = $host;
        $this->login = $login;
        $this->password = $password;


    }

    function setDatabase($database){
        $this->database = $database;
    }

    function connectHost(){

        mysql_connect($this->host, $this->login, $this->password) or die(mysql_error());

    }

    function connectDB(){

        mysql_select_db($this->database) or die(mysql_error());
    }
}

class User {

    var $userID;
    var $username;
    var $password;
    var $firstname;
    var $lastname;
    var $email;
    var $role;
    var $location;
    var $scenarios;


    function setUserFromID($id){

        $id = $this->userID;
        $results = mysql_query("SELECT * FROM users WHERE ID='$id'");
        $userData = mysql_fetch_row($results);

        $userData[1] = $this->username;
        $userData[2] = $this->password;
        $userData[3] = $this->firstname;
        $userData[4] = $this->lastname;
        $userData[5] = $this->email;
        $userData[6] = $this->role;
        $userData[7] = $this->location;

        }

    function getScenarios(){
        // this method should only be run after a User has been created
        $results=mysql_query("SELECT scenario_id FROM user_scenarios WHERE user_id='$this->userID'");
        while($row = mysql_fetch_row($result)){

            array_push($this->scenarios, $row[0]);

        }




    }

    function getFeedBack(){
        // this method should only be run after a User has been created



    }

}
?>
