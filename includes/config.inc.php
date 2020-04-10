<?php
	define('DBHOST', '35.226.117.208');
	define('DBNAME', 'Assign2');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
	
	$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
?>
