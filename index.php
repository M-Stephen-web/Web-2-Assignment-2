<?php
$userName = '';
$userId = '';
// require_once('header.php');
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8' />
	<title>Movie Browser</title>

	<link rel='stylesheet' href='css/index.css'>
</head>

<body>
	<?php //printHeader(); ?>
	<section id='homeSection'>
		<div id='movieBrowserBox'>
			<div class='row'>
				<a href="login.php" id="login" class="button">Login</a>
				<a href="registration.php" id="join" class="button">Join</a>
			</div>
			<form action="default.php" method="get">
				<input type='text' name="movieFilter" id='searchBox' placeholder='Search box for Movies' />
			</form>
		</div>
	</section>
	<footer></footer>
</body>

</html>