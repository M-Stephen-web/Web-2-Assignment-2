<?php

    require_once('./db-helper.inc.php');
    require_once('./session-helper.inc.php');

    function getRecommendedMovies($connection)
    {
        $user = GetSessionUser();

        $movieIds = getFavoriteMovieIds($user ,$connection);

        //https://www.w3schools.com/php/func_array_count.asp For array count
        //https://www.w3schools.com/pHP/func_math_rand.asp For random number
        $randomIndex = rand(0, count($movieIds));

        $movieCompare = $movieIds[$randomIndex];

        $allMovies = getAllMovies($connection);
        $recommendedMovies = [];

        foreach($allMovies as $movie)
        {
            if((($movie->vote_average - $movieCompare->vote_average) < 0.25 && ($movie->vote_average - $movieCompare->vote_average) > -0.25) 
                && substr($movie->release_date, 0, 4) == substr($movieCompare->release_date, 0, 4))
            {
                $recommendedMovies[] = $movie;
            }

            if(count($recommendedMovies) == 15)
            {
                break;
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