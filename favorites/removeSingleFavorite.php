<?php 

    require_once('../includes/session-helper.inc.php');
    require_once('../includes/class-helper.inc.php');
    require_once('../includes/db-helper.inc.php');
    require_once('../includes/config.inc.php');

    if(isset($_GET['movieId']) && IsLoggedIn() && isset($_SESSION['Favorites'])) //Checks if user is logged in and there is a provided movie id
    {
        $deleteMovieId = $_GET['movieId'];

        $user = GetSessionUser(); //Get current user

        if(deleteFromDatabase($deleteMovieId, $user, $connection))
        {

            $favoriteMovies = unserialize($_SESSION['Favorites']);
    
            for($i = 0; $i < count($favoriteMovies); $i++)
            {
                if($favoriteMovies[$i]->id = $deleteMovieId)
                {
                    array_splice($favoriteMovies, $i, 1);
                    break;
                }
            }
    
            $_SESSION['Favorites'] = serialize($favoriteMovies);
        }
    }

    header('Location: favorites.php');


    function deleteFromDatabase($movieId, $user, $connection)
    {
        $deleteFavorite = new Favorite($user->id, $movieId); //Create the favorite object to be
        //given to the database to refer to which favorite to delete

        if(checkFavoriteExist($deleteFavorite, $connection)) //Checks if the favorite does exist of the database
        {
            if(deleteFavoriteMovieId($movieId, $user->id,$connection))//Attempt to delete the favorite
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {//Return error if the favorite does not exist
            return false;
        }
    }
?>