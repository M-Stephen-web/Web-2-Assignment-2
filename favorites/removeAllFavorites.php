<?php 

    require_once('../includes/session-helper.inc.php');
    require_once('../includes/class-helper.inc.php');
    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');

    if(IsLoggedIn() && isset($_SESSION['Favorites'])) //Checks if user is logged in and there is a provided movie id
    {
        if(deleteFromDatabase($connection)) //Delete from database
        {
            $favoriteMovies = [];
    
            $_SESSION['Favorites'] = serialize($favoriteMovies);
        }
    }

    header('Location: favorites.php');


    function deleteFromDatabase($connection)
    {
        if(deleteAllFavoriteMovie(GetSessionUser(), $connection)) //Try to delete the favorites
        {
            return true;
        }
        else //Give error if error occurs from the database
        {
            return false;
        }
    }
?>