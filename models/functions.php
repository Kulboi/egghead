<?php

	$servername = "localhost";
  	$username = "root";
  	$password = "";
  	$databasename = "";

  	$datetime = date('Y-m-d H:i:s');

    $date = date("Y/m/d");

  	// db connection
	$connection = new PDO("mysql:host=$servername;dbname=$databasename",$username,$password); 
	if (!$connection) {
		echo "No connection esterblished";
	}


?>