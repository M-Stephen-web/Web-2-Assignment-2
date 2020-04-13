<?php
    //This page's purpose is to delete all favorites for the current user

    //https://www.techiediaries.com/php-rest-api/ For the structure of creating an API
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/session-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    if(IsLoggedIn()) //Checks if user is logged in
    {
        if(deleteAllFavoriteMovie(GetSessionUser(), $connection)) //Try to delete the favorites
        {
            $payload = new Payload(true, null, null);
        }
        else //Give error if error occurs from the database
        {
            $payload = new Payload(false, null, "Error! DB error!");
        }
    }
    else //Give error is the user is not logged in
    {
        $payload = new Payload(false, null, "Error! Not logged in!");
    }

    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>