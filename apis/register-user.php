<?php
    require_once('../includes/session-helper.inc.php');
    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');


    $firstname = null;
    $lastname = null;
    $city = null;
    $country = null;
    $email = null;
    $password = null;

    $payload = null;
    
    if(isset($_POST['firstname'])) {$firstname = $_POST['firstname'];}
    if(isset($_POST['lastname'])) {$lastname = $_POST['lastname'];}
    if(isset($_POST['city'])) {$city = $_POST['city'];}
    if(isset($_POST['country'])) {$country = $_POST['country'];}
    if(isset($_POST['email'])) {$email = $_POST['email'];}
    if(isset($_POST['password'])) {$password = $_POST['password'];}

    $digest = null;

    if($password != null)
    {
        $digest = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    if($firstname != null && $lastname != null && $city != null && $country != null && $email != null && $digest != null)
    {
        $UserData = array();

        $UserData['firstname'] = $firstname;
        $UserData['lastname'] = $lastname;
        $UserData['city'] = $city;
        $UserData['country'] = $country;
        $UserData['email'] = $email;
        $UserData['digest'] = $digest;
        
        $NewUser = new User($UserData);
        
        if(RegisterUser($NewUser, $connection))
        {
            $payload = new Payload(true, null, null);
        }
        else
        {
            $payload = new Payload(false, null, null);
        }
        
    }
    else
    {
        $payload = new Payload(false, null, null);
    }

    $json = json_encode($payload);

    echo $json;
?>