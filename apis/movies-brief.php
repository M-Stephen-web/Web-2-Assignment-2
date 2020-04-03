<?php
    //https://www.techiediaries.com/php-rest-api/
    header("Content-Type: application/json; charset=UTF-8");

    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');
    require_once('../includes/class-helper.inc.php');
    
    if(isset($_GET['id']))
    {
        $movie = getMovieDetail($_GET['id'], $connection);
    
        if($movie != null && $movies > 0)
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