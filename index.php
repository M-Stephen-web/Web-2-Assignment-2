<?php
$userName = '';
$userId = '';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset='utf-8' />
	<title>Movie Browser</title>

	<link rel='stylesheet' href='css/index.css'>
</head>

<body>
	<section id='homeSection'>
		<div id='movieBrowserBox'>
			<div class='row'>
				<a href="login.php" id="login" class="button">Login</a>
				<a href="registration.php" id="join" class="button">Join</a>
			</div>
			<input type='text' id='searchBox' placeholder='Search for Movies' />
		</div>
	</section>
	<footer>Photo by Johannes Plenio on Unsplash</footer>
	<script src='js/index.js'></script>
</body>

</html>