<?php
    //Purpose of this page is to handle the recommendation of movies for the home page

    require_once('db-helper.inc.php'); //Needed to access the database for movies0
    require_once('session-helper.inc.php'); //To get the current user

    function getRecommendedMovies($connection)
    {
        $user = GetSessionUser(); //Get current user

        if($user != null) //Check if it is not null
        {
            $favoriteMovieIds = getFavoriteMovieIds($user ,$connection); //Get all the movie ids that are favorited by the user
    
            $recommendedMovies = []; //Initalize array to place movie objects to be recommended
    
            $allMovies = getAllMovies($connection); //Get all the movies but with basic values, such as release date and vote average
            
            $movieCompare = null; //Declare movie object to be used to compare other movies with
    
            while(count($recommendedMovies) < 15) //Go in a while loop until we have 15 recommended movies to show
            {
                if(count($favoriteMovieIds) > 0) //If there are favorited movies to compare with, use those
                {
                    //https://www.w3schools.com/php/func_array_count.asp For array count
                    //https://www.w3schools.com/pHP/func_math_rand.asp For random number
                    $randomIndex = rand(0, count($favoriteMovieIds)-1); //Select random index to access a random movie to compare with
    
                    $movieCompareId = $favoriteMovieIds[$randomIndex]; //Use the random index to select a random movie id
    
                    $idArray = []; //To get a movie by id, we need it to be in an array
    
                    $idArray[] = $movieCompareId; //Place movie id into array
                    
                    $movieCompare = getMoviesByIds($idArray, $connection)[0]; //Get movie by the randomly selected id
    
                    //https://stackoverflow.com/questions/369602/deleting-an-element-from-an-array-in-php For array_splice
                    array_splice($favoriteMovieIds, $randomIndex, 1); //Remove the used index so we do not get the same recommended movies again
                    
                    foreach($allMovies as $movie) //Go through all the movies
                    {
                        if((($movie->vote_average - $movieCompare->vote_average) < 0.25 && ($movie->vote_average - $movieCompare->vote_average) > -0.25) 
                            && substr($movie->release_date, 0, 4) == substr($movieCompare->release_date, 0, 4) && $movie->id != $movieCompare->id) 
                            //If a movie that is being compared to movieCompare has a different of 0.25 vote average and released in the same year and the two
                            //movies are not the same, then have it added to the movies to be recommended.
                        {
                            $recommendedMovies[] = $movie;
                        }
            
                        if(count($recommendedMovies) == 15) //If there are 15 movies in the recommended array, then stop searching for more
                        {
                            break;
                        }
                    }
                }
                else //If there are no favorites to compare with, then get the rest of the recommended movies by the latest year and with greatest rating
                {
                    $topRecommendedMovies = getTopRecommendedMovies($connection);
    
                    $max = (15 - count($recommendedMovies) - 1);
    
                    for ($i = 0; $i <= $max; $i++)
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
    
            return $recommendedMoviesFull; //Return movies
        }
    }

?>