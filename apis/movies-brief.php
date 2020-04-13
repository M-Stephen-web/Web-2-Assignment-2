<?php
    //This page's purpose is to get all the information of a specific movie

    //https://www.techiediaries.com/php-rest-api/ For the structure of creating an API
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    if(isset($_GET['movieId'])) //Checks if the movie does exist
    {
        $movie = getMovieDetail($_GET['movieId'], $connection); //Gets the movie from the database
    
        if($movie != null) //Makes sure the movie is not null
        {
            $payload = new Payload(true, $movie, null); //Make payload with the movie
        }
        else
        {//Throw an error if there was something wrong with the database
            $payload = new Payload(false, null, "Error! DB error!");
        }
    }
    else
    {//Throw error if no movie id was provided
        $payload = new Payload(false, null, "Error! No movie id provided!");
    }

    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>