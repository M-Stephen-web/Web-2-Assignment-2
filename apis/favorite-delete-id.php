<?php
    //This page's purpose is to delete a favorite for the current user with a provided movie id

    //https://www.techiediaries.com/php-rest-api/ For the structure of creating an API
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    require_once('../includes/session-helper.inc.php');
    

    if(isset($_GET['movieId']) && IsLoggedIn()) //Checks if user is logged in and there is a provided movie id
    {
        $user = GetSessionUser(); //Get current user

        $deleteFavorite = new Favorite($user->id, $_GET['movieId']); //Create the favorite object to be
        //given to the database to refer to which favorite to delete

        if(checkFavoriteExist($deleteFavorite, $connection)) //Checks if the favorite does exist of the database
        {
            if(deleteFavoriteMovieId($_GET['movieId'], $user->id,$connection))//Attempt to delete the favorite
            {
                $payload = new Payload(true, null, null); //Return true is successful
            }
            else
            {
                $payload = new Payload(false, null, "Error! DB error!"); //Return error if a database error occurs
            }
        }
        else
        {//Return error if the favorite does not exist
            $payload = new Payload(false, null, "Error! Favorite does not exist!");
        }

    }
    else
    { //Return error if user is not logged in or movie Id not provided
        $payload = new Payload(false, null, "Error! Incomplete data!");
    }

    $json = json_encode($payload); //Encode the payload in json

    echo $json; //Return the json
?>