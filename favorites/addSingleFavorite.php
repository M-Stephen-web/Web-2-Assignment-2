<?php

require_once('../includes/session-helper.inc.php');
require_once('../includes/class-helper.inc.php');
require_once('../includes/db-helper.inc.php');
require_once('../includes/config.inc.php');

if(isset($_GET['movieId']) && IsLoggedIn()) //Checks if user is logged in and there is a provided movie id
{
    $addMovieId = $_GET['movieId'];

    $idArray = [];
    $idArray[] = $addMovieId;

    $addMovie = getMoviesByIds($idArray, $connection)[0];

    $user = GetSessionUser(); //Get current user

    if(isset($_SESSION['Favorites'])) //Sees if Favorites is already in session
    {
        $favoriteMovies = unserialize($_SESSION['Favorites']);

        foreach($favoriteMovies as $movie) //Checks if movie is already added
        {
            if($movie->id == $addMovieId)
            {
                header('Location: ../detail.php?movieId=' . $addMovieId);
            }
        }
    }
    else
    {
        $favoriteMovies = [];
    }

    if(addToDatabase($addMovieId, $user, $connection)) //Add the favorite to database
    {
        $favoriteMovies[] = $addMovie;
    
        $_SESSION['Favorites'] = serialize($favoriteMovies);
    }

    header('Location: ../detail.php?movieId=' . $addMovieId);
}

function addToDatabase($movieId, $user, $connection)
{
    $newFavorite = new Favorite($user->id, $movieId); //Create the new favorite object

    if(checkFavoriteExist($newFavorite, $connection)) //Checks if the favorite already exists
    {
        return false;
    }
    else //Else insert the new favorite to the database
    {
        if(insertFavorite($newFavorite, $connection))
        {
            return true;
        }
        else //If an error occurs in the database, give message back
        {
            return false;
        }
    }
}

?>