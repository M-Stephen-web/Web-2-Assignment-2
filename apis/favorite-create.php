<?php
    //https://www.techiediaries.com/php-rest-api/
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/session-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    if(IsLoggedIn() && isset($_GET['movieId']))
    {
        $user = GetSessionUser();

        $newFavorite = new Favorite($user->id, $_GET['movieId']);

        if(checkFavoriteExist($newFavorite, $connection))
        {
            $payload = new Payload(false, null, "Error! Already favorited!");
        }
        else
        {
            if(insertFavorite($newFavorite, $connection))
            {
                $payload = new Payload(true, null, null);
            }
            else
            {
                $payload = new Payload(false, null, "Error! DB error!");
            }
        }
    }
    else
    {
        $payload = new Payload(false, null, "Error! Incomplete data!");
    }

    $json = json_encode($payload);

    echo $json;
?>