<?php
	define('DBHOST', 'localhost');
	define('DBNAME', 'Assign2');
	define('DBUSER', 'Server1');
	define('DBPASS', 'admin');
	define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
	
	$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
?>