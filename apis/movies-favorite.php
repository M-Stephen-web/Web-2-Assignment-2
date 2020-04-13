<?php
	//This page's purpose is to get all movies the user has favorited
	
    //https://www.techiediaries.com/php-rest-api/
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    require_once('../includes/session-helper.inc.php');
    
	$payload = null; //Declare the payload variable
	
	if(IsLoggedIn())//Checks if the user is logged in
	{
		$User = GetSessionUser(); //Gets current user

		$movieIds = getFavoriteMovieIds($User, $connection); //Get all the movie ids the user has favorited

		$movies = getMoviesByIds($movieIds, $connection); //Passes the ids from above to get the movies
		
		$payload = new Payload(true, $movies, null); //Puts all the movies into the payload
	}
	else
	{//Throw error if a database error occured
		$payload = new Payload(false, null, "Error! DB error!");
	}

    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>