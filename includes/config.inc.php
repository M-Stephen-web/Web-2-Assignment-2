<?php
define('DBHOST', 'localhost');
define('DBNAME', 'movie');
define('DBUSER', 'root');
define('DBPASS', '');
//define('DBHOST', 'localhost');
//define('DBNAME', 'Assign2');
//define('DBUSER', 'root');
//define('DBPASS', 'admin');
define('DBCONNSTRING', "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4;");

$connection = new PDO(DBCONNSTRING, DBUSER, DBPASS);
