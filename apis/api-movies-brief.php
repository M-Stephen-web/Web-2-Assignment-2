<?php
    //This page's purpose is to get all movies but have less information

    //https://www.techiediaries.com/php-rest-api/ For the structure of creating an API
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    $movies = getAllMovies($connection);//Get the movies from the database

    if($movies != null && $movies > 0) //Checks if they are not null and not empty
    {
        $payload = new Payload(true, $movies, null); //Creates the payload to hold the movies
    }
    else
    {//Return an error if an error does occur
        $payload = new Payload(false, null, "Error!");
    }

    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>