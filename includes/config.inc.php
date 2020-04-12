<?php
	//This page's purpose is to define the connection to the database

	//Define all variables required to connect to the database
	define('DBHOST', '35.226.117.208');
	define('DBNAME', 'Assign2');
	define('DBUSER', 'root');
	define('DBPASS', 'admin');
	define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
	
	//Connection string
	$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
?>
