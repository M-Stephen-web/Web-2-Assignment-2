<?php
    require_once('../includes/session-helper.inc.php');
    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');


    $email = null;
    $password = null;

    $payload = null;
        
    if(isset($_POST['email']))
    {
        $email = $_POST['email'];
    }
        
    if(isset($_POST['password']))
    {
        $password = $_POST['password'];
    }

    if($email != null && $password != null && LoginUser($email, $password))
    {
        $payload = new Payload(true, null, null);
    }
    else
    {
        $payload = new Payload(false, null, null);
    }

    $json = json_encode($payload);

    echo $json;
?>