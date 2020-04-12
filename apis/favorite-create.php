<?php
    //This page's purpose is to create a favorite with the given movieId and current user

    //https://www.techiediaries.com/php-rest-api/ For the structure of creating an API
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/session-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    if(IsLoggedIn() && isset($_GET['movieId'])) //Checks if user is logged in and there is a provided movie id
    {
        $user = GetSessionUser(); //Get user

        $newFavorite = new Favorite($user->id, $_GET['movieId']); //Create the new favorite object

        if(checkFavoriteExist($newFavorite, $connection)) //Checks if the favorite already exists
        {
            $payload = new Payload(false, null, "Error! Already favorited!");
        }
        else //Else insert the new favorite to the database
        {
            if(insertFavorite($newFavorite, $connection))
            {
                $payload = new Payload(true, null, null);
            }
            else //If an error occurs in the database, give message back
            {
                $payload = new Payload(false, null, "Error! DB error!");
            }
        }
    }
    else //If there is incomplete data or user is not logged in, send error to user
    {
        $payload = new Payload(false, null, "Error! Incomplete data!");
    }

    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>