<?php
<<<<<<< HEAD
	define('DBHOST', 'localhost');
	define('DBNAME', 'movie');
	define('DBUSER', 'root');
	define('DBPASS', 'admin');
	define('DBCONNSTRING',"mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");
	
	$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
?>
=======
define('DBHOST', 'localhost');
define('DBNAME', 'Assign2');
define('DBUSER', 'root');
define('DBPASS', 'admin');
define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
>>>>>>> 80414428aa3df395f2c8c8ab6d52ba5cbcb6e717
