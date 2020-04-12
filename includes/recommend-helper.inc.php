<?php

    require_once('db-helper.inc.php');
    require_once('session-helper.inc.php');

    function getRecommendedMovies($connection)
    {
        $user = GetSessionUser();

        $favoriteMovieIds = getFavoriteMovieIds($user ,$connection);

        $recommendedMovies = [];

        $allMovies = getAllMovies($connection);

        if(count($recommendedMovies) < 15)
        {
            $movieCompare = null;

            if(count($favoriteMovieIds) > 0)
            {
                //https://www.w3schools.com/php/func_array_count.asp For array count
                //https://www.w3schools.com/pHP/func_math_rand.asp For random number
                $randomIndex = rand(0, count($favoriteMovieIds)-1); //Select random index of array of favorite movies' ids

                $movieCompareId = $favoriteMovieIds[$randomIndex]; //Use the random index to select a random movie's id

                $idArray = []; //To get a movie by id, we need it to be in an array

                $idArray[] = $movieCompareId; //Place movie's id into array
                
                $movieCompare = getMoviesByIds($idArray, $connection)[0]; //Get movie by the randomly selected id

                //https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php For array_splice
                array_splice($favoriteMovieIds, $randomIndex, 1); //Remove the used index so we do not get the same recommended movies again
                
                foreach($allMovies as $movie)
                {
                    if((($movie->vote_average - $movieCompare->vote_average) < 0.25 && ($movie->vote_average - $movieCompare->vote_average) > -0.25) 
                        && substr($movie->release_date, 0, 4) == substr($movieCompare->release_date, 0, 4) && $movie->id != $movieCompare->id)
                    {
                        $recommendedMovies[] = $movie;
                    }
        
                    if(count($recommendedMovies) == 15)
                    {
                        break;
                    }
                }
            }
            else
            {
                $topRecommendedMovies = getTopRecommendedMovies($connection);

                for ($i = 0; $i <= (15 - count($recommendedMovies)); $i++)
                {
                    $recommendedMovies[] = $topRecommendedMovies[$i];
                }
            }
        }

        $recommendedMovieIds = [];

        foreach($recommendedMovies as $movie)
        {
            $recommendedMovieIds[] = $movie->id;
        }

        $recommendedMoviesFull = getMoviesByIds($recommendedMovieIds, $connection);

        return $recommendedMoviesFull;
    }

?>