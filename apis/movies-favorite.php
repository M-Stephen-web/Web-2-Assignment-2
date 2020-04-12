<?php
    //https://www.techiediaries.com/php-rest-api/
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    require_once('../includes/session-helper.inc.php');
    
	$payload = null;
	
	if(IsLoggedIn())
	{
		$User = GetSessionUser();

		$movieIds = getFavoriteMovieIds($User, $connection); //Get all the movie ids the user has favorited

		$movies = getMoviesByIds($movieIds, $connection);
		
		$payload = new Payload(true, $movies, null);
	}
	else
	{
		$payload = new Payload(false, null, "Error! DB error!");
	}

    $json = json_encode($payload);

    echo $json;
?>