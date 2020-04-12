<?php 

    require_once('includes/session-helper.inc.php');

    if(LogoutUser())
    {
        header('Location: index.php');
    }
    else
    {
        header('Location: ' . $_SERVER["HTTP_REFERER"]);
    }
?>