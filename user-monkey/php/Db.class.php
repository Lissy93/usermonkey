<?php

class Db {
	//IMPORTANT Enter your database credentials here
    private $_username = "root";
    private $_password = "";
    private $_hostname = "localhost";
    private $_database = "usermonkey";

    function connect(){

        $dbhandle = mysql_connect($this->_hostname, $this->_username, $this->_password)
        or die("Unable to connect to MySQL");

        $selected = mysql_select_db($this->_database,$dbhandle)
        or die("Could not select examples");
    }


    function query_insert($query){
        $mysqli = new mysqli($this->_hostname, $this->_username, $this->_password, $this->_database);
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->close();
    }

    function query($query){
        $result = mysql_query($query);

        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
        }

        $returnResult = array();

        while( $row = mysql_fetch_assoc( $result)){
            $returnResult[] = $row; // Inside while loop
        }
        return $returnResult;
    }





}