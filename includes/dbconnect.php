<?php
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
?>
