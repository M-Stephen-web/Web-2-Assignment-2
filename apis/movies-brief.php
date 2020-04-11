<?php
    //https://www.techiediaries.com/php-rest-api/
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    if(isset($_GET['movieId']))
    {
        $movie = getMovieDetail($_GET['movieId'], $connection);
    
        if($movie != null)
        {
            $payload = new Payload(true, $movie, null);
        }
        else
        {
            $payload = new Payload(false, null, "Error!");
        }
    }
    else
    {
        $payload = new Payload(false, null, "Error!");
    }

    $json = json_encode($payload);

    echo $json;
?>