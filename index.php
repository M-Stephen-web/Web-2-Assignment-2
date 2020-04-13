<?php
	require_once('includes/session-helper.inc.php');
	
	if(IsLoggedIn())
	{
		
    require_once('header.php');
    require_once('includes/session-helper.inc.php');
    require_once('includes/recommend-helper.inc.php');
    require_once('includes/db-helper.inc.php');
    require_once('includes/config.inc.php');
    
    $posterURL = "https://image.tmdb.org/t/p/w92";

    $user = GetSessionUser();

    $recommendedMovies = getRecommendedMovies($connection);

    if(isset($_SESSION['Favorites']))
    {
        $favoritedMovies = unserialize($_SESSION['Favorites']);
    }
    else
    {
        $favoritedMovies = [];
    }
?>
	<!DOCTYPE html>
	<html>

		<head>
			<link rel="stylesheet" href="css/index.css">
			<link rel="stylesheet" href="css/home.css">
			<meta title="Home Page">
		</head>

		<body>
		<?php  
			printHeader(); 
		?>
		<div id="homeGridBlock">
			<div id="homeGridLeft">
				<div class="transparentBox">
					<h2>User Information</h2>
					<div id="userInfoBox">
						<div>
							Firstname: <?php echo $user->firstname ?>
						</div>
						<div>
							Lastname: <?php echo $user->lastname ?>
						</div>
						<div>
							City: <?php echo $user->city ?>
						</div>
						<div>
							Country: <?php echo $user->country ?>
						</div>
						<div>
							Email: <?php echo $user->email ?>
						</div>
					</div>
				</div>
				<div class="transparentBox">
					<h2>Favorites</h2>
					<div id="favoriteMoviesBox">
						<?php
							foreach($favoritedMovies as $movie)
							{
								echo 
								"<div class='favoriteMovieBlock'>
									<a class='imageAnchor' href='detail.php?movieId=" . $movie->id . "'>
										<img src='" . $posterURL . $movie->poster_path . "' />
									</a>
									<a class='imageAnchor' href='detail.php?movieId=" . $movie->id . "'>
										".$movie->title."
									</a>
								</div>";
							}
						?>
					</div>
				</div>
			</div>
			<div id="homeGridRight">
				<div class="transparentBox" id="searchBox">
					<h2>Search Box For Movies</h2>
					<form method="GET" action="default.php">
						<input id="movieSearch" name="movieFilter">
					</form>
				</div>
				<div class="transparentBox">
					<h2>Recommendations</h2>
					<div id="recommendations">
						<?php
							foreach($recommendedMovies as $movie)
							{
								echo 
								"<div class='favoriteMovieBlock'>
									<a class='imageAnchor' href='detail.php?movieId=" . $movie->id . "'>
										<img src='" . $posterURL . $movie->poster_path . "' />
									</a>
									<a class='imageAnchor' href='detail.php?movieId=" . $movie->id . "'>
										".$movie->title."
									</a>
								</div>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
		</body>
	<footer></footer>
	</html>
<?php
}
else{
	?>
	<!DOCTYPE html>
	<html>
	
	<head>
		<meta charset='utf-8' />
		<title>Movie Browser</title>
	
		<link rel='stylesheet' href='css/index.css'>
	</head>
	
	<body>
		<?php 
		?>
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
	</body>
	<footer></footer>
	
	</html>
<?php
}
?>
