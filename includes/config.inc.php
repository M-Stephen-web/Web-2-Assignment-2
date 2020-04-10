<?php
	define('DBHOST', 'localhost');
	define('DBNAME', 'movie');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
	
	$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
?>