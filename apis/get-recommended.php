<?php
    //This page's purpose is to get recommended movies for the current user

    //https://www.techiediaries.com/php-rest-api/ For the structure of creating an API
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    require_once('../includes/recommend-helper.inc.php');


    if (IsLoggedIn()) { //Checks is the user is logged in

        $recommended = getRecommendedMovies($connection); //Get all the recommended movies

        $payload = new Payload(true, $recommended, null);//Put the movies in a payload
    } else {//Give error if an error does occur
        $payload = new Payload(false, null, "Error getting list of recommendations");
    }
    
    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>